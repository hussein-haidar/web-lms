<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Penilaian Tugas') ?>
        <small><?= esc($title2 ?? '') ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('home_siswa/kumpul_tugas') ?>"><i class="fa fa-arrow-left"></i> Kembali</a></li>
    </ol>
</section>

<section class="content">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-check-square-o"></i> Detail Penilaian</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($kumpul)): ?>
                <table class="table table-bordered">
                    <tr>
                        <th style="width:200px">Tugas</th>
                        <td><?= esc($kumpul['judul_tugas'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>File Tugas</th>
                        <td>
                            <?php if (!empty($kumpul['file_tugas'])): ?>
                                <a href="<?= base_url('kursus/tugassiswa/' . $kumpul['file_tugas']) ?>" target="_blank"><i class="fa fa-file"></i> <?= esc($kumpul['file_tugas']) ?></a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Nilai</th>
                        <td><span class="label label-<?= ($kumpul['nilai'] ?? 0) >= 70 ? 'success' : 'danger' ?>"><?= ($kumpul['nilai'] ?? 0) ?></span></td>
                    </tr>
                    <tr>
                        <th>Status Penilaian</th>
                        <td><span class="label label-<?= ($kumpul['status_penilaian'] ?? '') == 'dinilai' ? 'success' : (($kumpul['status_penilaian'] ?? '') == 'menunggu' ? 'warning' : 'default') ?>"><?= esc($kumpul['status_penilaian'] ?? '-') ?></span></td>
                    </tr>
                    <tr>
                        <th>Tanggal Kirim</th>
                        <td><?= esc($kumpul['tanggal_kirim'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td><?= esc($kumpul['catatan_siswa'] ?? '-') ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Data penilaian tidak ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
