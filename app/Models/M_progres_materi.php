<?php

namespace App\Models;

use CodeIgniter\Model;

class M_progres_materi extends Model
{
    protected $table = 'progres_materi';
    protected $primaryKey = 'id_progres';
    protected $allowedFields = [
        'id_pendaftaran',
        'id_materi',
        'last_position',
        'is_completed',
        'updated_at'
    ];
    protected $useTimestamps = false; // Managed manually or via DB DEFAULT

    public function getProgresPendaftaran($id_pendaftaran)
    {
        return $this->where('id_pendaftaran', $id_pendaftaran)->findAll();
    }

    public function updateProgres($id_pendaftaran, $id_materi, $data)
    {
        $existing = $this->where('id_pendaftaran', $id_pendaftaran)
            ->where('id_materi', $id_materi)
            ->first();

        if ($existing) {
            return $this->update($existing['id_progres'], $data);
        } else {
            $data['id_pendaftaran'] = $id_pendaftaran;
            $data['id_materi'] = $id_materi;
            return $this->insert($data);
        }
    }

    // ✅ UPDATE PROGRESS MATERI
    public function updateProgress($id_pendaftaran, $id_materi, $is_completed)
    {
        $data = [
            'is_completed' => $is_completed,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->updateProgres($id_pendaftaran, $id_materi, $data);
    }
}
