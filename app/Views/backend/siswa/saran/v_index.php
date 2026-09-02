<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Saran & Kritik') ?>
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
            <h3 class="box-title"><i class="fa fa-comments-o"></i> Kirim Saran & Kritik</h3>
        </div>
        <div class="box-body">
            <form action="<?= base_url('home_siswa/saran') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>Tulis Saran atau Kritik Anda</label>
                    <textarea name="saran" class="form-control" rows="6" placeholder="Tuliskan saran atau kritik Anda di sini (minimal 10 karakter)..." required minlength="10" maxlength="1000"><?= old('saran') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Kirim</button>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
