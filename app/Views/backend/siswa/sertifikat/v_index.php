<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-folder"></i> Data <?= $title2 ?>
            </h3>

            <!-- Tombol Kembali -->
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_siswa') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Pending Certificates -->
            <?php if (!empty($pending_courses)): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="fa fa-gift"></i> Kursus Selesai - Sertifikat Tersedia!</h5>
                    <p class="mb-3">Selamat! Anda telah menyelesaikan kursus berikut dan dapat mengklaim sertifikat:</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kursus</th>
                                    <th>Progress</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_courses as $course): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($course['nama_kursus']) ?></strong>
                                            <br>
                                            <small class="text-muted">ID: <?= $course['id_pendaftaran'] ?></small>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" style="width: <?= $course['progress'] ?>%">
                                                    <?= $course['progress'] ?>%
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= date('d M Y', strtotime($course['tanggal_selesai'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('sertifikat/claim/' . $course['id_pendaftaran']) ?>"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin mengklaim sertifikat untuk kursus ini?')">
                                                <i class="fa fa-download"></i> Klaim Sertifikat
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- My Certificates -->
            <?php if (!empty($sertifikat)): ?>
                <h4 class="mb-3"><i class="fa fa-award"></i> Sertifikat yang Telah Diterbitkan</h4>

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kursus</th>
                                <th>Program</th>
                                <th>Paket</th>
                                <th>Nomor Sertifikat</th>
                                <th>Predikat</th>
                                <th>Nilai</th>
                                <th>Tanggal Terbit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($sertifikat as $cert): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= esc($cert['nama_kursus']) ?></strong>
                                        <?php if (!empty($cert['nama_paket'])): ?>
                                            <br><small class="text-muted"><?= esc($cert['nama_paket']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeColor = 'bg-blue';
                                        $icon = 'graduation-cap';
                                        if (!empty($cert['nama_program'])) {
                                            if (strtolower($cert['nama_program']) === 'kelas online') {
                                                $badgeColor = 'bg-aqua';
                                                $icon = 'wifi';
                                            } elseif (strtolower($cert['nama_program']) === 'profesi 1 tahun') {
                                                $badgeColor = 'bg-maroon';
                                                $icon = 'briefcase';
                                            }
                                        }
                                        ?>
                                        <span class="label <?= $badgeColor ?>" style="font-size: 11px;">
                                            <i class="fa fa-<?= $icon ?>"></i>
                                            <?= esc(ucfirst($cert['nama_program'] ?? 'Reguler')) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($cert['nama_paket'] ?? '-') ?></td>
                                    <td>
                                        <code><?= esc($cert['nomor_sertifikat']) ?></code>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= getPredikatBadge($cert['predikat']) ?>">
                                            <?= esc($cert['predikat']) ?>
                                        </span>
                                    </td>
                                    <td><?= $cert['nilai_akhir'] ?></td>
                                    <td><?= date('d M Y', strtotime($cert['tanggal_terbit'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('sertifikat/view/' . $cert['id_sertifikat']) ?>"
                                                class="btn btn-info btn-sm" target="_blank" title="Lihat">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('sertifikat/print/' . $cert['id_sertifikat']) ?>"
                                                class="btn btn-primary btn-sm" target="_blank" title="Cetak/Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            <a href="<?= base_url('sertifikat/download/' . $cert['id_sertifikat']) ?>"
                                                class="btn btn-success btn-sm" title="Download">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="<?= base_url('sertifikat/verify/' . $cert['nomor_sertifikat']) ?>"
                                                class="btn btn-warning btn-sm" target="_blank" title="Verifikasi">
                                                <i class="fa fa-qrcode"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fa fa-info-circle fa-3x mb-3"></i>
                    <h5>Belum Ada Sertifikat</h5>
                    <p>Anda belum memiliki sertifikat. Selesaikan kursus Anda untuk dapat mengklaim sertifikat.</p>

                    <a href="<?= base_url('home_siswa/kursus_saya') ?>" class="btn btn-primary">
                        <i class="fa fa-graduation-cap"></i> Lihat Kursus Saya
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php
// Helper function for badge colors
function getPredikatBadge($predikat)
{
    switch ($predikat) {
        case 'Excellent':
            return 'success';
        case 'Very Good':
            return 'info';
        case 'Good':
            return 'primary';
        case 'Pass':
            return 'warning';
        default:
            return 'secondary';
    }
}
?>

<?= $this->endSection() ?>