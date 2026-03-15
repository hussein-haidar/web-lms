<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h5 class="card-title">Edit <?= $title2 ?></h5>
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
                        <?= form_open_multipart(base_url('home_karyawan/update_tugas/' . ($tugas['id_tugas'] ?? ''))) ?>
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label>Kursus <span class="text-danger">*</span></label>
                            <select name="id_kursus" class="form-control" required>
                                <option value="">-- Pilih Kursus --</option>
                                <?php foreach ($kursus as $k): ?>
                                    <option value="<?= $k['id_kursus'] ?>" <?= ($tugas['id_kursus'] ?? 0) == $k['id_kursus'] ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kursus']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Judul Tugas -->
                        <div class="form-group mb-3">
                            <label>Nama Tugas <span class="text-danger">*</span></label>
                            <input type="text" name="judul_tugas" class="form-control"
                                value="<?= esc($tugas['judul_tugas'] ?? old('judul_tugas')) ?>" required maxlength="255">
                        </div>

                        <!-- Upload File Tugas (Opsional) -->
                        <div class="form-group mb-3">
                            <label>Upload File Tugas (Opsional)</label>
                            <div class="alert alert-info">
                                <strong><i class="fa fa-info-circle"></i> Petunjuk Pengisian:</strong><br>
                                • <strong>Jika ingin mengganti file tugas</strong>, pilih file baru di bawah.<br>
                                • <strong>Jika tidak ingin mengganti file</strong>, biarkan kosong - file lama akan tetap disimpan.<br>
                                • Format yang diizinkan: PDF, DOC, DOCX, TXT (Maksimal 10 MB)
                            </div>

                            <!-- Tampilkan file saat ini -->
                            <?php if (!empty($tugas['dokumen_tugas'])): ?>
                                <div class="mb-2">
                                    <strong>File saat ini:</strong><br>
                                    <a href="<?= base_url('kursus/tugas/' . $tugas['dokumen_tugas']) ?>" target="_blank">
                                        <?= esc($tugas['dokumen_tugas']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <input type="file" name="dokumen_tugas" class="form-control-file" accept=".pdf,.doc,.docx,.txt">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file</small>
                        </div>

                        <!-- Deskripsi Tugas -->
                        <div class="form-group mb-3">
                            <label>Deskripsi Tugas <span class="text-danger">*</span></label>
                            <div class="alert alert-warning">
                                <strong><i class="fa fa-exclamation-triangle"></i> Wajib Diisi:</strong><br>
                                • Kolom ini <strong>WAJIB diisi</strong> baik Anda mengupload file maupun tidak.<br>
                                • Jika ada file tugas, gunakan deskripsi untuk menjelaskan detail tugas.<br>
                                • Jika tidak ada file tugas, tuliskan seluruh instruksi tugas di sini.
                            </div>
                            <textarea name="deskripsi" class="form-control" rows="6" required
                                placeholder="Contoh: 
1. Buat laporan praktikum komputer
2. Format PDF atau DOC
3. Deadline: 15 Desember 2024"><?= esc($tugas['deskripsi'] ?? old('deskripsi')) ?></textarea>
                        </div>

                        <!-- Tenggat Waktu -->
                        <div class="form-group mb-3">
                            <label>Tenggat Waktu <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="deadline" class="form-control"
                                value="<?= isset($tugas['deadline']) ? date('Y-m-d\TH:i', strtotime($tugas['deadline'])) : (old('deadline') ? date('Y-m-d\TH:i', strtotime(old('deadline'))) : '') ?>" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Perbarui Tugas
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