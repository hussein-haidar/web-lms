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
                <?php if (session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
                <?php endif; ?>

                <?php
                $errors = session()->getFlashdata('errors');
                if (!empty($errors)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach ($errors as $key => $value) { ?>
                                <li><?= esc($value) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="card-body">

                        <?php echo form_open_multipart('home_superadmin/update_web/' . $web['id_setting']); ?>
                        <!-- ✅ CSRF TOKEN WAJIB DITAMBAHKAN -->
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <label>Nama Website</label>
                            <input type="text" name="nama_website" class="form-control" value="<?= esc($web['nama_website'] ?? '') ?>" placeholder="Masukkan Nama">
                        </div>

                        <div class="form-group">
                            <label>Logo Terkini</label>
                            <div class="preview-container" style="margin-top: 5px;">
                                <img src="<?= !empty($web['logo']) ? base_url('logo/' . $web['logo']) : base_url('assets/img/placeholder-logo.png') ?>"
                                    id="logo_preview"
                                    class="img-preview"
                                    width="100"
                                    alt="Logo Saat Ini">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Upload Logo Baru</label>
                            <input type="file" class="form-control" name="logo" id="logo_input" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label>Banner Terkini</label>
                            <div class="preview-container" style="margin-top: 5px;">
                                <img src="<?= !empty($web['banner_utama']) ? base_url('banner/' . $web['banner_utama']) : base_url('assets/img/placeholder-banner.png') ?>"
                                    id="banner_preview"
                                    class="img-preview"
                                    width="100"
                                    alt="Banner Saat Ini">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Upload Banner Baru</label>
                            <input type="file" class="form-control" name="banner_utama" id="banner_input" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label>URL YouTube</label>
                            <input type="text" name="url_yt" class="form-control" value="<?= esc($web['url_yt'] ?? '') ?>" placeholder="https://youtube.com/...">
                        </div>

                        <div class="form-group mb-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3"><?= esc($web['alamat'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="<?= esc($web['no_telepon'] ?? '') ?>" placeholder="Contoh: +62 857-9674-08">
                        </div>

                        <div class="form-group mb-3">
                            <label>Email Kontak</label>
                            <input type="email" name="email_kontak" class="form-control" value="<?= esc($web['email_kontak'] ?? '') ?>" placeholder="kontak@tokomu.com">
                        </div>

                        <div class="form-group mb-3">
                            <label>Jam Kerja</label>
                            <input type="text" name="jam_kerja" class="form-control" value="<?= esc($web['jam_kerja'] ?? '') ?>" placeholder="Senin–Jumat, 08.00–17.00">
                        </div>

                        <div class="form-group mb-3">
                            <label>Sejarah Lengkap</label>
                            <textarea name="sejarah_lengkap" class="form-control" rows="5"><?= esc($web['sejarah_lengkap'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Meta Description (SEO)</label>
                            <textarea name="meta_description" class="form-control" rows="2"><?= esc($web['meta_description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Meta Keywords (SEO)</label>
                            <input type="text" name="meta_keywords" class="form-control" value="<?= esc($web['meta_keywords'] ?? '') ?>" placeholder="kata,kunci,produk,lokal">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Perbarui Data</button>
                            <a href="<?= base_url('home_superadmin/web') ?>" class="btn btn-secondary">Kembali</a>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function previewImage(inputId, imgId) {
            const input = document.getElementById(inputId);
            const img = document.getElementById(imgId);

            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Untuk logo website
        previewImage('logo_input', 'logo_preview');

        // Untuk background website
        previewImage('banner_input', 'banner_preview');

    });
</script>

<?= $this->endSection() ?>