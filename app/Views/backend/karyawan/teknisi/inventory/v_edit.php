<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Edit <?= $title2 ?? 'Inventory' ?></h3>
                </div>
                
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

                <div class="box-body">
                    <?= form_open('home_karyawan/update_inventory') ?>
                        <?= csrf_field() ?>

                        <!-- Hidden ID -->
                        <input type="hidden" name="id_simpan" value="<?= $inventory['id_simpan'] ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" 
                                        name="nama_barang" 
                                        class="form-control <?= session('errors.nama_barang') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('nama_barang', $inventory['nama_barang'] ?? '') ?>" 
                                        placeholder="Contoh: Laptop Dell, Proyektor Epson"
                                        required>
                                    <?php if (session('errors.nama_barang')): ?>
                                        <div class="invalid-feedback"><?= session('errors.nama_barang') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Barang <span class="text-danger">*</span></label>
                                    <input type="number" 
                                        name="jumlah_barang" 
                                        class="form-control <?= session('errors.jumlah_barang') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('jumlah_barang', $inventory['jumlah_barang'] ?? 1) ?>" 
                                        min="1"
                                        required>
                                    <?php if (session('errors.jumlah_barang')): ?>
                                        <div class="invalid-feedback"><?= session('errors.jumlah_barang') ?></div>
                                    <?php endif; ?>
                                    <small class="text-muted">Jumlah barang saat ini</small>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                        name="tanggal_masuk" 
                                        class="form-control <?= session('errors.tanggal_masuk') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('tanggal_masuk', date('Y-m-d\TH:i', strtotime($inventory['tanggal_masuk'] ?? date('Y-m-d H:i')))) ?>" 
                                        required>
                                    <?php if (session('errors.tanggal_masuk')): ?>
                                        <div class="invalid-feedback"><?= session('errors.tanggal_masuk') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Keluar</label>
                                    <input type="datetime-local" 
                                        name="tanggal_keluar" 
                                        class="form-control <?= session('errors.tanggal_keluar') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('tanggal_keluar', !empty($inventory['tanggal_keluar']) ? date('Y-m-d\TH:i', strtotime($inventory['tanggal_keluar'])) : '') ?>">
                                    <?php if (session('errors.tanggal_keluar')): ?>
                                        <div class="invalid-feedback"><?= session('errors.tanggal_keluar') ?></div>
                                    <?php endif; ?>
                                    <small class="text-muted">Kosongkan jika barang belum keluar</small>
                                </div>

                                <div class="form-group">
                                    <label>ID Karyawan <span class="text-danger">*</span></label>
                                    <select name="id_karyawan" class="form-control <?= session('errors.id_karyawan') ? 'is-invalid' : '' ?>" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        <?php foreach ($karyawan ?? [] as $k): ?>
                                            <option value="<?= esc($k['id_karyawan']) ?>" 
                                                <?= old('id_karyawan', $inventory['id_karyawan'] ?? '') == $k['id_karyawan'] ? 'selected' : '' ?>>
                                                <?= esc($k['nama_lengkap']) ?> (ID: <?= esc($k['id_karyawan']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.id_karyawan')): ?>
                                        <div class="invalid-feedback"><?= session('errors.id_karyawan') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label>ID Pemilik</label>
                                    <input type="number" 
                                        name="id_pemilik" 
                                        class="form-control <?= session('errors.id_pemilik') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('id_pemilik', $inventory['id_pemilik'] ?? 1) ?>" 
                                        min="1">
                                    <?php if (session('errors.id_pemilik')): ?>
                                        <div class="invalid-feedback"><?= session('errors.id_pemilik') ?></div>
                                    <?php endif; ?>
                                    <small class="text-muted">Default: 1 (Superadmin)</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Perbaikan</label>
                                    <input type="datetime-local" 
                                        name="tanggal_perbaikan" 
                                        class="form-control <?= session('errors.tanggal_perbaikan') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('tanggal_perbaikan', !empty($inventory['tanggal_perbaikan']) ? date('Y-m-d\TH:i', strtotime($inventory['tanggal_perbaikan'])) : '') ?>">
                                    <?php if (session('errors.tanggal_perbaikan')): ?>
                                        <div class="invalid-feedback"><?= session('errors.tanggal_perbaikan') ?></div>
                                    <?php endif; ?>
                                    <small class="text-muted">Tanggal terakhir barang diperbaiki</small>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Pengecekan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                        name="tanggal_pengecekan" 
                                        class="form-control <?= session('errors.tanggal_pengecekan') ? 'is-invalid' : '' ?>" 
                                        value="<?= old('tanggal_pengecekan', date('Y-m-d\TH:i', strtotime($inventory['tanggal_pengecekan'] ?? date('Y-m-d H:i')))) ?>" 
                                        required>
                                    <?php if (session('errors.tanggal_pengecekan')): ?>
                                        <div class="invalid-feedback"><?= session('errors.tanggal_pengecekan') ?></div>
                                    <?php endif; ?>
                                    <small class="text-muted">Tanggal terakhir barang dicek kondisinya</small>
                                </div>

                                <div class="form-group">
                                    <label>Kondisi Barang <span class="text-danger">*</span></label>
                                    <select name="kondisi" class="form-control <?= session('errors.kondisi') ? 'is-invalid' : '' ?>" required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        <option value="baik" <?= old('kondisi', $inventory['kondisi'] ?? '') == 'baik' ? 'selected' : '' ?>>Baik</option>
                                        <option value="rusak_ringan" <?= old('kondisi', $inventory['kondisi'] ?? '') == 'rusak_ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                                        <option value="rusak_berat" <?= old('kondisi', $inventory['kondisi'] ?? '') == 'rusak_berat' ? 'selected' : '' ?>>Rusak Berat</option>
                                    </select>
                                    <?php if (session('errors.kondisi')): ?>
                                        <div class="invalid-feedback"><?= session('errors.kondisi') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label>Catatan Tambahan</label>
                                    <textarea name="catatan" 
                                        class="form-control <?= session('errors.catatan') ? 'is-invalid' : '' ?>" 
                                        rows="4"
                                        placeholder="Catatan tambahan tentang barang ini..."><?= old('catatan', $inventory['catatan'] ?? '') ?></textarea>
                                    <?php if (session('errors.catatan')): ?>
                                        <div class="invalid-feedback"><?= session('errors.catatan') ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Informasi Tambahan -->
                                <div class="alert alert-info">
                                    <strong><i class="fa fa-info-circle"></i> Informasi Barang:</strong><br>
                                    <small>
                                        ID Barang: <strong><?= $inventory['id_simpan'] ?></strong><br>
                                        <?php if (!empty($inventory['created_at'])): ?>
                                            Dibuat: <?= date('d-m-Y H:i', strtotime($inventory['created_at'])) ?><br>
                                        <?php endif; ?>
                                        Terakhir Update: <?= date('d-m-Y H:i', strtotime($inventory['tanggal_pengecekan'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save"></i> Update Inventory
                            </button>
                            <a href="<?= base_url('home_karyawan/inventory') ?>" class="btn btn-default">
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