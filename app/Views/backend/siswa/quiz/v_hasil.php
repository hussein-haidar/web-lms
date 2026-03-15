<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h3 mb-1">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        <?= esc($title) ?>
                    </h2>
                    <p class="text-muted mb-0">Riwayat hasil quiz Anda</p>
                </div>
                <div>
                    <a href="<?= base_url('home_siswa/quiz/' . ($quiz['id_kursus'] ?? '')) ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Quiz
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

    <?php if (!empty($results) && is_array($results)): ?>
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-1">Total Attempt</h6>
                                <h3 class="mb-0"><?= count($results) ?></h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-redo fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-1">Tertinggi</h6>
                                <h3 class="mb-0"><?= max(array_column($results, 'total_nilai')) ?></h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-trophy fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-1">Rata-rata</h6>
                                <h3 class="mb-0"><?= round(array_sum(array_column($results, 'total_nilai')) / count($results)) ?></h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-chart-bar fa-2x opacity-75"></i>
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
                                <h6 class="card-title mb-1">Status</h6>
                                <h3 class="mb-0">
                                    <?php $lulus_count = count(array_filter($results, fn($r) => $r['is_lulus'])); ?>
                                    <?= $lulus_count > 0 ? 'LULUS' : 'COBA' ?>
                                </h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-<?= $lulus_count > 0 ? 'check-circle' : 'exclamation-triangle' ?> fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>
                            Detail Hasil Quiz
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th class="text-center" style="width: 80px;">Attempt</th>
                                        <th class="text-center" style="width: 100px;">Nilai</th>
                                        <th class="text-center" style="width: 80px;">Benar</th>
                                        <th class="text-center" style="width: 80px;">Salah</th>
                                        <th class="text-center" style="width: 80px;">Total Soal</th>
                                        <th class="text-center" style="width: 100px;">Status</th>
                                        <th style="width: 150px;">Waktu Mulai</th>
                                        <th style="width: 150px;">Waktu Selesai</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($results as $r): ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-secondary rounded-pill"><?= $no++ ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info rounded-pill"><?= esc($r['attempt_ke']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <div class="progress" style="height: 25px;">
                                                    <div class="progress-bar <?= $r['total_nilai'] >= 70 ? 'bg-success' : ($r['total_nilai'] >= 50 ? 'bg-warning' : 'bg-danger') ?>" 
                                                         style="width: <?= $r['total_nilai'] ?>%">
                                                        <?= esc($r['total_nilai']) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-success fw-bold"><?= esc($r['total_benar']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-danger fw-bold"><?= esc($r['total_salah']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill"><?= esc($r['total_soal']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($r['is_lulus']): ?>
                                                    <span class="badge bg-success rounded-pill">
                                                        <i class="fas fa-check me-1"></i>LULUS
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary rounded-pill">
                                                        <i class="fas fa-times me-1"></i>COBA
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $waktu_mulai = $r['waktu_mulai'];
                                                if (empty($waktu_mulai) || 
                                                    $waktu_mulai === '0000-00-00 00:00:00' || 
                                                    strpos($waktu_mulai, '0000-00-00') === 0) {
                                                    echo '<span class="text-muted"><i class="fas fa-minus-circle"></i> Belum dimulai</span>';
                                                } else {
                                                    echo '<small class="text-muted"><i class="fas fa-clock me-1"></i>' . date('d/m/Y H:i', strtotime($waktu_mulai)) . '</small>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $waktu_selesai = $r['waktu_selesai'];
                                                if (empty($waktu_selesai) || $waktu_selesai === '0000-00-00 00:00:00') {
                                                    echo '<span class="text-muted"><i class="fas fa-minus-circle"></i> Belum selesai</span>';
                                                } else {
                                                    echo '<small class="text-muted"><i class="fas fa-clock me-1"></i>' . date('d/m/Y H:i', strtotime($waktu_selesai)) . '</small>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                // Check if student has passed with 70-100 score
                                                $bestResult = $quizHasilModel->getNilaiTerbaik($quiz['id_quiz'], $pendaftaran['id_pendaftaran']);
                                                $hasPassedWithHighScore = $bestResult && $bestResult['total_nilai'] >= 70 && $bestResult['is_lulus'] == 1;
                                                $hasExceededAttempts = $r['attempt_ke'] >= 3;
                                                
                                                if (!$r['is_lulus'] && $r['attempt_ke'] < ($quiz['max_attempt'] ?? 0) && !$hasPassedWithHighScore && !$hasExceededAttempts): ?>
                                                    <form method="post" action="<?= base_url('home_siswa/quiz/retry/' . $quiz['id_quiz']) ?>" style="display:inline">
                                                        <button type="submit" class="btn btn-sm btn-warning rounded-pill">
                                                            <i class="fas fa-redo me-1"></i>Retry
                                                        </button>
                                                    </form>
                                                <?php elseif ($hasPassedWithHighScore): ?>
                                                    <span class="text-success small">
                                                        <i class="fas fa-award"></i> Lulus (<?= round($bestResult['total_nilai']) ?>%)
                                                    </span>
                                                <?php elseif ($hasExceededAttempts): ?>
                                                    <span class="text-muted small">
                                                        <i class="fas fa-ban text-danger"></i> Batas 3x Percobaan
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-clipboard-list fa-4x text-muted opacity-50"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Hasil Quiz</h4>
                        <p class="text-muted mb-4">Anda belum mengerjakan quiz apapun. Mulai quiz pertama Anda untuk melihat hasil di sini.</p>
                        <a href="<?= base_url('home_siswa/quiz/' . ($quiz['id_kursus'] ?? '')) ?>" class="btn btn-primary rounded-pill">
                            <i class="fas fa-play me-2"></i>Mulai Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>