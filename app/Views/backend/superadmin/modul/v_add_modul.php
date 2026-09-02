<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="card-title">Tambah <?= $title2 ?></h5>
                </div>
                <div class="box-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?= form_open('home_superadmin/save_modul') ?>
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Modul <span class="text-danger">*</span></label>
                                <input type="text" name="nama_modul" class="form-control" value="<?= old('nama_modul') ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Urutan <span class="text-danger">*</span></label>
                                <input type="number" name="urutan" class="form-control" value="<?= old('urutan', 1) ?>" min="1" required>
                                <small class="text-muted">Nomor urutan modul dalam kursus</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kursus <span class="text-danger">*</span></label>
                                <?php
                                    $display_kursus_name = '';
                                    $selected_id_kursus = old('id_kursus');
                                    
                                    if (isset($selected_kursus)) {
                                        $selected_id_kursus = $selected_kursus;
                                        
                                        // Find the kursus name
                                        foreach ($kursus_list as $k) {
                                            if ($k['id_kursus'] == $selected_kursus) {
                                                $display_kursus_name = esc($k['nama_kursus']);
                                                break;
                                            }
                                        }
                                    }
                                ?>
                                
                                <?php if (isset($selected_kursus)): ?>
                                    <input type="text" class="form-control" value="<?= $display_kursus_name ?>" readonly>
                                    <input type="hidden" name="id_kursus" value="<?= $selected_kursus ?>">
                                    <small class="text-muted">Kursus untuk modul ini</small>
                                <?php else: ?>
                                    <select name="id_kursus" class="form-control" required>
                                        <option value="">-- Pilih Kursus --</option>
                                        <?php if (!empty($kursus_list)): ?>
                                            <?php foreach ($kursus_list as $k): ?>
                                                <option value="<?= $k['id_kursus'] ?>" 
                                                    <?= old('id_kursus') == $k['id_kursus'] ? 'selected' : '' ?>>
                                                    <?= esc($k['nama_kursus']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <small class="text-muted">Pilih kursus untuk modul ini</small>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Modul</label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi singkat tentang modul ini..."><?= old('deskripsi') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan Modul
                        </button>
                        <a href="<?= base_url('home_superadmin/kursus') ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Batal
                        </a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>