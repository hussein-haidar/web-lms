<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i> <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/mitra_kerja') ?>" class="btn btn-sm btn-default">
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

            <form action="<?= base_url('home_superadmin/update_mitra_kerja/' . $mitra['id_mitra']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_mitra">Nama Mitra <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" 
                                   value="<?= old('nama_mitra', $mitra['nama_mitra']) ?>" required>
                            <?php if (isset($validation) && $validation->hasError('nama_mitra')) : ?>
                                <span class="text-danger"><?= $validation->getError('nama_mitra') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi', $mitra['deskripsi']) ?></textarea>
                            <small class="form-text text-muted">Jelaskan tentang mitra kerja ini</small>
                            <?php if (isset($validation) && $validation->hasError('deskripsi')) : ?>
                                <span class="text-danger"><?= $validation->getError('deskripsi') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="url_website">Website</label>
                            <input type="url" class="form-control" id="url_website" name="url_website" 
                                   value="<?= old('url_website', $mitra['url_website']) ?>" placeholder="https://www.contoh.com">
                            <?php if (isset($validation) && $validation->hasError('url_website')) : ?>
                                <span class="text-danger"><?= $validation->getError('url_website') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="logo_mitra">Logo Mitra <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" id="logo_mitra" name="logo_mitra" 
                                   accept="image/*" onchange="previewImage(this)">
                            <small class="form-text text-muted">Format: JPG, PNG, JPEG, GIF, WEBP (Maks: 10 MB)</small>
                            <?php if (isset($validation) && $validation->hasError('logo_mitra')) : ?>
                                <span class="text-danger"><?= $validation->getError('logo_mitra') ?></span>
                            <?php endif ?>

                            <?php if (!empty($mitra['logo_mitra'])): ?>
                                <div class="mt-2">
                                    <small>Logo saat ini:</small><br>
                                    <img src="<?= base_url('slider/' . $mitra['logo_mitra']) ?>" 
                                         alt="Current Logo" style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                                </div>
                            <?php endif; ?>

                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="#" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="urutan">Urutan Tampil <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="urutan" name="urutan" 
                                   value="<?= old('urutan', $mitra['urutan']) ?>" required>
                            <small class="form-text text-muted">Nomor urutan untuk tampil di website</small>
                            <?php if (isset($validation) && $validation->hasError('urutan')) : ?>
                                <span class="text-danger"><?= $validation->getError('urutan') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="aktif" <?= old('status', $mitra['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="tidak_aktif" <?= old('status', $mitra['status']) == 'tidak_aktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('status')) : ?>
                                <span class="text-danger"><?= $validation->getError('status') ?></span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="<?= base_url('home_superadmin/mitra_kerja') ?>" class="btn btn-default">
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
