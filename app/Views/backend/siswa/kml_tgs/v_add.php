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
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Perhatian!</h4>
                        <ul>
                            <?php foreach ($errors as $key => $value) { ?>
                                <li><?= esc($value) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="box-body">
                    <div class="card-body">

                        <?= form_open_multipart('home_siswa/save_kumpul') ?>
                        <?= csrf_field() ?>

                        <!-- Tugas: dropdown atau hidden jika dari link -->
                        <div class="form-group mb-3">
                            <label><strong>Pilih Tugas</strong> <span class="text-danger">*</span></label>
                            <?php if (!empty($id_tugas)): ?>
                                <input type="hidden" name="id_tugas" value="<?= esc($id_tugas) ?>">
                                <div class="well well-sm" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
                                    <p class="mb-0">Tugas ID: <?= esc($id_tugas) ?></p>
                                </div>
                            <?php else: ?>
                                <select name="id_tugas" class="form-control" required>
                                    <option value="">-- Pilih Tugas --</option>
                                    <?php if (!empty($tugas) && is_array($tugas)): foreach ($tugas as $tg): ?>
                                        <option value="<?= $tg['id_tugas'] ?? '' ?>"><?= esc($tg['nama_tugas'] ?? $tg['judul_tugas'] ?? '') ?> (<?= esc($tg['nama_kursus'] ?? '') ?>)</option>
                                    <?php endforeach; endif; ?>
                                </select>
                            <?php endif; ?>
                        </div>

                        <!-- Informasi Tugas (jika dari link) -->
                        <div class="form-group mb-3">
                            <label><strong>Informasi Tugas</strong></label>
                            <div class="well well-sm" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
                                <p class="mb-1"><strong>Nama Tugas:</strong> <?= esc($nama_tugas ?? 'Pilih tugas di atas') ?></p>
                                <p class="mb-0"><strong>Status:</strong>
                                    <span class="label label-primary">Belum Dikumpulkan</span>
                                </p>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group mb-3">
                            <label>Catatan *</label>
                            <textarea name="catatan_siswa" class="form-control <?= session('errors.catatan_siswa') ? 'is-invalid' : '' ?>" rows="4" required placeholder="Tuliskan catatan atau penjelasan tentang tugas Anda..."><?= old('catatan_siswa') ?></textarea>
                            <?php if (session('errors.catatan_siswa')): ?>
                                <div class="invalid-feedback"><?= session('errors.catatan_siswa') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Upload File Tugas -->
                        <div class="form-group mb-3">
                            <label>Upload File Tugas *</label>
                            <input type="file" name="file_tugas" class="form-control-file <?= session('errors.file_tugas') ? 'is-invalid' : '' ?>" accept=".pdf,.doc,.docx,.txt" required>
                            <?php if (session('errors.file_tugas')): ?>
                                <div class="invalid-feedback"><?= session('errors.file_tugas') ?></div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i>
                                Format yang diizinkan: PDF, DOC, DOCX, TXT (Maksimal 2 MB)
                            </small>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="form-group mb-0">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('home_siswa/kumpul_tugas') ?>" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-upload"></i> Kirim Tugas
                                </button>
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