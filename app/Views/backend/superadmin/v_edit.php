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
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach ($errors as $key => $value) { ?>
                                <li><?= esc($value) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="box-body">
                    <div class="card-body">

                        <!-- Form Update Profil -->
                        <?= form_open_multipart('home_superadmin/update_profil', ['id' => 'updateProfilForm']) ?>
                        <!-- CSRF Token -->
                        <?= csrf_field() ?>

                        <div class="form-group profile">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                value="<?= old('email', esc($data_profil['email'])) ?>"
                                class="form-control profile"
                                placeholder="Masukkan Email"
                                required>
                            <?php if (session('errors.email')): ?>
                                <small class="text-danger"><?= session('errors.email') ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group profile">
                            <label>Kata Sandi (Kosongkan jika tidak ingin ganti)</label>
                            <input type="password" name="kata_sandi"
                                value="<?= old('kata_sandi') ?>"
                                class="form-control profile"
                                placeholder="Minimal 6 karakter">
                            <?php if (session('errors.kata_sandi')): ?>
                                <small class="text-danger"><?= session('errors.kata_sandi') ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group profile">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap"
                                value="<?= old('nama_lengkap', esc($data_profil['nama_lengkap'])) ?>"
                                class="form-control profile"
                                placeholder="Masukkan Nama Lengkap"
                                required>
                            <?php if (session('errors.nama_lengkap')): ?>
                                <small class="text-danger"><?= session('errors.nama_lengkap') ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group profile">
                            <label>No Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="no_telepon"
                                value="<?= old('no_telepon', esc($data_profil['no_telepon'])) ?>"
                                class="form-control profile"
                                placeholder="Masukkan No Telepon"
                                required>
                            <?php if (session('errors.no_telepon')): ?>
                                <small class="text-danger"><?= session('errors.no_telepon') ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group profile">
                            <label>Foto Profil Terkini</label>
                            <div class="mb-3">
                                <?php if (!empty($data_profil['foto_profil']) && file_exists(FCPATH . 'fotoprofil/' . $data_profil['foto_profil'])): ?>
                                    <img src="<?= base_url('fotoprofil/' . $data_profil['foto_profil']) ?>"
                                        id="gambar_preview"
                                        class="img-thumbnail"
                                        width="150px"
                                        height="150px">
                                <?php else: ?>
                                    <img src="<?= base_url('fotoprofil/default.png') ?>"
                                        id="gambar_preview"
                                        class="img-thumbnail"
                                        width="150px"
                                        height="150px">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group profile">
                            <label>Upload Foto Profil Baru</label>
                            <input type="file"
                                class="form-control profile"
                                name="foto_profil"
                                id="foto_profil"
                                accept="image/*"
                                onchange="previewImage(this)">
                            <?php if (session('errors.foto_profil')): ?>
                                <small class="text-danger"><?= session('errors.foto_profil') ?></small>
                            <?php endif; ?>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('home_siswa/profil') ?>" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</section>

<!-- Preview Image Script -->
<script>
    function previewImage(input) {
        const preview = document.getElementById('gambar_preview');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>