<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h5 class="card-title">Tambah <?= $title2 ?></h5>
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
                        <?= form_open_multipart('home_karyawan/save_siswa') ?>
                        <?= csrf_field() ?> <!-- ← BARIS INI YANG KURANG! -->

                        <div class="form-group mb-3">
                            <label>NIS *</label>
                            <input type="text" name="nis" class="form-control" value="<?= old('nis') ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Password *</label>
                            <input type="password" name="kata_sandi" class="form-control" required minlength="6">
                        </div>
                        <div class="form-group mb-3">
                            <label>No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="<?= old('no_telepon') ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"><?= old('alamat') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Foto Profil</label>
                            <input type="file" name="foto_profil" class="form-control-file" accept="image/*">
                        </div>

                        <!-- Level biasanya default 'instruktur' atau diatur oleh sistem -->
                        <input type="hidden" name="level" value="siswa">

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Simpan Siswa</button>
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

<?= $this->endSection() ?>