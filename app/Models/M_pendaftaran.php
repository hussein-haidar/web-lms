<?php

namespace App\Models;

use CodeIgniter\Model;

class M_pendaftaran extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id_pendaftaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // ✅ ALLOWED FIELDS LENGKAP (sesuai struktur tabel aktual)
    protected $allowedFields = [
        // 🔗 Foreign Keys
        'id_siswa',
        'kode_invoice',
        'id_kursus',

        // 💰 Paket & Pembayaran
        'nama_paket',
        'harga_kursus',

        // 📊 Status & Progress
        'status',            // pending/aktif/selesai/dibatalkan
        'tanggal_pendaftaran',
        'tanggal_konfirmasi', // Tanggal konfirmasi pembayaran
        'tanggal_aktif',
        'progress',          // Persentase penyelesaian (0-100)
        'tanggal_selesai',   // Tanggal kursus selesai
        'last_accessed',     // Waktu terakhir akses materi

        // 📝 Catatan & Evaluasi
        'nilai_akhir',       // Nilai evaluasi akhir
        'sertifikat_dikirim', // Status pengiriman sertifikat
        'tanggal_sertifikat',

        // 👤 Data Pribadi Siswa
        'email',
        'nama_lengkap',
        'foto_profil',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'no_telepon',
        'alamat',
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    protected $allowCallbacks = true;

    // ✅ GET PENDAFTARAN BY SISWA
    public function getBySiswa($id_siswa, $status = null)
    {
        $builder = $this->db->table($this->table . ' p')
            ->select('p.*, k.nama_kursus, k.slug, k.gambar_utama, k.id_karyawan,
                     dk.gambar_detail_a, pk.nama_program, pkt.nama_paket, pkt.total_pertemuan, pb.status_pembayaran,
                     kar.nama_lengkap as nama_instruktur,
                     (SELECT COUNT(q.id_quiz) FROM quiz q WHERE q.id_kursus = k.id_kursus) as jumlah_quiz')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->join('karyawan kar', 'kar.id_karyawan = k.id_karyawan', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pk', 'pk.id_program = k.id_program', 'left')
            ->join('paket_kursus pkt', 'pkt.id_kursus = k.id_kursus', 'left')
            ->join('pembayaran pb', 'pb.kode_invoice = p.kode_invoice', 'left')
            ->where('p.id_siswa', $id_siswa);

        if (!empty($status)) {
            $builder->where('p.status', $status);
        }

        return $builder->orderBy('p.tanggal_pendaftaran', 'DESC')->get()->getResultArray();
    }

    public function getEnrolledCoursesForDashboard($id_siswa)
    {
        return $this->db->table('pendaftaran p')
            ->select('p.*, k.nama_kursus, k.gambar_utama, k.deskripsi_singkat, tp.status_pembayaran as status_pembelian, p.kode_invoice as kode_pembelian, tp.jumlah_bayar as total_bayar')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->join('pembayaran tp', 'tp.kode_invoice = p.kode_invoice', 'left')
            ->where('p.id_siswa', $id_siswa)
            ->whereNotIn('p.status', ['dibatalkan'])
            ->orderBy('p.tanggal_pendaftaran', 'DESC')
            ->get()->getResultArray();
    }

    // ✅ CLEANUP DATA EXPIRED (auto delete)
    public function cleanupExpired()
    {
        $db = \Config\Database::connect();
        $dua_jam_lalu = date('Y-m-d H:i:s', strtotime('-2 hours'));

        // Hapus pendaftaran yang pending lebih dari batas waktu (otomatis invoice batal)
        $this->where('status', 'pending')
            ->where('tanggal_pendaftaran <', $dua_jam_lalu)
            ->delete();
    }

    // ✅ UPDATE PROGRESS SISWA
    public function updateProgress($id_pendaftaran, $progress)
    {
        return $this->update($id_pendaftaran, [
            'progress' => $progress,
            'last_accessed' => date('Y-m-d H:i:s')
        ]);
    }

    // ✅ GET DETAIL PENDAFTARAN
    public function detailDaftar($id_pendaftaran)
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, k.nama_kursus, k.slug, dk.gambar_detail_a, pk.nama_program, k.deskripsi_singkat, dk.materi_yang_dipelajari, pkt.durasi_per_pertemuan_jam, pkt.total_pertemuan, pkt.harga_reguler as harga,
                     pb.status_pembayaran, pb.jumlah_bayar, pb.metode_pembayaran, pb.tanggal_konfirmasi as pembayaran_tanggal_konfirmasi,
                     (SELECT COUNT(q.id_quiz) FROM quiz q WHERE q.id_kursus = k.id_kursus) as jumlah_quiz')
            ->join('kursus k', 'k.id_kursus = p.id_kursus', 'left')
            ->join('detail_kursus dk', 'dk.id_kursus = k.id_kursus', 'left')
            ->join('program_kursus pk', 'pk.id_program = k.id_program', 'left')
            ->join('paket_kursus pkt', 'pkt.id_kursus = k.id_kursus', 'left')
            ->join('pembayaran pb', 'pb.kode_invoice = p.kode_invoice', 'left')
            ->where('p.id_pendaftaran', $id_pendaftaran)
            ->get()
            ->getRowArray();
    }

    // ✅ SIMPAN PENDAFTARAN
    public function simpanDaftar($data)
    {
        // Generate kode invoice unik
        $kode_invoice = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());
        
        $data['kode_invoice'] = $kode_invoice;
        $data['tanggal_pendaftaran'] = date('Y-m-d H:i:s');
        $data['status'] = 'pending';
        
        return $this->insert($data);
    }

    // ✅ UPDATE PENDAFTARAN
    public function updateDaftar($id_pendaftaran, $data)
    {
        return $this->update($id_pendaftaran, $data);
    }

    // ✅ DELETE PENDAFTARAN
    public function deletedDaftar($id_pendaftaran)
    {
        return $this->delete($id_pendaftaran);
    }

    // ✅ GET PENDAFTARAN PENDING
    public function getPendaftaranPending()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, s.nama_lengkap, s.email, s.no_telepon, k.nama_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->where('p.status', 'pending')
            ->orderBy('p.tanggal_pendaftaran', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ✅ GET PENDAFTARAN BY INVOICE
    public function getByInvoice($kode_invoice)
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, s.nama_lengkap, s.email, s.no_telepon, k.nama_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->where('p.kode_invoice', $kode_invoice)
            ->get()
            ->getRowArray();
    }

    // ✅ UPDATE STATUS PENDAFTARAN
    public function updateStatus($id_pendaftaran, $status, $data = [])
    {
        $updateData = array_merge(['status' => $status], $data);
        
        if ($status == 'aktif') {
            $updateData['tanggal_aktif'] = date('Y-m-d H:i:s');
        }
        
        return $this->update($id_pendaftaran, $updateData);
    }

    // ✅ HITUNG NILAI AKHIR OTOMATIS DARI QUIZ
    public function hitungNilaiAkhir($id_pendaftaran)
    {
        $db = \Config\Database::connect();
        
        // Ambil data pendaftaran untuk mendapatkan id_kursus
        $pendaftaran = $this->find($id_pendaftaran);
        if (!$pendaftaran) {
            return false;
        }

        // Ambil semua quiz untuk kursus ini
        $quiz_results = $db->table('quiz_hasil qh')
            ->select('AVG(qh.total_nilai) as nilai_akhir')
            ->join('quiz q', 'q.id_quiz = qh.id_quiz')
            ->join('modul m', 'm.id_modul = q.id_modul')
            ->join('pendaftaran p', 'p.id_pendaftaran = qh.id_pendaftaran')
            ->where('p.id_kursus', $pendaftaran['id_kursus'])
            ->where('qh.is_lulus', 1)
            ->where('p.id_pendaftaran', $id_pendaftaran)
            ->get()
            ->getRowArray();

        $nilai_akhir = $quiz_results ? round($quiz_results['nilai_akhir']) : 0;

        // Update nilai akhir di tabel pendaftaran
        $this->update($id_pendaftaran, ['nilai_akhir' => $nilai_akhir]);

        return $nilai_akhir;
    }

    // ✅ GET ALL INVENTORY
    public function getAllInventory()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, s.nama_lengkap as nama_siswa, k.nama_kursus')
            ->join('siswa s', 'p.id_siswa = s.id_siswa', 'left')
            ->join('kursus k', 'p.id_kursus = k.id_kursus', 'left')
            ->orderBy('p.tanggal_pendaftaran', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ GET PENDAFTARAN WITH SISWA
    public function getPendaftaranWithSiswa()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, s.nama_lengkap, s.email, s.no_telepon, k.nama_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->orderBy('p.tanggal_pendaftaran', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ GET SISWA BY PENGAJAR
    public function getSiswaByPengajar($id_karyawan)
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, s.nama_lengkap, s.email, s.no_telepon, k.nama_kursus')
            ->join('siswa s', 's.id_siswa = p.id_siswa')
            ->join('kursus k', 'k.id_kursus = p.id_kursus')
            ->where('k.id_pengajar', $id_karyawan)
            ->orWhere('k.id_karyawan', $id_karyawan)
            ->orderBy('p.tanggal_pendaftaran', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ GET TUGAS BY PENGAJAR
    public function getTugasByPengajar($id_karyawan)
    {
        return $this->db->table('tugas t')
            ->select('t.*, k.nama_kursus')
            ->join('kursus k', 'k.id_kursus = t.id_kursus')
            ->where('k.id_pengajar', $id_karyawan)
            ->orWhere('k.id_karyawan', $id_karyawan)
            ->orderBy('t.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    // ✅ INSERT TUGAS
    public function insertTugas($data)
    {
        return $this->db->table('tugas')->insert($data);
    }

    // ✅ GET TUGAS BY ID
    public function getTugasById($id_tugas)
    {
        return $this->db->table('tugas')
            ->where('id_tugas', $id_tugas)
            ->get()
            ->getRowArray();
    }
}
