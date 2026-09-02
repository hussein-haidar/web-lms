<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Notifikasi') ?>
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

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bell"></i> Notifikasi</h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_siswa/mark_all_read') ?>" class="btn btn-sm btn-default">Tandai Semua Dibaca</a>
            </div>
        </div>
        <div class="box-body">
            <?php if (empty($notifikasi)): ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Tidak ada notifikasi baru.</p>
                </div>
            <?php else: ?>
                <?php foreach ($notifikasi as $notifikasi_item): ?>
                    <div class="alert alert-<?= ($notifikasi_item['is_read'] ?? 0) ? 'default' : 'info' ?>">
                        <p><?= esc($notifikasi_item['pesan'] ?? '') ?></p>
                        <small><i class="fa fa-clock-o"></i> <?= esc($notifikasi_item['tanggal'] ?? '') ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
