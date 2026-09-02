<?php

namespace App\Models;

use CodeIgniter\Model;

class M_materi extends Model
{
    protected $table            = 'materi';
    protected $primaryKey       = 'id_materi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_modul',
        'id_kursus',
        'judul_materi',
        'tipe_materi',
        'url_youtube',
        'konten_text',
        'deskripsi_materi',
        'urutan',
        'is_preview',
        'prerequisite_id',
        'status',
        'tanggal_dibuat'
    ];

    // Dates
    protected $useTimestamps = false;

    /**
     * Get materi by Modul ID
     */
    public function getByModul($id_modul, $id_pendaftaran = null)
    {
        $materi = $this->where('id_modul', $id_modul)
            ->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->findAll();
            
        // Add progress tracking if pendaftaran ID is provided
        if ($id_pendaftaran && !empty($materi)) {
            $db = \Config\Database::connect();
            foreach ($materi as &$m) {
                $progress = $db->table('progres_materi')
                    ->where('id_pendaftaran', $id_pendaftaran)
                    ->where('id_materi', $m['id_materi'])
                    ->get()
                    ->getRowArray();
                $m['is_completed'] = $progress ? 1 : 0;
                $m['updated_at'] = $progress ? $progress['updated_at'] : null;
                // Add durasi field - check if it exists in the materi table
                $m['durasi'] = $m['durasi'] ?? '0';
                // If durasi doesn't exist in materi table, set a default value
                if (!isset($m['durasi'])) {
                    $m['durasi'] = '30'; // Default 30 minutes
                }
            }
        }
        
        return $materi;
    }

    /**
     * Get materi by Modul ID (alias for consistency)
     */
    public function getMateriByModul($id_modul)
    {
        return $this->getByModul($id_modul);
    }

    /**
     * Get counts of video, zoom, quiz, and text materials for a course
     */
    public function getMateriStats($id_kursus)
    {
        return $this->select('tipe_materi, COUNT(*) as total')
            ->where('id_kursus', $id_kursus)
            ->where('status', 'aktif')
            ->groupBy('tipe_materi')
            ->findAll();
    }

    // ✅ Check if prerequisite is completed
    public function isPrerequisiteCompleted($id_materi, $id_pendaftaran)
    {
        $materi = $this->find($id_materi);
        if (!$materi || empty($materi['prerequisite_id'])) {
            return true; // No prerequisite
        }

        $db = \Config\Database::connect();
        $progress = $db->table('progres_materi')
            ->where('id_pendaftaran', $id_pendaftaran)
            ->where('id_materi', $materi['prerequisite_id'])
            ->where('is_completed', 1)
            ->countAllResults();

        return $progress > 0;
    }

    // ✅ Get materi list with prerequisite status
    public function getByModulWithPrerequisite($id_modul, $id_pendaftaran = null)
    {
        $materiList = $this->getByModul($id_modul, $id_pendaftaran);

        if ($id_pendaftaran) {
            foreach ($materiList as &$m) {
                $m['prerequisite_completed'] = $this->isPrerequisiteCompleted($m['id_materi'], $id_pendaftaran);
            }
        }

        return $materiList;
    }
}
