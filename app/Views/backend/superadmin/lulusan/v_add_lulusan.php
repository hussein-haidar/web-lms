<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-plus-circle"></i> <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/lulusan') ?>" class="btn btn-sm btn-default">
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

            <form action="<?= base_url('home_superadmin/save_lulusan') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Alumni <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                   value="<?= old('nama') ?>" required>
                            <?php if (isset($validation) && $validation->hasError('nama')) : ?>
                                <span class="text-danger"><?= $validation->getError('nama') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori <span class="text-danger">*</span></label>
                            <select class="form-control" id="kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Percetakan & Desain" <?= old('kategori') == 'Percetakan & Desain' ? 'selected' : '' ?>>Percetakan & Desain</option>
                                <option value="Teknologi" <?= old('kategori') == 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                                <option value="Kuliner" <?= old('kategori') == 'Kuliner' ? 'selected' : '' ?>>Kuliner</option>
                                <option value="Fashion" <?= old('kategori') == 'Fashion' ? 'selected' : '' ?>>Fashion</option>
                                <option value="Jasa" <?= old('kategori') == 'Jasa' ? 'selected' : '' ?>>Jasa</option>
                                <option value="Lainnya" <?= old('kategori') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('kategori')) : ?>
                                <span class="text-danger"><?= $validation->getError('kategori') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" 
                                   value="<?= old('lokasi') ?>" placeholder="Contoh: Pekalongan, Jawa Tengah">
                            <?php if (isset($validation) && $validation->hasError('lokasi')) : ?>
                                <span class="text-danger"><?= $validation->getError('lokasi') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="foto_profil">Foto Profil</label>
                            <input type="file" class="form-control-file" id="foto_profil" name="foto_profil" 
                                   accept="image/*" onchange="previewImage(this)">
                            <small class="form-text text-muted">Format: JPG, PNG, JPEG, GIF, WEBP (Maks: 10 MB)</small>
                            <?php if (isset($validation) && $validation->hasError('foto_profil')) : ?>
                                <span class="text-danger"><?= $validation->getError('foto_profil') ?></span>
                            <?php endif ?>

                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img src="#" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="warna_tema">Warna Tema</label>
                            <input type="color" class="form-control" id="warna_tema" name="warna_tema" 
                                   value="<?= old('warna_tema', '#0d6efd') ?>">
                            <small class="form-text text-muted">Pilih warna tema untuk tampilan alumni</small>
                            <?php if (isset($validation) && $validation->hasError('warna_tema')) : ?>
                                <span class="text-danger"><?= $validation->getError('warna_tema') ?></span>
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
                            <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
                            <small class="form-text text-muted">Jelaskan tentang alumni dan usahanya</small>
                            <?php if (isset($validation) && $validation->hasError('deskripsi')) : ?>
                                <span class="text-danger"><?= $validation->getError('deskripsi') ?></span>
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label>Media Sosial</label>

                            <div class="mb-2">
                                <label for="facebook_url">Facebook URL</label>
                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                       value="<?= old('facebook_url') ?>" placeholder="https://www.facebook.com/...">
                                <?php if (isset($validation) && $validation->hasError('facebook_url')) : ?>
                                    <span class="text-danger"><?= $validation->getError('facebook_url') ?></span>
                                <?php endif ?>
                            </div>

                            <div class="mb-2">
                                <label for="tiktok_url">TikTok URL</label>
                                <input type="url" class="form-control" id="tiktok_url" name="tiktok_url" 
                                       value="<?= old('tiktok_url') ?>" placeholder="https://tiktok.com/@...">
                                <?php if (isset($validation) && $validation->hasError('tiktok_url')) : ?>
                                    <span class="text-danger"><?= $validation->getError('tiktok_url') ?></span>
                                <?php endif ?>
                            </div>

                            <div class="mb-2">
                                <label for="whatsapp_url">WhatsApp URL</label>
                                <input type="url" class="form-control" id="whatsapp_url" name="whatsapp_url" 
                                       value="<?= old('whatsapp_url') ?>" placeholder="https://wa.me/628...">
                                <?php if (isset($validation) && $validation->hasError('whatsapp_url')) : ?>
                                    <span class="text-danger"><?= $validation->getError('whatsapp_url') ?></span>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Galeri Foto</label>
                            <button type="button" class="btn btn-info btn-sm" onclick="addGalleryField()">
                                <i class="fa fa-plus"></i> Tambah Foto
                            </button>

                            <div id="galleryFields" class="mt-2">
                                <!-- Gallery fields will be added here dynamically -->
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
                            <a href="<?= base_url('home_superadmin/lulusan') ?>" class="btn btn-default">
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

    let galleryCount = 0;

    function addGalleryField() {
        galleryCount++;
        const galleryFields = document.getElementById('galleryFields');
        
        const fieldDiv = document.createElement('div');
        fieldDiv.className = 'mb-2 p-2 border rounded';
        fieldDiv.innerHTML = `
            <div class="row">
                <div class="col-md-8">
                    <input type="file" name="gallery_foto_${galleryCount}" class="form-control-file" accept="image/*">
                </div>
                <div class="col-md-4">
                    <input type="text" name="gallery_keterangan_${galleryCount}" class="form-control" placeholder="Keterangan foto">
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeGalleryField(this)">
                <i class="fa fa-trash"></i> Hapus
            </button>
        `;
        
        galleryFields.appendChild(fieldDiv);
    }

    function removeGalleryField(button) {
        button.parentElement.remove();
    }
</script>

<?= $this->endSection() ?>
