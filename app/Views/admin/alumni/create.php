<?= $this->extend('admin/template/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Alumni Baru</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('/alumni') ?>" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/alumni/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Alumni <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama')) ? 'is-invalid' : '' ?>" 
                                           id="nama" name="nama" value="<?= old('nama') ?>" required>
                                    <?php if (isset($validation) && $validation->hasError('nama')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('kategori')) ? 'is-invalid' : '' ?>" 
                                           id="kategori" name="kategori" value="<?= old('kategori') ?>" placeholder="Contoh: Percetakan & Desain" required>
                                    <?php if (isset($validation) && $validation->hasError('kategori')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('kategori') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('lokasi')) ? 'is-invalid' : '' ?>" 
                                           id="lokasi" name="lokasi" value="<?= old('lokasi') ?>" placeholder="Contoh: Pekalongan, Jawa Tengah">
                                    <?php if (isset($validation) && $validation->hasError('lokasi')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('lokasi') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="warna_tema">Warna Tema <span class="text-danger">*</span></label>
                                    <input type="color" class="form-control" id="warna_tema" name="warna_tema" value="<?= old('warna_tema', '#0d6efd') ?>">
                                    <small class="form-text text-muted">Pilih warna tema untuk alumni ini</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foto_profil">Foto Profil</label>
                                    <input type="file" class="form-control-file <?= (isset($validation) && $validation->hasError('foto_profil')) ? 'is-invalid' : '' ?>" 
                                           id="foto_profil" name="foto_profil" accept="image/*">
                                    <?php if (isset($validation) && $validation->hasError('foto_profil')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('foto_profil') ?>
                                        </div>
                                    <?php endif; ?>
                                    <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                </div>

                                <div class="form-group">
                                    <label for="facebook_url">Facebook URL</label>
                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="<?= old('facebook_url') ?>" 
                                           placeholder="https://www.facebook.com/username">
                                </div>

                                <div class="form-group">
                                    <label for="tiktok_url">TikTok URL</label>
                                    <input type="url" class="form-control" id="tiktok_url" name="tiktok_url" value="<?= old('tiktok_url') ?>" 
                                           placeholder="https://tiktok.com/@username">
                                </div>

                                <div class="form-group">
                                    <label for="whatsapp_url">WhatsApp URL</label>
                                    <input type="url" class="form-control" id="whatsapp_url" name="whatsapp_url" value="<?= old('whatsapp_url') ?>" 
                                           placeholder="https://wa.me/628123456789">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= (isset($validation) && $validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" 
                                      id="deskripsi" name="deskripsi" rows="4" required><?= old('deskripsi') ?></textarea>
                            <?php if (isset($validation) && $validation->hasError('deskripsi')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('deskripsi') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Foto Galeri</label>
                            <div id="galeri-container">
                                <div class="galeri-item row mb-3">
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file" name="galeri[]" accept="image/*">
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan foto (opsional)">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahGaleri()">
                                <i class="fas fa-plus"></i> Tambah Foto
                            </button>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('/alumni') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function tambahGaleri() {
    const container = document.getElementById('galeri-container');
    const itemCount = container.children.length;
    
    const newItem = document.createElement('div');
    newItem.className = 'galeri-item row mb-3';
    newItem.innerHTML = `
        <div class="col-md-6">
            <input type="file" class="form-control-file" name="galeri[]" accept="image/*">
            <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan foto (opsional)">
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusGaleri(this)">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    `;
    
    container.appendChild(newItem);
}

function hapusGaleri(button) {
    button.closest('.galeri-item').remove();
}
</script>

<?= $this->endSection() ?>
