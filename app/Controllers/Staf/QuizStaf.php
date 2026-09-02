<?php

namespace App\Controllers\Staf;

use App\Controllers\BaseController;
use App\Models\M_pendaftaran;
use App\Models\M_quiz;
use App\Models\M_bank_soal;

class QuizStaf extends BaseController
{
    protected $pendaftaranModel;
    protected $quizModel;
    protected $bankSoalModel;

    public function __construct()
    {
        $this->pendaftaranModel = new M_pendaftaran();
        $this->quizModel = new M_quiz();
        $this->bankSoalModel = new M_bank_soal();
    }

    public function index()
    {
        $id_karyawan = session()->get('id_karyawan');
        $data = [
            'title' => 'Quiz Management',
            'title2' => 'Quiz Management',
            'quiz' => $this->pendaftaranModel->getQuizByPengajar($id_karyawan)
        ];
        return view('backend/karyawan/pengajar/quiz/v_quiz_management', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Quiz',
            'title2' => 'Tambah Quiz'
        ];
        return view('backend/karyawan/pengajar/quiz/v_add_quiz', $data);
    }

    public function save()
    {
        $rules = [
            'id_kursus' => 'required',
            'judul_quiz' => 'required',
            'pertanyaan' => 'required'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', \Config\Services::validation()->getErrors());
        }
        $data = [
            'id_kursus' => $this->request->getPost('id_kursus'),
            'judul_quiz' => $this->request->getPost('judul_quiz'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'status' => 'aktif'
        ];
        $this->pendaftaranModel->insertQuiz($data);
        session()->setFlashdata('pesan', 'Quiz berhasil ditambahkan!');
        return redirect()->to(base_url('home_karyawan/quiz_management'));
    }

    public function edit($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/quiz_management'));
        }
        $data = [
            'title' => 'Edit Quiz',
            'title2' => 'Edit Quiz',
            'quiz' => $quiz
        ];
        return view('backend/karyawan/pengajar/quiz/v_edit_quiz', $data);
    }

    public function update($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/quiz_management'));
        }
        $data = [
            'judul_quiz' => $this->request->getPost('judul_quiz'),
            'pertanyaan' => $this->request->getPost('pertanyaan')
        ];
        $this->pendaftaranModel->updateQuiz($id_quiz, $data);
        session()->setFlashdata('pesan', 'Quiz berhasil diperbarui!');
        return redirect()->to(base_url('home_karyawan/quiz_management'));
    }

    public function delete($id_quiz)
    {
        $quiz = $this->pendaftaranModel->getQuizById($id_quiz);
        if (!$quiz) {
            session()->setFlashdata('error', 'Data quiz tidak ditemukan!');
            return redirect()->to(base_url('home_karyawan/quiz_management'));
        }
        $this->pendaftaranModel->deleteQuiz($id_quiz);
        session()->setFlashdata('pesan', 'Quiz berhasil dihapus!');
        return redirect()->to(base_url('home_karyawan/quiz_management'));
    }

    public function stats($id_quiz)
    {
        $data = [
            'title' => 'Quiz Statistics',
            'title2' => 'Quiz Statistics',
            'stats' => $this->pendaftaranModel->getQuizStats($id_quiz)
        ];
        return view('backend/karyawan/pengajar/quiz/v_quiz_stats', $data);
    }
}
