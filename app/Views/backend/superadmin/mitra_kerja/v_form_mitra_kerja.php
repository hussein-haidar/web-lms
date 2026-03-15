<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= esc($title2) ?></h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger">
                            <?= $validation->listErrors() ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('home_superadmin/save_mitra_kerja') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_mitra" class="form-label">Nama Mitra *</label>
                                    <input type="text" class="form-control" id="nama_mitra" 
                                           name="nama_mitra" value="<?= old('nama_mitra', $mitra['nama_mitra'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url_website" class="form-label">Website *</label>
                                    <input type="url" class="form-control" id="url_website" 
                                           name="url_website" value="<?= old('url_website', $mitra['url_website'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="urutan" class="form-label">Urutan Tampil *</label>
                                    <input type="number" class="form-control" id="urutan" 
                                           name="urutan" value="<?= old('urutan', $mitra['urutan'] ?? '') ?>" required>
                                    <small class="form-text">Nomor urutan untuk tampil di website</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="aktif" <?= (old('status', $mitra['status'] ?? '') == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                        <option value="tidak_aktif" <?= (old('status', $mitra['status'] ?? '') == 'tidak_aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= old('deskripsi', $mitra['deskripsi'] ?? '') ?></textarea>
                                    <small class="form-text">Deskripsi singkat tentang mitra kerja</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo_mitra" class="form-label">Logo Mitra</label>
                                    <input type="file" class="form-control" id="logo_mitra" name="logo_mitra" accept="image/*">
                                    <small class="form-text">Format: JPG, JPEG, PNG. Maksimal ukuran: 2MB</small>
                                    
                                    <?php if (!empty($mitra['logo_mitra'])): ?>
                                        <div class="mt-2">
                                            <small class="text-muted">Logo saat ini:</small><br>
                                            <img src="<?= base_url('logo_mitra/' . $mitra['logo_mitra']) ?>" 
                                                 alt="<?= esc($mitra['nama_mitra']) ?>" 
                                                 class="img-thumbnail" 
                                                 style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 
                                    <?= isset($mitra['id_mitra']) ? 'Update Mitra Kerja' : 'Simpan Mitra Kerja' ?>
                                </button>
                                <a href="<?= base_url('home_superadmin/mitra_kerja') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
