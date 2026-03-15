<?php namespace App\Models;

use CodeIgniter\Model;

class M_diskusi extends Model
{
    protected $table = 'diskusi';
    protected $primaryKey = 'id_diskusi';
    protected $allowedFields = [
        'id_kursus',
        'id_modul',
        'id_pendaftaran',     // Jika diskusi private ke siswa tertentu
        'id_user',            // ID siswa/karyawan yang membuat
        'user_role',          // siswa/mentor/admin
        'user_name',          // Nama display (snapshot)
        'user_avatar',        // Foto profil (opsional)
        'judul',
        'slug',               // Untuk URL friendly
        'konten',
        'kategori',           // pertanyaan/diskusi/pengumuman
        'tags',               // JSON atau comma-separated
        'komentar_json',      // ✅ KOMENTAR DALAM JSON (nested replies)
        'total_views',
        'total_comments',
        'total_likes',
        'is_pinned',          // 1 = sticky di atas
        'is_locked',          // 1 = tidak bisa komentar lagi
        'status',             // open/answered/closed
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $returnType = 'array';

    // ✅ Generate slug dari judul
    public function generateSlug($judul)
    {
        $slug = url_title($judul, '-', true);
        $original = $slug;
        $count = 1;
        
        while ($this->where('slug', $slug)->countAllResults() > 0) {
            $slug = $original . '-' . $count;
            $count++;
        }
        return $slug;
    }

 // ✅ GANTI method getByKursus - HAPUS paginate(), pakai limit+offset
public function getByKursus($id_kursus, $filter = [], $limit = 20, $offset = 0)
{
    $builder = $this->db->table($this->table);
    
    $builder->select('diskusi.*')
        ->where('id_kursus', $id_kursus)
        ->where('is_locked', 0);
    
    // Filter kategori
    if (!empty($filter['kategori']) && $filter['kategori'] !== 'all') {
        $builder->where('kategori', $filter['kategori']);
    }
    
    // Filter status
    if (!empty($filter['status']) && $filter['status'] !== 'all') {
        $builder->where('status', $filter['status']);
    }
    
    // Search judul/konten
    if (!empty($filter['search'])) {
        $builder->groupStart()
            ->like('judul', $filter['search'])
            ->orLike('konten', $filter['search'])
            ->groupEnd();
    }
    
    // Order: pinned dulu, lalu terbaru/teraktif
    $orderBy = !empty($filter['sort']) ? $filter['sort'] : 'terbaru';
    if ($orderBy === 'teraktif') {
        $builder->orderBy('is_pinned', 'DESC')
                ->orderBy('updated_at', 'DESC');
    } else {
        $builder->orderBy('is_pinned', 'DESC')
                ->orderBy('created_at', 'DESC');
    }
    
    // ✅ PAKAI limit + offset (bukan paginate)
    return $builder->limit($limit, $offset)->get()->getResultArray();
}

// ✅ TAMBAH METHOD: Hitung total untuk pagination
public function countByKursus($id_kursus, $filter = [])
{
    $builder = $this->db->table($this->table);
    
    $builder->where('id_kursus', $id_kursus)
        ->where('is_locked', 0);
    
    if (!empty($filter['kategori']) && $filter['kategori'] !== 'all') {
        $builder->where('kategori', $filter['kategori']);
    }
    if (!empty($filter['status']) && $filter['status'] !== 'all') {
        $builder->where('status', $filter['status']);
    }
    if (!empty($filter['search'])) {
        $builder->groupStart()
            ->like('judul', $filter['search'])
            ->orLike('konten', $filter['search'])
            ->groupEnd();
    }
    
    return $builder->countAllResults();
}

    // ✅ Get single diskusi + decode komentar JSON
    public function getWithKomentar($id_diskusi)
    {
        $diskusi = $this->find($id_diskusi);
        if ($diskusi) {
            // Update view count
            $this->update($id_diskusi, ['total_views' => ($diskusi['total_views'] ?? 0) + 1]);
            
            // Decode komentar JSON ke array
            $diskusi['komentar'] = json_decode($diskusi['komentar_json'] ?? '[]', true);
            unset($diskusi['komentar_json']);
        }
        return $diskusi;
    }

    // ✅ Tambah komentar baru (nested via JSON)
    public function addKomentar($id_diskusi, $data)
    {
        $diskusi = $this->find($id_diskusi);
        if (!$diskusi) return false;
        
        $komentarLama = json_decode($diskusi['komentar_json'] ?? '[]', true);
        
        $komentarBaru = [
            'id' => uniqid('cmt_'),
            'id_user' => $data['id_user'],
            'user_name' => $data['user_name'],
            'user_role' => $data['user_role'],
            'user_avatar' => $data['user_avatar'] ?? '',
            'konten' => $data['konten'],
            'parent_id' => $data['parent_id'] ?? null, // Untuk nested reply
            'total_likes' => 0,
            'is_solution' => $data['is_solution'] ?? 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'replies' => [] // Untuk nested reply level 2+
        ];
        
        // Jika ada parent_id, masukkan ke replies parent
        if (!empty($data['parent_id'])) {
            $komentarLama = $this->insertNestedReply($komentarLama, $data['parent_id'], $komentarBaru);
        } else {
            $komentarLama[] = $komentarBaru;
        }
        
        // Update total_comments
        $totalComments = $this->countAllComments($komentarLama);
        
        // Jika komentar dari mentor & is_solution, update status diskusi
        $status = $diskusi['status'];
        if ($data['is_solution'] && $data['user_role'] === 'mentor') {
            $status = 'answered';
        }
        
        return $this->update($id_diskusi, [
            'komentar_json' => json_encode($komentarLama, JSON_UNESCAPED_UNICODE),
            'total_comments' => $totalComments,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    // ✅ Helper: Insert nested reply ke dalam array komentar
    private function insertNestedReply($comments, $parentId, $newReply)
    {
        foreach ($comments as &$comment) {
            if ($comment['id'] === $parentId) {
                if (!isset($comment['replies'])) {
                    $comment['replies'] = [];
                }
                $comment['replies'][] = $newReply;
                return $comments;
            }
            if (!empty($comment['replies'])) {
                $comment['replies'] = $this->insertNestedReply($comment['replies'], $parentId, $newReply);
            }
        }
        return $comments;
    }

    // ✅ Helper: Hitung total komentar termasuk nested
    private function countAllComments($comments)
    {
        $count = count($comments);
        foreach ($comments as $comment) {
            if (!empty($comment['replies'])) {
                $count += $this->countAllComments($comment['replies']);
            }
        }
        return $count;
    }

    // ✅ Set komentar sebagai solusi terbaik
    public function setSolution($id_diskusi, $komentarId)
    {
        $diskusi = $this->find($id_diskusi);
        if (!$diskusi) return false;
        
        $komentar = json_decode($diskusi['komentar_json'] ?? '[]', true);
        $komentar = $this->markAsSolution($komentar, $komentarId);
        
        return $this->update($id_diskusi, [
            'komentar_json' => json_encode($komentar, JSON_UNESCAPED_UNICODE),
            'status' => 'answered',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    // ✅ Helper: Mark comment as solution in nested array
    private function markAsSolution($comments, $targetId)
    {
        foreach ($comments as &$comment) {
            if ($comment['id'] === $targetId) {
                // Reset semua komentar lain di level ini
                foreach ($comments as &$c) {
                    $c['is_solution'] = 0;
                }
                $comment['is_solution'] = 1;
                return $comments;
            }
            if (!empty($comment['replies'])) {
                $comment['replies'] = $this->markAsSolution($comment['replies'], $targetId);
            }
        }
        return $comments;
    }

    // ✅ Like/unlike komentar
    public function toggleLike($id_diskusi, $komentarId, $id_user)
    {
        $diskusi = $this->find($id_diskusi);
        if (!$diskusi) return false;
        
        $komentar = json_decode($diskusi['komentar_json'] ?? '[]', true);
        $result = $this->incrementLike($komentar, $komentarId, $id_user);
        
        if ($result['success']) {
            return $this->update($id_diskusi, [
                'komentar_json' => json_encode($komentar, JSON_UNESCAPED_UNICODE),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        return false;
    }

    // ✅ Helper: Increment/decrement like
    private function incrementLike(&$comments, $targetId, $userId)
    {
        foreach ($comments as &$comment) {
            if ($comment['id'] === $targetId) {
                // Cek apakah user sudah like sebelumnya (simpan di session/localStorage di frontend)
                // Di sini kita asumsikan frontend yang manage state like
                $comment['total_likes'] = ($comment['total_likes'] ?? 0) + 1;
                return ['success' => true, 'new_count' => $comment['total_likes']];
            }
            if (!empty($comment['replies'])) {
                $result = $this->incrementLike($comment['replies'], $targetId, $userId);
                if ($result['success']) return $result;
            }
        }
        return ['success' => false];
    }

    // ✅ Get diskusi yang belum dijawab untuk mentor
    public function getUnansweredByKursus($id_kursus, $limit = 10)
    {
        return $this->db->table($this->table)
            ->where('id_kursus', $id_kursus)
            ->where('status', 'open')
            ->where('is_locked', 0)
            ->orderBy('created_at', 'ASC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    // ✅ Search diskusi global
    public function search($keyword, $id_kursus = null, $limit = 20)
    {
        $builder = $this->db->table($this->table);
        
        $builder->select('id_diskusi, judul, slug, konten, kategori, status, total_views, total_comments, created_at')
            ->groupStart()
                ->like('judul', $keyword)
                ->orLike('konten', $keyword)
                ->orLike('tags', $keyword)
            ->groupEnd()
            ->where('is_locked', 0);
        
        if ($id_kursus) {
            $builder->where('id_kursus', $id_kursus);
        }
        
        return $builder->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    // ✅ Delete diskusi (soft delete via status)
    public function softDelete($id_diskusi)
    {
        return $this->update($id_diskusi, [
            'status' => 'closed',
            'is_locked' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}