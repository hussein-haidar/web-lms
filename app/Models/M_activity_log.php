<?php

namespace App\Models;

use CodeIgniter\Model;

class M_activity_log extends Model
{
    protected $table = 'activity_log';
    protected $primaryKey = 'id_log';
    protected $allowedFields = [
        'id_user',
        'user_role',
        'user_name',
        'action',
        'description',
        'model',
        'model_id',
        'ip_address',
        'user_agent',
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    public static function log($action, $description = null, $model = null, $modelId = null)
    {
        $session = session();

        $data = [
            'id_user'     => $session->get('id_siswa') ?? $session->get('id_karyawan') ?? $session->get('id_superadmin') ?? null,
            'user_role'   => $session->get('level') ?? null,
            'user_name'   => $session->get('nama_lengkap') ?? 'System',
            'action'      => $action,
            'description' => $description,
            'model'       => $model,
            'model_id'    => $modelId,
            'ip_address'  => service('request')->getIPAddress(),
            'user_agent'  => service('request')->getUserAgent()->toString(),
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $db = \Config\Database::connect();
        $db->table('activity_log')->insert($data);
    }

    public function getLogs($limit = 100, $offset = 0, $filters = [])
    {
        $builder = $this->db->table('activity_log');

        if (!empty($filters['user_role'])) {
            $builder->where('user_role', $filters['user_role']);
        }
        if (!empty($filters['action'])) {
            $builder->where('action', $filters['action']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('user_name', $filters['search'])
                ->orLike('description', $filters['search'])
                ->orLike('action', $filters['search'])
                ->groupEnd();
        }

        return $builder->orderBy('created_at', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    public function countAllFiltered($filters = [])
    {
        $builder = $this->db->table('activity_log');

        if (!empty($filters['user_role'])) {
            $builder->where('user_role', $filters['user_role']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('user_name', $filters['search'])
                ->orLike('description', $filters['search'])
                ->groupEnd();
        }

        return $builder->countAllResults();
    }
}
