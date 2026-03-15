<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Edit Profil</h2>
                    <p class="text-muted mb-0">Perbarui informasi pribadi Anda</p>
                </div>
                <a href="<?= base_url('home_siswa/profil') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Silakan perbaiki kesalahan berikut:
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('pesan') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Profile Picture Section -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <h5 class="fw-bold mb-4">Foto Profil</h5>
                    
                    <!-- Current Profile Picture -->
                    <div class="position-relative d-inline-block mb-4">
                        <img src="<?= (!empty($data_profil['foto_profil']) && file_exists(FCPATH . 'fotosiswa/' . $data_profil['foto_profil'])) ? base_url('fotosiswa/' . $data_profil['foto_profil']) : base_url('fotosiswa/default.png') ?>" 
                             id="gambar_preview"
                             alt="Foto Profil" 
                             class="rounded-circle shadow-lg"
                             style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #0d6efd;">
                        
                        <!-- Camera Icon Overlay -->
                        <div class="position-absolute bottom-0 end-0">
                            <div class="bg-primary rounded-circle p-2 shadow" style="cursor: pointer;" onclick="document.getElementById('foto_profil_form').click()">
                                <i class="fas fa-camera text-white"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upload Button -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('foto_profil_form').click()">
                            <i class="fas fa-upload me-2"></i>Pilih Foto
                        </button>
                    </div>
                    
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Format: JPG, PNG, GIF (Maks. 1MB)
                    </small>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?= form_open_multipart('home_siswa/update_profil', ['id' => 'updateProfilForm', 'class' => 'needs-validation', 'novalidate']) ?>
                    <?= csrf_field() ?>
                    
                    <!-- Hidden file input moved inside form -->
                    <input type="file" 
                           id="foto_profil_form" 
                           name="foto_profil" 
                           accept="image/*" 
                           onchange="previewImage(this)"
                           class="d-none">

                    <div class="row g-3">
                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= old('email', esc($data_profil['email'])) ?>"
                                       placeholder="nama@email.com"
                                       required>
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="kata_sandi" class="form-label fw-semibold">
                                Kata Sandi
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" 
                                       class="form-control <?= session('errors.kata_sandi') ? 'is-invalid' : '' ?>" 
                                       id="kata_sandi" 
                                       name="kata_sandi"
                                       placeholder="Kosongkan jika tidak ingin ganti">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('kata_sandi')">
                                    <i class="fas fa-eye" id="kata_sandi_toggle"></i>
                                </button>
                                <?php if (session('errors.kata_sandi')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.kata_sandi') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <small class="text-muted">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah.</small>
                        </div>

                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" 
                                       class="form-control <?= session('errors.nama_lengkap') ? 'is-invalid' : '' ?>" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap"
                                       value="<?= old('nama_lengkap', esc($data_profil['nama_lengkap'])) ?>"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                <?php if (session('errors.nama_lengkap')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.nama_lengkap') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label fw-semibold">
                                Tanggal Lahir
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" 
                                       class="form-control" 
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir"
                                       value="<?= old('tanggal_lahir', esc($data_profil['tanggal_lahir'])) ?>">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="no_telepon" class="form-label fw-semibold">
                                No. Telepon <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" 
                                       class="form-control <?= session('errors.no_telepon') ? 'is-invalid' : '' ?>" 
                                       id="no_telepon" 
                                       name="no_telepon"
                                       value="<?= old('no_telepon', esc($data_profil['no_telepon'])) ?>"
                                       placeholder="08123456789"
                                       pattern="[0-9]{10,15}"
                                       required>
                                <?php if (session('errors.no_telepon')): ?>
                                    <div class="invalid-feedback">
                                        <?= session('errors.no_telepon') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <small class="text-muted">Minimal 10 digit, hanya angka.</small>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="alamat" class="form-label fw-semibold">
                                Alamat
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <textarea class="form-control" 
                                          id="alamat" 
                                          name="alamat"
                                          rows="3"
                                          placeholder="Masukkan alamat lengkap"><?= old('alamat', esc($data_profil['alamat'])) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= base_url('home_siswa/profil') ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('updateProfilForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Phone number validation
    const phoneInput = document.getElementById('no_telepon');
    phoneInput.addEventListener('input', function(e) {
        const value = e.target.value;
        if (!/^[0-9]*$/.test(value)) {
            e.target.value = value.replace(/[^0-9]/g, '');
        }
    });
});

function previewImage(input) {
    const preview = document.getElementById('gambar_preview');
    const file = input.files[0];

    if (file) {
        // Check file size (1MB max)
        if (file.size > 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 1MB.');
            input.value = '';
            return;
        }

        // Check file type
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = document.getElementById(fieldId + '_toggle');
    
    if (field.type === 'password') {
        field.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}
</script>

<style>
.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-control.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

#gambar_preview {
    transition: transform 0.2s ease-in-out;
}

#gambar_preview:hover {
    transform: scale(1.05);
}
</style>

<?= $this->endSection() ?>