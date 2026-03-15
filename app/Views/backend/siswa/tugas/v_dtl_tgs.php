<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<?php
$t = $tugas ?? [];
$nama_tugas = $t['nama_tugas'] ?? $t['judul_tugas'] ?? 'Detail Tugas';
?>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($nama_tugas) ?></h3>
            <a href="<?= base_url('home_siswa/v_tugas') ?>" class="btn btn-default btn-sm pull-right">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <div class="well">
                <p><strong>Kursus:</strong> <?= esc($t['nama_kursus'] ?? '–') ?></p>
                <p><strong>Deskripsi:</strong><br><?= nl2br(esc($t['deskripsi'] ?? '–')) ?></p>
                <p><strong>Tenggat:</strong> <?= esc($t['tenggat_waktu'] ?? $t['deadline'] ?? '–') ?></p>
                <?php if (!empty($t['dokumen_tugas'])): ?>
                    <p>
                        <a href="<?= base_url('kursus/tugas/' . $t['dokumen_tugas']) ?>" target="_blank" class="btn btn-info btn-sm">
                            <i class="fa fa-download"></i> Download File Tugas
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <h4>Pengumpulan Saya</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Kirim</th>
                            <th>File</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($submissions) && is_array($submissions)): ?>
                            <?php $no = 1; foreach ($submissions as $s): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= !empty($s['tanggal_kirim']) ? date('d/m/Y H:i', strtotime($s['tanggal_kirim'])) : '–' ?></td>
                                    <td>
                                        <?php if (!empty($s['file_tugas'])): ?>
                                            <a href="<?= base_url('kursus/tugassiswa/' . $s['file_tugas']) ?>" target="_blank" class="btn btn-xs btn-info">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        <?php else: ?>–<?php endif; ?>
                                    </td>
                                    <td><?= esc($s['nilai'] ?? '–') ?></td>
                                    <td>
                                        <?php if (($s['status_penilaian'] ?? '') === 'sudah_dinilai'): ?>
                                            <span class="label label-success">Sudah Dinilai</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Menunggu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('home_siswa/edit_kumpul/' . ($s['id_kumpul'] ?? '')) ?>" class="btn btn-xs btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pengumpulan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <a href="<?= base_url('home_siswa/add_kumpul') ?>?id_tugas=<?= $t['id_tugas'] ?? '' ?>" class="btn btn-success">
                <i class="fa fa-upload"></i> Kumpulkan Tugas
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
