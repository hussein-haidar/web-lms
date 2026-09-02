<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Profil Siswa</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <tr><td><strong>Nama</strong></td><td><?= esc($pendaftaran['nama_siswa'] ?? '-') ?></td></tr>
                    <tr><td><strong>Email</strong></td><td><?= esc($pendaftaran['email'] ?? '-') ?></td></tr>
                    <tr><td><strong>Kursus</strong></td><td><?= esc($pendaftaran['nama_kursus'] ?? '-') ?></td></tr>
                    <tr><td><strong>Status</strong></td><td><span class="label label-<?= ($pendaftaran['status'] === 'aktif') ? 'success' : 'warning' ?>"><?= ucfirst($pendaftaran['status']) ?></span></td></tr>
                    <tr><td><strong>Progress</strong></td><td><?= $pendaftaran['progress'] ?? 0 ?>%</td></tr>
                    <tr>
                        <td><strong>Nilai Akhir</strong></td>
                        <td>
                            <h3 class="<?= (($pendaftaran['nilai_akhir'] ?? 0) >= 70) ? 'text-success' : 'text-danger' ?>">
                                <?= number_format($pendaftaran['nilai_akhir'] ?? 0, 1) ?>
                            </h3>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Nilai Quiz -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-question-circle"></i> Nilai Quiz</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($quiz_nilai)): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Quiz</th>
                                <th>Attempt</th>
                                <th>Nilai</th>
                                <th>Passing Grade</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quiz_nilai as $idx => $q): ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td><?= esc($q['judul_quiz'] ?? '-') ?></td>
                                    <td>#<?= $q['attempt_ke'] ?></td>
                                    <td>
                                        <strong class="<?= ($q['total_nilai'] >= ($q['passing_grade'] ?? 70)) ? 'text-success' : 'text-danger' ?>">
                                            <?= number_format($q['total_nilai'], 1) ?>%
                                        </strong>
                                    </td>
                                    <td><?= $q['passing_grade'] ?? 70 ?>%</td>
                                    <td>
                                        <?php if ($q['is_lulus']): ?>
                                            <span class="label label-success">Lulus</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Belum Lulus</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($q['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-center text-muted">Belum ada nilai quiz</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Nilai Tugas -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tasks"></i> Nilai Tugas</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($tugas_nilai)): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tugas</th>
                                <th>Nilai</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tugas_nilai as $idx => $t): ?>
                                <tr>
                                    <td><?= $idx + 1 ?></td>
                                    <td><?= esc($t['judul_tugas'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($t['nilai'] !== null): ?>
                                            <strong class="<?= ($t['nilai'] >= 70) ? 'text-success' : 'text-danger' ?>">
                                                <?= number_format($t['nilai'], 1) ?>
                                            </strong>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="label label-<?= ($t['status_penilaian'] === 'dinilai') ? 'success' : 'warning' ?>">
                                            <?= ucfirst($t['status_penilaian']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="text-center text-muted">Belum ada nilai tugas</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="text-center" style="margin-bottom:20px">
    <a href="<?= base_url('home_superadmin/gradebook') ?>" class="btn btn-default">
        <i class="fa fa-arrow-left"></i> Kembali ke Gradebook
    </a>
</div>

<?= $this->endSection() ?>
