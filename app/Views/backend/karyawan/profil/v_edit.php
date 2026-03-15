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
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="box-body">
                    <?= form_open_multipart('home_karyawan/update_profil') ?>
                    <?= csrf_field() ?>

                    <!-- Foto saat ini -->
                  <div class="form-group">
                        <label>Foto Profil</label>
                        <p></p>
                        <img src="<?= base_url('fotoprofil/' . ($result['foto_profil'] ?? 'default.png')) ?>" 
                             class="img-circle" 
                             width="100" height="100"
                             onerror="this.src='<?= base_url('assets/img/default-user.png') ?>'">
                    </div>

                    <!-- Upload baru -->
                    <div class="form-group mb-3">
                        <label>Upload Foto Baru (Opsional)</label>
                        <input type="file" name="foto_profil" id="gambar_input" 
                               class="form-control-file" accept="image/*">
                    </div>

                     <div class="form-group">
                    <label>Email</label>
                    <input name="email" value="<?= esc($result['email'] ?? '') ?>" 
                           class="form-control" required>
                </div>

                   <div class="form-group">
                    <label>NIP</label>
                    <input name="nip" value="<?= esc($result['nip'] ?? '') ?>" 
                           class="form-control" required>
                </div>

                            <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input name="nama_lengkap" value="<?= esc($result['nama_lengkap'] ?? '') ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" value="<?= esc($result['no_telepon'] ?? '') ?>" 
                           class="form-control" required>
                </div>

                    <div class="form-group mb-3">
                        <label>Password Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="kata_sandi" class="form-control" minlength="6">
                    </div>

                                       <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="<?= esc($result['alamat'] ?? '') ?>" 
                           class="form-control" required>
                </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">Perbarui Data</button>
                        <a href="<?= base_url('home_karyawan/profil') ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Batal
                        </a>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('gambar_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('gambar_preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?= $this->endSection() ?>