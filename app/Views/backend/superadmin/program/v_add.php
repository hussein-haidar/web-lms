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
                <div class="box-body">
                    <div class="card-body">

                        <?= form_open('home_superadmin/save_program') ?>
                        <?= csrf_field() ?>
                        
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label>Nama Program *</label>
                                <input type="text" name="nama_program" class="form-control" value="<?= old('judul_program') ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Deskripsi *</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?= old('deskripsi') ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-success">Simpan Program</button>
                                <a href="<?= base_url('home_superadmin/program') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
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