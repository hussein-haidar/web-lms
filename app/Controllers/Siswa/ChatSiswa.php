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

        // Get last message per conversation
        $chats = $this->db->table('chat c')
            ->select('c.*, 
                CASE WHEN c.id_pengirim = ? THEN c.id_penerima ELSE c.id_pengirim END as other_id,
                CASE WHEN c.id_pengirim = ? THEN c.role_penerima ELSE c.role_pengirim END as other_role,
                (SELECT pesan FROM chat WHERE (id_pengirim = c.id_pengirim AND id_penerima = c.id_penerima) OR (id_pengirim = c.id_penerima AND id_penerima = c.id_pengirim) ORDER BY id DESC LIMIT 1) as last_message,
                (SELECT created_at FROM chat WHERE (id_pengirim = c.id_pengirim AND id_penerima = c.id_penerima) OR (id_pengirim = c.id_penerima AND id_penerima = c.id_pengirim) ORDER BY id DESC LIMIT 1) as last_time', [$id_siswa, $id_siswa])
            ->where('c.id_pengirim', $id_siswa)
            ->orWhere('c.id_penerima', $id_siswa)
            ->orderBy('c.created_at', 'DESC')
            ->groupBy('other_id, other_role')
            ->get()
            ->getResultArray();

        // Get other user info
        foreach ($chats as &$chat) {
            $other_id = $chat['other_id'];
            $other_role = $chat['other_role'];
            
            if ($other_role === 'siswa') {
                $other = $this->db->table('siswa')->where('id_siswa', $other_id)->getRowArray();
            } else {
                $other = $this->db->table('karyawan')->where('id_karyawan', $other_id)->getRowArray();
            }
            $chat['other_name'] = $other['nama_lengkap'] ?? 'Unknown';
            $chat['other_foto'] = $other['foto_profil'] ?? null;
            
            // Unread count per conversation
            $chat['unread_count'] = $this->db->table('chat')
                ->where('id_penerima', $id_siswa)
                ->where('id_pengirim', $other_id)
                ->where('is_read', 0)
                ->countAllResults();
        }

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

        // FIXED: Use groupStart/groupEnd to prevent orWhere bug
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $messages = $this->db->table('chat')
            ->groupStart()
                ->where('id_pengirim', $id_siswa)
                ->where('id_penerima', $other_id)
            ->groupEnd()
            ->orGroupStart()
                ->where('id_pengirim', $other_id)
                ->where('id_penerima', $id_siswa)
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        // Mark as read
        $this->db->table('chat')
            ->where('id_penerima', $id_siswa)
            ->where('id_pengirim', $other_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);

        // Get other user info (siswa or karyawan)
        $other = null;
        if ($other_role === 'siswa') {
            $other = $this->db->table('siswa')->where('id_siswa', $other_id)->getRowArray();
        } else {
            $other = $this->db->table('karyawan')->where('id_karyawan', $other_id)->getRowArray();
        }

        // Total messages for pagination
        $totalMessages = $this->db->table('chat')
            ->groupStart()
                ->where('id_pengirim', $id_siswa)
                ->where('id_penerima', $other_id)
            ->groupEnd()
            ->orGroupStart()
                ->where('id_pengirim', $other_id)
                ->where('id_penerima', $id_siswa)
            ->groupEnd()
            ->countAllResults();

        $data = [
            'title'         => 'Chat',
            'title2'        => 'Pesan dengan ' . ($other['nama_lengkap'] ?? 'Pengajar'),
            'messages'      => $messages,
            'other'         => $other,
            'other_id'      => $other_id,
            'other_role'    => $other_role,
            'total_messages' => $totalMessages,
            'current_page'  => (int) $page,
            'per_page'      => $perPage,
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
        $reply_to = $this->request->getPost('reply_to');

        if (empty($pesan) && empty($this->request->getFile('file'))) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pesan tidak boleh kosong']);
        }

        // Handle file upload
        $file = $this->request->getFile('file');
        $fileName = null;
        $fileType = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Tipe file tidak didukung']);
            }
            if ($file->getSize() > 5 * 1024 * 1024) { // 5MB max
                return $this->response->setJSON(['status' => 'error', 'message' => 'File terlalu besar (max 5MB)']);
            }
            $fileName = time() . '_' . $file->getRandomName();
            $file->move('uploads/chat', $fileName);
            $fileType = $file->getMimeType();
        }

        $data = [
            'id_pengirim'   => $id_siswa,
            'role_pengirim' => 'siswa',
            'id_penerima'   => $id_penerima,
            'role_penerima' => $role_penerima,
            'pesan'         => $pesan ?? '',
            'file_name'     => $fileName,
            'file_type'     => $fileType,
            'reply_to'      => $reply_to,
            'is_read'       => 0,
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $id_chat = $this->db->table('chat')->insert($data);

        // Send notification
        $this->db->table('notifikasi')->insert([
            'id_user'     => $id_penerima,
            'user_role'   => $role_penerima === 'siswa' ? 'siswa' : 'karyawan',
            'judul'       => 'Pesan Baru',
            'pesan'       => 'Anda mendapat pesan baru dari siswa',
            'tipe'        => 'info',
            'link'        => base_url('home_siswa/chat/' . $id_siswa),
            'is_read'     => 0,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'status'     => 'success',
            'message'    => 'Pesan terkirim',
            'id_chat'    => $id_chat,
            'timestamp'  => date('Y-m-d H:i:s'),
            'file_name'  => $fileName,
            'file_type'  => $fileType,
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

        // FIXED: Use groupStart/groupEnd
        $messages = $this->db->table('chat')
            ->groupStart()
                ->where('id >', $last_id)
                ->where('id_pengirim', $id_siswa)
                ->where('id_penerima', $other_id)
            ->groupEnd()
            ->orGroupStart()
                ->where('id >', $last_id)
                ->where('id_pengirim', $other_id)
                ->where('id_penerima', $id_siswa)
            ->groupEnd()
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        if (!empty($messages)) {
            $this->db->table('chat')
                ->where('id_penerima', $id_siswa)
                ->where('id_pengirim', $other_id)
                ->where('is_read', 0)
                ->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
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

    public function delete_message($id_chat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $chat = $this->db->table('chat')->where('id', $id_chat)->getRowArray();
        if (!$chat || $chat['id_pengirim'] != $id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak bisa hapus pesan ini']);
        }

        // Delete file if exists
        if (!empty($chat['file_name']) && file_exists('uploads/chat/' . $chat['file_name'])) {
            unlink('uploads/chat/' . $chat['file_name']);
        }

        $this->db->table('chat')->where('id', $id_chat)->delete();
        return $this->response->setJSON(['status' => 'success', 'message' => 'Pesan dihapus']);
    }

    public function edit_message($id_chat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $chat = $this->db->table('chat')->where('id', $id_chat)->getRowArray();
        if (!$chat || $chat['id_pengirim'] != $id_siswa) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak bisa edit pesan ini']);
        }

        $pesan = $this->request->getPost('pesan');
        if (empty($pesan)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pesan tidak boleh kosong']);
        }

        $this->db->table('chat')->where('id', $id_chat)->update([
            'pesan'     => $pesan,
            'is_edited' => 1,
            'edited_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pesan diedit']);
    }

    public function search_messages()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $keyword = $this->request->getGet('keyword');
        $other_id = $this->request->getGet('other_id');

        if (empty($keyword)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Keyword kosong']);
        }

        $builder = $this->db->table('chat')
            ->groupStart()
                ->where('id_pengirim', $id_siswa)
                ->where('id_penerima', $other_id)
            ->groupEnd()
            ->orGroupStart()
                ->where('id_pengirim', $other_id)
                ->where('id_penerima', $id_siswa)
            ->groupEnd()
            ->like('pesan', $keyword);

        $results = $builder->orderBy('created_at', 'DESC')->limit(50)->get()->getResultArray();

        return $this->response->setJSON(['status' => 'success', 'messages' => $results]);
    }

    public function pin_message($id_chat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $chat = $this->db->table('chat')->where('id', $id_chat)->getRowArray();
        if (!$chat) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pesan tidak ditemukan']);
        }

        $newPin = $chat['is_pinned'] ? 0 : 1;
        $this->db->table('chat')->where('id', $id_chat)->update(['is_pinned' => $newPin]);

        return $this->response->setJSON(['status' => 'success', 'is_pinned' => $newPin]);
    }

    public function react_message($id_chat)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $emoji = $this->request->getPost('emoji');
        if (empty($emoji)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Emoji kosong']);
        }

        // Check if already reacted
        $existing = $this->db->table('chat_reactions')
            ->where('id_chat', $id_chat)
            ->where('id_siswa', $id_siswa)
            ->where('emoji', $emoji)
            ->getRowArray();

        if ($existing) {
            // Remove reaction
            $this->db->table('chat_reactions')->where('id', $existing['id'])->delete();
            return $this->response->setJSON(['status' => 'success', 'action' => 'removed']);
        }

        // Add reaction
        $this->db->table('chat_reactions')->insert([
            'id_chat'   => $id_chat,
            'id_siswa'  => $id_siswa,
            'emoji'     => $emoji,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['status' => 'success', 'action' => 'added']);
    }

    public function typing_indicator()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $other_id = $this->request->getPost('other_id');
        $is_typing = $this->request->getPost('is_typing') ? 1 : 0;

        $this->db->table('chat_typing')->replace([
            'id_siswa'   => $id_siswa,
            'other_id'   => $other_id,
            'is_typing'  => $is_typing,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function check_typing($other_id)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['is_typing' => false]);
        }

        $typing = $this->db->table('chat_typing')
            ->where('id_siswa', $other_id)
            ->where('other_id', $id_siswa)
            ->where('is_typing', 1)
            ->where('updated_at >', date('Y-m-d H:i:s', strtotime('-10 seconds')))
            ->getRowArray();

        return $this->response->setJSON(['is_typing' => !empty($typing)]);
    }

    public function export_chat($other_id)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $messages = $this->db->table('chat')
            ->groupStart()
                ->where('id_pengirim', $id_siswa)
                ->where('id_penerima', $other_id)
            ->groupEnd()
            ->orGroupStart()
                ->where('id_pengirim', $other_id)
                ->where('id_penerima', $id_siswa)
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();

        $other = $this->db->table('karyawan')->where('id_karyawan', $other_id)->getRowArray();
        $other_name = $other['nama_lengkap'] ?? 'Unknown';

        $csv = "Waktu,Pengirim,Pesan\n";
        foreach ($messages as $m) {
            $sender = $m['id_pengirim'] == $id_siswa ? 'Saya' : $other_name;
            $csv .= '"' . $m['created_at'] . '","' . $sender . '","' . str_replace('"', '""', $m['pesan']) . "\"\n";
        }

        return $this->response->download('chat_export_' . date('Y-m-d') . '.csv', $csv);
    }

    public function set_online_status()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $this->db->table('siswa')->where('id_siswa', $id_siswa)->update(['last_activity' => date('Y-m-d H:i:s')]);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function check_online_status($other_id)
    {
        $other = $this->db->table('karyawan')->where('id_karyawan', $other_id)->getRowArray();
        if (!$other) {
            return $this->response->setJSON(['online' => false]);
        }

        $lastActivity = strtotime($other['last_activity'] ?? '0');
        $isOnline = (time() - $lastActivity) < 300; // 5 minutes

        return $this->response->setJSON(['online' => $isOnline, 'last_seen' => $other['last_activity']]);
    }

    public function groups()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $groups = $this->db->table('chat_group_members cgm')
            ->select('cg.*, cgm.role, (SELECT COUNT(*) FROM chat_group_members WHERE id_group = cg.id_group) as member_count')
            ->join('chat_groups cg', 'cg.id_group = cgm.id_group')
            ->where('cgm.id_siswa', $id_siswa)
            ->get()
            ->getResultArray();

        // Get last message per group
        foreach ($groups as &$g) {
            $lastMsg = $this->db->table('chat')
                ->where('id_group', $g['id_group'])
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->getRowArray();
            $g['last_message'] = $lastMsg['pesan'] ?? '';
            $g['last_time'] = $lastMsg['created_at'] ?? '';
            $g['unread_count'] = $this->db->table('chat')
                ->where('id_group', $g['id_group'])
                ->where('id_pengirim !=', $id_siswa)
                ->where('is_read', 0)
                ->countAllResults();
        }

        $data = [
            'title'  => 'Group Chat',
            'title2' => 'Group Chat',
            'groups' => $groups,
        ];
        return view('backend/siswa/chat/v_groups', $data);
    }

    public function create_group()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $nama = $this->request->getPost('nama_group');
        $deskripsi = $this->request->getPost('deskripsi');
        $members = $this->request->getPost('members'); // array of siswa IDs

        if (empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama group wajib diisi']);
        }

        $id_group = $this->db->table('chat_groups')->insert([
            'nama_group' => $nama,
            'deskripsi'  => $deskripsi,
            'created_by' => $id_siswa,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Add creator as admin
        $this->db->table('chat_group_members')->insert([
            'id_group'  => $id_group,
            'id_siswa'  => $id_siswa,
            'role'      => 'admin',
            'joined_at' => date('Y-m-d H:i:s'),
        ]);

        // Add members
        if (!empty($members) && is_array($members)) {
            foreach ($members as $m) {
                if ($m != $id_siswa) {
                    $this->db->table('chat_group_members')->insert([
                        'id_group'  => $id_group,
                        'id_siswa'  => $m,
                        'role'      => 'member',
                        'joined_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        return $this->response->setJSON(['status' => 'success', 'id_group' => $id_group]);
    }

    public function group_conversation($id_group)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        // Check membership
        $member = $this->db->table('chat_group_members')
            ->where('id_group', $id_group)
            ->where('id_siswa', $id_siswa)
            ->getRowArray();
        if (!$member) {
            return redirect()->to(base_url('siswa/chat/groups'));
        }

        $group = $this->db->table('chat_groups')->where('id_group', $id_group)->getRowArray();

        $messages = $this->db->table('chat c')
            ->select('c.*, s.nama_lengkap as sender_name, s.foto_profil as sender_foto')
            ->join('siswa s', 's.id_siswa = c.id_pengirim', 'left')
            ->where('c.id_group', $id_group)
            ->orderBy('c.created_at', 'ASC')
            ->limit(100)
            ->get()
            ->getResultArray();

        // Mark as read
        $this->db->table('chat')
            ->where('id_group', $id_group)
            ->where('id_pengirim !=', $id_siswa)
            ->where('is_read', 0)
            ->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);

        $members = $this->db->table('chat_group_members cgm')
            ->select('s.id_siswa, s.nama_lengkap, s.foto_profil, cgm.role')
            ->join('siswa s', 's.id_siswa = cgm.id_siswa')
            ->where('cgm.id_group', $id_group)
            ->get()
            ->getResultArray();

        $data = [
            'title'   => 'Group Chat',
            'title2'  => $group['nama_group'] ?? 'Group',
            'group'   => $group,
            'messages' => $messages,
            'members' => $members,
            'id_group' => $id_group,
        ];

        return view('backend/siswa/chat/v_group_conversation', $data);
    }

    public function send_group_message()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $id_group = $this->request->getPost('id_group');
        $pesan = $this->request->getPost('pesan');

        if (empty($pesan)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pesan kosong']);
        }

        // Check membership
        $member = $this->db->table('chat_group_members')
            ->where('id_group', $id_group)
            ->where('id_siswa', $id_siswa)
            ->getRowArray();
        if (!$member) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Bukan anggota group']);
        }

        $id_chat = $this->db->table('chat')->insert([
            'id_pengirim'   => $id_siswa,
            'role_pengirim' => 'siswa',
            'id_penerima'   => 0,
            'role_penerima' => 'group',
            'id_group'      => $id_group,
            'pesan'         => $pesan,
            'is_read'       => 0,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['status' => 'success', 'id_chat' => $id_chat]);
    }

    public function ajax_group_messages($id_group)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $last_id = $this->request->getGet('last_id') ?? 0;

        $messages = $this->db->table('chat c')
            ->select('c.*, s.nama_lengkap as sender_name, s.foto_profil as sender_foto')
            ->join('siswa s', 's.id_siswa = c.id_pengirim', 'left')
            ->where('c.id_group', $id_group)
            ->where('c.id >', $last_id)
            ->orderBy('c.id', 'ASC')
            ->get()
            ->getResultArray();

        if (!empty($messages)) {
            $this->db->table('chat')
                ->where('id_group', $id_group)
                ->where('id_pengirim !=', $id_siswa)
                ->where('is_read', 0)
                ->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
        }

        return $this->response->setJSON(['status' => 'success', 'messages' => $messages]);
    }

    public function sse_chat($other_id)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            http_response_code(401);
            exit;
        }

        // SSE headers
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');

        $last_id = (int) ($this->request->getGet('last_id') ?? 0);

        // Send initial connection message
        echo "data: " . json_encode(['type' => 'connected', 'last_id' => $last_id]) . "\n\n";
        ob_flush();
        flush();

        $startTime = time();
        $maxTime = 30; // Run for 30 seconds then client reconnects

        while (time() - $startTime < $maxTime) {
            // Check for new messages
            $messages = $this->db->table('chat')
                ->groupStart()
                    ->where('id >', $last_id)
                    ->where('id_pengirim', $id_siswa)
                    ->where('id_penerima', $other_id)
                ->groupEnd()
                ->orGroupStart()
                    ->where('id >', $last_id)
                    ->where('id_pengirim', $other_id)
                    ->where('id_penerima', $id_siswa)
                ->groupEnd()
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();

            if (!empty($messages)) {
                foreach ($messages as $msg) {
                    echo "data: " . json_encode(['type' => 'message', 'data' => $msg]) . "\n\n";
                    $last_id = $msg['id'];
                }
                ob_flush();
                flush();
            }

            // Check typing status
            $typing = $this->db->table('chat_typing')
                ->where('id_siswa', $other_id)
                ->where('other_id', $id_siswa)
                ->where('is_typing', 1)
                ->where('updated_at >', date('Y-m-d H:i:s', strtotime('-10 seconds')))
                ->getRowArray();

            echo "data: " . json_encode(['type' => 'typing', 'is_typing' => !empty($typing)]) . "\n\n";
            ob_flush();
            flush();

            // Check online status
            $other = $this->db->table('karyawan')->where('id_karyawan', $other_id)->getRowArray();
            $lastActivity = strtotime($other['last_activity'] ?? '0');
            $isOnline = (time() - $lastActivity) < 300;

            echo "data: " . json_encode(['type' => 'online', 'is_online' => $isOnline]) . "\n\n";
            ob_flush();
            flush();

            sleep(2); // Check every 2 seconds
        }

        echo "data: " . json_encode(['type' => 'reconnect']) . "\n\n";
        ob_flush();
        flush();
    }

    public function sse_group($id_group)
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            http_response_code(401);
            exit;
        }

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');

        $last_id = (int) ($this->request->getGet('last_id') ?? 0);

        echo "data: " . json_encode(['type' => 'connected', 'last_id' => $last_id]) . "\n\n";
        ob_flush();
        flush();

        $startTime = time();
        $maxTime = 30;

        while (time() - $startTime < $maxTime) {
            $messages = $this->db->table('chat c')
                ->select('c.*, s.nama_lengkap as sender_name, s.foto_profil as sender_foto')
                ->join('siswa s', 's.id_siswa = c.id_pengirim', 'left')
                ->where('c.id_group', $id_group)
                ->where('c.id >', $last_id)
                ->orderBy('c.id', 'ASC')
                ->get()
                ->getResultArray();

            if (!empty($messages)) {
                foreach ($messages as $msg) {
                    echo "data: " . json_encode(['type' => 'message', 'data' => $msg]) . "\n\n";
                    $last_id = $msg['id'];
                }
                ob_flush();
                flush();
            }

            sleep(2);
        }

        echo "data: " . json_encode(['type' => 'reconnect']) . "\n\n";
        ob_flush();
        flush();
    }
}
