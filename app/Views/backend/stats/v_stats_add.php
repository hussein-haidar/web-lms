<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Statistik</h1>
        <a href="<?= base_url('home_superadmin/stats') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Silakan periksa kembali input Anda.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Statistik</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('home_superadmin/stats/save') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul_stats">Judul Statistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['judul_stats']) ? 'is-invalid' : '' ?>" 
                                   id="judul_stats" name="judul_stats" 
                                   value="<?= old('judul_stats') ?>" 
                                   placeholder="Contoh: Peserta Program" required>
                            <?php if (isset(session()->getFlashdata('errors')['judul_stats'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['judul_stats'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="nilai_stats">Nilai <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= isset(session()->getFlashdata('errors')['nilai_stats']) ? 'is-invalid' : '' ?>" 
                                   id="nilai_stats" name="nilai_stats" 
                                   value="<?= old('nilai_stats') ?>" 
                                   placeholder="Contoh: 10000" min="0" required>
                            <?php if (isset(session()->getFlashdata('errors')['nilai_stats'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['nilai_stats'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="suffix_stats">Suffix (Opsional)</label>
                            <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['suffix_stats']) ? 'is-invalid' : '' ?>" 
                                   id="suffix_stats" name="suffix_stats" 
                                   value="<?= old('suffix_stats') ?>" 
                                   placeholder="Contoh: +, %, Tahun">
                            <small class="form-text text-muted">Akan ditampilkan setelah nilai (contoh: 10000+, 70%, 25 Tahun)</small>
                            <?php if (isset(session()->getFlashdata('errors')['suffix_stats'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['suffix_stats'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="baris_stats">Baris <span class="text-danger">*</span></label>
                            <select class="form-control <?= isset(session()->getFlashdata('errors')['baris_stats']) ? 'is-invalid' : '' ?>" 
                                    id="baris_stats" name="baris_stats" required>
                                <option value="">Pilih Baris</option>
                                <option value="1" <?= old('baris_stats') == '1' ? 'selected' : '' ?>>Baris 1 (6 cards)</option>
                                <option value="2" <?= old('baris_stats') == '2' ? 'selected' : '' ?>>Baris 2 (3 cards)</option>
                            </select>
                            <small class="form-text text-muted">Baris 1 untuk 6 cards pertama, Baris 2 untuk 3 cards terakhir</small>
                            <?php if (isset(session()->getFlashdata('errors')['baris_stats'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['baris_stats'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="urutan_stats">Urutan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= isset(session()->getFlashdata('errors')['urutan_stats']) ? 'is-invalid' : '' ?>" 
                                   id="urutan_stats" name="urutan_stats" 
                                   value="<?= old('urutan_stats') ?? 1 ?>" 
                                   placeholder="1" min="1" required>
                            <small class="form-text text-muted">
                                Urutan tampil dalam baris. Baris 1: 1-6, Baris 2: 1-3. 
                                <br>Saran: Baris 1 mulai dari <?= $max_order_row1 ?>, Baris 2 mulai dari <?= $max_order_row2 ?>
                            </small>
                            <?php if (isset(session()->getFlashdata('errors')['urutan_stats'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['urutan_stats'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <div class="card bg-light">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-2">Preview</h6>
                                    <div class="border rounded p-3 text-center" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
                                        <div class="bg-light rounded p-3">
                                            <div class="display-6 fw-bold text-primary" id="preview-value">0</div>
                                            <div class="fw-bold small mt-2" id="preview-title">Judul Statistik</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="<?= base_url('home_superadmin/stats') ?>" class="btn btn-secondary">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const judulInput = document.getElementById('judul_stats');
    const nilaiInput = document.getElementById('nilai_stats');
    const suffixInput = document.getElementById('suffix_stats');
    const previewTitle = document.getElementById('preview-title');
    const previewValue = document.getElementById('preview-value');

    function updatePreview() {
        const judul = judulInput.value || 'Judul Statistik';
        const nilai = nilaiInput.value || '0';
        const suffix = suffixInput.value || '';

        previewTitle.textContent = judul;
        previewValue.textContent = nilai + suffix;
    }

    judulInput.addEventListener('input', updatePreview);
    nilaiInput.addEventListener('input', updatePreview);
    suffixInput.addEventListener('input', updatePreview);

    // Update preview on load
    updatePreview();
});
</script>

<?= $this->endSection() ?>
