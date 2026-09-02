<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Form Pendaftaran') ?>
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
            <h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Form Pendaftaran</h3>
        </div>
        <div class="box-body">
            <form action="<?= base_url('home_siswa/simpan_pendaftaran') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kursus" value="<?= esc($kursus['id_kursus'] ?? '') ?>">
                <div class="form-group">
                    <label>Kursus</label>
                    <input type="text" class="form-control" value="<?= esc($kursus['nama_kursus'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Harga Kursus</label>
                    <input type="number" name="harga_kursus" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Daftar</button>
                <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
