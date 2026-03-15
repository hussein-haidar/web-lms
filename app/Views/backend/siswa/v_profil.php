<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">Profil Siswa</h2>
                <a href="<?= base_url('home_siswa/edit_profil') ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <!-- Profile Image & Basic Info -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <!-- Profile Image -->
                    <div class="position-relative d-inline-block mb-3">
                        <?php if (!empty($profil['foto_profil']) && file_exists(FCPATH . 'fotosiswa/' . $profil['foto_profil'])): ?>
                            <img src="<?= base_url('fotosiswa/' . $profil['foto_profil']) ?>" 
                                 alt="Foto Profil" 
                                 class="rounded-circle shadow-lg"
                                 style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #fff;">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow-lg"
                                 style="width: 180px; height: 180px; border: 4px solid #fff;">
                                <i class="fas fa-user fa-4x text-white"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Status Badge -->
                        <div class="position-absolute bottom-0 end-0">
                            <span class="badge <?= ($profil['status_aktif'] == 'aktif') ? 'bg-success' : 'bg-danger' ?> rounded-pill px-3 py-2">
                                <?= ($profil['status_aktif'] == 'aktif') ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Name & NIS -->
                    <h3 class="fw-bold mb-1"><?= esc($profil['nama_lengkap']) ?></h3>
                    <p class="text-muted mb-3">NIS: <?= esc($profil['nis']) ?></p>
                    
                    <!-- Quick Stats -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <small class="text-muted d-block">Email</small>
                                <strong class="d-block text-truncate"><?= esc($profil['email']) ?></strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <small class="text-muted d-block">Telepon</small>
                                <strong><?= esc($profil['no_telepon'] ?? '-') ?></strong>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Last Login -->
                    <div class="text-muted small">
                        <i class="fas fa-clock me-1"></i>
                        <?php
                        if (!empty($profil['last_login'])) {
                            setlocale(LC_TIME, 'id_ID.UTF-8');
                            $tanggal = strtotime($profil['last_login']);
                            $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                            $formattedDate = date('d', $tanggal) . ' ' . $bulan[date('n', $tanggal)] . ' ' . date('Y, H:i:s', $tanggal);
                        } else {
                            $formattedDate = 'Belum pernah login';
                        }
                        ?>
                        Terakhir login: <?= $formattedDate ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="col-lg-8">
            <!-- Personal Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user-circle me-2 text-primary"></i>Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Nama Lengkap</label>
                            <div class="form-control bg-light border-0"><?= esc($profil['nama_lengkap']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">NIS</label>
                            <div class="form-control bg-light border-0"><?= esc($profil['nis']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email</label>
                            <div class="form-control bg-light border-0"><?= esc($profil['email']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">No. Telepon</label>
                            <div class="form-control bg-light border-0"><?= esc($profil['no_telepon'] ?? '-') ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small">Alamat</label>
                            <div class="form-control bg-light border-0" style="min-height: 60px;"><?= esc($profil['alamat'] ?? '-') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi Tambahan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tempat, Tanggal Lahir</label>
                            <div class="form-control bg-light border-0">
                                <?= esc($profil['tempat_lahir'] ?? '-') ?>, <?= !empty($profil['tanggal_lahir']) ? date('d-m-Y', strtotime($profil['tanggal_lahir'])) : '-' ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Jenis Kelamin</label>
                            <div class="form-control bg-light border-0"><?= esc($profil['jenis_kelamin'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Agama</label>
                            <div class="form-control bg-light border-0"><?= esc($profil['agama'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tanggal Daftar</label>
                            <div class="form-control bg-light border-0">
                                <?= !empty($profil['tanggal_daftar']) ? date('d-m-Y H:i', strtotime($profil['tanggal_daftar'])) : '-' ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted small">Status Akun</label>
                            <div class="form-control bg-light border-0">
                                <span class="badge <?= ($profil['status_aktif'] == 'aktif') ? 'bg-success' : 'bg-danger' ?> rounded-pill px-3 py-1">
                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                    <?= ($profil['status_aktif'] == 'aktif') ? 'Akun Aktif' : 'Akun Nonaktif' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Information Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-shield-alt me-2 text-warning"></i>Keamanan Akun
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted small">Password</label>
                            <div class="form-control bg-light border-0">
                                <span class="text-muted">••••••••••••••••••••</span>
                                <small class="text-muted ms-2">(Disembunyikan untuk keamanan)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
