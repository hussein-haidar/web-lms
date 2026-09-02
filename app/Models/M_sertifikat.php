<?php namespace App\Models;

use CodeIgniter\Model;

class M_sertifikat extends Model
{
    protected $table = 'sertifikat';
    protected $primaryKey = 'id_sertifikat';
    protected $allowedFields = [
        'id_pendaftaran',
        'id_kursus',
        'id_siswa',
        'nomor_sertifikat',
        'qr_code',
        'verification_url',
        'nama_peserta',
        'nama_kursus',
        'nama_paket',
        'nilai_akhir',
        'predikat',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_terbit',
        'file_pdf',
        'file_thumb',
        'is_active',
        'is_verified',
        'issued_by',
        'notes',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $returnType = 'array';

    // ✅ Generate nomor sertifikat otomatis: CERT/TAHUN/SLUG/URUTAN
    public function generateNomor($id_kursus)
    {
        $kursus = $this->db->table('kursus')
            ->select('slug')
            ->where('id_kursus', $id_kursus)
            ->get()
            ->getRowArray();
        
        $slug = $kursus['slug'] ?? 'kursus';
        $tahun = date('Y');
        
        $count = $this->db->table($this->table)
            ->where('id_kursus', $id_kursus)
            ->where('YEAR(tanggal_terbit)', $tahun)
            ->countAllResults();
        
        return sprintf('CERT/%s/%s/%06d', $tahun, strtoupper($slug), $count + 1);
    }

    // ✅ Buat sertifikat dari data pendaftaran
    public function createFromPendaftaran($id_pendaftaran)
    {
        $pendaftaran = $this->db->table('pendaftaran')
            ->select('pendaftaran.*, kursus.nama_kursus, kursus.slug, siswa.nama_lengkap')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa')
            ->where('pendaftaran.id_pendaftaran', $id_pendaftaran)
            ->get()
            ->getRowArray();
        
        // Log untuk debugging
        log_message('info', 'Creating certificate for pendaftaran ID: ' . $id_pendaftaran);
        log_message('info', 'Pendaftaran data: ' . json_encode($pendaftaran));
        
        if (!$pendaftaran || $pendaftaran['progress'] < 100) {
            log_message('warning', 'Certificate creation failed: Invalid pendaftaran or progress < 100');
            return false;
        }
        
        // Check if there's a valid score (not 0 or null)
        $nilai = $pendaftaran['nilai_akhir'] ?? 0;
        if ($nilai <= 0) {
            log_message('warning', 'Certificate creation failed: Invalid score (0 or negative): ' . $nilai);
            return false; // Don't create certificate for 0 or negative scores
        }
        
        $predikat = $this->getPredikat($nilai);
        log_message('info', 'Score: ' . $nilai . ', Predicate: ' . $predikat);
        
        // Generate nomor sertifikat
        $nomor_sertifikat = $this->generateNomor($pendaftaran['id_kursus']);
        
        // Generate QR code
        $qr_code = 'qr_' . str_replace(['/', '-'], '_', $nomor_sertifikat);
        
        // Generate verification URL
        $verification_url = base_url('sertifikat/verify/' . $nomor_sertifikat);
        
        $data = [
            'id_pendaftaran' => $pendaftaran['id_pendaftaran'],
            'id_kursus' => $pendaftaran['id_kursus'],
            'id_siswa' => $pendaftaran['id_siswa'],
            'nomor_sertifikat' => $nomor_sertifikat,
            'qr_code' => $qr_code,
            'verification_url' => $verification_url,
            'nama_peserta' => $pendaftaran['nama_lengkap'],
            'nama_kursus' => $pendaftaran['nama_kursus'],
            'nama_paket' => $pendaftaran['nama_paket'] ?? 'Standard', // Ambil dari pendaftaran jika ada
            'nilai_akhir' => $nilai,
            'predikat' => $predikat,
            'tanggal_mulai' => date('Y-m-d', strtotime($pendaftaran['tanggal_aktif'] ?? $pendaftaran['tanggal_pendaftaran'])),
            'tanggal_selesai' => date('Y-m-d'),
            'tanggal_terbit' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'is_verified' => 1,
            'issued_by' => session()->get('id_karyawan') ?? 0,
            'notes' => 'Sertifikat diterbitkan otomatis setelah penyelesaian kursus'
        ];
        
        $id_sertifikat = $this->insert($data);
        
        // Update status sertifikat di tabel_pendaftaran (jika field ada)
        $this->db->table('pendaftaran')
            ->where('id_pendaftaran', $id_pendaftaran)
            ->update([
                'sertifikat_dikirim' => 1,
                'tanggal_sertifikat' => date('Y-m-d H:i:s')
            ]);
        
        return $this->find($id_sertifikat);
    }

    // ✅ Helper: Konversi nilai ke predikat
    private function getPredikat($nilai)
    {
        if ($nilai >= 90) return 'Excellent';
        if ($nilai >= 80) return 'Very Good';
        if ($nilai >= 70) return 'Good';
        if ($nilai >= 60) return 'Pass';
        // Only return 'Need Improvement' if score is between 0-59, not for 0
        if ($nilai > 0 && $nilai < 60) return 'Need Improvement';
        // For 0 or null scores, return 'Not Assessed'
        return 'Not Assessed';
    }

    // ✅ Verifikasi sertifikat via QR/URL/Nomor
    public function verifyCertificate($kode)
    {
        return $this->db->table($this->table)
            ->where('nomor_sertifikat', $kode)
            ->orWhere('qr_code', $kode)
            ->orWhere('verification_url LIKE', "%{$kode}")
            ->where('is_active', 1)
            ->get()
            ->getRowArray();
    }

    // ✅ Get sertifikat siswa
    public function getBySiswa($id_siswa)
    {
        return $this->db->table($this->table)
            ->where('id_siswa', $id_siswa)
            ->where('is_active', 1)
            ->orderBy('tanggal_terbit', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ Get sertifikat pending untuk admin
    public function getPendingSertifikat()
    {
        return $this->db->table('pendaftaran')
            ->select('pendaftaran.*, siswa.nama_lengkap, kursus.nama_kursus')
            ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa')
            ->join('kursus', 'kursus.id_kursus = pendaftaran.id_kursus')
            ->where('pendaftaran.progress >=', 100)
            ->where('pendaftaran.sertifikat_dikirim', 0)
            ->whereIn('pendaftaran.status', ['aktif', 'selesai'])
            ->orderBy('pendaftaran.tanggal_selesai', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ PERBAIKI DATA SERTIFIKAT YANG NULL/KOSONG
    public function fixSertifikatData()
    {
        $fixed = 0;
        
        // 1. Perbaiki nilai_akhir dari pendaftaran
        $this->db->query("
            UPDATE sertifikat s
            JOIN pendaftaran p ON p.id_pendaftaran = s.id_pendaftaran
            SET s.nilai_akhir = p.nilai_akhir
            WHERE (s.nilai_akhir IS NULL OR s.nilai_akhir = 0) 
            AND p.nilai_akhir IS NOT NULL 
            AND p.nilai_akhir > 0
        ");
        $fixed += $this->db->affectedRows();
        
        // 2. Update predikat berdasarkan nilai_akhir yang baru
        $this->db->query("
            UPDATE sertifikat 
            SET predikat = CASE
                WHEN nilai_akhir >= 90 THEN 'Excellent'
                WHEN nilai_akhir >= 80 THEN 'Very Good'
                WHEN nilai_akhir >= 70 THEN 'Good'
                WHEN nilai_akhir >= 60 THEN 'Pass'
                WHEN nilai_akhir > 0 AND nilai_akhir < 60 THEN 'Need Improvement'
                ELSE 'Not Assessed'
            END
            WHERE nilai_akhir > 0
        ");
        $fixed += $this->db->affectedRows();
        
        // 3. Perbaiki tanggal_selesai dari pendaftaran
        $this->db->query("
            UPDATE sertifikat s
            JOIN pendaftaran p ON p.id_pendaftaran = s.id_pendaftaran
            SET s.tanggal_selesai = p.tanggal_selesai
            WHERE (s.tanggal_selesai IS NULL OR s.tanggal_selesai = '0000-00-00')
            AND p.tanggal_selesai IS NOT NULL
        ");
        $fixed += $this->db->affectedRows();
        
        // 4. Perbaiki issued_by yang kosong
        $this->db->query("
            UPDATE sertifikat 
            SET issued_by = 8 
            WHERE issued_by IS NULL OR issued_by = 0
        ");
        $fixed += $this->db->affectedRows();
        
        // 5. Perbaiki notes yang kosong
        $this->db->query("
            UPDATE sertifikat 
            SET notes = 'Sertifikat diterbitkan otomatis' 
            WHERE notes IS NULL OR notes = ''
        ");
        $fixed += $this->db->affectedRows();
        
        // 6. Generate thumbnail path jika kosong
        $this->db->query("
            UPDATE sertifikat 
            SET file_thumb = CONCAT(
                'certificates/thumbs/',
                REPLACE(REPLACE(nomor_sertifikat, '/', '_'), '-', '_'),
                '_thumb.jpg'
            )
            WHERE (file_thumb IS NULL OR file_thumb = '') 
            AND file_pdf IS NOT NULL 
            AND file_pdf != ''
        ");
        $fixed += $this->db->affectedRows();
        
        return $fixed;
    }

    // ✅ GET ALL SERTIFIKAT
    public function getSertifikatAll()
    {
        return $this->db->table($this->table . ' s')
            ->select('s.*, p.nama_lengkap as nama_siswa, k.nama_kursus')
            ->join('siswa p', 's.id_siswa = p.id_siswa')
            ->join('kursus k', 's.id_kursus = k.id_kursus')
            ->orderBy('s.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ HITUNG NILAI AKHIR DARI QUIZ UNTUK SERTIFIKAT
    public function hitungNilaiDariQuiz($id_pendaftaran)
    {
        $query = $this->db->query("
            SELECT AVG(qh.total_nilai) as rata_nilai, COUNT(*) as jumlah_quiz
            FROM quiz_hasil qh
            JOIN quiz q ON q.id_quiz = qh.id_quiz
            WHERE qh.id_pendaftaran = ?
        ", [$id_pendaftaran]);
        
        $result = $query->getRowArray();
        
        if ($result && $result['jumlah_quiz'] > 0) {
            return round($result['rata_nilai'], 2);
        }
        
        return null;
    }

    // ✅ SYNC SERTIFIKAT DENGAN DATA TERBARU
    public function syncSertifikat($id_sertifikat)
    {
        $sertifikat = $this->find($id_sertifikat);
        if (!$sertifikat) return false;
        
        // Ambil data terbaru dari pendaftaran
        $pendaftaran = $this->db->table('pendaftaran')
            ->where('id_pendaftaran', $sertifikat['id_pendaftaran'])
            ->get()
            ->getRowArray();
        
        if (!$pendaftaran) return false;
        
        $updateData = [];
        
        // Sync nilai_akhir
        if ($pendaftaran['nilai_akhir'] > 0) {
            $updateData['nilai_akhir'] = $pendaftaran['nilai_akhir'];
            $updateData['predikat'] = $this->getPredikat($pendaftaran['nilai_akhir']);
        }
        
        // Sync tanggal_selesai
        if ($pendaftaran['tanggal_selesai']) {
            $updateData['tanggal_selesai'] = $pendaftaran['tanggal_selesai'];
        }
        
        // Sync nama jika berubah
        if ($pendaftaran['nama_lengkap'] !== $sertifikat['nama_peserta']) {
            $updateData['nama_peserta'] = $pendaftaran['nama_lengkap'];
        }
        
        if (!empty($updateData)) {
            return $this->update($id_sertifikat, $updateData);
        }
        
        return true;
    }
}