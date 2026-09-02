<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Akses Kursus') ?>
        <small><?= esc($title2 ?? '') ?></small>
    </h1>
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
            <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Akses Kursus</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($pendaftaran)): ?>
                <table class="table table-bordered">
                    <tr>
                        <th style="width:200px">Kursus</th>
                        <td><?= esc($pendaftaran['nama_kursus'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Paket</th>
                        <td><?= esc($pendaftaran['nama_paket'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Progress</th>
                        <td><?= ($pendaftaran['progress'] ?? 0) ?>%</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="label label-<?= ($pendaftaran['status'] ?? '') == 'aktif' ? 'success' : 'warning' ?>"><?= esc($pendaftaran['status'] ?? '-') ?></span></td>
                    </tr>
                </table>
                <a href="<?= base_url('home_siswa/belajar/' . $pendaftaran['id_pendaftaran']) ?>" class="btn btn-primary"><i class="fa fa-play-circle"></i> Mulai Belajar</a>
            <?php else: ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Data akses kursus tidak ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
