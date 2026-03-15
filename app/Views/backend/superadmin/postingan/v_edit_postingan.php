<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Postingan</h3>
                </div>

                <?php if (isset($validation) && $validation->getErrors()): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i>
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>

                <?= form_open_multipart('home_superadmin/postingan_update/' . $post['id_postingan']) ?>
                <div class="box-body">
                    <!-- Judul Postingan -->
                    <div class="form-group">
                        <label for="judul_postingan">Judul Postingan <span class="text-danger">*</span></label>
                        <input type="text"
                            name="judul_postingan"
                            class="form-control <?= isset($validation) && $validation->hasError('judul_postingan') ? 'is-invalid' : '' ?>"
                            id="judul_postingan"
                            value="<?= old('judul_postingan', $post['judul_postingan']) ?>"
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
                                value="<?= old('slug', $post['slug']) ?>"
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
                            required><?= old('konten', $post['konten']) ?></textarea>
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
                            placeholder="Ringkasan postingan (opsional, akan dibuat otomatis jika kosong)"><?= old('excerpt', $post['excerpt']) ?></textarea>
                        <small class="form-text text-muted">Ringkasan akan ditampilkan di halaman daftar postingan</small>
                    </div>

                    <!-- Gambar Postingan -->
                    <div class="form-group">
                        <label for="gambar_postingan">Gambar Utama</label>
                        <input type="file"
                            name="gambar_postingan"
                            class="form-control-file <?= isset($validation) && $validation->hasError('gambar_postingan') ? 'is-invalid' : '' ?>"
                            id="gambar_postingan"
                            accept="image/*"
                            onchange="previewImage(event)">
                        <?php if (isset($validation) && $validation->hasError('gambar_postingan')): ?>
                            <div class="invalid-feedback d-block"><?= $validation->getError('gambar_postingan') ?></div>
                        <?php endif; ?>
                        <small class="form-text text-muted">Maksimal 2MB. Format: JPG, PNG, WebP. Kosongkan jika tidak ingin mengubah gambar</small>

                        <!-- Preview Gambar -->
                        <div id="imagePreviewContainer" class="mt-3">
                            <?php if (!empty($post['gambar_postingan'])): ?>
                                <div class="current-image-container">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="<?= base_url('uploads/postingan/' . $post['gambar_postingan']) ?>"
                                            id="currentImage"
                                            class="img-thumbnail mr-3"
                                            alt="<?= esc($post['judul_postingan']) ?>"
                                            style="max-height: 150px; max-width: 200px;">
                                        <div>
                                            <small class="text-muted d-block">Gambar saat ini</small>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="removeCurrentImage()">
                                                <i class="fa fa-trash"></i> Hapus Gambar
                                            </button>
                                            <input type="hidden" name="remove_current_image" id="removeCurrentImageFlag" value="0">
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Preview untuk gambar baru -->
                            <div id="newImagePreview" class="new-image-preview" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <img id="previewImg" 
                                         class="img-thumbnail mr-3" 
                                         style="max-height: 150px; max-width: 200px;"
                                         alt="Preview">
                                    <div>
                                        <small class="text-success d-block">Preview gambar baru</small>
                                        <button type="button" 
                                                class="btn btn-sm btn-warning" 
                                                onclick="clearNewImage()">
                                            <i class="fa fa-times"></i> Batalkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <option value="<?= $key ?>" <?= old('kategori', $post['kategori']) == $key ? 'selected' : '' ?>>
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
                            value="<?= old('penulis', $post['penulis']) ?>"
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
                                    <?= old('status', $post['status']) == 'draft' ? 'checked' : '' ?>
                                    required>
                                <i class="fa fa-edit text-warning"></i> Draft
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="published"
                                    <?= old('status', $post['status']) == 'published' ? 'checked' : '' ?>>
                                <i class="fa fa-check-circle text-success"></i> Published (Tampil di Website)
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                    name="status"
                                    value="archived"
                                    <?= old('status', $post['status']) == 'archived' ? 'checked' : '' ?>>
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
                            placeholder="Deskripsi untuk SEO (max 160 karakter)"><?= old('meta_description', $post['meta_description']) ?></textarea>
                        <small class="form-text text-muted">Digunakan untuk SEO di mesin pencari</small>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text"
                            name="meta_keywords"
                            class="form-control"
                            id="meta_keywords"
                            value="<?= old('meta_keywords', $post['meta_keywords']) ?>"
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
                            <i class="fa fa-save"></i> Update Postingan
                        </button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript untuk Auto Slug dan Image Management -->
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

    // Image Management Functions
    function previewImage(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('newImagePreview');
        const previewImg = document.getElementById('previewImg');
        const currentImageContainer = document.querySelector('.current-image-container');
        
        if (file) {
            // Validasi tipe file
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Tipe file tidak valid! Hanya JPG, PNG, dan WebP yang diperbolehkan.');
                event.target.value = '';
                return;
            }
            
            // Validasi ukuran file (2MB)
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                event.target.value = '';
                return;
            }
            
            // Tampilkan preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
                
                // Sembunyikan gambar saat ini jika ada
                if (currentImageContainer) {
                    currentImageContainer.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    }
    
    function clearNewImage() {
        const fileInput = document.getElementById('gambar_postingan');
        const previewContainer = document.getElementById('newImagePreview');
        const currentImageContainer = document.querySelector('.current-image-container');
        
        // Reset file input
        fileInput.value = '';
        
        // Sembunyikan preview baru
        previewContainer.style.display = 'none';
        
        // Tampilkan kembali gambar saat ini jika ada
        if (currentImageContainer) {
            currentImageContainer.style.display = 'block';
        }
    }
    
    function removeCurrentImage() {
        const currentImageContainer = document.querySelector('.current-image-container');
        const removeFlag = document.getElementById('removeCurrentImageFlag');
        const fileInput = document.getElementById('gambar_postingan');
        
        if (confirm('Apakah Anda yakin ingin menghapus gambar saat ini?')) {
            // Set flag untuk menghapus gambar
            removeFlag.value = '1';
            
            // Sembunyikan container gambar saat ini
            if (currentImageContainer) {
                currentImageContainer.style.display = 'none';
            }
            
            // Reset file input
            fileInput.value = '';
        }
    }
</script>

<?= $this->endSection() ?>
