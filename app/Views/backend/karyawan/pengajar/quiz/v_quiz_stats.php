<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($title) ?></h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_karyawan/quiz_management') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="box-body">
            <!-- Quiz Info -->
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h4><i class="fa fa-info-circle"></i> <?= esc($quiz['judul_quiz']) ?></h4>
                        <p class="mb-0"><?= esc($quiz['deskripsi']) ?></p>
                        <small>
                            <i class="fa fa-book"></i> <?= esc($quiz['nama_kursus']) ?> | 
                            <i class="fa fa-clock"></i> <?= $quiz['durasi_menit'] ?> menit | 
                            <i class="fa fa-percentage"></i> Passing: <?= $quiz['passing_grade'] ?>%
                        </small>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Peserta</span>
                            <span class="info-box-number"><?= $stats['total_attempts'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Lulus</span>
                            <span class="info-box-number"><?= $stats['passed_count'] ?? 0 ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rata-rata</span>
                            <span class="info-box-number"><?= number_format($stats['avg_score'] ?? 0, 1) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-trophy"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tertinggi</span>
                            <span class="info-box-number"><?= number_format($stats['max_score'] ?? 0, 1) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pass Rate Chart -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Tingkat Kelulusan</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $passRate = ($stats['total_attempts'] > 0) ? (($stats['passed_count'] / $stats['total_attempts']) * 100) : 0;
                            $failRate = 100 - $passRate;
                            ?>
                            <div class="progress-group">
                                <span class="progress-text">Lulus</span>
                                <span class="float-right"><b><?= number_format($passRate, 1) ?>%</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-green" style="width: <?= $passRate ?>%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Tidak Lulus</span>
                                <span class="float-right"><b><?= number_format($failRate, 1) ?>%</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-red" style="width: <?= $failRate ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Distribusi Nilai</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $scoreRanges = [
                                '90-100' => 0,
                                '80-89' => 0,
                                '70-79' => 0,
                                '60-69' => 0,
                                '0-59' => 0
                            ];
                            
                            if (!empty($results)) {
                                foreach ($results as $result) {
                                    $score = $result['total_nilai'];
                                    if ($score >= 90) $scoreRanges['90-100']++;
                                    elseif ($score >= 80) $scoreRanges['80-89']++;
                                    elseif ($score >= 70) $scoreRanges['70-79']++;
                                    elseif ($score >= 60) $scoreRanges['60-69']++;
                                    else $scoreRanges['0-59']++;
                                }
                            }
                            
                            $totalResults = count($results);
                            foreach ($scoreRanges as $range => $count) {
                                $percentage = ($totalResults > 0) ? ($count / $totalResults) * 100 : 0;
                                $color = ($range === '90-100' || $range === '80-89') ? 'bg-green' : 
                                        (($range === '70-79') ? 'bg-yellow' : 'bg-red');
                                ?>
                                <div class="progress-group">
                                    <span class="progress-text"><?= $range ?></span>
                                    <span class="float-right"><b><?= $count ?></b></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar <?= $color ?>" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Results -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Hasil Detail Peserta</h3>
                        </div>
                        <div class="box-body">
                            <?php if (!empty($results)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="25%">Nama Siswa</th>
                                                <th width="20%">Email</th>
                                                <th width="10%">Attempt</th>
                                                <th width="10%">Nilai</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Benar</th>
                                                <th width="10%">Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($results as $result): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= esc($result['nama_lengkap']) ?></td>
                                                    <td><?= esc($result['email']) ?></td>
                                                    <td class="text-center"><?= $result['attempt_ke'] ?></td>
                                                    <td class="text-center">
                                                        <strong><?= number_format($result['total_nilai'], 1) ?></strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($result['is_lulus']): ?>
                                                            <span class="label label-success">LULUS</span>
                                                        <?php else: ?>
                                                            <span class="label label-danger">TIDAK</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $result['total_benar'] ?>/<?= ($result['total_benar'] + $result['total_salah']) ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        $waktuMulai = new DateTime($result['waktu_mulai']);
                                                        $waktuSelesai = new DateTime($result['waktu_selesai']);
                                                        $duration = $waktuMulai->diff($waktuSelesai);
                                                        echo $duration->format('%i:%s');
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fa fa-warning"></i> Belum ada peserta yang mengerjakan quiz ini.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
