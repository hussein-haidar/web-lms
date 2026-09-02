<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;

class ChatSiswa extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $chats = $this->db->table('chat c')
            ->select('c.*, 
                CASE WHEN c.id_pengirim = ? THEN c.id_penerima ELSE c.id_pengirim END as other_id,
                CASE WHEN c.id_pengirim = ? THEN c.role_penerima ELSE c.role_pengirim END as other_role', [$id_siswa, $id_siswa])
            ->where('c.id_pengirim', $id_siswa)
            ->orWhere('c.id_penerima', $id_siswa)
            ->orderBy('c.created_at', 'DESC')
            ->groupBy('other_id, other_role')
            ->get()
            ->getResultArray();

        $data = [
            'title'  => 'Chat',
            'title2' => 'Pesan',
            'chats'  => $chats,
        ];

        return view('backend/siswa/chat/v_index', $data);
    }

    public function conversation($other_id, $other_role = 'pengajar')
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        if (!is_numeric($other_id)) {
            return redirect()->to(base_url('siswa/chat'));
        }

        $messages = $this->db->table('chat')
            ->where('id_pengirim', $id_siswa)
            ->where('id_penerima', $other_id)
            ->orWhere(function ($query) use ($other_id, $id_siswa) {
                $query->where('id_pengirim', $other_id)
                      ->where('id_penerima', $id_siswa);
            })
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();

        $this->db->table('chat')
            ->where('id_penerima', $id_siswa)
            ->where('id_pengirim', $other_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $other = null;
        if ($other_role == 'pengajar' || $other_role == 'karyawan') {
            $other = $this->db->table('karyawan')->where('id_karyawan', $other_id)->getRowArray();
        }

        $data = [
            'title'     => 'Chat',
            'title2'    => 'Pesan dengan ' . ($other['nama_lengkap'] ?? 'Pengajar'),
            'messages'  => $messages,
            'other'     => $other,
            'other_id'  => $other_id,
            'other_role' => $other_role,
        ];

        return view('backend/siswa/chat/v_conversation', $data);
    }

    public function send()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $id_penerima = $this->request->getPost('id_penerima');
        $role_penerima = $this->request->getPost('role_penerima') ?? 'pengajar';
        $pesan = $this->request->getPost('pesan');

        if (empty($pesan) || empty($id_penerima)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pesan tidak boleh kosong']);
        }

        $this->db->table('chat')->insert([
            'id_pengirim'   => $id_siswa,
            'role_pengirim' => 'siswa',
            'id_penerima'   => $id_penerima,
            'role_penerima' => $role_penerima,
            'pesan'         => $pesan,
            'is_read'       => 0,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Pesan terkirim',
            'timestamp' => date('Y-m-d H:i:s'),
        ]);
    }

    public function ajax_messages($other_id)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        if (!is_numeric($other_id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid ID']);
        }

        $last_id = $this->request->getGet('last_id') ?? 0;

        $messages = $this->db->table('chat')
            ->where('id >', $last_id)
            ->where('id_pengirim', $id_siswa)
            ->where('id_penerima', $other_id)
            ->orWhere(function ($query) use ($other_id, $id_siswa, $last_id) {
                $query->where('id >', $last_id)
                      ->where('id_pengirim', $other_id)
                      ->where('id_penerima', $id_siswa);
            })
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        if (!empty($messages)) {
            $this->db->table('chat')
                ->where('id_penerima', $id_siswa)
                ->where('id_pengirim', $other_id)
                ->where('is_read', 0)
                ->update(['is_read' => 1]);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'messages' => $messages,
        ]);
    }

    public function ajax_unread_count()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['count' => 0]);
        }

        $count = $this->db->table('chat')
            ->where('id_penerima', $id_siswa)
            ->where('role_penerima', 'siswa')
            ->where('is_read', 0)
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }
}
