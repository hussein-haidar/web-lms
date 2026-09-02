<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="card-title">Edit <?= $title2 ?></h5>
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="box-body">
                    <?= form_open_multipart('home_superadmin/update_paket/' . $paket['id_paket']) ?>
                    <?= csrf_field() ?>

                    <!-- Informasi Dasar -->
                    <h6 class="text-primary"><i class="fa fa-info-circle"></i> Informasi Dasar</h6>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kursus <span class="text-danger">*</span></label>
                                <select name="id_kursus" class="form-control" id="kursus-select" required>
                                    <option value="">-- Pilih Kursus --</option>
                                    <?php foreach ($kursus as $k): ?>
                                        <option value="<?= $k['id_kursus'] ?>" data-nama-kursus="<?= esc($k['nama_kursus']) ?>" data-nama-program="<?= esc($k['nama_program']) ?>" 
                                            <?= (old('id_kursus', $paket['id_kursus'] ?? '') == $k['id_kursus']) ? 'selected' : '' ?>>
                                            <?= esc($k['nama_kursus']) ?> - <?= esc($k['nama_program']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Jenis kelas akan ditentukan otomatis berdasarkan program kursus</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- ✅ JADWAL PELATIHAN -->
                            <div class="form-group">
                                <label>Jadwal Pelatihan (Opsional)</label>
                                <textarea name="jadwal_pelatihan" class="form-control" rows="5"
                                    placeholder="08.00 - 10.00 (WIB)&#10;10.00 - 12.00 (WIB)"><?= esc($kursus['jadwal_pelatihan'] ?? '') ?></textarea>
                                <small class="text-muted">Masukkan jadwal pelatihan, satu baris per waktu.<br>
                                    Contoh: 08.00 - 10.00 (WIB)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total Pertemuan <span class="text-danger">*</span></label>
                                <input type="number" name="total_pertemuan" class="form-control"
                                    value="<?= old('total_pertemuan', $paket['total_pertemuan'] ?? '') ?>" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Durasi per Pertemuan (Jam) <span class="text-danger">*</span></label>
                                <input type="number" name="durasi_per_pertemuan_jam" class="form-control"
                                    value="<?= old('durasi_per_pertemuan_jam', $paket['durasi_per_pertemuan_jam'] ?? '') ?>" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- PAKET A (SELALU VISIBLE) -->
                    <h6 class="text-primary mt-4"><i class="fa fa-graduation-cap"></i> Detail Paket</h6>
                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border bg-blue">
                                    <h3 class="box-title text-white">Paket A</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Paket A <span class="text-danger">*</span></label>
                                                <input type="text" name="paket_a" class="form-control"
                                                    value="<?= old('paket_a', $paket['paket_a'] ?? 'Kelas Reguler') ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga (Rp) <span class="text-danger">*</span></label>
                                                <input type="number" name="harga_reguler" class="form-control"
                                                    value="<?= old('harga_reguler', $paket['harga_reguler'] ?? '') ?>" min="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Deskripsi Paket A <span class="text-danger">*</span></label>
                                                <textarea name="deskripsi_a" class="form-control" rows="7" required placeholder="Setiap baris = 1 poin fitur"><?= old('deskripsi_a', $paket['deskripsi_a'] ?? '') ?></textarea>
                                                <small class="text-muted">Gunakan Enter untuk tiap poin</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOGGLE BUTTON FOR PAKET B & C -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-left" 
                                    id="toggleOptionalPackets" data-toggle="collapse" data-target="#optionalPacketsContent" 
                                    aria-expanded="false" aria-controls="optionalPacketsContent">
                                <i class="fa fa-plus-circle mr-2" id="togglePacketsIcon"></i>
                                <span id="togglePacketsText">Tampilkan Paket Tambahan (Opsional)</span>
                            </button>
                        </div>
                    </div>

                    <!-- COLLAPSIBLE CONTENT FOR PAKET B & C -->
                    <div class="collapse" id="optionalPacketsContent">
                        <hr class="my-3">
                        
                        <h6 class="text-primary mb-3"><i class="fa fa-graduation-cap"></i> Paket Tambahan</h6>

                        <div class="row">
                            <!-- Paket B -->
                            <div class="col-md-6" id="paket-b-container">
                                <div class="box box-warning">
                                    <div class="box-header with-border bg-orange">
                                        <h3 class="box-title text-white">Paket B</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Nama Paket B <span class="text-danger">*</span></label>
                                            <input type="text" name="paket_b" class="form-control"
                                                value="<?= old('paket_b', $paket['paket_b'] ?? 'Kelas Intensive') ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi Paket B <span class="text-danger">*</span></label>
                                            <textarea name="deskripsi_b" class="form-control" rows="7" required placeholder="Setiap baris = 1 poin fitur"><?= old('deskripsi_b', $paket['deskripsi_b'] ?? '') ?></textarea>
                                            <small class="text-muted">Gunakan Enter untuk tiap poin</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" name="harga_intensive" class="form-control"
                                                value="<?= old('harga_intensive', $paket['harga_intensive'] ?? '') ?>" min="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Paket C -->
                            <div class="col-md-6" id="paket-c-container">
                                <div class="box box-danger">
                                    <div class="box-header with-border bg-red">
                                        <h3 class="box-title text-white">Paket C</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Nama Paket C <span class="text-danger">*</span></label>
                                            <input type="text" name="paket_c" class="form-control"
                                                value="<?= old('paket_c', $paket['paket_c'] ?? 'Kelas Private') ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi Paket C <span class="text-danger">*</span></label>
                                            <textarea name="deskripsi_c" class="form-control" rows="7" required placeholder="Setiap baris = 1 poin fitur"><?= old('deskripsi_c', $paket['deskripsi_c'] ?? '') ?></textarea>
                                            <small class="text-muted">Gunakan Enter untuk tiap poin</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" name="harga_private" class="form-control"
                                                value="<?= old('harga_private', $paket['harga_private'] ?? '') ?>" min="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="<?= base_url('home_superadmin/paket_kursus') ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success pull-right">
                            <i class="fa fa-save"></i> Update Paket
                        </button>
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
    const $toggleBtn = $('#toggleOptionalPackets');
    const $icon = $('#togglePacketsIcon');
    const $text = $('#togglePacketsText');
    const $content = $('#optionalPacketsContent');
    
    // Auto-expand jika ada data yang sudah diisi atau ada error validasi
    const hasPaketData = <?= json_encode(!empty($paket['paket_b']) || !empty($paket['paket_c'])) ?>;
    const hasErrors = <?= json_encode(!!session()->getFlashdata('errors')) ?>;
    
    if (hasPaketData || hasErrors || sessionStorage.getItem('optionalPacketsExpanded') === 'true') {
        $content.collapse('show');
        updateToggleState(true);
    }
    
    // Handle toggle events
    $content.on('shown.bs.collapse hidden.bs.collapse', function() {
        const isExpanded = $content.hasClass('show');
        updateToggleState(isExpanded);
        sessionStorage.setItem('optionalPacketsExpanded', isExpanded);
    });
    
    function updateToggleState(isExpanded) {
        if (isExpanded) {
            $icon.removeClass('fa-plus-circle').addClass('fa-minus-circle');
            $text.text('Sembunyikan Paket Tambahan');
        } else {
            $icon.removeClass('fa-minus-circle').addClass('fa-plus-circle');
            $text.text('Tampilkan Paket Tambahan (Opsional)');
        }
    }
});
</script>

<?= $this->endSection() ?>