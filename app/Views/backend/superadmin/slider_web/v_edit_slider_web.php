<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h5 class="card-title">Edit <?= $title2 ?></h5>
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i>
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?= form_open_multipart('home_superadmin/update_slider_web/' . $slider['id_slider']) ?>
                <div class="box-body">
                    <!-- Judul Slider -->
                    <div class="form-group">
                        <label for="judul_slider">Judul Slider <span class="text-danger">*</span></label>
                        <input type="text"
                            name="judul_slider"
                            class="form-control <?= session('errors.judul_slider') ? 'is-invalid' : '' ?>"
                            id="judul_slider"
                            value="<?= old('judul_slider', $slider['judul_slider']) ?>"
                            placeholder="Contoh: Selamat Datang di Website Kami"
                            required>
                        <?php if (session('errors.judul_slider')): ?>
                            <div class="invalid-feedback"><?= session('errors.judul_slider') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi"
                            class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>"
                            id="deskripsi"
                            rows="4"
                            placeholder="Deskripsi singkat tentang slider ini..."
                            required><?= old('deskripsi', $slider['deskripsi']) ?></textarea>
                        <?php if (session('errors.deskripsi')): ?>
                            <div class="invalid-feedback"><?= session('errors.deskripsi') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Maksimal 500 karakter</small>
                    </div>

                    <!-- Link URL -->
                    <div class="form-group">
                        <label for="link_url">Link URL (Opsional)</label>
                        <input type="url"
                            name="link_url"
                            class="form-control <?= session('errors.link_url') ? 'is-invalid' : '' ?>"
                            id="link_url"
                            value="<?= old('link_url', $slider['link_url']) ?>"
                            placeholder="https://example.com/halaman">
                        <?php if (session('errors.link_url')): ?>
                            <div class="invalid-feedback"><?= session('errors.link_url') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Kosongkan jika tidak ada link</small>
                    </div>

                    <!-- Gambar Slider -->
                    <div class="form-group">
                        <label for="gambar_slider">Gambar Slider</label>
                        <input type="file"
                            name="gambar_slider"
                            class="form-control-file <?= session('errors.gambar_slider') ? 'is-invalid' : '' ?>"
                            id="gambar_slider"
                            accept="image/*">
                        <?php if (session('errors.gambar_slider')): ?>
                            <div class="invalid-feedback d-block"><?= session('errors.gambar_slider') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">
                            Kosongkan jika tidak ingin mengubah gambar | Format: PNG, JPG, JPEG, WEBP | Max: 2 MB
                        </small>
                    </div>

                    <!-- Preview Gambar Lama -->
                    <div class="form-group">
                        <label>Gambar Saat Ini</label>
                        <div class="mt-2">
                            <?php if (!empty($slider['gambar_slider'])): ?>
                                <img id="current-image"
                                    src="<?= base_url('uploads/slider_web/' . $slider['gambar_slider']) ?>"
                                    alt="Current Image"
                                    class="img-thumbnail"
                                    style="max-width: 100%; height: auto; max-height: 300px; display: block;"
                                    onerror="this.src='<?= base_url('assets/img/no-image.png') ?>'">
                            <?php else: ?>
                                <img src="<?= base_url('assets/img/no-image.png') ?>" 
                                    alt="No Image" 
                                    class="img-thumbnail" 
                                    style="max-width: 100%; height: auto; max-height: 300px; display: block;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Preview Gambar Baru -->
                    <div class="form-group">
                        <label>Preview Gambar Baru</label>
                        <div class="mt-2">
                            <img id="preview-image"
                                src="<?= base_url('assets/img/no-image.png') ?>"
                                alt="Preview"
                                class="img-thumbnail"
                                style="max-width: 100%; height: auto; max-height: 300px; display: none;">
                        </div>
                    </div>

                    <!-- Urutan -->
                    <div class="form-group">
                        <label for="urutan">Urutan Tampil <span class="text-danger">*</span></label>
                        <input type="number"
                            name="urutan"
                            class="form-control <?= session('errors.urutan') ? 'is-invalid' : '' ?>"
                            id="urutan"
                            value="<?= old('urutan', $slider['urutan']) ?>"
                            min="1"
                            required>
                        <?php if (session('errors.urutan')): ?>
                            <div class="invalid-feedback"><?= session('errors.urutan') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Semakin kecil angka, semakin awal tampil</small>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="aktif"
                                    <?= old('status', $slider['status']) == 'aktif' ? 'checked' : '' ?>
                                    required>
                                <i class="fa fa-toggle-on text-success"></i> Aktif (Tampil di Website)
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="nonaktif"
                                    <?= old('status', $slider['status']) == 'nonaktif' ? 'checked' : '' ?>>
                                <i class="fa fa-toggle-off text-danger"></i> Nonaktif (Tidak Tampil)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('home_superadmin/slider_web') ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Update Slider
                        </button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<script>
    // Preview gambar baru sebelum upload
    document.getElementById('gambar_slider').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview-image');
        const currentImage = document.getElementById('current-image');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
                currentImage.style.display = 'none';
            }

            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            currentImage.style.display = 'block';
        }
    });
</script>

<?= $this->endSection() ?>
