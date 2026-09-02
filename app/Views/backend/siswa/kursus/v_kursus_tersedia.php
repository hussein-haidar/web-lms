<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Kursus Tersedia') ?>
        <small><?= esc($title2 ?? '') ?></small>
    </h1>
</section>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($kursus)): ?>
            <div class="col-md-12">
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Tidak ada kursus tersedia saat ini.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($kursus as $row): ?>
                <div class="col-md-4">
                    <div class="box box-widget widget-user-2">
                        <div class="widget-user-header bg-aqua">
                            <h3 class="widget-user-username"><?= esc($row['nama_kursus'] ?? '') ?></h3>
                            <h5 class="widget-user-desc"><?= esc($row['slug'] ?? '') ?></h5>
                        </div>
                        <div class="box-footer no-padding">
                            <ul class="nav-stacked">
                                <li><a href="<?= base_url('home_siswa/detail_kursus/' . $row['id_kursus']) ?>">Lihat Detail <span class="pull-right badge bg-blue"><i class="fa fa-eye"></i></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
