<?php

namespace App\Models;

use CodeIgniter\Model;

class M_backup extends Model
{
    protected $table = 'backup_log';
    protected $primaryKey = 'id_backup';
    protected $allowedFields = [
        'filename',
        'filepath',
        'filesize',
        'backup_type',
        'created_by',
        'created_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $returnType = 'array';
    
    public function getBackupList()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
    
    public function getBackupById($id_backup)
    {
        return $this->find($id_backup);
    }
    
    public function saveBackup($data)
    {
        return $this->insert($data);
    }
    
    public function deleteBackup($id_backup)
    {
        return $this->delete($id_backup);
    }
    
    public function getBackupStats()
    {
        return [
            'total_backups' => $this->countAll(),
            'total_size' => $this->selectSum('filesize')->get()->getRow()->filesize ?? 0,
            'last_backup' => $this->orderBy('created_at', 'DESC')->get()->getRow()
        ];
    }
}
