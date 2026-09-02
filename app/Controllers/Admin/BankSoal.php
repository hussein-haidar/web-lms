<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_bank_soal;
use App\Models\M_quiz;

class BankSoal extends BaseController
{
    protected $bankSoalModel;
    protected $quizModel;

    public function __construct()
    {
        $this->bankSoalModel = new M_bank_soal();
        $this->quizModel = new M_quiz();
    }

    public function index($id_kursus = null)
    {
        $data = [
            'title' => 'Bank Soal',
            'title2' => 'Bank Soal',
            'bank_soal' => $id_kursus ? $this->bankSoalModel->where('id_kursus', $id_kursus)->findAll() : $this->bankSoalModel->findAll(),
            'id_kursus' => $id_kursus,
            'quizzes' => $this->quizModel->findAll()
        ];
        return view('backend/superadmin/bank_soal/v_index', $data);
    }

    public function add($id_quiz)
    {
        $quiz = $this->quizModel->find($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz tidak ditemukan!');
            return redirect()->to(base_url('admin/bank-soal'));
        }
        $data = [
            'title' => 'Tambah Soal',
            'title2' => 'Tambah Soal',
            'quiz' => $quiz
        ];
        return view('backend/superadmin/bank_soal/v_add', $data);
    }

    public function save()
    {
        $rules = [
            'id_quiz' => 'required',
            'pertanyaan' => 'required',
            'tipe_soal' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'id_quiz' => $this->request->getPost('id_quiz'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'tipe_soal' => $this->request->getPost('tipe_soal'),
            'opsi_a' => $this->request->getPost('opsi_a'),
            'opsi_b' => $this->request->getPost('opsi_b'),
            'opsi_c' => $this->request->getPost('opsi_c'),
            'opsi_d' => $this->request->getPost('opsi_d'),
            'opsi_e' => $this->request->getPost('opsi_e'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
            'bobot' => $this->request->getPost('bobot') ?? 1,
            'pembahasan' => $this->request->getPost('pembahasan')
        ];
        $this->bankSoalModel->insert($data);
        session()->setFlashdata('pesan', 'Soal berhasil ditambahkan!');
        return redirect()->to(base_url('admin/bank-soal/' . $this->request->getPost('id_quiz')));
    }

    public function edit($id_soal)
    {
        $soal = $this->bankSoalModel->find($id_soal);
        if (!$soal) {
            session()->setFlashdata('error', 'Data soal tidak ditemukan!');
            return redirect()->to(base_url('admin/bank-soal'));
        }
        $data = [
            'title' => 'Edit Soal',
            'title2' => 'Edit Soal',
            'soal' => $soal
        ];
        return view('backend/superadmin/bank_soal/v_edit', $data);
    }

    public function update($id_soal)
    {
        $soal = $this->bankSoalModel->find($id_soal);
        if (!$soal) {
            session()->setFlashdata('error', 'Data soal tidak ditemukan!');
            return redirect()->to(base_url('admin/bank-soal'));
        }
        $data = [
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'tipe_soal' => $this->request->getPost('tipe_soal'),
            'opsi_a' => $this->request->getPost('opsi_a'),
            'opsi_b' => $this->request->getPost('opsi_b'),
            'opsi_c' => $this->request->getPost('opsi_c'),
            'opsi_d' => $this->request->getPost('opsi_d'),
            'opsi_e' => $this->request->getPost('opsi_e'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar'),
            'bobot' => $this->request->getPost('bobot') ?? 1,
            'pembahasan' => $this->request->getPost('pembahasan')
        ];
        $this->bankSoalModel->update($id_soal, $data);
        session()->setFlashdata('pesan', 'Soal berhasil diperbarui!');
        return redirect()->to(base_url('admin/bank-soal/' . $soal['id_quiz']));
    }

    public function delete($id_soal)
    {
        $soal = $this->bankSoalModel->find($id_soal);
        if (!$soal) {
            session()->setFlashdata('error', 'Data soal tidak ditemukan!');
            return redirect()->to(base_url('admin/bank-soal'));
        }
        $this->bankSoalModel->delete($id_soal);
        session()->setFlashdata('pesan', 'Soal berhasil dihapus!');
        return redirect()->to(base_url('admin/bank-soal/' . $soal['id_quiz']));
    }

    public function import()
    {
        $id_quiz = $this->request->getPost('id_quiz');
        $json_data = $this->request->getPost('json_data');

        if (!$id_quiz || !$json_data) {
            session()->setFlashdata('error', 'Data tidak lengkap!');
            return redirect()->back();
        }

        $soal_array = json_decode($json_data, true);
        if (!$soal_array) {
            session()->setFlashdata('error', 'Format JSON tidak valid!');
            return redirect()->back();
        }

        foreach ($soal_array as $soal) {
            $data = [
                'id_quiz' => $id_quiz,
                'pertanyaan' => $soal['pertanyaan'] ?? '',
                'tipe_soal' => $soal['tipe_soal'] ?? 'pilihan_ganda',
                'opsi_a' => $soal['opsi_a'] ?? '',
                'opsi_b' => $soal['opsi_b'] ?? '',
                'opsi_c' => $soal['opsi_c'] ?? '',
                'opsi_d' => $soal['opsi_d'] ?? '',
                'opsi_e' => $soal['opsi_e'] ?? '',
                'jawaban_benar' => $soal['jawaban_benar'] ?? '',
                'bobot' => $soal['bobot'] ?? 1,
                'pembahasan' => $soal['pembahasan'] ?? ''
            ];
            $this->bankSoalModel->insert($data);
        }

        session()->setFlashdata('pesan', count($soal_array) . ' soal berhasil diimpor!');
        return redirect()->to(base_url('admin/bank-soal/' . $id_quiz));
    }
}
