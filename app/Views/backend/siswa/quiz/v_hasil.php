<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<script>
function toggleDetail(id) {
    const detailRow = document.getElementById('detail-' + id);
    if (detailRow) {
        const currentDisplay = window.getComputedStyle(detailRow).display;
        if (currentDisplay === 'none' || currentDisplay === '') {
            detailRow.style.display = 'table-row';
        } else {
            detailRow.style.display = 'none';
        }
    }
}
</script>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 mb-1">
                <i class="fas fa-chart-line text-primary me-2"></i>
                <?= esc($title) ?>
            </h2>
            <p class="text-muted mb-0">Riwayat hasil quiz Anda</p>
        </div>
    </div>

    <?php if (!empty($results) && is_array($results)): ?>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Attempt</th>
                                        <th>Nilai</th>
                                        <th>Benar</th>
                                        <th>Salah</th>
                                        <th>Status</th>
                                        <th>Waktu</th>
                                        <th>Aksi</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($results as $r): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= esc($r['attempt_ke']) ?></span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar <?= $r['total_nilai'] >= 70 ? 'bg-success' : 'bg-danger' ?>" 
                                                         style="width: <?= $r['total_nilai'] ?>%">
                                                        <?= esc($r['total_nilai']) ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success"><?= esc($r['total_benar']) ?></span>
                                            </td>
                                            <td>
                                                <span class="text-danger"><?= esc($r['total_salah']) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($r['is_lulus']): ?>
                                                    <span class="badge bg-success">LULUS</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">COBA</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d/m H:i', strtotime($r['waktu_mulai'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php 
                                                // Check if student has passed with 70-100 score
                                                $bestResult = $quizHasilModel->getNilaiTerbaik($quiz['id_quiz'], $pendaftaran['id_pendaftaran']);
                                                $hasPassedWithHighScore = $bestResult && $bestResult['total_nilai'] >= 70 && $bestResult['is_lulus'] == 1;
                                                $hasExceededAttempts = $r['attempt_ke'] >= 3;
                                                
                                                if (!$r['is_lulus'] && $r['attempt_ke'] < ($quiz['max_attempt'] ?? 3) && !$hasPassedWithHighScore && !$hasExceededAttempts): ?>
                                                    <form method="post" action="<?= base_url('home_siswa/quiz/retry/' . $quiz['id_quiz']) ?>" style="display:inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-sm btn-warning">
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
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="toggleDetail(<?= $r['id_quiz_hasil'] ?>)">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="detail-<?= $r['id_quiz_hasil'] ?>" style="display: none;" class="bg-light">
                                            <td colspan="9" class="p-4">
                                                <h6 class="mb-3">
                                                    <i class="fas fa-list-check me-2"></i>
                                                    Detail Jawaban - Attempt <?= $r['attempt_ke'] ?>
                                                </h6>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-primary">Jawaban Anda:</h6>
                                                        <div class="bg-white p-3 rounded border">
                                                            <?php 
                                                            $jawaban_user = json_decode($r['jawaban_json'], true);
                                                            if (is_array($jawaban_user)) {
                                                                foreach ($jawaban_user as $soal_id => $jawaban) {
                                                                    echo '<div class="mb-2">';
                                                                    echo '<strong>Soal ' . ($soal_id + 1) . ':</strong> ';
                                                                    
                                                                    // Konversi ke huruf yang benar (A-D)
                                                                    $jawaban_display = '';
                                                                    
                                                                    if (is_array($jawaban)) {
                                                                        // Cek apakah ini object dengan key 'jawaban'
                                                                        if (isset($jawaban['jawaban'])) {
                                                                            $jawaban_value = $jawaban['jawaban'];
                                                                            if (is_numeric($jawaban_value)) {
                                                                                $jawaban_index = (int)$jawaban_value;
                                                                                // Batasi hanya 0-3 (A-D)
                                                                                if ($jawaban_index >= 0 && $jawaban_index <= 3) {
                                                                                    $jawaban_display = chr(65 + $jawaban_index);
                                                                                } else {
                                                                                    $jawaban_display = '?';
                                                                                }
                                                                            } else {
                                                                                $jawaban_display = (string) $jawaban_value;
                                                                            }
                                                                        } else {
                                                                            // Jika array biasa, ambil nilai pertama
                                                                            $first_value = reset($jawaban);
                                                                            if (is_numeric($first_value)) {
                                                                                $jawaban_index = (int)$first_value;
                                                                                // Batasi hanya 0-3 (A-D)
                                                                                if ($jawaban_index >= 0 && $jawaban_index <= 3) {
                                                                                    $jawaban_display = chr(65 + $jawaban_index);
                                                                                } else {
                                                                                    $jawaban_display = '?';
                                                                                }
                                                                            } else {
                                                                                $jawaban_display = (string) $first_value;
                                                                            }
                                                                        }
                                                                    } elseif (is_numeric($jawaban)) {
                                                                        $jawaban_index = (int)$jawaban;
                                                                        // Batasi hanya 0-3 (A-D)
                                                                        if ($jawaban_index >= 0 && $jawaban_index <= 3) {
                                                                            $jawaban_display = chr(65 + $jawaban_index);
                                                                        } else {
                                                                            $jawaban_display = '?';
                                                                        }
                                                                    } else {
                                                                        $jawaban_display = (string) $jawaban;
                                                                    }
                                                                    
                                                                    echo '<span class="badge bg-info">' . esc($jawaban_display) . '</span>';
                                                                    echo '</div>';
                                                                }
                                                            } else {
                                                                echo '<span class="text-muted">Tidak ada jawaban</span>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-success">Jawaban Benar:</h6>
                                                        <div class="bg-white p-3 rounded border">
                                                            <?php 
                                                            $quiz_details = $quizModel->find($quiz['id_quiz']);
                                                            if ($quiz_details && !empty($quiz_details['soal_json'])) {
                                                                $quiz_data = json_decode($quiz_details['soal_json'], true);
                                                                if (is_array($quiz_data)) {
                                                                    foreach ($quiz_data as $index => $soal) {
                                                                        $jawaban_benar = $soal['jawaban_benar'] ?? '';
                                                                        echo '<div class="mb-2">';
                                                                        echo '<strong>Soal ' . ($index + 1) . ':</strong> ';
                                                                        echo '<span class="badge bg-success">' . esc($jawaban_benar) . '</span>';
                                                                        echo '</div>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
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
        <div class="text-center py-5">
            <h4 class="text-muted">Belum Ada Hasil Quiz</h4>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
