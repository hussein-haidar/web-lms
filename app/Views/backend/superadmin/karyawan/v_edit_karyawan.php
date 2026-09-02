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

                <?php $errors = session()->getFlashdata('errors'); if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <div class="box-body">
                    <?= form_open_multipart('home_superadmin/update_karyawan/' . ($kn['id_karyawan'] ?? '')) ?>
                    <?= csrf_field() ?>
                    <!-- Hidden field untuk validasi level -->
                    <input type="hidden" name="level_filter" value="<?= $level_filter ?? 'lainnya' ?>">

                    <!-- Preview Foto -->
                    <div class="form-group mb-3">
                        <label>Foto Saat Ini</label><br>
                        <img src="<?= !empty($kn['foto_profil']) ? base_url('fotoprofil/' . $kn['foto_profil']) : base_url('assets/img/placeholder.png') ?>" 
                             id="gambar_preview" class="img-thumbnail" width="100">
                    </div>
                    <div class="form-group mb-3">
                        <label>Upload Foto Baru (Opsional)</label>
                        <input type="file" name="foto_profil" id="gambar_input" class="form-control-file" accept="image/*">
                    </div>

                    <div class="form-group mb-3">
                        <label>NIP</label>
                        <input type="text" class="form-control" value="<?= esc($kn['nip'] ?? '') ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= esc($kn['nama_lengkap'] ?? '') ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($kn['email'] ?? '') ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Password Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="kata_sandi" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>No Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="<?= esc($kn['no_telepon'] ?? '') ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control"><?= esc($kn['alamat'] ?? '') ?></textarea>
                    </div>

                    <!-- ✅ DROPDOWN LEVEL DINAMIS (SEDERHANA) -->
                    <div class="form-group mb-3">
                        <label>Level *</label>
                        <select name="level" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                                                           <option value="pengajar" <?= ($kn['level'] ?? '') == 'pengajar' ? 'selected' : '' ?>>Pengajar</option>
                                                        <option value="staf_admin" <?= ($kn['level'] ?? '') == 'staf_admin' ? 'selected' : '' ?>>Staf Admin</option>
                                <option value="teknisi" <?= ($kn['level'] ?? '') == 'teknisi' ? 'selected' : '' ?>>Teknisi</option>
                      
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif" <?= ($kn['status'] ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= ($kn['status'] ?? '') == 'nonaktif' ? 'selected' : '' ?>>Non Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="<?= base_url('home_superadmin/' . (($level_filter ?? '') == 'pengajar' ? 'pengajar' : 'karyawan')) ?>" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</section>

<!-- Script Preview Gambar -->
<script>
document.getElementById('gambar_input')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('gambar_preview').src = ev.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?= $this->endSection() ?>