<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Welcome Header -->
<div class="container-fluid bg-light py-3 border-bottom">
    <div class="container">
        <div class="d-flex align-items-center">
            <?php if (!empty($profil['foto_profil']) && file_exists(FCPATH . 'fotosiswa/' . $profil['foto_profil'])): ?>
                <img src="<?= base_url('fotosiswa/' . $profil['foto_profil']) ?>" 
                     alt="<?= htmlspecialchars($profil['nama_lengkap'] ?? 'User') ?>" 
                     class="rounded-circle me-3 shadow-sm" 
                     style="width: 50px; height: 50px; object-fit: cover;">
            <?php else: ?>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                    <?= strtoupper(substr($profil['nama_lengkap'] ?? 'U', 0, 1)) ?>
                </div>
            <?php endif; ?>
            <div>
                <h6 class="mb-0 fw-bold">Welcome back, <?= $profil['nama_lengkap'] ?? 'User' ?></h6>
                <small class="text-muted">Student at LPK INASADA</small>
            </div>
        </div>
    </div>
</div>

<!-- Hero Banner Slider -->
<div class="container-fluid py-5">
    <div class="container position-relative">
        <div id="bannerSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php if (!empty($sliders)): ?>
                    <?php foreach ($sliders as $key => $s): ?>
                        <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="<?= $key ?>" class="<?= $key == 0 ? 'active' : '' ?>" aria-current="<?= $key == 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $key + 1 ?>"></button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <?php endif; ?>
            </div>

            <div class="carousel-inner rounded-4 shadow" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); min-height: 350px;">
                <?php if (!empty($sliders)): ?>
                    <?php foreach ($sliders as $key => $s): ?>
                        <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                            <div class="row align-items-center py-5 px-4 h-100">
                                <div class="col-md-6 order-2 order-md-1">
                                    <h2 class="mb-3 text-white fw-bold"><?= htmlspecialchars($s['judul_slider']) ?></h2>
                                    <p class="mb-4 text-white-50 opacity-75"><?= htmlspecialchars($s['deskripsi']) ?></p>
                                    <a href="<?= $s['link_url'] ?: '#' ?>" class="btn btn-light btn-lg text-primary fw-bold px-4 rounded-pill">Explore Now</a>
                                </div>
                                <div class="col-md-6 text-center order-1 order-md-2 mb-4 mb-md-0">
                                    <?php 
                                    $imagePath = 'slider/' . $s['gambar_slider'];
                                    $defaultImage = \App\Models\M_slider::DEFAULT_IMAGE;
                                    
                                    // Check if file exists and is not default
                                    if (!empty($s['gambar_slider']) && $s['gambar_slider'] !== $defaultImage && file_exists(FCPATH . $imagePath)) {
                                        echo '<img src="' . base_url($imagePath) . '" alt="' . htmlspecialchars($s['judul_slider']) . '" class="img-fluid rounded-3 shadow-lg" style="max-height: 280px; object-fit: cover;">';
                                    } else {
                                        // Use default image
                                        echo '<img src="' . base_url('assets/img/' . $defaultImage) . '" alt="' . htmlspecialchars($s['judul_slider']) . '" class="img-fluid rounded-3">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item active">
                        <div class="row align-items-center py-5 px-4 h-100">
                            <div class="col-md-6 order-2 order-md-1">
                                <h2 class="mb-3 text-white fw-bold">Selamat Datang di LPK INASADA</h2>
                                <p class="mb-4 text-white-50 opacity-75">Tingkatkan keahlianmu dengan kursus online terbaik kami.</p>
                                <a href="<?= base_url('home_siswa/v_kursus') ?>" class="btn btn-light btn-lg text-primary fw-bold px-4 rounded-pill">Lihat Kursus</a>
                            </div>
                            <div class="col-md-6 text-center order-1 order-md-2 mb-4 mb-md-0">
                                <img src="<?= base_url('assets/img/' . \App\Models\M_slider::DEFAULT_HERO) ?>" alt="Default Hero" class="img-fluid rounded-3">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

               </div>
    </div>
</div>

<!-- Let's Start Learning -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Let's start learning</h4>
        <a href="<?= base_url('home_siswa/v_kursus') ?>" class="btn btn-link fw-bold text-decoration-none">My learning <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    <div class="row">
        <?php if (!empty($enrolled)): ?>
            <?php foreach ($enrolled as $e): ?>
                <?php
                // Determine status display
                $statusLabel = 'Menunggu Pembayaran';
                $statusClass = 'bg-warning text-dark';
                $iconClass = 'fas fa-clock';
                $iconBg = 'bg-warning';
                
                // Check if payment is successful
                $isPaymentSuccess = ($e['status_pembelian'] === 'success');
                
                if ($isPaymentSuccess && $e['status'] === 'diverifikasi') {
                    // If payment success but status still diverifikasi, show as aktif
                    $statusLabel = 'Aktif';
                    $statusClass = 'bg-success';
                    $iconClass = 'fas fa-play';
                    $iconBg = 'bg-primary';
                } elseif ($e['status'] === 'aktif') {
                    $statusLabel = 'Aktif';
                    $statusClass = 'bg-success';
                    $iconClass = 'fas fa-play';
                    $iconBg = 'bg-primary';
                } elseif ($e['status'] === 'selesai') {
                    $statusLabel = 'Selesai';
                    $statusClass = 'bg-info';
                    $iconClass = 'fas fa-check-circle';
                    $iconBg = 'bg-success';
                } elseif ($e['status'] === 'menunggu') {
                    $statusLabel = 'Menunggu Admin';
                    $statusClass = 'bg-warning text-dark';
                    $iconClass = 'fas fa-user-clock';
                    $iconBg = 'bg-warning';
                } elseif ($e['status'] === 'expired') {
                    $statusLabel = 'Expired';
                    $statusClass = 'bg-secondary';
                    $iconClass = 'fas fa-ban';
                    $iconBg = 'bg-secondary';
                }
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle <?= $iconBg ?> text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 50px; height: 50px; min-width: 50px;">
                                    <i class="<?= $iconClass ?> fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold"><?= htmlspecialchars($e['nama_kursus']) ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($e['nama_program'] ?? '') ?></small>
                                </div>
                                <span class="badge <?= $statusClass ?> rounded-pill ms-2"><?= $statusLabel ?></span>
                            </div>

                            <?php if (($e['status'] === 'aktif' || $e['status'] === 'selesai') || ($isPaymentSuccess && $e['status'] === 'diverifikasi')): ?>
                                <!-- Progress bar for active/completed courses -->
                                <div class="progress mb-2" style="height: 6px; border-radius: 10px;">
                                    <div class="progress-bar bg-success" style="width: <?= $e['progress'] ?>%"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><?= $e['progress'] > 0 ? $e['progress'] . '% completed' : 'Not started' ?></small>
                                    <div class="d-flex gap-2 align-items-center">
                                        <?php if ($e['progress'] >= 80 && !in_array($e['id_pendaftaran'], $reviewed_ids ?? [])): ?>
                                            <a href="<?= base_url('home_siswa/review/buat/' . $e['id_pendaftaran']) ?>"
                                                class="small text-warning fw-bold text-decoration-none" title="Beri Review">
                                                <i class="fas fa-star me-1"></i>Review
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($e['status_pembelian'] === 'success'): ?>
                                            <a href="<?= base_url('home_siswa/detail_kelas_saya/' . $e['id_pendaftaran']) ?>" 
                                                class="small text-info fw-bold text-decoration-none" title="Detail Kelas">
                                                <i class="fas fa-info-circle me-1"></i>Detail
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('home_siswa/belajar/' . $e['id_pendaftaran']) ?>" class="small text-primary fw-bold text-decoration-none">
                                            <?= $e['status'] === 'selesai' ? 'Lihat Kursus' : 'Continue' ?> <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php if ($e['status'] === 'menunggu'): ?>
                                    <div class="alert alert-warning py-2 px-3 mb-2 small rounded-3 border-0">
                                        <i class="fas fa-info-circle me-1"></i> Akun / Pembayaran Anda sedang menunggu verifikasi Admin.
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Rp <?= number_format($e['total_bayar'] ?? $e['harga_kursus'] ?? 0, 0, ',', '.') ?></small>
                                        <span class="small text-warning fw-bold"><i class="fas fa-lock me-1"></i>Belum Bisa Belajar</span>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning py-2 px-3 mb-2 small rounded-3 border-0">
                                        <i class="fas fa-info-circle me-1"></i> Kursus ini menunggu pembayaran untuk diaktifkan.
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Rp <?= number_format($e['total_bayar'] ?? $e['harga_kursus'] ?? 0, 0, ',', '.') ?></small>
                                        <a href="<?= base_url('home_siswa/status_bayar') ?>" class="small text-warning fw-bold text-decoration-none">
                                            Bayar Sekarang <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-4">
                <div class="alert alert-info border-0 shadow-sm rounded-3">
                    <i class="fas fa-info-circle me-2"></i> Anda belum memiliki kursus aktif. <a href="<?= base_url('home_website/store') ?>" class="alert-link">Mulai berlangganan sekarang!</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Featured / Recommended -->
<div class="container py-5 border-top">
    <h4 class="mb-4 fw-bold text-center">Kelas Online</h4>
    <div class="row">
        <?php if (!empty($recommendations)): ?>
            <?php foreach ($recommendations as $r): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="position-relative">
                            <a href="<?= base_url('home_website/detail_online/' . $r['id_paket']) ?>" class="text-decoration-none">
                                <img src="<?= base_url('kursus/materi/' . ($r['gambar_detail_a'] ?? $r['gambar_utama'] ?? 'as.png')) ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($r['nama_kursus']) ?>" 
                                     style="height: 250px; object-fit: contain; background-color: #f8f9fa; padding: 10px;" 
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <!-- Course Title -->
                            <h6 class="card-title fw-bold mb-2">
                                <a href="<?= base_url('home_website/detail_online/' . $r['id_paket']) ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($r['nama_kursus']) ?>
                                </a>
                            </h6>
                            
                            <!-- Online Badge -->
                            <div class="mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                                    <i class="fas fa-globe me-1"></i><?= htmlspecialchars($r['nama_program'] ?? 'Kelas Online') ?>
                                </span>
                            </div>
                            
                            <!-- Star Rating -->
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            
                            <!-- Description -->
                            <p class="card-text small text-muted mb-3"><?= substr(strip_tags($r['deskripsi_singkat'] ?? ''), 0, 80) ?>...</p>
                            
                            <div class="mt-auto">
                                <!-- Price -->
                                <div class="text-primary fw-bold fs-5 mb-3">
                                    <?php if (($r['harga_reguler'] ?? 0) > 0): ?>
                                        Rp <?= number_format($r['harga_reguler'], 0, ',', '.') ?>
                                    <?php else: ?>
                                        <span class="text-success">Gratis</span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="d-flex gap-2">
                                    <!-- Form Tambah ke Keranjang -->
                                    <?php if (!empty($r['id_paket'])): ?>
                                        <form action="<?= base_url('home_siswa/save_cart') ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_kursus" value="<?= $r['id_kursus'] ?>">
                                            <input type="hidden" name="id_paket" value="<?= $r['id_paket'] ?>">
                                            <input type="hidden" name="nama_paket" value="<?= $r['nama_kursus'] ?>">
                                            <input type="hidden" name="nama_program" value="<?= $r['nama_program'] ?>">
                                            <input type="hidden" name="harga_kursus" value="<?= $r['harga_reguler'] ?>">
                                            <button type="submit" class="btn btn-outline-warning btn-sm rounded-circle" title="Tambah ke Keranjang">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>

                                        <!-- Tombol Beli Sekarang -->
                                        <a href="<?= base_url('home_siswa/checkout_direct/' . $r['id_paket']) ?>" class="btn btn-primary btn-sm rounded-pill px-3">Beli</a>
                                    <?php else: ?>
                                        <span class="text-muted small">Hubungi Admin</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">Tidak ada rekomendasi kursus online saat ini.</div>
        <?php endif; ?>
    </div>
</div>

<!-- What to Learn Next (Additional) -->
<div class="container py-5 border-top">
    <h4 class="mb-2 fw-bold">Explore More Topics</h4>
    <h6 class="text-muted mb-4">Temukan berbagai materi menarik lainnya di LPK INASADA</h6>

    <div class="row">
        <?php if (empty($recommendations)): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="https://via.placeholder.com/400x250/1a237e/ffffff?text=General+Course" class="card-img-top" alt="Course">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">Telusuri Semua Kursus</h6>
                        <p class="small text-muted">Jelajahi ratusan materi profesional kami.</p>
                        <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-primary rounded-pill px-4">Buka Store</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-outline-primary rounded-pill px-5 fw-bold">Show all courses</a>
    </div>
</div>

<?= $this->endSection() ?>