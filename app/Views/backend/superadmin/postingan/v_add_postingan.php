<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Postingan</h3>
                </div>

                <?php if (isset($validation) && $validation->getErrors()): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i>
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <?= form_open_multipart('home_superadmin/postingan_save') ?>
                <div class="box-body">
                    <!-- Judul Postingan -->
                    <div class="form-group">
                        <label for="judul_postingan">Judul Postingan <span class="text-danger">*</span></label>
                        <input type="text"
                            name="judul_postingan"
                            class="form-control <?= isset($validation) && $validation->hasError('judul_postingan') ? 'is-invalid' : '' ?>"
                            id="judul_postingan"
                            value="<?= old('judul_postingan') ?>"
                            placeholder="Masukkan judul postingan"
                            required>
                        <?php if (isset($validation) && $validation->hasError('judul_postingan')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('judul_postingan') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Slug -->
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <div class="input-group">
                            <span class="input-group-addon"><?= base_url('postingan/detail/') ?></span>
                            <input type="text"
                                class="form-control"
                                id="slug"
                                name="slug"
                                value="<?= old('slug') ?>"
                                placeholder="otomatis-dari-judul"
                                readonly>
                        </div>
                        <small class="form-text text-muted">Slug akan dibuat otomatis dari judul</small>
                    </div>

                    <!-- Konten -->
                    <div class="form-group">
                        <label for="konten">Konten <span class="text-danger">*</span></label>
                        <textarea name="konten"
                            class="form-control <?= isset($validation) && $validation->hasError('konten') ? 'is-invalid' : '' ?>"
                            id="konten"
                            rows="12"
                            placeholder="Tulis konten postingan di sini..."
                            required><?= old('konten') ?></textarea>
                        <?php if (isset($validation) && $validation->hasError('konten')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('konten') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Excerpt -->
                    <div class="form-group">
                        <label for="excerpt">Ringkasan</label>
                        <textarea name="excerpt"
                            class="form-control"
                            id="excerpt"
                            rows="3"
                            placeholder="Ringkasan postingan (opsional, akan dibuat otomatis jika kosong)"><?= old('excerpt') ?></textarea>
                        <small class="form-text text-muted">Ringkasan akan ditampilkan di halaman daftar postingan</small>
                    </div>

                    <!-- Gambar Postingan -->
                    <div class="form-group">
                        <label for="gambar_postingan">Gambar Utama</label>
                        <input type="file"
                            name="gambar_postingan"
                            class="form-control-file <?= isset($validation) && $validation->hasError('gambar_postingan') ? 'is-invalid' : '' ?>"
                            id="gambar_postingan"
                            accept="image/*">
                        <?php if (isset($validation) && $validation->hasError('gambar_postingan')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('gambar_postingan') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Maksimal 2MB. Format: JPG, PNG, WebP</small>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="kategori">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori"
                            class="form-control <?= isset($validation) && $validation->hasError('kategori') ? 'is-invalid' : '' ?>"
                            id="kategori"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $key => $value): ?>
                                <option value="<?= $key ?>" <?= old('kategori') == $key ? 'selected' : '' ?>>
                                    <?= $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('kategori')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('kategori') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Penulis -->
                    <div class="form-group">
                        <label for="penulis">Penulis <span class="text-danger">*</span></label>
                        <input type="text"
                            name="penulis"
                            class="form-control <?= isset($validation) && $validation->hasError('penulis') ? 'is-invalid' : '' ?>"
                            id="penulis"
                            value="<?= old('penulis', 'Admin INASABA') ?>"
                            placeholder="Nama penulis"
                            required>
                        <?php if (isset($validation) && $validation->hasError('penulis')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('penulis') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="draft"
                                    <?= old('status') == 'draft' ? 'checked' : '' ?>
                                    required>
                                <i class="fa fa-edit text-warning"></i> Draft
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="published"
                                    <?= old('status') == 'published' ? 'checked' : '' ?>>
                                <i class="fa fa-check-circle text-success"></i> Published (Tampil di Website)
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="archived"
                                    <?= old('status') == 'archived' ? 'checked' : '' ?>>
                                <i class="fa fa-archive text-default"></i> Archived
                            </label>
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description"
                            class="form-control"
                            id="meta_description"
                            rows="3"
                            placeholder="Deskripsi untuk SEO (max 160 karakter)"><?= old('meta_description') ?></textarea>
                        <small class="form-text text-muted">Digunakan untuk SEO di mesin pencari</small>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text"
                            name="meta_keywords"
                            class="form-control"
                            id="meta_keywords"
                            value="<?= old('meta_keywords') ?>"
                            placeholder="keyword1, keyword2, keyword3">
                        <small class="form-text text-muted">Pisahkan dengan koma</small>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('home_superadmin/postingan_admin') ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Postingan
                        </button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript untuk Auto Slug -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const judulInput = document.getElementById('judul_postingan');
        const slugInput = document.getElementById('slug');

        // Auto generate slug from title
        judulInput.addEventListener('input', function() {
            const judul = this.value;
            const slug = judul.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                .trim();

            slugInput.value = slug;
        });

        // Character counter for meta description
        const metaDescInput = document.getElementById('meta_description');
        if (metaDescInput) {
            metaDescInput.addEventListener('input', function() {
                const length = this.value.length;
                if (length > 160) {
                    this.value = this.value.substring(0, 160);
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>
