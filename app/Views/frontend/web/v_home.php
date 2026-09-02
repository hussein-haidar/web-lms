<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php
// Ambil data kelas offline dari controller
$offline_courses = $offline ?? [];
$recommendations = $recommendations ?? [];
$sliders = $sliders ?? [];
?>

<!-- Program Banner - Carousel dengan Gambar -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php if (!empty($sliders)): ?>
            <?php foreach ($sliders as $key => $slider): ?>
                <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('uploads/slider_web/' . $slider['gambar_slider']) ?>"
                        class="d-block w-100"
                        alt="<?= htmlspecialchars($slider['judul_slider']) ?>"
                        style="height: 300px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="carousel-item active">
                <img src="<?= base_url('/gambar_kursus/tf.png') ?>"
                    class="d-block w-100"
                    alt="Program Profesi 1 Tahun"
                    style="height: 300px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
            </div>
        <?php endif; ?>
    </div>
    <div class="carousel-indicators">
        <?php if (!empty($sliders)): ?>
            <?php foreach ($sliders as $key => $slider): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $key ?>" class="<?= $key == 0 ? 'active' : '' ?>" aria-current="<?= $key == 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $key + 1 ?>"></button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Stats Section - Padding dikurangi -->
<section class="py-4 text-center" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
    <div class="container">
        <!-- Judul Section -->
        <h1 class="display-5 fw-bold text-white mb-4">LPK INASABA</h1>

        <!-- Baris 1: 6 cards -->
        <div class="row g-3 mb-3">
            <?php if (!empty($stats_row1)): ?>
                <?php foreach ($stats_row1 as $stat): ?>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                            <div class="display-6 fw-bold text-primary counter <?= !empty($stat['suffix_stats']) && strpos($stat['suffix_stats'], 'Tahun') !== false ? 'text-nowrap' : '' ?>" 
                                 data-target="<?= $stat['nilai_stats'] ?>" 
                                 data-suffix="<?= htmlspecialchars($stat['suffix_stats'] ?? '') ?>">0</div>
                            <div class="fw-bold small mt-2"><?= htmlspecialchars($stat['judul_stats']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback hardcoded stats if database is empty -->
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="10000" data-suffix="+">0</div>
                        <div class="fw-bold small mt-2">Peserta Program</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter text-nowrap" data-target="25" data-suffix=" Tahun">0</div>
                        <div class="fw-bold small mt-2">Mendidik & mengedukasi Indonesia</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="100" data-suffix="+">0</div>
                        <div class="fw-bold small mt-2">Mitra</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="70" data-suffix="%">0</div>
                        <div class="fw-bold small mt-2">Praktek</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="30" data-suffix="%">0</div>
                        <div class="fw-bold small mt-2">Teori</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="95" data-suffix="%">0</div>
                        <div class="fw-bold small mt-2">Alumni Terserap Kerja</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Baris 2: 3 cards (centered) -->
        <div class="row g-3 justify-content-center">
            <?php if (!empty($stats_row2)): ?>
                <?php foreach ($stats_row2 as $stat): ?>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                            <?php if (empty($stat['suffix_stats']) && $stat['nilai_stats'] == 0): ?>
                                <!-- Special case for LSP P1 -->
                                <div class="display-6 fw-bold text-primary"><?= htmlspecialchars($stat['judul_stats']) ?></div>
                                <div class="fw-bold small mt-2"><?= htmlspecialchars($stat['judul_stats']) ?></div>
                            <?php else: ?>
                                <div class="display-6 fw-bold text-primary counter" 
                                     data-target="<?= $stat['nilai_stats'] ?>" 
                                     data-suffix="<?= htmlspecialchars($stat['suffix_stats'] ?? '') ?>">0</div>
                                <div class="fw-bold small mt-2"><?= htmlspecialchars($stat['judul_stats']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback hardcoded stats if database is empty -->
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="20" data-suffix="+">0</div>
                        <div class="fw-bold small mt-2">Instruktur Bersertifikat</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary counter" data-target="15" data-suffix="+">0</div>
                        <div class="fw-bold small mt-2">Program Pelatihan</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="bg-light border rounded p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="display-6 fw-bold text-primary">LSP P1</div>
                        <div class="fw-bold small mt-2">Sertifikasi Resmi</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Wave Divider -->
<div class="position-relative overflow-hidden" style="height: 80px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
        <path d="M0,120V73.71c47.79,-22.2,103.59,-32.17,158,-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27,-18,138.3,-24.88,209.4,-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9,-9.42,98.6,-31.56,31.77,-25.39,62.32,-62,103.63,-73,40.44,-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28,-22.88,168.9,-38.84,30.2,-8.66,59,-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48,-12.24,165.56,-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Partners Section - Bootstrap Carousel - Margin dikurangi -->
<div class="bg-light py-3">
    <div class="container">
        <h2 class="text-center mb-3 fw-bold text-primary">Mitra Kerja</h2>

        <?php if (!empty($partners_carousel)): ?>
            <!-- Bootstrap Carousel -->
            <div id="partnersCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators" style="bottom: -50px; margin-top: 50px;">
                    <?php foreach ($partners_carousel as $index => $slide): ?>
                        <button type="button"
                            data-bs-target="#partnersCarousel"
                            data-bs-slide-to="<?= $index ?>"
                            class="<?= $index === 0 ? 'active' : '' ?>"
                            <?= $index === 0 ? 'aria-current="true"' : '' ?>
                            aria-label="Slide <?= $index + 1 ?>"
                            style="background-color: #0d6efd; width: 12px; height: 12px; border-radius: 50%; margin: 0 5px;"></button>
                    <?php endforeach; ?>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <?php foreach ($partners_carousel as $slide_index => $slide): ?>
                        <div class="carousel-item <?= $slide_index === 0 ? 'active' : '' ?>">
                            <div class="row g-3">
                                <?php foreach ($slide as $partner): ?>
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded p-3 d-flex align-items-center justify-content-center h-100 bg-white">
                                            <?php if (!empty($partner['url_website'])): ?>
                                                <a href="<?= esc($partner['url_website']) ?>" target="_blank" rel="noopener noreferrer">
                                                    <img src="<?= base_url('/uploads/mitra_kerja/' . $partner['logo_mitra']) ?>"
                                                        alt="<?= esc($partner['nama_mitra']) ?>"
                                                        class="img-fluid"
                                                        loading="lazy">
                                                </a>
                                            <?php else: ?>
                                                <img src="<?= base_url('/uploads/mitra_kerja/' . $partner['logo_mitra']) ?>"
                                                    alt="<?= esc($partner['nama_mitra']) ?>"
                                                    class="img-fluid"
                                                    loading="lazy">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- End Carousel -->
        <?php else: ?>
            <div class="text-center text-muted">
                <p>Belum ada data mitra kerja tersedia.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Program Kursus (Kelas Offline) -->
<div class="container my-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Program Kursus (Kelas Offline)</h2>
                <button type="button" class="btn btn-primary btn-sm" id="toggleOffline">Lihat Semua</button>
            </div>

            <div class="row g-4" id="offlineCourses">
                <?php if (!empty($offline_courses)): ?>
                    <?php foreach ($offline_courses as $r): ?>
                        <div class="col-md-6 col-lg-3 course-item">
                            <div class="card h-100 shadow-sm border-0 rounded-2 d-flex flex-column">
                                <div class="position-relative" style="height: 200px; overflow: hidden;">
                                    <img src="<?= base_url('kursus/materi/' . ($r['gambar_detail_a'] ?? $r['gambar_utama'] ?? 'as.png')) ?>"
                                        class="w-100 h-100"
                                        alt="<?= htmlspecialchars($r['nama_kursus']) ?>"
                                        style="object-fit: contain; background-color: #f8f9fa; padding: 10px;"
                                        onerror="this.src='<?= base_url('gambar_kursus/as.png') ?>'">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="fw-bold text-dark mb-2">
                                        <a href="<?= base_url('home_website/detail_offline/' . $r['id_paket']) ?>" class="text-decoration-none text-dark">
                                            <?= htmlspecialchars($r['nama_paket'] ?? $r['nama_kursus']) ?>
                                        </a>
                                    </h6>

                                    <!-- Badges -->
                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="fas fa-check-circle me-1"></i>Reguler
                                        </span>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="fas fa-check-circle me-1"></i>Intensive
                                        </span>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="fas fa-check-circle me-1"></i>Private
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

                                    <p class="card-text text-muted small"><?= substr(strip_tags($r['deskripsi_singkat'] ?? ''), 0, 80) ?>...</p>
                                    <div class="mb-3">
                                        <span class="badge bg-light text-primary me-1"><?= $r['total_pertemuan'] ?? 25 ?>x</span>
                                        <span class="badge bg-light text-primary">Offline</span>
                                    </div>
                                    <div class="fw-bold text-primary mb-3">
                                        <?php
                                        $harga = min(array_filter([$r['harga_reguler'] ?? 0, $r['harga_intensive'] ?? 0, $r['harga_private'] ?? 0]));
                                        if ($harga > 0): ?>
                                            Rp <?= number_format($harga, 0, ',', '.') ?>
                                        <?php else: ?>
                                            <span class="text-success">Gratis</span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?= base_url('home_website/detail_offline/' . $r['id_paket']) ?>" class="btn btn-primary w-100 mt-auto">Daftar Sekarang</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">Tidak ada kursus offline tersedia saat ini.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Featured / Recommended -->
<div class="container my-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Program Kursus (Kelas Online)</h2>
                <button type="button" class="btn btn-primary btn-sm" id="toggleOnline">Lihat Semua</button>
            </div>
            <div class="row" id="onlineCourses">
                <?php if (!empty($online_courses)): ?>
                    <?php foreach ($online_courses as $r): ?>
                        <div class="col-md-4 mb-4 course-item">
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
                                                    <input type="hidden" name="nama_paket" value="<?= $r['nama_paket'] ?? $r['nama_kursus'] ?>">
                                                    <input type="hidden" name="nama_program" value="<?= $r['nama_program'] ?>">
                                                    <input type="hidden" name="harga_kursus" value="<?= $r['harga_reguler'] ?>">
                                                    <input type="hidden" name="gambar_detail_a" value="<?= $r['gambar_detail_a'] ?>">
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
    </div>
</div>

<!-- Tempat Uji Kompetensi Section - Padding dikurangi -->
<section class="py-4 bg-light">
    <div class="container">
        <!-- Logo dan Judul -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <div class="mb-3">
                    <h2 class="fw-bold text-primary mb-3">Tempat Uji Kompetensi</h2>
                    <img src="<?= base_url('/gambar_kursus/cx.png') ?>"
                        alt="Logo INASABA"
                        class="img-fluid mb-3"
                        style="max-width: 120px;">
                </div>
                <div class="bg-white p-3 rounded-3 shadow-sm">
                    <p class="text-muted mb-3 small">
                        Inasaba ditunjuk sebagai <strong>Tempat Uji Kompetensi (TUK)</strong> di bidang TIK yang sudah diakui oleh <strong>LSK – TIK</strong> yaitu Lembaga yang mengeluarkan Sertifikasi Kompetensi tingkat Nasional yang ditetapkan oleh Kemdikbud untuk menyelenggarakan Sertifikasi Kompetensi di bidang komputer di seluruh Indonesia.
                    </p>
                    <div class="alert alert-primary mb-0 py-2">
                        <strong>Surat Ketetapan Kemdikbud:</strong> SK.KEP/152/E/KK/2009
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Cards (GLCP & OACS) -->
        <div class="row justify-content-center g-4 mb-4">
            <!-- GLCP Card -->
            <div class="col-md-6 col-lg-5">
                <div class="card h-100 border-0 shadow-lg d-flex flex-column">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="mb-3">
                            <img src="<?= base_url('/gambar_kursus/clcp.png') ?>"
                                alt="Logo INASABA"
                                class="img-fluid mb-3"
                                style="max-width: 120px;">
                        </div>

                        <ul class="list-unstyled text-start mx-auto" style="max-width: 250px;">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Durasi: 3 Bulan</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Online & Offline</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Sertifikat Google</span>
                            </li>
                        </ul>

                        <div class="mt-auto pt-4">
                            <div class="fw-bold text-primary fs-5 mb-3">Rp 450.000</div>
                            <a href="#" class="btn btn-primary w-100">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- OACS Card -->
            <div class="col-md-6 col-lg-5">
                <div class="card h-100 border-0 shadow-lg d-flex flex-column">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="mb-3">
                            <img src="<?= base_url('/gambar_kursus/oa.png') ?>"
                                alt="Logo INASABA"
                                class="img-fluid mb-3"
                                style="max-width: 120px;">
                        </div>
                        <ul class="list-unstyled text-start mx-auto" style="max-width: 250px;">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Durasi: 4 Bulan</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Belajar Akuntansi Cloud</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Software Modern</span>
                            </li>
                        </ul>

                        <div class="mt-auto pt-4">
                            <div class="fw-bold text-primary fs-5 mb-3">Rp 450.000</div>
                            <a href="#" class="btn btn-primary w-100">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Postingan Terbaru Section - Padding dikurangi -->
<section class="py-4 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold text-primary mb-4">Postingan Terbaru</h2>

        <div class="row g-4">
            <?php if (!empty($recent_posts)): ?>
                <?php foreach ($recent_posts as $post): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm border-0 d-flex flex-column">
                            <?php if (!empty($post['gambar_postingan'])): ?>
                                <img src="<?= base_url('uploads/postingan/' . $post['gambar_postingan']) ?>"
                                    class="card-img-top"
                                    alt="<?= esc($post['judul_postingan']) ?>"
                                    style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fas fa-tag me-1"></i><?= esc($post['kategori']) ?>
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-eye me-1"></i><?= number_format($post['views']) ?>
                                    </span>
                                </div>
                                <h6 class="card-title fw-bold text-primary">
                                    <a href="<?= base_url('postingan/detail/' . $post['slug']) ?>"
                                        class="text-decoration-none text-primary">
                                        <?= esc(substr($post['judul_postingan'], 0, 50) . (strlen($post['judul_postingan']) > 50 ? '...' : '')) ?>
                                    </a>
                                </h6>
                                <p class="card-text small text-muted"><?= esc($post['excerpt']) ?></p>
                                <a href="<?= base_url('postingan/detail/' . $post['slug']) ?>"
                                    class="btn btn-sm btn-outline-primary mt-auto">Baca Selengkapnya</a>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <small class="text-muted">
                                    <i class="far fa-calendar me-2"></i><?= date('d M Y', strtotime($post['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada postingan</h5>
                    <p class="text-muted">Postingan akan segera tersedia. Silakan kunjungi kembali nanti.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Link Lihat Semua -->
        <div class="text-center mt-4">
            <a href="<?= base_url('postingan') ?>" class="btn btn-primary">
                <i class="fas fa-newspaper me-2"></i>Lihat Semua Postingan
            </a>
        </div>
    </div>
</section>

<!-- Script untuk Toggle Lihat Semua -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Offline Courses - Show first 4, hide rest
        const toggleOffline = document.getElementById('toggleOffline');
        const offlineCourses = document.getElementById('offlineCourses');
        const offlineItems = offlineCourses.querySelectorAll('.course-item');

        // Hide items 5+ initially (show only first 4)
        offlineItems.forEach((item, index) => {
            if (index >= 4) {
                item.style.display = 'none';
            }
        });

        if (toggleOffline) {
            toggleOffline.addEventListener('click', function() {
                let visibleCount = 0;
                offlineItems.forEach(item => {
                    if (item.style.display !== 'none') visibleCount++;
                });

                if (visibleCount < offlineItems.length) {
                    // Show all
                    offlineItems.forEach(item => {
                        item.style.display = 'block';
                    });
                    this.textContent = 'Sembunyikan';
                } else {
                    // Hide items 5+, show only first 4
                    offlineItems.forEach((item, index) => {
                        if (index >= 4) {
                            item.style.display = 'none';
                        } else {
                            item.style.display = 'block';
                        }
                    });
                    this.textContent = 'Lihat Semua';
                }
            });
        }

        // Toggle Online Courses - Show first 3, hide rest
        const toggleOnline = document.getElementById('toggleOnline');
        const onlineCourses = document.getElementById('onlineCourses');
        const onlineItems = onlineCourses.querySelectorAll('.course-item');

        // Hide items 4+ initially (show only first 3)
        onlineItems.forEach((item, index) => {
            if (index >= 3) {
                item.style.display = 'none';
            }
        });

        if (toggleOnline) {
            toggleOnline.addEventListener('click', function() {
                let visibleCount = 0;
                onlineItems.forEach(item => {
                    if (item.style.display !== 'none') visibleCount++;
                });

                if (visibleCount < onlineItems.length) {
                    // Show all
                    onlineItems.forEach(item => {
                        item.style.display = 'block';
                    });
                    this.textContent = 'Sembunyikan';
                } else {
                    // Hide items 4+, show only first 3
                    onlineItems.forEach((item, index) => {
                        if (index >= 3) {
                            item.style.display = 'none';
                        } else {
                            item.style.display = 'block';
                        }
                    });
                    this.textContent = 'Lihat Semua';
                }
            });
        }

        // Counter Animation for Stats
        function animateCounter() {
            const counters = document.querySelectorAll('.counter');
            const speed = 200; // Animation speed

            counters.forEach(counter => {
                const animate = () => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const suffix = counter.getAttribute('data-suffix') || '';
                    const current = parseInt(counter.innerText.replace(/[^0-9]/g, ''));
                    const increment = target / speed;

                    if (current < target) {
                        counter.innerText = Math.ceil(current + increment) + suffix;
                        setTimeout(animate, 1);
                    } else {
                        counter.innerText = target + suffix;
                    }
                };

                // Start animation when element is in viewport
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animate();
                            observer.unobserve(entry.target);
                        }
                    });
                });

                observer.observe(counter);
            });
        }

        // Initialize counter animation
        animateCounter();
    });
</script>

<?= $this->endSection() ?>