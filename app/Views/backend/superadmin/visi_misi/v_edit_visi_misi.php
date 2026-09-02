<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-edit"></i> <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/visi_misi') ?>" class="btn btn-default btn-sm float-end">
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

            <?php if (!empty($visimisi)): ?>
            <form action="<?= base_url('home_superadmin/update_visi_misi/' . $visimisi['id_visimisi']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis">Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="visi" <?= old('jenis', $visimisi['jenis'] ?? '') == 'visi' ? 'selected' : '' ?>>Visi</option>
                                <option value="misi" <?= old('jenis', $visimisi['jenis'] ?? '') == 'misi' ? 'selected' : '' ?>>Misi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="urutan">Urutan <span class="text-danger">*</span></label>
                            <input type="number" name="urutan" id="urutan" class="form-control"
                                   value="<?= old('urutan', $visimisi['urutan'] ?? 1) ?>" min="1" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="aktif" <?= old('status', $visimisi['status'] ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status', $visimisi['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="konten">Konten <span class="text-danger">*</span></label>
                    <textarea name="konten" id="konten" class="form-control" rows="5"
                              required><?= old('konten', $visimisi['konten'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('home_superadmin/visi_misi') ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i> Data visi/misi tidak ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
