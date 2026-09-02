<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Ganti Password') ?>
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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lock"></i> Ganti Password</h3>
        </div>
        <div class="box-body">
            <form action="<?= base_url('home_siswa/update_password') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= base_url('home_siswa/profil') ?>" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
