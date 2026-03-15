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

                        <?= form_open_multipart('home_siswa/update_kumpul/' . ($kml['id_kumpul'] ?? '')) ?>

                        <input type="hidden" name="id_tugas" value="<?= $kml['id_tugas'] ?? '' ?>">

                        <!-- Informasi Tugas -->
                        <div class="form-group mb-3">
                            <label><strong>Informasi Tugas</strong></label>
                            <div class="well well-sm" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
                                <p class="mb-1"><strong>ID Tugas:</strong> <?= $kml['id_tugas'] ?? '' ?></p>
                                <p class="mb-1"><strong>Tanggal Kirim:</strong> <?= !empty($kml['tanggal_kirim']) ? date('d-m-Y H:i', strtotime($kml['tanggal_kirim'])) : '–' ?></p>
                                <p class="mb-0"><strong>Status:</strong>
                                    <?php if (($kml['status_penilaian'] ?? '') == 'sudah_dinilai'): ?>
                                        <span class="label label-success">Sudah Dinilai</span>
                                    <?php else: ?>
                                        <span class="label label-warning">Menunggu Penilaian</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group mb-3">
                            <label>Catatan *</label>
                            <textarea name="catatan_siswa" class="form-control <?= session('errors.catatan_siswa') ? 'is-invalid' : '' ?>" rows="4" required><?= old('catatan_siswa', $kml['catatan_siswa'] ?? '') ?></textarea>
                            <?php if (session('errors.catatan_siswa')): ?>
                                <div class="invalid-feedback"><?= session('errors.catatan_siswa') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- File Tugas Lama -->
                        <div class="form-group mb-3">
                            <label><strong>File Terupload Saat Ini</strong></label>
                            <div class="well well-sm" style="background-color: #e8f5e9; padding: 15px; border-radius: 5px;">
                                <?php if (!empty($kml['file_tugas'])): ?>
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-file-pdf-o fa-3x text-danger mr-3"></i>
                                        <div>
                                            <p class="mb-1"><strong><?= esc($kml['file_tugas']) ?></strong></p>
                                            <a href="<?= base_url('kursus/tugassiswa/' . $kml['file_tugas']) ?>" target="_blank" class="btn btn-info btn-xs">
                                                <i class="fa fa-download"></i> Download File
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted mb-0">Belum ada file terupload</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Ganti File (Opsional) -->
                        <div class="form-group mb-3">
                            <label>Ganti File Tugas (PDF/DOC/DOCX/TXT) - Opsional</label>
                            <input type="file" name="file_tugas" class="form-control-file <?= session('errors.file_tugas') ? 'is-invalid' : '' ?>" accept=".pdf,.doc,.docx,.txt">
                            <?php if (session('errors.file_tugas')): ?>
                                <div class="invalid-feedback"><?= session('errors.file_tugas') ?></div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Kosongkan jika tidak ingin mengganti file. 
                                Jika diisi, file lama akan diganti dengan file baru.
                            </small>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="form-group mb-0">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('home_siswa/kumpul_tugas') ?>" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-save"></i> Update Pengumpulan
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