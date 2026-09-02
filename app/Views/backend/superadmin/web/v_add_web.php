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

                        <?php echo form_open_multipart('home_superadmin/save_web'); ?>
                        <!-- ✅ CSRF TOKEN WAJIB DITAMBAHKAN -->
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <label>Nama Website</label>
                            <textarea name="nama_website" class="form-control" rows="3" placeholder="Masukkan nama"><?= old('nama_website') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Logo (Unggah file gambar)</label>
                            <input type="file" name="logo" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label>Banner Utama</label>
                            <input type="file" name="banner_utama" class="form-control-file" accept="image/*">
                        </div>

                        <div class="form-group mb-3">
                            <label>URL YouTube (Embed Link)</label>
                            <input type="text" name="url_yt" class="form-control" placeholder="https://youtube.com/..." value="<?= old('url_yt') ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"><?= old('alamat') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" placeholder="Contoh: +62 857-9674-08" value="<?= old('no_telepon') ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label>Email Kontak</label>
                            <input type="email" name="email_kontak" class="form-control" placeholder="kontak@tokomu.com" value="<?= old('email_kontak') ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label>Jam Kerja</label>
                            <input type="text" name="jam_kerja" class="form-control" placeholder="Senin–Jumat, 08.00–17.00" value="<?= old('jam_kerja') ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label>Sejarah Lengkap Toko/Perusahaan</label>
                            <textarea name="sejarah_lengkap" class="form-control" rows="5"><?= old('sejarah_lengkap') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Meta Description (SEO)</label>
                            <textarea name="meta_description" class="form-control" rows="2" placeholder="Deskripsi untuk mesin pencari"><?= old('meta_description') ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Meta Keywords (SEO)</label>
                            <input type="text" name="meta_keywords" class="form-control" placeholder="kata,kunci,produk,lokal" value="<?= old('meta_keywords') ?>">
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">Simpan Data Website</button>
                            <a href="<?= base_url('home_superadmin/web') ?>" class="btn btn-secondary">Kembali</a>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
    </div>
    </div>
</section>

<?= $this->endSection() ?>