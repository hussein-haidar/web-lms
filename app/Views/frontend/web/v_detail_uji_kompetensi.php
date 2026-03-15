<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('uji_kompetensi') ?>">Uji Kompetensi</a></li>
        <li class="breadcrumb-item active"><?= esc($detail['nama_uji_kompetensi']) ?></li>
    </ol>
</nav>

<!-- Detail Uji Kompetensi -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h1 class="fw-bold text-primary mb-2"><?= esc($detail['nama_uji_kompetensi']) ?></h1>
                                <div class="d-flex gap-3 flex-wrap">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-clock me-1"></i><?= esc($detail['durasi']) ?>
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-graduation-cap me-1"></i><?= esc($detail['sertifikat']) ?>
                                    </span>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="fas fa-laptop me-1"></i><?= esc($detail['tipe_pembelajaran']) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary fs-3 mb-2">Rp <?= number_format($detail['harga'], 0, ',', '.') ?></div>
                                <span class="badge bg-success">Aktif</span>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <?php if (!empty($detail['gambar'])): ?>
                            <div class="mb-4">
                                <img src="<?= base_url('gambar_kursus/' . $detail['gambar']) ?>" 
                                     alt="<?= esc($detail['nama_uji_kompetensi']) ?>"
                                     class="img-fluid rounded shadow"
                                     style="max-height: 400px; width: 100%; object-fit: cover;">
                            </div>
                        <?php endif; ?>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Deskripsi Program</h4>
                            <div class="text-muted">
                                <?= !empty($detail['deskripsi']) ? nl2br(esc(is_array($detail['deskripsi']) ? implode(' ', $detail['deskripsi']) : (string)$detail['deskripsi'])) : '<p class="text-muted">Deskripsi belum tersedia.</p>' ?>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="fas fa-certificate fa-2x text-primary mb-2"></i>
                                        <h6 class="fw-bold">Sertifikat</h6>
                                        <p class="mb-0 text-muted"><?= esc($detail['sertifikat']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users fa-2x text-success mb-2"></i>
                                        <h6 class="fw-bold">Tipe Pembelajaran</h6>
                                        <p class="mb-0 text-muted"><?= esc($detail['tipe_pembelajaran']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="text-center">
                            <a href="#" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-graduation-cap me-2"></i>Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Info Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Program</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <strong>Durasi:</strong> <?= esc($detail['durasi']) ?>
                            </li>
                            <li class="mb-3">
                                <strong>Tipe:</strong> <?= esc($detail['tipe_pembelajaran']) ?>
                            </li>
                            <li class="mb-3">
                                <strong>Sertifikat:</strong> <?= esc($detail['sertifikat']) ?>
                            </li>
                            <li class="mb-0">
                                <strong>Status:</strong> 
                                <span class="badge bg-success">Aktif</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Harga Card -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-tag me-2"></i>Investasi</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="fw-bold text-success fs-2 mb-2">Rp <?= number_format($detail['harga'], 0, ',', '.') ?></div>
                        <small class="text-muted">Per peserta</small>
                    </div>
                </div>

                <!-- CTA Card -->
                <div class="card border-0 shadow">
                    <div class="card-body text-center">
                        <a href="#" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-lock me-1"></i>Pendaftaran aman & terpercaya
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
