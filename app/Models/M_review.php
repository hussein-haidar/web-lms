<?php

namespace App\Models;

use CodeIgniter\Model;

class M_review extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'id_review';
    protected $allowedFields = [
        'id_pendaftaran',
        'id_kursus',
        'id_siswa',
        'rating_overall',
        'rating_materi',
        'rating_mentor',
        'review_title',
        'review_text',
        'pros',
        'cons',
        'is_verified',
        'is_visible',
        'helpful_count'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $returnType = 'array';

    protected $validationRules = [
        'rating_overall' => 'required|integer|in_list[1,2,3,4,5]'
    ];

    // ✅ Get review by kursus WITH nama siswa (for public display)
    public function getByKursusWithSiswa($id_kursus, $limit = 10)
    {
        return $this->db->table('review r')
            ->select('r.*, s.nama_lengkap, s.foto_profil')
            ->join('siswa s', 's.id_siswa = r.id_siswa', 'left')
            ->where('r.id_kursus', $id_kursus)
            ->where('r.is_visible', 1)
            ->orderBy('r.created_at', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    // ✅ Get review by kursus (simple)
    public function getByKursus($id_kursus, $limit = 5)
    {
        return $this->where('id_kursus', $id_kursus)
            ->where('is_visible', 1)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // ✅ Get average rating
    public function getAverageRating($id_kursus)
    {
        return $this->select('
            AVG(rating_overall) as avg_rating,
            AVG(rating_materi) as avg_materi,
            AVG(rating_mentor) as avg_mentor,
            COUNT(*) as total_review
        ')
            ->where('id_kursus', $id_kursus)
            ->where('is_visible', 1)
            ->first();
    }

    // ✅ Check if student already reviewed
    public function alreadyReviewed($id_pendaftaran)
    {
        return $this->where('id_pendaftaran', $id_pendaftaran)->first();
    }

    // ✅ Get semua review milik siswa
    public function getReviewSaya($id_siswa)
    {
        return $this->db->table('review r')
            ->select('r.*, k.nama_kursus, k.gambar_utama')
            ->join('kursus k', 'k.id_kursus = r.id_kursus', 'left')
            ->where('r.id_siswa', $id_siswa)
            ->orderBy('r.created_at', 'DESC')
            ->get()->getResultArray();
    }
}
