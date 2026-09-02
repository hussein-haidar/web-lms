<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-plus-circle"></i> <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/uji_kompetensi') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <!-- /.box-header -->
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

            <form action="<?= base_url('home_superadmin/save_uji_kompetensi') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_uji_kompetensi">Nama Uji Kompetensi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_uji_kompetensi" name="nama_uji_kompetensi" 
                                   value="<?= old('nama_uji_kompetensi') ?>" required>
                            <?php if (isset($validation) && $validation->hasError('nama_uji_kompetensi')) : ?>
                                <span class="text-danger"><?= $validation->getError('nama_uji_kompetensi') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
                            <small class="form-text text-muted">Jelaskan tentang program uji kompetensi ini</small>
                            <?php if (isset($validation) && $validation->hasError('deskripsi')) : ?>
                                <span class="text-danger"><?= $validation->getError('deskripsi') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="durasi">Durasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="durasi" name="durasi" 
                                   value="<?= old('durasi') ?>" placeholder="Contoh: 3 Bulan" required>
                            <small class="form-text text-muted">Durasi program uji kompetensi</small>
                            <?php if (isset($validation) && $validation->hasError('durasi')) : ?>
                                <span class="text-danger"><?= $validation->getError('durasi') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="tipe_pembelajaran">Tipe Pembelajaran <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipe_pembelajaran" name="tipe_pembelajaran" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="Online" <?= old('tipe_pembelajaran') == 'Online' ? 'selected' : '' ?>>Online</option>
                                <option value="Offline" <?= old('tipe_pembelajaran') == 'Offline' ? 'selected' : '' ?>>Offline</option>
                                <option value="Hybrid" <?= old('tipe_pembelajaran') == 'Hybrid' ? 'selected' : '' ?>>Hybrid (Online & Offline)</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('tipe_pembelajaran')) : ?>
                                <span class="text-danger"><?= $validation->getError('tipe_pembelajaran') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="sertifikat">Sertifikat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sertifikat" name="sertifikat" 
                                   value="<?= old('sertifikat') ?>" placeholder="Contoh: Sertifikat Kompetensi" required>
                            <small class="form-text text-muted">Jenis sertifikat yang diberikan</small>
                            <?php if (isset($validation) && $validation->hasError('sertifikat')) : ?>
                                <span class="text-danger"><?= $validation->getError('sertifikat') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="harga" name="harga" 
                                   value="<?= old('harga') ?>" placeholder="0" min="0" step="1000" required>
                            <small class="form-text text-muted">Harga program dalam Rupiah</small>
                            <?php if (isset($validation) && $validation->hasError('harga')) : ?>
                                <span class="text-danger"><?= $validation->getError('harga') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="aktif" <?= old('status', 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('status')) : ?>
                                <span class="text-danger"><?= $validation->getError('status') ?></span>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gambar">Gambar Program <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" id="gambar" name="gambar" 
                                   accept="image/*" onchange="previewImage(this)" required>
                            <small class="form-text text-muted">Format: JPG, PNG, JPEG (Maks: 2 MB)</small>
                            <?php if (isset($validation) && $validation->hasError('gambar')) : ?>
                                <span class="text-danger"><?= $validation->getError('gambar') ?></span>
                            <?php endif ?>

                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="#" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('home_superadmin/uji_kompetensi') ?>" class="btn btn-default">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('imagePreview').querySelector('img').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?= $this->endSection() ?>
