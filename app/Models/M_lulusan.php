<?php

namespace App\Models;

use CodeIgniter\Model;

class M_lulusan extends Model
{
    protected $table = 'lulusan';
    protected $primaryKey = 'id_lulusan';
    protected $allowedFields = [
        'nama_lulusan',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'nama_kursus',
        'tahun_lulus',
        'predikat',
        'nilai_akhir',
        'foto_lulusan',
        'status_pekerjaan',
        'nama_perusahaan',
        'jabatan',
        'kategori',
        'is_active',
        'deleted_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $returnType = 'array';

    // Get all lulusan with filtering
    public function getAllLulusan($status = null, $kategori = null, $perPage = 10)
    {
        $builder = $this->where('deleted_at IS NULL');

        if ($status) {
            $builder->where('is_active', $status);
        }

        if ($kategori) {
            $builder->where('kategori', $kategori);
        }

        return $builder->orderBy('tahun_lulus', 'DESC')
                     ->orderBy('created_at', 'DESC')
                     ->paginate($perPage);
    }

    // Get lulusan by ID
    public function getLulusanById($id)
    {
        return $this->where('id_lulusan', $id)
                   ->where('deleted_at IS NULL')
                   ->first();
    }

    // Get lulusan categories
    public function getCategories()
    {
        return [
            'Terbaik' => 'Terbaik',
            'Berprestasi' => 'Berprestasi',
            'Standar' => 'Standar'
        ];
    }

    // Get employment status options
    public function getEmploymentStatus()
    {
        return [
            'Bekerja' => 'Bekerja',
            'Wirausaha' => 'Wirausaha',
            'Melanjutkan Studi' => 'Melanjutkan Studi',
            'Menganggur' => 'Menganggur'
        ];
    }

    // Save lulusan data
    public function saveLulusan($data)
    {
        // Handle file upload for photo
        if (isset($data['foto_lulusan']) && is_object($data['foto_lulusan'])) {
            $file = $data['foto_lulusan'];
            if (method_exists($file, 'isValid') && $file->isValid() && method_exists($file, 'hasMoved') && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/lulusan/', $newName);
                $data['foto_lulusan'] = $newName;
            } else {
                unset($data['foto_lulusan']);
            }
        }

        return $this->insert($data);
    }

    // Update lulusan data
    public function updateLulusan($id, $data)
    {
        // Handle file upload for photo
        if (isset($data['foto_lulusan']) && is_object($data['foto_lulusan'])) {
            $file = $data['foto_lulusan'];
            if (method_exists($file, 'isValid') && $file->isValid() && method_exists($file, 'hasMoved') && !$file->hasMoved()) {
                // Delete old photo
                $oldData = $this->find($id);
                if ($oldData && $oldData['foto_lulusan']) {
                    $oldPhoto = FCPATH . 'uploads/lulusan/' . $oldData['foto_lulusan'];
                    if (file_exists($oldPhoto)) {
                        unlink($oldPhoto);
                    }
                }

                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/lulusan/', $newName);
                $data['foto_lulusan'] = $newName;
            } else {
                unset($data['foto_lulusan']);
            }
        }

        return $this->update($id, $data);
    }

    // Soft delete
    public function deleteLulusan($id)
    {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    // Get deleted lulusan
    public function getDeletedLulusan()
    {
        return $this->where('deleted_at IS NOT NULL')
                   ->orderBy('deleted_at', 'DESC')
                   ->findAll();
    }

    // Restore deleted lulusan
    public function restoreLulusan($id)
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    // Permanent delete
    public function forceDeleteLulusan($id)
    {
        $lulusan = $this->find($id);
        
        if ($lulusan && $lulusan['foto_lulusan']) {
            $photoPath = FCPATH . 'uploads/lulusan/' . $lulusan['foto_lulusan'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        
        return parent::delete($id);
    }

    // Get statistics
    public function getStatistics()
    {
        $db = \Config\Database::connect();
        
        $total = $this->where('deleted_at IS NULL')->countAllResults();
        $active = $this->where('deleted_at IS NULL')->where('is_active', 1)->countAllResults();
        $bekerja = $this->where('deleted_at IS NULL')->where('status_pekerjaan', 'Bekerja')->countAllResults();
        $wirausaha = $this->where('deleted_at IS NULL')->where('status_pekerjaan', 'Wirausaha')->countAllResults();
        
        return [
            'total' => $total,
            'active' => $active,
            'bekerja' => $bekerja,
            'wirausaha' => $wirausaha
        ];
    }
}
