<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h3 mb-1">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        <?= esc($title) ?>
                    </h2>
                    <p class="text-muted mb-0">Daftar quiz tersedia untuk kursus Anda</p>
                </div>
                <div>
                    <a href="<?= base_url('home_siswa/kursus') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Kursus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('pesan') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($quizzes) && is_array($quizzes)): ?>
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">Total Quiz</h6>
                                <h3 class="mb-0"><?= count($quizzes) ?></h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-list fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">Sudah Dikerjakan</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    $attempted = 0;
                                    foreach ($quizzes as $q) {
                                        $attempt = $quizModel->getAttemptCount($q['id_quiz'], $pendaftaran['id_pendaftaran']);
                                        if ($attempt > 0) $attempted++;
                                    }
                                    echo $attempted;
                                    ?>
                                </h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">Total Soal</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    $total_soal = 0;
                                    foreach ($quizzes as $q) {
                                        $total_soal += $q['jumlah_soal'] ?? 0;
                                    }
                                    echo $total_soal;
                                    ?>
                                </h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-tasks fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-warning text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">Durasi Total</h6>
                                <h3 class="mb-0">
                                    <?php 
                                    $total_menit = 0;
                                    foreach ($quizzes as $q) {
                                        $total_menit += $q['durasi_menit'] ?? 0;
                                    }
                                    echo $total_menit;
                                    ?> mnt
                                </h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Cards Grid -->
        <div class="row">
            <?php foreach ($quizzes as $q): ?>
                <?php if (!is_array($q)) continue; ?>
                <?php $attempt = $quizModel->getAttemptCount($q['id_quiz'], $pendaftaran['id_pendaftaran']); ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0"><?= esc($q['judul_quiz']) ?></h6>
                                <span class="badge bg-info rounded-pill">
                                    <i class="fas fa-tasks me-1"></i><?= $q['jumlah_soal'] ?? 0 ?> soal
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Durasi</small>
                                    <div class="fw-bold">
                                        <i class="fas fa-clock text-primary me-1"></i>
                                        <?= esc($q['durasi_menit']) ?> menit
                                    </div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Passing Grade</small>
                                    <div class="fw-bold">
                                        <i class="fas fa-percentage text-success me-1"></i>
                                        <?= esc($q['passing_grade']) ?>%
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Attempt</small>
                                    <div class="fw-bold">
                                        <i class="fas fa-redo text-warning me-1"></i>
                                        <?= $attempt ?> / <?= esc($q['max_attempt']) ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Status</small>
                                    <div class="fw-bold">
                                        <?php if ($attempt > 0): ?>
                                            <span class="text-success">
                                                <i class="fas fa-check-circle me-1"></i>Sudah Dikerjakan
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-circle me-1"></i>Belum Dikerjakan
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <?php if ($attempt > 0): ?>
                                    <a href="<?= base_url('home_siswa/quiz/hasil/' . $q['id_quiz']) ?>" 
                                       class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-chart-line me-1"></i>Lihat Hasil
                                    </a>
                                <?php endif; ?>

                                <?php 
                                // Check if student has passed with 70-100 score
                                $bestResult = $quizHasilModel->getNilaiTerbaik($q['id_quiz'], $pendaftaran['id_pendaftaran']);
                                $hasPassedWithHighScore = $bestResult && $bestResult['total_nilai'] >= 70 && $bestResult['is_lulus'] == 1;
                                $hasExceededAttempts = $attempt >= 3;
                                ?>

                                <?php if ($attempt < $q['max_attempt'] && !$hasPassedWithHighScore): ?>
                                    <a href="<?= base_url('home_siswa/quiz/kerjakan/' . $q['id_quiz']) ?>" 
                                       class="btn btn-sm btn-primary rounded-pill">
                                        <i class="fas fa-play me-1"></i>Kerjakan Quiz
                                    </a>
                                <?php elseif ($hasPassedWithHighScore): ?>
                                    <button class="btn btn-sm btn-success rounded-pill" disabled>
                                        <i class="fas fa-award me-1"></i>Sudah Lulus (<?= round($bestResult['total_nilai']) ?>%)
                                    </button>
                                <?php elseif ($hasExceededAttempts): ?>
                                    <button class="btn btn-sm btn-secondary rounded-pill" disabled>
                                        <i class="fas fa-ban me-1"></i>Batas 3x Percobaan Terpakai
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary rounded-pill" disabled>
                                        <i class="fas fa-ban me-1"></i>Batas Terpakai
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-question-circle fa-4x text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3">Tidak Ada Quiz Tersedia</h4>
                        <p class="text-muted mb-4">Quiz untuk kursus ini akan ditampilkan di sini ketika tersedia.</p>
                        <a href="<?= base_url('home_siswa/kursus') ?>" class="btn btn-primary rounded-pill">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Kursus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>