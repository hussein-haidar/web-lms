<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-plus-circle"></i> <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/galeri_uji_kompetensi') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <?= session()->getFlashdata('errors') ?>
                </div>
            <?php endif ?>

            <form action="<?= base_url('home_superadmin/save_galeri_uji_kompetensi') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="judul">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" id="judul" class="form-control"
                           value="<?= old('judul') ?>" required minlength="3" maxlength="100">
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                              required minlength="10"><?= old('deskripsi') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar <span class="text-danger">*</span></label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('home_superadmin/galeri_uji_kompetensi') ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
