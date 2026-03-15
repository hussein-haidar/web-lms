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

                    <?= form_open_multipart('home_superadmin/save_kursus') ?>
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Program <span class="text-danger">*</span></label>
                                <select name="id_program" class="form-control" required>
                                    <option value="">-- Pilih Program --</option>
                                    <?php foreach ($program ?? [] as $p): ?>
                                        <?php 
                                            $jenisKelas = strtolower($p['nama_program'] ?? '');
                                            $badgeInfo = ($jenisKelas === 'kelas online') ? '🌐 Online' : '🖥️ Offline';
                                        ?>
                                        <option value="<?= esc($p['id_program']) ?>" <?= old('id_program') == $p['id_program'] ? 'selected' : '' ?>>
                                            <?= esc($p['nama_program']) ?> - <?= $badgeInfo ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Pilih jenis kelas: Online (video-based) atau Offline (tatap muka)</small>
                            </div>

                            <div class="form-group">
                                <label>Pengajar</label>
                                <select name="id_karyawan" class="form-control">
                                    <option value="">-- Pilih Pengajar --</option>
                                    <?php foreach ($karyawan ?? [] as $k): ?>
                                        <option value="<?= esc($k['id_karyawan']) ?>" <?= old('id_karyawan') == $k['id_karyawan'] ? 'selected' : '' ?>>
                                            <?= esc($k['nama_lengkap']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Opsional, bisa dikosongkan</small>
                            </div>

                            <div class="form-group">
                                <label>Nama Kursus <span class="text-danger">*</span></label>
                                <input type="text" name="nama_kursus" class="form-control" value="<?= old('nama_kursus') ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" class="form-control" value="<?= old('slug') ?>" required>
                                <small class="text-muted">Gunakan huruf kecil, angka, dan underscore (_)</small>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Singkat <span class="text-danger">*</span></label>
                                <textarea name="deskripsi_singkat" class="form-control" rows="3" required><?= old('deskripsi_singkat') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="aktif" <?= old('status', 'aktif') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Materi yang Dipelajari <span class="text-danger">*</span></label>
                                <textarea name="materi_yang_dipelajari" class="form-control" rows="4" required><?= old('materi_yang_dipelajari') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Syarat Pendaftaran <span class="text-danger">*</span></label>
                                <textarea name="syarat_pendaftaran" class="form-control" rows="3" required><?= old('syarat_pendaftaran') ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Gambar Utama</label>
                                <input type="file" name="gambar_utama" class="form-control" accept="image/*">
                                <small class="text-muted">Maksimal 10 MB (JPG, JPEG, PNG, GIF, WEBP)</small>
                            </div>

                            <div class="form-group">
                                <label>Gambar Detail A (Opsional)</label>
                                <input type="file" name="gambar_detail_a" class="form-control" accept="image/*">
                                <small class="text-muted">Maksimal 10 MB</small>
                            </div>

                            <!-- TOGGLE BUTTON FOR OPTIONAL FIELDS -->
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-left" 
                                        id="toggleOptionalFields" data-toggle="collapse" data-target="#optionalFieldsContent" 
                                        aria-expanded="false" aria-controls="optionalFieldsContent">
                                    <i class="fa fa-plus-circle mr-2" id="toggleIcon"></i>
                                    <span id="toggleText">Tampilkan Gambar Detail (Opsional)</span>
                                </button>
                            </div>

                            <!-- COLLAPSIBLE CONTENT -->
                            <div class="collapse" id="optionalFieldsContent">
                                <hr class="my-3">
                                
                                <!-- GAMBAR DETAIL B, C -->
                                <h6 class="text-muted mb-3"><i class="fa fa-images mr-1"></i> Gambar Detail</h6>
                                
                                <div class="form-group">
                                    <label>Gambar Detail B (Opsional)</label>
                                    <input type="file" name="gambar_detail_b" class="form-control" accept="image/*">
                                    <small class="text-muted">Maksimal 10 MB</small>
                                </div>
                                <div class="form-group">
                                    <label>Gambar Detail C (Opsional)</label>
                                    <input type="file" name="gambar_detail_c" class="form-control" accept="image/*">
                                    <small class="text-muted">Maksimal 10 MB</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan Kursus
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

<!-- JAVASCRIPT FOR TOGGLE -->
<script>
$(document).ready(function() {
    const $toggleBtn = $('#toggleOptionalFields');
    const $icon = $('#toggleIcon');
    const $text = $('#toggleText');
    const $content = $('#optionalFieldsContent');
    
    // Load saved state from sessionStorage (opsional)
    if (sessionStorage.getItem('optionalFieldsExpanded') === 'true') {
        $content.collapse('show');
        updateToggleState(true);
    }
    
    // Auto-expand jika ada error validasi
    <?php if (session()->getFlashdata('errors')): ?>
        $content.collapse('show');
        updateToggleState(true);
    <?php endif; ?>
    
    // Handle toggle events
    $content.on('shown.bs.collapse hidden.bs.collapse', function() {
        const isExpanded = $content.hasClass('show');
        updateToggleState(isExpanded);
        sessionStorage.setItem('optionalFieldsExpanded', isExpanded);
    });
    
    function updateToggleState(isExpanded) {
        if (isExpanded) {
            $icon.removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $text.text('Tampilkan Gambar Detail (Opsional)');
        } else {
            $icon.removeClass('fa-minus-circle').addClass('fa-plus-circle');
            $text.text('Tampilkan Gambar Detail (Opsional)');
        }
    }
});
</script>

<?= $this->endSection() ?>