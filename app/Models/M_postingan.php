<?php

namespace App\Models;

use CodeIgniter\Model;

class M_postingan extends Model
{
    protected $table = 'postingan';
    protected $primaryKey = 'id_postingan';
    protected $allowedFields = [
        'judul_postingan',
        'slug',
        'konten',
        'excerpt',
        'gambar_postingan',
        'kategori',
        'status',
        'penulis',
        'meta_description',
        'meta_keywords',
        'views'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $returnType = 'array';

    // Validasi rules
    protected $validationRules = [
        'judul_postingan' => 'required|max_length[255]',
        'slug' => 'required|max_length[255]',
        'konten' => 'required',
        'kategori' => 'required|max_length[100]',
        'penulis' => 'required|max_length[100]',
        'meta_description' => 'max_length[255]',
        'meta_keywords' => 'max_length[255]'
    ];

    protected $validationMessages = [
        'judul_postingan' => [
            'required' => 'Judul postingan wajib diisi',
            'max_length' => 'Judul postingan maksimal 255 karakter'
        ],
        'slug' => [
            'required' => 'Slug wajib diisi',
            'max_length' => 'Slug maksimal 255 karakter',
            'is_unique' => 'Slug sudah digunakan, pilih slug lain'
        ],
        'konten' => [
            'required' => 'Konten postingan wajib diisi'
        ],
        'penulis' => [
            'required' => 'Penulis wajib diisi',
            'max_length' => 'Nama penulis maksimal 100 karakter'
        ]
    ];

    // Get published posts
    public function getPublishedPosts($limit = null, $offset = 0)
    {
        $builder = $this->where('status', 'published')
                       ->where('deleted_at IS NULL')
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    // Get post by slug
    public function getPostBySlug($slug)
    {
        return $this->where('slug', $slug)
                   ->where('status', 'published')
                   ->where('deleted_at IS NULL')
                   ->first();
    }

    // Get all posts with pagination
    public function getAllPosts($status = null, $perPage = 10)
    {
        $builder = $this->where('deleted_at IS NULL');

        if ($status) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('created_at', 'DESC')
                     ->paginate($perPage);
    }

    // Get posts by category
    public function getPostsByCategory($category, $limit = null)
    {
        $builder = $this->where('kategori', $category)
                       ->where('status', 'published')
                       ->where('deleted_at IS NULL')
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    // Search posts
    public function searchPosts($keyword, $limit = null)
    {
        $builder = $this->like('judul_postingan', $keyword)
                       ->orLike('konten', $keyword)
                       ->orLike('excerpt', $keyword)
                       ->orLike('kategori', $keyword)
                       ->where('status', 'published')
                       ->where('deleted_at IS NULL')
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    // Increment views
    public function incrementViews($id_postingan)
    {
        $this->set('views', 'views + 1', false)
             ->where('id_postingan', $id_postingan)
             ->update();
    }

    // Get popular posts
    public function getPopularPosts($limit = 5)
    {
        return $this->where('status', 'published')
                   ->where('deleted_at IS NULL')
                   ->orderBy('views', 'DESC')
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->get()
                   ->getResultArray();
    }

    // Get recent posts
    public function getRecentPosts($limit = 5)
    {
        return $this->where('status', 'published')
                   ->where('deleted_at IS NULL')
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->get()
                   ->getResultArray();
    }

    // Generate unique slug
    public function generateSlug($title, $id = null)
    {
        $slug = url_title($title, '-', true);
        $originalSlug = $slug;
        $count = 1;

        while (true) {
            $builder = $this->where('slug', $slug);
            
            // Exclude current ID when updating
            if ($id) {
                $builder->where('id_postingan !=', $id);
            }
            
            $existing = $builder->first();

            if (!$existing) {
                break;
            }

            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    // Create excerpt from content
    public function createExcerpt($content, $length = 150)
    {
        $content = strip_tags($content);
        $content = preg_replace('/\s+/', ' ', $content);
        
        if (strlen($content) > $length) {
            $content = substr($content, 0, $length);
            $content = substr($content, 0, strrpos($content, ' '));
            $content .= '...';
        }

        return $content;
    }

    // Upload image
    public function uploadImage($file, $oldImage = null)
    {
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old image if exists
            if ($oldImage && file_exists(FCPATH . 'uploads/postingan/' . $oldImage)) {
                unlink(FCPATH . 'uploads/postingan/' . $oldImage);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/postingan/', $newName);
            
            return $newName;
        }

        return $oldImage;
    }

    // Soft delete (update deleted_at)
    public function delete($id = null, bool $purge = false)
    {
        if ($purge === false) {
            // Soft delete
            return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        } else {
            // Permanent delete
            return parent::delete($id);
        }
    }

    // ✅ GET ALL POSTINGAN
    public function getPostinganAll()
    {
        return $this->where('deleted_at IS NULL')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    // Get only deleted records
    public function onlyDeleted()
    {
        return $this->where('deleted_at IS NOT NULL')
                   ->orderBy('deleted_at', 'DESC');
    }

    // Restore soft deleted record
    public function restore($id)
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    // Permanent delete with cleanup
    public function forceDelete($id)
    {
        $post = $this->find($id);
        
        if ($post && $post['gambar_postingan']) {
            $imagePath = FCPATH . 'uploads/postingan/' . $post['gambar_postingan'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        return parent::delete($id);
    }
}
