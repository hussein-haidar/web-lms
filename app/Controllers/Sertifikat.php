<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_sertifikat;
use App\Models\M_pendaftaran;
use App\Models\M_siswa;

class Sertifikat extends BaseController
{
    protected $M_sertifikat;
    protected $M_pendaftaran;
    protected $M_siswa;

    public function __construct()
    {
        $this->M_sertifikat = new M_sertifikat();
        $this->M_pendaftaran = new M_pendaftaran();
        $this->M_siswa = new M_siswa();
    }

    // ================================
    // SISWA SECTION
    // ================================

    /**
     * Dashboard sertifikat siswa
     */
    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat->getBySiswa($id_siswa);
        $pending_courses = $this->getPendingCourses($id_siswa);

        $data = [
            'title' => 'Sertifikat Saya',
            'title2' => 'Sertifikat Saya',
            'sertifikat' => $sertifikat,
            'pending_courses' => $pending_courses,
            'siswa' => $this->M_siswa->get_profil($id_siswa)
        ];

        return view('backend/siswa/sertifikat/v_index', $data);
    }

    /**
     * Klaim sertifikat oleh siswa
     */
    public function claim($id_pendaftaran)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Check if pendaftaran belongs to this student
        $pendaftaran = $this->M_pendaftaran->detailDaftar($id_pendaftaran);
        if (!$pendaftaran || $pendaftaran['id_siswa'] != $id_siswa) {
            session()->setFlashdata('error', 'Pendaftaran tidak ditemukan!');
            return redirect()->back();
        }

        // Check if already has certificate
        $existing = $this->M_sertifikat->where('id_pendaftaran', $id_pendaftaran)->first();
        if ($existing) {
            session()->setFlashdata('warning', 'Sertifikat sudah diterbitkan sebelumnya!');
            return redirect()->back();
        }

        // Check if course is completed (100% progress)
        if ($pendaftaran['progress'] < 100) {
            session()->setFlashdata('error', 'Anda harus menyelesaikan kursus terlebih dahulu! Progress: ' . $pendaftaran['progress'] . '%');
            return redirect()->back();
        }

        // Create certificate
        $sertifikat = $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);
        
        if ($sertifikat) {
            // Generate PDF certificate
            $pdf_file = $this->generatePDFCertificate($sertifikat);
            
            // Update certificate with PDF file
            $this->M_sertifikat->update($sertifikat['id_sertifikat'], [
                'file_pdf' => $pdf_file,
                'qr_code' => $this->generateQRCode($sertifikat),
                'verification_url' => base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat'])
            ]);

            session()->setFlashdata('pesan', 'Sertifikat berhasil diklaim! Anda dapat mengunduh sertifikat Anda.');
        } else {
            session()->setFlashdata('error', 'Gagal membuat sertifikat!');
        }

        return redirect()->to(base_url('sertifikat'));
    }

    /**
     * Download sertifikat PDF
     */
    public function download($id_sertifikat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $sertifikat = $this->M_sertifikat
            ->where('id_sertifikat', $id_sertifikat)
            ->where('id_siswa', $id_siswa)
            ->first();

        if (!$sertifikat || empty($sertifikat['file_pdf'])) {
            session()->setFlashdata('error', 'Sertifikat tidak ditemukan!');
            return redirect()->back();
        }

        // Use the existing file path structure
        $file_path = WRITEPATH . 'uploads/certificates/' . $sertifikat['file_pdf'];
        if (file_exists($file_path)) {
            return $this->response->download($file_path, null);
        } else {
            session()->setFlashdata('error', 'File sertifikat tidak ditemukan!');
            return redirect()->back();
        }
    }

    /**
     * View sertifikat online
     */
    public function view($id_sertifikat)
    {
        $sertifikat = $this->M_sertifikat->find($id_sertifikat);
        
        if (!$sertifikat || $sertifikat['is_active'] != 1) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sertifikat tidak ditemukan');
        }

        $data = [
            'title' => 'Verifikasi Sertifikat',
            'title2' => 'Verifikasi Sertifikat',
            'sertifikat' => $sertifikat
        ];

        return view('public/sertifikat/v_view', $data);
    }

    /**
     * Verifikasi sertifikat (public)
     */
    public function verify($kode = null)
    {
        // If no $kode parameter, try to get from POST data
        if ($kode === null) {
            $kode = $this->request->getPost('kode');
        }
        
        if (!$kode) {
            session()->setFlashdata('error', 'Silakan masukkan nomor sertifikat!');
            return redirect()->to(base_url('sertifikat/verify'));
        }
        
        $sertifikat = $this->M_sertifikat->verifyCertificate($kode);
        
        if (!$sertifikat) {
            session()->setFlashdata('error', 'Sertifikat tidak valid atau tidak ditemukan!');
            return redirect()->to(base_url('sertifikat/verify'));
        }

        $data = [
            'title' => 'Verifikasi Sertifikat',
            'title2' => 'Verifikasi Sertifikat',
            'sertifikat' => $sertifikat,
            'is_valid' => true
        ];

        return view('public/sertifikat/v_verify', $data);
    }

    /**
     * Form verifikasi sertifikat
     */
    public function verify_form()
    {
        $data = [
            'title' => 'Verifikasi Sertifikat',
            'title2' => 'Verifikasi Sertifikat'
        ];

        return view('public/sertifikat/v_verify_form', $data);
    }

    // ================================
    // ADMIN SECTION
    // ================================

    /**
     * Dashboard admin untuk sertifikat
     */
    public function admin_index()
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login'));
        }

        $pending = $this->M_sertifikat->getPendingSertifikat();
        $issued = $this->M_sertifikat->orderBy('tanggal_terbit', 'DESC')->findAll();

        $data = [
            'title' => 'Manajemen Sertifikat',
            'title2' => 'Manajemen Sertifikat',
            'pending' => $pending,
            'issued' => $issued
        ];

        return view('backend/admin/sertifikat/v_index', $data);
    }

    /**
     * Admin buat sertifikat manual
     */
    public function admin_create($id_pendaftaran)
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login'));
        }

        // Check if already has certificate
        $existing = $this->M_sertifikat->where('id_pendaftaran', $id_pendaftaran)->first();
        if ($existing) {
            session()->setFlashdata('warning', 'Sertifikat sudah diterbitkan!');
            return redirect()->back();
        }

        // Create certificate
        $sertifikat = $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);
        
        if ($sertifikat) {
            session()->setFlashdata('pesan', 'Sertifikat berhasil dibuat untuk ' . $sertifikat['nama_peserta'] . ' dengan predikat ' . $sertifikat['predikat']);
            
            // Generate PDF certificate
            $pdf_file = $this->generatePDFCertificate($sertifikat);
            
            // Update certificate with PDF file
            $this->M_sertifikat->update($sertifikat['id_sertifikat'], [
                'file_pdf' => $pdf_file,
                'qr_code' => $this->generateQRCode($sertifikat),
                'verification_url' => base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat'])
            ]);
        } else {
            session()->setFlashdata('error', 'Gagal membuat sertifikat! Pastikan siswa sudah menyelesaikan kursus dengan nilai yang valid (bukan 0).');
        }

        return redirect()->to(base_url('sertifikat/admin'));
    }

    /**
     * Admin bulk create certificates
     */
    public function admin_bulk_create()
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login'));
        }

        $pendaftaran_ids = $this->request->getPost('pendaftaran_ids');
        $success_count = 0;
        $error_count = 0;

        if (!empty($pendaftaran_ids)) {
            foreach ($pendaftaran_ids as $id_pendaftaran) {
                $sertifikat = $this->M_sertifikat->createFromPendaftaran($id_pendaftaran);
                
                if ($sertifikat) {
                    $pdf_file = $this->generatePDFCertificate($sertifikat);
                    $this->M_sertifikat->update($sertifikat['id_sertifikat'], [
                        'file_pdf' => $pdf_file,
                        'qr_code' => $this->generateQRCode($sertifikat),
                        'verification_url' => base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat'])
                    ]);
                    $success_count++;
                } else {
                    $error_count++;
                }
            }

            session()->setFlashdata('pesan', "Berhasil menerbitkan $success_count sertifikat. Gagal: $error_count");
        }

        return redirect()->to(base_url('sertifikat/admin'));
    }

    /**
     * Admin delete certificate
     */
    public function admin_delete($id_sertifikat)
    {
        if (!session()->get('id_karyawan')) {
            return redirect()->to(base_url('auth_login/login'));
        }

        $sertifikat = $this->M_sertifikat->find($id_sertifikat);
        if ($sertifikat) {
            // Delete PDF file
            if (!empty($sertifikat['file_pdf'])) {
                $file_path = WRITEPATH . 'uploads/sertifikat/' . $sertifikat['file_pdf'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $this->M_sertifikat->delete($id_sertifikat);
            
            // Update pendaftaran status
            $this->M_pendaftaran->update($sertifikat['id_pendaftaran'], [
                'sertifikat_dikirim' => 0,
                'tanggal_sertifikat' => null
            ]);

            session()->setFlashdata('pesan', 'Sertifikat berhasil dihapus!');
        }

        return redirect()->to(base_url('sertifikat/admin'));
    }

    // ================================
    // HELPER METHODS
    // ================================

    /**
     * Get courses that can be claimed by student
     */
    private function getPendingCourses($id_siswa)
    {
        return $this->M_pendaftaran
            ->select('p.*, k.nama_kursus, k.slug')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->where('p.id_siswa', $id_siswa)
            ->where('p.progress >=', 100)
            ->where('p.sertifikat_dikirim', 0)
            ->whereIn('p.status', ['aktif', 'selesai'])
            ->orderBy('p.tanggal_selesai', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Generate PDF certificate
     */
    private function generatePDFCertificate($sertifikat)
    {
        // Generate filename based on existing pattern
        $filename = 'CERT_' . strtoupper(str_replace(['/', '-'], '_', $sertifikat['nomor_sertifikat'])) . '.pdf';
        
        // Create directories if not exist
        $cert_dir = WRITEPATH . 'uploads/certificates/' . date('Y');
        $thumb_dir = WRITEPATH . 'uploads/certificates/' . date('Y') . '/thumbs';
        
        if (!is_dir($cert_dir)) {
            mkdir($cert_dir, 0755, true);
        }
        if (!is_dir($thumb_dir)) {
            mkdir($thumb_dir, 0755, true);
        }

        // TODO: Implement actual PDF generation with proper certificate design
        // For now, create a placeholder text file
        $content = "SERTIFIKAT KELULUSAN\n\n";
        $content .= "Nomor Sertifikat: " . $sertifikat['nomor_sertifikat'] . "\n";
        $content .= "QR Code: " . $sertifikat['qr_code'] . "\n";
        $content .= "Verification URL: " . $sertifikat['verification_url'] . "\n\n";
        $content .= "Nama Peserta: " . $sertifikat['nama_peserta'] . "\n";
        $content .= "Kursus: " . $sertifikat['nama_kursus'] . "\n";
        if (!empty($sertifikat['nama_paket'])) {
            $content .= "Paket: " . $sertifikat['nama_paket'] . "\n";
        }
        $content .= "Predikat: " . $sertifikat['predikat'] . "\n";
        $content .= "Nilai Akhir: " . $sertifikat['nilai_akhir'] . "\n";
        $content .= "Tanggal Mulai: " . $sertifikat['tanggal_mulai'] . "\n";
        $content .= "Tanggal Selesai: " . $sertifikat['tanggal_selesai'] . "\n";
        $content .= "Tanggal Terbit: " . $sertifikat['tanggal_terbit'] . "\n";
        $content .= "Diterbitkan oleh: " . $sertifikat['issued_by'] . "\n";
        $content .= "Status: " . ($sertifikat['is_verified'] ? 'Terverifikasi' : 'Belum Diverifikasi') . "\n";
        
        file_put_contents($cert_dir . '/' . $filename, $content);
        
        // Create thumbnail placeholder
        $thumb_content = "THUMBNAIL: " . $sertifikat['nomor_sertifikat'];
        file_put_contents($thumb_dir . '/' . str_replace('.pdf', '_thumb.pdf', $filename), $thumb_content);
        
        return date('Y') . '/' . $filename;
    }

    /**
     * Generate QR Code for certificate
     */
    private function generateQRCode($sertifikat)
    {
        try {
            // Check if QR code library is available
            if (class_exists('\Endroid\QrCode\QrCode')) {
                $qrCode = new \Endroid\QrCode\QrCode(base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']));
                $qrCode->setSize(200);
                $qrCode->setMargin(10);
                
                // Generate QR code image
                $writer = new \Endroid\QrCode\Writer\PngWriter();
                $qrImage = $qrCode->writeToString();
                
                // Save QR code image
                $qr_filename = 'qr_' . str_replace(['/', '-'], '_', $sertifikat['nomor_sertifikat']) . '.png';
                $qr_path = WRITEPATH . 'certificates/qr_codes/' . $qr_filename;
                
                // Create directory if not exists
                if (!is_dir(WRITEPATH . 'certificates/qr_codes')) {
                    mkdir(WRITEPATH . 'certificates/qr_codes', 0755, true);
                }
                
                file_put_contents($qr_path, $qrImage);
                
                // Return the filename for display
                return 'certificates/qr_codes/' . $qr_filename;
            } else {
                // Fallback: generate a simple data URI QR code using Google Charts API
                $qr_url = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode(base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']));
                return $qr_url;
            }
        } catch (\Exception $e) {
            // Fallback to verification URL
            return base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']);
        }
    }
}
