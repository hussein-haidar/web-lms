<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-plus"></i> <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/manajemen') ?>" class="btn btn-default btn-sm float-end">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="<?= base_url('home_superadmin/save_manajemen') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" 
                                   value="<?= old('nama_lengkap') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" 
                                   value="<?= old('jabatan') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="<?= old('email') ?>">
                        </div>

                        <div class="form-group">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control" 
                                   value="<?= old('no_telepon') ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        </div>

                        <div class="form-group">
                            <label for="urutan">Urutan <span class="text-danger">*</span></label>
                            <input type="number" name="urutan" id="urutan" class="form-control" 
                                   value="<?= old('urutan', 1) ?>" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"><?= old('deskripsi') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5>Sosial Media</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" name="facebook" id="facebook" class="form-control" 
                                           value="<?= old('facebook') ?>" placeholder="Username Facebook">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" name="twitter" id="twitter" class="form-control" 
                                           value="<?= old('twitter') ?>" placeholder="Username Twitter">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" name="instagram" id="instagram" class="form-control" 
                                           value="<?= old('instagram') ?>" placeholder="Username Instagram">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <input type="text" name="linkedin" id="linkedin" class="form-control" 
                                           value="<?= old('linkedin') ?>" placeholder="Username LinkedIn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('home_superadmin/manajemen') ?>" class="btn btn-default">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
