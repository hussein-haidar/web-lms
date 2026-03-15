<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-body">
            <h3><?= esc($title) ?></h3>
            <?php if (isset($valid) && $valid && !empty($sertifikat)): ?>
                <div class="alert alert-success">
                    Sertifikat ditemukan dan valid!<br>
                    <strong>Nama:</strong> <?= esc($sertifikat['nama_siswa'] ?? '-') ?><br>
                    <strong>Kursus:</strong> <?= esc($sertifikat['nama_kursus'] ?? '-') ?><br>
                    <strong>Kode:</strong> <?= esc($sertifikat['kode_sertifikat'] ?? '-') ?><br>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    Sertifikat tidak ditemukan atau tidak aktif.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>