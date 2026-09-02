<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <!-- Header -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden">
                <div class="bg-gradient-primary text-white p-4 text-center">
                    <h2 class="mb-2 fw-bold"><i class="fas fa-clipboard-list me-2"></i><?= esc($quiz['judul_quiz']) ?></h2>
                    <p class="mb-0 opacity-90">Preview Quiz - Pastikan Anda siap sebelum memulai</p>
                </div>
            </div>

            <!-- Quiz Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Quiz</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width:40%"><i class="fas fa-book me-2"></i>Kursus</td>
                            <td class="fw-bold"><?= esc($quiz['nama_kursus'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-clock me-2"></i>Durasi</td>
                            <td class="fw-bold text-primary"><?= esc($quiz['durasi_menit'] ?? 30) ?> Menit</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-list-ol me-2"></i>Jumlah Soal</td>
                            <td class="fw-bold"><?= count($quiz['soal']) ?> Soal</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-percentage me-2"></i>Passing Grade</td>
                            <td class="fw-bold text-success"><?= esc($quiz['passing_grade'] ?? 70) ?>%</td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-redo me-2"></i>Percobaan</td>
                            <td class="fw-bold">Attempt #<?= $attempt ?> dari <?= $quiz['max_attempt'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Question Type Breakdown -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-tags text-info me-2"></i>Jenis Soal</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php
                        // Count question types
                        $typeCounts = ['pilihan_ganda' => 0, 'essay' => 0, 'benar_salah' => 0, 'fill_blank' => 0, 'matching' => 0, 'true_false' => 0];
                        foreach ($quiz['soal'] as $s) {
                            $tipe = $s['tipe'] ?? 'pilihan_ganda';
                            if (isset($typeCounts[$tipe])) {
                                $typeCounts[$tipe]++;
                            } else {
                                $typeCounts['pilihan_ganda']++;
                            }
                        }
                        $typeLabels = [
                            'pilihan_ganda' => ['Pilihan Ganda', 'fas fa-check-circle', 'primary'],
                            'essay' => ['Essay', 'fas fa-pen', 'warning'],
                            'benar_salah' => ['Benar/Salah', 'fas fa-toggle-on', 'success'],
                            'true_false' => ['Benar/Salah', 'fas fa-toggle-on', 'success'],
                            'fill_blank' => ['Isian Kosong', 'fas fa-pencil-alt', 'info'],
                            'matching' => ['Menjodohkan', 'fas fa-link', 'secondary']
                        ];
                        foreach ($typeCounts as $type => $count):
                            if ($count > 0):
                                $label = $typeLabels[$type] ?? [$type, 'fas fa-question', 'dark'];
                        ?>
                        <div class="col-md-4">
                            <div class="card border h-100">
                                <div class="card-body text-center py-3">
                                    <i class="<?= $label[1] ?> fa-2x text-<?= $label[2] ?> mb-2"></i>
                                    <h6 class="mb-1"><?= $label[0] ?></h6>
                                    <span class="badge bg-<?= $label[2] ?> fs-6"><?= $count ?> Soal</span>
                                </div>
                            </div>
                        </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>

            <!-- Important Rules -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Peraturan Quiz</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0" style="list-style:none; padding-left:0;">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Quiz akan dimulai setelah Anda menekan tombol "Mulai Quiz"</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Timer akan berjalan otomatis setelah quiz dimulai</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Quiz akan otomatis disubmit jika waktu habis</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pastikan semua soal terjawab sebelum waktu habis</li>
                        <li class="mb-0"><i class="fas fa-check text-success me-2"></i>Anda memiliki <?= $quiz['max_attempt'] ?> kali percobaan</li>
                    </ul>
                </div>
            </div>

            <!-- Start Button -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <a href="<?= base_url('home_siswa/quiz/start/' . $quiz['id_quiz']) ?>" class="btn btn-primary btn-lg px-5 py-3" id="startBtn">
                        <i class="fas fa-play-circle me-2"></i>Mulai Quiz
                    </a>
                    <div class="mt-3">
                        <a href="<?= base_url('home_siswa/quiz/' . $quiz['id_kursus']) ?>" class="text-muted">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%) !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('startBtn').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Mulai Quiz?',
        html: 'Timer akan mulai berjalan setelah Anda mengklik "Ya, Mulai!".<br><br><strong> <?= count($quiz['soal']) ?> Soal | <?= $quiz['durasi_menit'] ?? 30 ?> Menit</strong>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Mulai!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = this.href;
        }
    });
});
</script>

<?= $this->endSection() ?>
