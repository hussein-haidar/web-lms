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

                    <?= form_open('home_superadmin/save_materi') ?>
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kursus <span class="text-danger">*</span></label>
                                <?php
                                    $display_kursus_name = '';
                                    $selected_id_kursus = old('id_kursus');
                                    $is_kursus_readonly = false;
                                    
                                    if (isset($selected_kursus)) {
                                        $selected_id_kursus = $selected_kursus;
                                        $is_kursus_readonly = true;
                                    }

                                    foreach ($kursus_list as $k) {
                                        if ($k['id_kursus'] == $selected_id_kursus) {
                                            $display_kursus_name = esc($k['nama_kursus']);
                                            break;
                                        }
                                    }
                                ?>
                                
                                <?php if ($is_kursus_readonly): ?>
                                    <input type="text" class="form-control" value="<?= $display_kursus_name ?>" readonly>
                                    <input type="hidden" name="id_kursus" value="<?= $selected_id_kursus ?>">
                                    <small class="text-muted">Kursus untuk materi ini</small>
                                <?php else: ?>
                                    <select name="id_kursus" class="form-control" id="kursusSelect" required>
                                        <option value="">-- Pilih Kursus --</option>
                                        <?php if (!empty($kursus_list)): ?>
                                            <?php foreach ($kursus_list as $k): ?>
                                                <option value="<?= $k['id_kursus'] ?>" <?= old('id_kursus') == $k['id_kursus'] ? 'selected' : '' ?>>
                                                    <?= esc($k['nama_kursus']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Modul <span class="text-danger">*</span></label>
                                <?php
                                    $display_modul_name = '';
                                    $selected_id_modul = old('id_modul');
                                    $is_modul_readonly = false;
                                    
                                    if (isset($selected_modul)) {
                                        $selected_id_modul = $selected_modul;
                                        $is_modul_readonly = true;
                                    }

                                    foreach ($modul_list as $m) {
                                        if ($m['id_modul'] == $selected_id_modul) {
                                            $display_modul_name = esc($m['nama_modul']);
                                            break;
                                        }
                                    }
                                ?>
                                
                                <?php if ($is_modul_readonly): ?>
                                    <input type="text" class="form-control" value="<?= $display_modul_name ?>" readonly>
                                    <input type="hidden" name="id_modul" value="<?= $selected_id_modul ?>">
                                    <small class="text-muted">Modul untuk materi ini</small>
                                <?php else: ?>
                                    <select name="id_modul" class="form-control" id="modulSelect" required>
                                        <option value="">-- Pilih Modul --</option>
                                        <?php if (!empty($modul_list)): ?>
                                            <?php foreach ($modul_list as $m): ?>
                                                <option value="<?= $m['id_modul'] ?>" data-kursus="<?= $m['id_kursus'] ?>" <?= old('id_modul') == $m['id_modul'] ? 'selected' : '' ?>>
                                                    <?= esc($m['nama_modul']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" name="judul_materi" class="form-control" value="<?= old('judul_materi') ?>" placeholder="Contoh: Pengenalan HTML" required>
                            </div>

                            <div class="form-group">
                                <label>Tipe Materi <span class="text-danger">*</span></label>
                                <select name="tipe_materi" class="form-control" id="tipe_materi" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="youtube" <?= old('tipe_materi') == 'youtube' ? 'selected' : '' ?>>YouTube Video</option>
                                    <option value="zoom" <?= old('tipe_materi') == 'zoom' ? 'selected' : '' ?>>Zoom Meeting</option>
                                    <option value="quiz" <?= old('tipe_materi') == 'quiz' ? 'selected' : '' ?>>Quiz</option>
                                    <option value="text" <?= old('tipe_materi') == 'text' ? 'selected' : '' ?>>Text Content</option>
                                </select>
                            </div>


                            <!-- Zoom Fields -->
                            <div id="zoomFields" class="tipe-fields" style="display: none;">
                                <div class="form-group">
                                    <label>URL Zoom/Meeting</label>
                                    <input type="url" name="url_zoom" class="form-control" value="<?= old('url_zoom') ?>" placeholder="https://zoom.us/j/... atau https://meet.google.com/...">
                                </div>
                                <div class="form-group">
                                    <label>Detail Meeting</label>
                                    <textarea name="konten_text" class="form-control" rows="3" placeholder="Jadwal, password, dan informasi meeting lainnya..."><?= old('konten_text') ?></textarea>
                                </div>
                            </div>

                            <!-- Quiz Fields -->
                            <div id="quizFields" class="tipe-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Detail Quiz</label>
                                    <textarea name="konten_text" class="form-control" rows="4" placeholder="Format ujian, jumlah soal, durasi, passing grade, dan materi yang diujikan..."><?= old('konten_text') ?></textarea>
                                </div>
                            </div>

                            <!-- Text Fields -->
                            <div id="textFields" class="tipe-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Konten Text</label>
                                    <textarea name="konten_text" class="form-control" rows="6" placeholder="Masukkan konten materi dalam format text..."><?= old('konten_text') ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Materi</label>
                                <textarea name="deskripsi_materi" class="form-control" rows="4" placeholder="Deskripsi singkat tentang materi ini..."><?= old('deskripsi_materi') ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="urutan" class="form-control" value="<?= old('urutan', 1) ?>" min="1" placeholder="Nomor urutan materi">
                                <small class="text-muted">Nomor urutan materi dalam modul</small>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan Materi
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

<script>
    // Filter modul berdasarkan kursus
    document.getElementById('kursusSelect').addEventListener('change', function() {
        const selectedKursusId = this.value;
        const modulSelect = document.getElementById('modulSelect');
        
        // Reset modul select
        modulSelect.innerHTML = '<option value="">-- Pilih Modul --</option>';
        
        if (selectedKursusId) {
            // Filter modul berdasarkan kursus yang dipilih
            const modulOptions = document.querySelectorAll('#modulSelect option[data-kursus]');
            modulOptions.forEach(function(option) {
                if (option.dataset.kursus == selectedKursusId) {
                    modulSelect.appendChild(option.cloneNode(true));
                }
            });
        }
    });

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