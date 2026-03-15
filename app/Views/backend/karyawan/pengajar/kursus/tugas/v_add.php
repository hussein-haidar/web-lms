<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h5 class="card-title">Tambah <?= $title2 ?></h5>
                </div>

                <?php if (!empty(session()->getFlashdata('errors'))): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="box-body">
                    <div class="card-body">
                        <?= form_open_multipart(base_url('home_karyawan/save_tugas')) ?>
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label>Kursus <span class="text-danger">*</span></label>
                            <select name="id_kursus" class="form-control" required>
                                <option value="">-- Pilih Kursus --</option>
                                <?php foreach ($kursus as $k): ?>
                                    <option value="<?= $k['id_kursus'] ?>" <?= old('id_kursus') == $k['id_kursus'] ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kursus']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Judul Tugas -->
                        <div class="form-group mb-3">
                            <label>Nama Tugas <span class="text-danger">*</span></label>
                            <input type="text" name="judul_tugas" class="form-control" value="<?= old('judul_tugas') ?>" required maxlength="255">
                        </div>

                        <!-- Upload Tugas - Dengan Instruksi Jelas -->
                        <div class="form-group mb-3">
                            <label>Upload File Tugas (Opsional)</label>
                            <div class="alert alert-info">
                                <strong><i class="fa fa-info-circle"></i> Petunjuk Pengisian:</strong><br>
                                • <strong>Jika ingin mengupload file tugas</strong> (PDF, DOC, DOCX, TXT),
                                silakan pilih file di bawah ini.<br>
                                • <strong>Jika tidak mengupload file</strong>, cukup isi deskripsi tugas
                                di kolom "Deskripsi Tugas" di bawah.
                            </div>
                            <input type="file" name="dokumen_tugas" class="form-control-file" accept=".pdf,.doc,.docx,.txt">
                            <small class="text-muted">Format: PDF, DOC, DOCX, TXT (Maksimal 10 MB)</small>
                        </div>

                        <!-- Deskripsi Tugas -->
                        <div class="form-group mb-3">
                            <label>Deskripsi Tugas <span class="text-danger">*</span></label>
                            <div class="alert alert-warning">
                                <strong><i class="fa fa-exclamation-triangle"></i> Wajib Diisi:</strong><br>
                                • Kolom ini <strong>WAJIB diisi</strong> baik Anda mengupload file maupun tidak.<br>
                                • Jika mengupload file, gunakan deskripsi untuk menjelaskan detail tugas.<br>
                                • Jika tidak mengupload file, tuliskan seluruh instruksi tugas di sini.
                            </div>
                            <textarea name="deskripsi" class="form-control" rows="6" required
                                placeholder="Contoh: 
1. Buat laporan praktikum komputer
2. Format PDF atau DOC
3. Deadline: 15 Desember 2024"><?= old('deskripsi') ?></textarea>
                        </div>

                        <!-- Tenggat Waktu -->
                        <div class="form-group mb-3">
                            <label>Tenggat Waktu <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="tenggat_waktu" class="form-control"
                                value="<?= old('tenggat_waktu') ? date('Y-m-d\TH:i', strtotime(old('tenggat_waktu'))) : '' ?>" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan Tugas
                            </button>
                            <a href="<?= base_url('home_karyawan/tugas') ?>" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</section>

<?= $this->endSection() ?>