<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit <?= $title2 ?></h3>
                    
                    <!-- Tombol Kembali -->
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('home_superadmin/materi/' . $modul['id_modul']) ?>" 
                           class="btn btn-sm btn-warning">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="box-body">
                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                            <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>

                    <?php $errors = session()->getFlashdata('errors');
                    if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?= form_open('home_superadmin/update_materi/' . $materi['id_materi']) ?>
                    <?= csrf_field() ?>

                    <input type="hidden" name="id_modul" value="<?= $modul['id_modul'] ?>">
                    <input type="hidden" name="id_kursus" value="<?= $kursus['id_kursus'] ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" name="judul_materi" class="form-control" 
                                       value="<?= old('judul_materi', $materi['judul_materi']) ?>" 
                                       placeholder="Contoh: Pengenalan HTML" required>
                            </div>

                            <div class="form-group">
                                <label>Tipe Materi <span class="text-danger">*</span></label>
                                <select name="tipe_materi" class="form-control" id="tipe_materi" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="youtube" <?= old('tipe_materi', $materi['tipe_materi']) == 'youtube' ? 'selected' : '' ?>>YouTube Video</option>
                                    <option value="zoom" <?= old('tipe_materi', $materi['tipe_materi']) == 'zoom' ? 'selected' : '' ?>>Zoom Meeting</option>
                                    <option value="quiz" <?= old('tipe_materi', $materi['tipe_materi']) == 'quiz' ? 'selected' : '' ?>>Quiz</option>
                                    <option value="text" <?= old('tipe_materi', $materi['tipe_materi']) == 'text' ? 'selected' : '' ?>>Text Content</option>
                                </select>
                            </div>


                            <!-- Zoom Fields -->
                            <div id="zoomFields" class="tipe-fields" style="display: none;">
                                <div class="form-group">
                                    <label>URL Zoom/Meeting</label>
                                    <input type="url" name="url_zoom" class="form-control" 
                                           value="<?= old('url_zoom', $materi['url_zoom'] ?? '') ?>" 
                                           placeholder="https://zoom.us/j/... atau https://meet.google.com/...">
                                </div>
                                <div class="form-group">
                                    <label>Detail Meeting</label>
                                    <textarea name="konten_text" class="form-control" rows="3" 
                                              placeholder="Jadwal, password, dan informasi meeting lainnya..."><?= old('konten_text', $materi['konten_text'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Quiz Fields -->
                            <div id="quizFields" class="tipe-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Detail Quiz</label>
                                    <textarea name="konten_text" class="form-control" rows="4" 
                                              placeholder="Format ujian, jumlah soal, durasi, passing grade, dan materi yang diujikan..."><?= old('konten_text', $materi['konten_text'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <!-- Text Fields -->
                            <div id="textFields" class="tipe-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Konten Text</label>
                                    <textarea name="konten_text" class="form-control" rows="6" 
                                              placeholder="Masukkan konten materi dalam format text..."><?= old('konten_text', $materi['konten_text'] ?? '') ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Materi</label>
                                <textarea name="deskripsi_materi" class="form-control" rows="3" 
                                          placeholder="Deskripsi singkat tentang materi ini..."><?= old('deskripsi_materi', $materi['deskripsi_materi'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Urutan <span class="text-danger">*</span></label>
                                <input type="number" name="urutan" class="form-control" 
                                       value="<?= old('urutan', $materi['urutan']) ?>" min="1" required>
                                <small class="text-muted">Nomor urutan materi dalam modul</small>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_preview" value="1" 
                                               <?= old('is_preview', $materi['is_preview']) ? 'checked' : '' ?>>
                                        Tampilkan sebagai Preview
                                    </label>
                                    <small class="text-muted">Materi preview dapat diakses tanpa login</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Modul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" 
                                       value="<?= esc($modul['nama_modul']) ?>" readonly>
                                <small class="text-muted">Materi akan ditambahkan ke modul ini</small>
                            </div>

                            <div class="form-group">
                                <label>Kursus <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" 
                                       value="<?= esc($kursus['nama_kursus']) ?>" readonly>
                                <small class="text-muted">Modul ini termasuk dalam kursus ini</small>
                            </div>

                            <!-- Info Box -->
                            <div class="box box-solid box-info">
                                <div class="box-header">
                                    <h4 class="box-title">
                                        <i class="fa fa-info-circle"></i> Info Materi
                                    </h4>
                                </div>
                                <div class="box-body">
                                    <p><strong>Kursus:</strong><br><?= esc($kursus['nama_kursus']) ?></p>
                                    <p><strong>Modul:</strong><br><?= esc($modul['nama_modul']) ?></p>
                                    <p><strong>ID Materi:</strong><br><?= $materi['id_materi'] ?></p>
                                    <hr>
                                    <small class="text-muted">
                                        Materi ini termasuk dalam modul di atas.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-save"></i> Update Materi
                        </button>
                        <a href="<?= base_url('home_superadmin/materi/' . $modul['id_modul']) ?>" 
                           class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Batal
                        </a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('tipe_materi').addEventListener('change', function() {
        // Hide all tipe fields
        document.querySelectorAll('.tipe-fields').forEach(function(field) {
            field.style.display = 'none';
        });

        // Show selected tipe field
        var selectedValue = this.value;
        if (selectedValue) {
            var fieldId = selectedValue + 'Fields';
            var field = document.getElementById(fieldId);
            if (field) {
                field.style.display = 'block';
            }
        }
    });

    // Trigger change on page load if value is set
    if (document.getElementById('tipe_materi').value) {
        document.getElementById('tipe_materi').dispatchEvent(new Event('change'));
    }
</script>

<?= $this->endSection() ?>