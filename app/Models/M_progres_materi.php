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
        'progress_percent',
        'milestone_25',
        'milestone_50',
        'milestone_75',
        'milestone_100',
        'is_completed',
        'updated_at'
    ];

    public function updateProgressPercent($id_pendaftaran, $id_materi, $percent)
    {
        $percent = max(0, min(100, (int) $percent));
        $existing = $this->where('id_pendaftaran', $id_pendaftaran)
            ->where('id_materi', $id_materi)->first();
        
        $data = [
            'progress_percent' => $percent,
            'last_position'    => $percent,
            'updated_at'       => date('Y-m-d H:i:s'),
        ];
        
        // Set milestones
        if ($percent >= 25) $data['milestone_25'] = 1;
        if ($percent >= 50) $data['milestone_50'] = 1;
        if ($percent >= 75) $data['milestone_75'] = 1;
        if ($percent >= 100) {
            $data['milestone_100'] = 1;
            $data['is_completed'] = 1;
        }
        
        if ($existing) {
            return $this->update($existing['id_progres'], $data);
        } else {
            $data['id_pendaftaran'] = $id_pendaftaran;
            $data['id_materi'] = $id_materi;
            $data['is_completed'] = ($percent >= 100) ? 1 : 0;
            return $this->insert($data);
        }
    }

    public function getProgressPercent($id_pendaftaran, $id_materi)
    {
        $record = $this->where('id_pendaftaran', $id_pendaftaran)
            ->where('id_materi', $id_materi)->first();
        return $record ? (int) $record['progress_percent'] : 0;
    }

    public function getMilestones($id_pendaftaran, $id_materi)
    {
        $record = $this->where('id_pendaftaran', $id_pendaftaran)
            ->where('id_materi', $id_materi)->first();
        if (!$record) return ['25' => 0, '50' => 0, '75' => 0, '100' => 0];
        return [
            '25'  => (int) $record['milestone_25'],
            '50'  => (int) $record['milestone_50'],
            '75'  => (int) $record['milestone_75'],
            '100' => (int) $record['milestone_100'],
        ];
    }

    public function getProgressStats($id_pendaftaran)
    {
        $records = $this->where('id_pendaftaran', $id_pendaftaran)->findAll();
        $total = count($records);
        $completed = 0;
        $totalPercent = 0;
        $milestones = ['25' => 0, '50' => 0, '75' => 0, '100' => 0];
        
        foreach ($records as $r) {
            $totalPercent += (int) $r['progress_percent'];
            if ($r['is_completed']) $completed++;
            if ($r['milestone_25']) $milestones['25']++;
            if ($r['milestone_50']) $milestones['50']++;
            if ($r['milestone_75']) $milestones['75']++;
            if ($r['milestone_100']) $milestones['100']++;
        }
        
        return [
            'total_materi'  => $total,
            'completed'     => $completed,
            'avg_percent'   => $total > 0 ? round($totalPercent / $total, 1) : 0,
            'milestones'    => $milestones,
            'progress_percentage' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
        ];
    }
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
        $data = ['is_completed' => $is_completed, 'updated_at' => date('Y-m-d H:i:s')];
        return $this->updateProgres($id_pendaftaran, $id_materi, $data);
    }

    public function autoTrackProgress($id_pendaftaran, $id_materi, $position = null)
    {
        $existing = $this->where('id_pendaftaran', $id_pendaftaran)
            ->where('id_materi', $id_materi)->first();
        $data = [
            'last_position' => $position ?? ($existing['last_position'] ?? 0),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($existing) {
            return $this->update($existing['id_progres'], $data);
        }
        $data['id_pendaftaran'] = $id_pendaftaran;
        $data['id_materi'] = $id_materi;
        return $this->insert($data);
    }

    public function markCompleted($id_pendaftaran, $id_materi)
    {
        return $this->updateProgres($id_pendaftaran, $id_materi, [
            'is_completed' => 1,
            'last_position' => 100,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getCompletionPercentage($id_pendaftaran)
    {
        $totalMateri = $this->db->table('progres_materi')
            ->where('id_pendaftaran', $id_pendaftaran)
            ->countAllResults();
        $completedMateri = $this->db->table('progres_materi')
            ->where('id_pendaftaran', $id_pendaftaran)
            ->where('is_completed', 1)
            ->countAllResults();
        return $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100, 2) : 0;
    }

    public function getCompletedMateriCount($id_pendaftaran)
    {
        return $this->where('id_pendaftaran', $id_pendaftaran)->where('is_completed', 1)->countAllResults();
    }

    public function getActiveMateriCount($id_pendaftaran)
    {
        return $this->where('id_pendaftaran', $id_pendaftaran)->countAllResults();
    }
}
