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
                        <form action="<?= base_url('home_karyawan/update_daftar/' . $daftar['id_pendaftaran']) ?>" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <!-- Foto Profil -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Foto Profil</label><br>
                                        <?php if (!empty($daftar['foto_profil'])): ?>
                                            <img src="<?= !empty($daftar['foto_profil']) ? base_url('fotosiswa/' . $daftar['foto_profil']) : base_url('template/dist/img/user2-160x160.jpg') ?>"
                                                id="gambar_preview"
                                                class="img-thumbnail"
                                                width="150"
                                                alt="Foto daftar">
                                        <?php else: ?>
                                            <img src="<?= base_url('fotosiswa/default.png') ?>"
                                                id="gambar_preview"
                                                class="img-thumbnail"
                                                width="150"
                                                alt="Default">
                                        <?php endif; ?>
                                        <input type="file"
                                            name="foto_profil"
                                            id="gambar_input"
                                            class="form-control mt-2"
                                            accept="image/*">
                                        <small class="text-muted">Max 1MB (PNG, JPG, JPEG, GIF)</small>
                                    </div>
                                </div>

                                <!-- Data Pribadi -->
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="nama_lengkap"
                                            class="form-control"
                                            value="<?= old('nama_lengkap', $daftar['nama_lengkap'] ?? '') ?>"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email"
                                            name="email"
                                            class="form-control"
                                            value="<?= old('email', $daftar['email'] ?? '') ?>"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label>No Telepon <span class="text-danger">*</span></label>
                                        <input type="text"
                                            name="no_telepon"
                                            class="form-control"
                                            value="<?= old('no_telepon', $daftar['no_telepon'] ?? '') ?>"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat <span class="text-danger">*</span></label>
                                        <textarea name="alamat"
                                            class="form-control"
                                            rows="3"
                                            required><?= old('alamat', $daftar['alamat'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text"
                                            name="tempat_lahir"
                                            class="form-control"
                                            value="<?= old('tempat_lahir', $daftar['tempat_lahir'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date"
                                            name="tanggal_lahir"
                                            class="form-control"
                                            value="<?= old('tanggal_lahir', $daftar['tanggal_lahir'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-laki" <?= old('jenis_kelamin', $daftar['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="Perempuan" <?= old('jenis_kelamin', $daftar['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select name="agama" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="Islam" <?= old('agama', $daftar['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                            <option value="Kristen" <?= old('agama', $daftar['agama'] ?? '') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                            <option value="Katolik" <?= old('agama', $daftar['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                            <option value="Hindu" <?= old('agama', $daftar['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                            <option value="Buddha" <?= old('agama', $daftar['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                            <option value="Konghucu" <?= old('agama', $daftar['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                                <a href="<?= base_url('home_karyawan/pendaftaran') ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</section>

<script>
    // Preview gambar
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
</script>

<?= $this->endSection() ?>