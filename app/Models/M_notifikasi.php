<?php

namespace App\Models;

use CodeIgniter\Model;

class M_notifikasi extends Model
{
    protected $table            = 'notifikasi';
    protected $primaryKey       = 'id_notifikasi';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $allowedFields    = [
        'id_user', 'user_role', 'judul', 'pesan', 'tipe', 'link', 'is_read'
    ];

    public function getByUser($id_user, $user_role, $limit = 50, $offset = 0)
    {
        return $this->where('id_user', $id_user)
            ->where('user_role', $user_role)
            ->orderBy('is_read', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll($limit, $offset);
    }

    public function getUnreadCount($id_user, $user_role)
    {
        return $this->where('id_user', $id_user)
            ->where('user_role', $user_role)
            ->where('is_read', 0)
            ->countAllResults();
    }

    public function markAsRead($id_notifikasi)
    {
        return $this->update($id_notifikasi, ['is_read' => 1]);
    }

    public function markAllAsRead($id_user, $user_role)
    {
        return $this->where('id_user', $id_user)
            ->where('user_role', $user_role)
            ->set('is_read', 1)
            ->update();
    }

    public function addNotification($id_user, $user_role, $judul, $pesan, $tipe = 'info', $link = null)
    {
        return $this->insert([
            'id_user'     => $id_user,
            'user_role'   => $user_role,
            'judul'       => $judul,
            'pesan'       => $pesan,
            'tipe'        => $tipe,
            'link'        => $link,
            'is_read'     => 0,
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }

    public function getUnreadForAll($user_role, $limit = 20)
    {
        return $this->where('user_role', $user_role)
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    public function deleteOld($days = 30)
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        return $this->where('created_at <', $date)->delete();
    }

    public function getDashboardStats($user_role)
    {
        return $this->db->table($this->table)
            ->select('tipe, COUNT(*) as total')
            ->where('user_role', $user_role)
            ->where('is_read', 0)
            ->groupBy('tipe')
            ->get()
            ->getResultArray();
    }
}
