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
                <!-- pop up alert -->
                <?php
                $errors = session()->getFlashdata('errors');
                if (!empty($errors)) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        <ul>
                            <?php foreach ($errors as $key => $value) { ?>
                                <li><?= esc($value) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="box-body">
                    <div class="card-body">

                        <!-- ✅ TAMBAHKAN CSRF TOKEN -->
                        <?= form_open_multipart('home_karyawan/update_siswa/' . ($siswa['id_siswa'] ?? '')) ?>
                        <?= csrf_field() ?> <!-- ← BARIS INI YANG KURANG! -->

                        <!-- Foto saat ini -->
                        <div class="form-group">
                            <label>Foto Saat Ini</label>
                            <div class="preview-container" style="margin-top: 5px;">
                                <img src="<?= !empty($siswa['foto_profil']) ? base_url('fotosiswa/' . $siswa['foto_profil']) : base_url('assets/img/placeholder-logo.png') ?>"
                                    id="gambar_preview"
                                    class="img-preview"
                                    width="100"
                                    alt="Foto Saat Ini">
                            </div>
                        </div>

                        <!-- Foto baru -->
                        <div class="form-group mb-3">
                            <label>Upload Foto Baru (Opsional)</label>
                            <input type="file" name="foto_profil" id="gambar_input" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label>NIS</label>
                            <input type="text" name="nis" class="form-control" value="<?= esc($siswa['nis'] ?? '') ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= esc($siswa['nama_lengkap'] ?? '') ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" value="<?= esc($siswa['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="kata_sandi" class="form-control" minlength="6">
                        </div>
                        <div class="form-group mb-3">
                            <label>No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="<?= esc($siswa['no_telepon'] ?? '') ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"><?= esc($siswa['alamat'] ?? '') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Perbarui Data</button>
                            <a href="<?= base_url('home_karyawan/siswa') ?>" class="btn btn-secondary">Kembali</a>
                        </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
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
        previewImage('gambar_input', 'gambar_preview');

    });
</script>

<?= $this->endSection() ?>