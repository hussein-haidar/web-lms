<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'View Materi') ?>
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
            <h3 class="box-title"><i class="fa fa-file-text-o"></i> Materi</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($materi)): ?>
                <h4><?= esc($materi['judul_materi'] ?? '') ?></h4>
                <p class="text-muted">Tipe: <?= esc($materi['tipe_materi'] ?? '-') ?></p>
                <hr>
                <div class="materi-content">
                    <?= $materi['deskripsi_materi'] ?? '' ?>
                </div>
                <?php if (!empty($materi['file_materi'])): ?>
                    <hr>
                    <a href="<?= base_url('uploads/materi/' . $materi['file_materi']) ?>" class="btn btn-info" target="_blank"><i class="fa fa-download"></i> Unduh File</a>
                <?php endif; ?>
            <?php else: ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Materi tidak ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
