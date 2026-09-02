<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\M_jadwal;

class JadwalController extends BaseController
{
    protected $M_jadwal;

    public function __construct()
    {
        $this->M_jadwal = new \App\Models\M_jadwal();
    }

    /**
     * Tampilkan kalender akademik (siswa)
     */
    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $jadwal = $this->M_jadwal->getJadwalBulan($bulan, $tahun, $id_siswa);

        $data = [
            'title'  => 'Kalender Akademik',
            'title2' => 'Jadwal ' . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)),
            'jadwal' => $jadwal,
            'bulan'  => $bulan,
            'tahun'  => $tahun,
        ];

        return view('backend/siswa/jadwal/v_calendar', $data);
    }

    /**
     * AJAX: Ambil data jadwal untuk FullCalendar
     */
    public function ajax_events()
    {
        $id_siswa = session()->get('id_siswa');
        if (!$id_siswa) {
            return $this->response->setJSON([]);
        }

        $start = $this->request->getGet('start') ?? date('Y-01-01');
        $end = $this->request->getGet('end') ?? date('Y-12-31');

        $jadwal = $this->M_jadwal->getJadwalRange($start, $end, $id_siswa);

        $events = [];
        foreach ($jadwal as $j) {
            $events[] = [
                'id'     => $j['id_jadwal'],
                'title'  => $j['judul'],
                'start'  => $j['tanggal_mulai'],
                'end'    => $j['tanggal_selesai'],
                'color'  => $j['warna'] ?? '#3c8dbc',
                'extendedProps' => [
                    'tipe'     => $j['tipe'],
                    'deskripsi' => $j['deskripsi'] ?? '',
                    'kursus'   => $j['nama_kursus'] ?? '',
                ],
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * Detail jadwal
     */
    public function detail($id_jadwal)
    {
        $jadwal = $this->M_jadwal->find($id_jadwal);
        if (!$jadwal) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Jadwal tidak ditemukan']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $jadwal,
        ]);
    }
}