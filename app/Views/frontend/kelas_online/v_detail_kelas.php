<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php
$kursus = $kursus ?? [];
$r = $kursus; // Buat variable $r dari $kursus
$idKursus   = $kursus['id_kursus'] ?? '';
$idPaket    = $kursus['id_paket'] ?? '';
$gambarBanner = !empty($kursus['gambar_utama']) ? $kursus['gambar_utama'] : 'as.png';
$judulAsli = !empty($kursus['nama_paket']) ? (string) $kursus['nama_paket'] : (!empty($kursus['nama_kursus']) ? (string) $kursus['nama_kursus'] : 'Program Pelatihan');
$judulPaket = preg_replace('/\s*-\s*\d+\s*(Pertemuan|sesi|Sesi)/i', '', $judulAsli);
$judulPaket = trim($judulPaket);
$deskripsi  = !empty($kursus['deskripsi_singkat']) ? (string) $kursus['deskripsi_singkat'] : '';
$materi     = !empty($kursus['materi_yang_dipelajari']) ? (string) $kursus['materi_yang_dipelajari'] : '';
$jadwal     = !empty($kursus['jadwal_pelatihan']) ? (string) $kursus['jadwal_pelatihan'] : '';
$totalPertemuan = !empty($kursus['total_pertemuan']) ? (int) $kursus['total_pertemuan'] : 25;
$durasiJam      = !empty($kursus['durasi_per_pertemuan_jam']) ? (int) $kursus['durasi_per_pertemuan_jam'] : 2;
$hargaReguler   = !empty($kursus['harga_reguler']) ? (float) $kursus['harga_reguler'] : 0;
$hargaIntensive = !empty($kursus['harga_intensive']) ? (float) $kursus['harga_intensive'] : 0;
$hargaPrivate   = !empty($kursus['harga_private']) ? (float) $kursus['harga_private'] : 0;
$instruktur = !empty($kursus['nama_pengajar']) ? (string) $kursus['nama_pengajar'] : '';
$instrukturFoto = !empty($kursus['foto_pengajar']) ? $kursus['foto_pengajar'] : '';

$instrukturName = !empty($instruktur) ? $instruktur : 'Professional Trainer';
if (!empty($instrukturFoto)) {
    $instrukturAvatar = base_url('fotoprofil/' . $instrukturFoto);
} else {
    $instrukturAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($instrukturName) . '&background=1976d2&color=fff&size=120';
}

// ✅ DATA DI KIRIM DARI CONTROLLER ($kurikulum, $stats, $contentStats)
$statsKonten = [
    'dokumen' => $contentStats['dokumen'] ?? 0,
    'video' => $contentStats['video'] ?? 0,
    'zoom' => $contentStats['zoom'] ?? 0,
    'quiz' => $contentStats['quiz'] ?? 0,
    'tugas' => $contentStats['tugas'] ?? 0,
    'preExam' => ($contentStats['pre_exam'] ?? 0) > 0,
    'exam' => ($contentStats['exam'] ?? 0) > 0,
    'sertifikat' => $contentStats['sertifikat'] ?? false
];
?>

<!-- Course Header -->
<div style="background: linear-gradient(90deg, #1976d2 0%, #00acc1 100%);">
    <div class="container py-4 py-lg-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="h3 h-lg-2 fw-bold mb-3 text-white"><?= esc($judulPaket) ?></h1>
                <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                    <?php
                    $avgRating = number_format((float)($rating_stats['avg_rating'] ?? 0), 1);
                    $totalReview = (int)($rating_stats['total_review'] ?? 0);
                    $fullStars = floor($avgRating);
                    $halfStar = ($avgRating - $fullStars) >= 0.3;
                    ?>
                    <div class="text-warning">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $fullStars): ?>
                                <i class="fas fa-star"></i>
                            <?php elseif ($i == $fullStars + 1 && $halfStar): ?>
                                <i class="fas fa-star-half-alt"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span class="text-white ms-2 fw-bold"><?= $avgRating ?></span>
                    </div>
                    <span class="text-white-50">(<?= $totalReview ?> reviews)</span>
                    <span class="text-white-50">|</span>
                    <span class="text-white"><i class="fas fa-users me-2"></i>Online</span>
                </div>
                <p class="lead text-white-50 mb-4">Kuasai Microsoft Word dari dasar hingga mahir dengan praktik langsung</p>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-light px-3 py-2 fw-bold" style="font-size: 0.85rem;" onclick="playPreview()">
                        <i class="fas fa-play-circle me-1"></i>Preview
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WAVE DIVIDER -->
<div class="position-relative" style="height: 80px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; transform: scaleY(-1);">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Main Content -->
<div class="container my-5">
    <?php $customGap = '40px'; ?>
    <div class="row" style="margin-left: -<?= $customGap ?>; margin-right: -<?= $customGap ?>;">
        <div class="col-lg-8" style="padding-left: <?= $customGap ?>; padding-right: <?= $customGap ?>;">
            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3 pb-2 border-bottom">Description</h2>
                <div class="text-secondary" style="line-height: 1.8;">
                    <?php if (!empty($deskripsi)): ?>
                        <?= nl2br(esc($deskripsi)) ?>
                    <?php else: ?>
                        <p>Microsoft Word adalah program pengolah kata yang paling banyak digunakan di dunia.</p>
                        <ul class="mt-3">
                            <li>✓ Formatting dokumen profesional</li>
                            <li>✓ Mail Merge untuk surat massal</li>
                            <li>✓ Table dan layout dokumen</li>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>

            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3 pb-2 border-bottom">Tentang Instruktur</h2>
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-4">
                            <img src="<?= $instrukturAvatar ?>"
                                alt="<?= esc($instrukturName) ?>"
                                class="rounded-circle"
                                style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #1976d2;">
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-2"><?= esc($instrukturName) ?></h4>
                                <p class="text-muted mb-2"><i class="fas fa-briefcase me-2"></i>Microsoft Certified Trainer</p>
                                <p class="text-secondary mb-0">Instruktur berpengalaman lebih dari 10 tahun.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3 pb-2 border-bottom">Topik yang akan dibahas</h2>
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <?php 
                // Calculate accurate content counts
                $totalSections = count($kurikulum);
                $totalLectures = 0;
                $totalQuizzes = 0;
                $totalVideos = 0;
                $totalZooms = 0;
                
                foreach ($kurikulum as $section) {
                    foreach ($section['materi'] as $m) {
                        switch($m['tipe_materi']) {
                            case 'quiz':
                                $totalQuizzes++;
                                break;
                            case 'video':
                            case 'youtube':
                                $totalVideos++;
                                $totalLectures++;
                                break;
                            case 'zoom':
                                $totalZooms++;
                                $totalLectures++;
                                break;
                            default:
                                $totalLectures++;
                                break;
                        }
                    }
                }
                
                // Build descriptive text
                $contentParts = [];
                if ($totalLectures > 0) {
                    $contentParts[] = $totalLectures . ' materi';
                }
                if ($totalQuizzes > 0) {
                    $contentParts[] = $totalQuizzes . ' kuis';
                }
                
                $contentText = implode(' • ', $contentParts);
                if (empty($contentText)) {
                    $contentText = '0 materi';
                }
                ?>
                <span class="text-secondary"><strong><?= $totalSections ?></strong> bagian • <strong><?= $contentText ?></strong></span>
                    <button class="btn btn-sm btn-outline-primary" id="toggleAllBtn" onclick="toggleAllAccordion()">
                        <i class="fas fa-chevron-down me-1"></i>Perluas Semua
                    </button>
                </div>
                <div class="accordion" id="courseAccordion">
                    <?php foreach ($kurikulum as $index => $section): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section<?= $index ?>" aria-expanded="false">
                                    <i class="fas fa-folder me-2"></i>
                                    <div class="flex-grow-1">
                                        <div><?= esc($section['judul']) ?></div>
                                        <?php 
                                        $contentTypes = [
                                            'materi' => 0,
                                            'quiz' => 0,
                                            'video' => 0,
                                            'zoom' => 0
                                        ];
                                        
                                        foreach ($section['materi'] as $m) {
                                            switch($m['tipe_materi']) {
                                                case 'quiz':
                                                    $contentTypes['quiz']++;
                                                    break;
                                                case 'video':
                                                case 'youtube':
                                                    $contentTypes['video']++;
                                                    break;
                                                case 'zoom':
                                                    $contentTypes['zoom']++;
                                                    break;
                                                default:
                                                    $contentTypes['materi']++;
                                                    break;
                                            }
                                        }
                                        
                                        // Build dynamic text
                                        $parts = [];
                                        if ($contentTypes['materi'] > 0) {
                                            $parts[] = $contentTypes['materi'] . ' materi';
                                        }
                                        if ($contentTypes['quiz'] > 0) {
                                            $parts[] = $contentTypes['quiz'] . ' quiz';
                                        }
                                        if ($contentTypes['video'] > 0) {
                                            $parts[] = $contentTypes['video'] . ' video';
                                        }
                                        if ($contentTypes['zoom'] > 0) {
                                            $parts[] = $contentTypes['zoom'] . ' zoom';
                                        }
                                        
                                        $result = '';
                                        if (empty($parts)) {
                                            $result = '0 materi';
                                        } elseif (count($parts) == 1) {
                                            $result = $parts[0];
                                        } elseif (count($parts) == 2) {
                                            $result = $parts[0] . ' dan ' . $parts[1];
                                        } else {
                                            $last = array_pop($parts);
                                            $result = implode(', ', $parts) . ', dan ' . $last;
                                        }
                                        ?>
                                        <small class="text-muted"><?= $result ?></small>
                                    </div>
                                </button>
                            </h2>
                            <div id="section<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                                <div class="accordion-body p-0">
                                    <?php foreach ($section['materi'] as $materiIndex => $m): ?>
                                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom hover-bg-light cursor-pointer"
                                            onclick="">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-2 p-2 me-3 <?= $m['tipe_materi'] === 'quiz' ? 'bg-warning bg-opacity-10 text-warning' : ($m['tipe_materi'] === 'zoom' ? 'bg-info bg-opacity-10 text-info' : 'bg-success bg-opacity-10 text-success') ?>">
                                                    <i class="fas fa-<?= $m['tipe_materi'] === 'quiz' ? 'question-circle' : ($m['tipe_materi'] === 'zoom' ? 'video' : 'file-alt') ?>"></i>
                                                </div>
                                                <span class="fw-semibold"><?= esc($m['judul_materi']) ?></span>
                                                <?php if ($m['is_preview']): ?>
                                                    <span class="badge bg-success ms-2" style="font-size: 0.65rem;">Preview</span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-secondary"><i class="far fa-clock me-1"></i>-:--</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3 pb-2 border-bottom">Konten Kelas</h2>
                <div class="bg-info bg-opacity-10 rounded-3 p-4">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-file-download text-success"></i>
                                <div class="fw-bold"><?= $statsKonten['dokumen'] ?> Dokumen</div>
                            </div>
                        </div>
                        <?php if ($statsKonten['video'] > 0): ?><div class="col-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-play-circle text-danger"></i>
                                <div class="fw-bold"><?= $statsKonten['video'] ?> Video</div>
                            </div>
                        </div><?php endif; ?>
                        <?php if ($statsKonten['zoom'] > 0): ?><div class="col-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-video text-info"></i>
                                <div class="fw-bold"><?= $statsKonten['zoom'] ?> Zoom</div>
                            </div>
                        </div><?php endif; ?>
                        <?php if ($statsKonten['quiz'] > 0): ?><div class="col-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-question-circle text-warning"></i>
                                <div class="fw-bold"><?= $statsKonten['quiz'] ?> Quiz</div>
                            </div>
                        </div><?php endif; ?>
                        <?php if ($statsKonten['tugas'] > 0): ?><div class="col-6 col-md-4">
                            <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-tasks text-primary"></i>
                                <div class="fw-bold"><?= $statsKonten['tugas'] ?> Tugas</div>
                            </div>
                        </div><?php endif; ?>
                        <?php if ($statsKonten['preExam']): ?><div class="col-6 col-md-4">
                                <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-clipboard-check text-info"></i>
                                    <div class="fw-bold">Pre Exam</div>
                                </div>
                            </div><?php endif; ?>
                        <?php if ($statsKonten['exam']): ?><div class="col-6 col-md-4">
                                <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-certificate text-danger"></i>
                                    <div class="fw-bold">Exam</div>
                                </div>
                            </div><?php endif; ?>
                        <?php if ($statsKonten['sertifikat']): ?><div class="col-6 col-md-4">
                                <div class="d-flex align-items-center gap-2 bg-white rounded-2 p-3"><i class="fas fa-award text-secondary"></i>
                                    <div class="fw-bold">Sertifikat</div>
                                </div>
                            </div><?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- ✅ Student Reviews Section -->
            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3 pb-2 border-bottom">Student Reviews</h2>
                <?php
                $reviewList = $reviews ?? [];
                $rAvg = number_format((float)($rating_stats['avg_rating'] ?? 0), 1);
                $rTotal = (int)($rating_stats['total_review'] ?? 0);
                ?>

                <?php if ($rTotal > 0): ?>
                    <!-- Average Rating Summary -->
                    <div class="card border-0 bg-light rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="display-3 fw-bold text-primary"><?= $rAvg ?></div>
                                    <div class="text-warning mb-1">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="<?= $i <= round($rAvg) ? 'fas' : 'far' ?> fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <small class="text-muted"><?= $rTotal ?> review<?= $rTotal > 1 ? 's' : '' ?></small>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <small class="text-muted" style="width: 50px;">Materi</small>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: <?= (($rating_stats['avg_materi'] ?? 0) / 5) * 100 ?>%"></div>
                                        </div>
                                        <small class="fw-bold" style="width: 25px;"><?= number_format((float)($rating_stats['avg_materi'] ?? 0), 1) ?></small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted" style="width: 50px;">Mentor</small>
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-info" style="width: <?= (($rating_stats['avg_mentor'] ?? 0) / 5) * 100 ?>%"></div>
                                        </div>
                                        <small class="fw-bold" style="width: 25px;"><?= number_format((float)($rating_stats['avg_mentor'] ?? 0), 1) ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Individual Reviews -->
                    <?php foreach ($reviewList as $rv): ?>
                        <div class="card border-0 shadow-sm rounded-3 mb-3">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <?php
                                    $reviewerName = $rv['nama_lengkap'] ?? 'Anonim';
                                    $reviewerFoto = $rv['foto_profil'] ?? '';
                                    $reviewerAvatar = !empty($reviewerFoto)
                                        ? base_url('fotosiswa/' . $reviewerFoto)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($reviewerName) . '&background=1976d2&color=fff&size=80';
                                    ?>
                                    <img src="<?= $reviewerAvatar ?>" alt="<?= esc($reviewerName) ?>"
                                        class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0"><?= esc($reviewerName) ?></h6>
                                        <small class="text-muted"><?= date('d M Y', strtotime($rv['created_at'])) ?></small>
                                    </div>
                                    <div class="text-warning">
                                        <?php for ($j = 1; $j <= 5; $j++): ?>
                                            <i class="<?= $j <= $rv['rating_overall'] ? 'fas' : 'far' ?> fa-star" style="font-size: 0.8rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-2"><?= esc($rv['review_title']) ?></h6>
                                <p class="text-secondary mb-2" style="font-size: 0.9rem;"><?= esc($rv['review_text']) ?></p>
                                <?php if (!empty($rv['pros'])): ?>
                                    <p class="mb-1 small text-success"><i class="fas fa-thumbs-up me-1"></i><?= esc($rv['pros']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($rv['cons'])): ?>
                                    <p class="mb-0 small text-danger"><i class="fas fa-thumbs-down me-1"></i><?= esc($rv['cons']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada review untuk kursus ini. Jadilah yang pertama!</p>
                    </div>
                <?php endif; ?>
            </section>

        </div>

        <div class="col-lg-4" style="padding-left: <?= $customGap ?>; padding-right: <?= $customGap ?>;">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Course Includes:</h5>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3"><i class="fas fa-infinity text-primary me-3"></i>Lifetime Access</li>
                        <li class="mb-3"><i class="fas fa-mobile-alt text-primary me-3"></i>Access on Mobile</li>
                        <li class="mb-3"><i class="fas fa-file-download text-primary me-3"></i>Downloadable Resources</li>
                        <li class="mb-3"><i class="fas fa-certificate text-primary me-3"></i>Certificate of Completion</li>
                    </ul>

                    <!-- Harga -->
                    <div class="text-center mb-3">
                        <?php if ($hargaReguler > 0): ?>
                            <div class="h4 fw-bold text-primary mb-0">Harga Rp <?= number_format($hargaReguler, 0, ',', '.') ?></div>
                        <?php else: ?>
                            <div class="h4 fw-bold text-success mb-0">Hubungi Admin untuk Harga</div>
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
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="cartToast" class="toast" role="alert">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i><strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body"><span id="toastMessage"></span></div>
    </div>
</div>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .pricing-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
    }

    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<script>
    // ✅ EXPAND/COLLAPSE ALL - FIXED (Single Click & Icon Correct)
    function toggleAllAccordion() {
        const accordionButtons = document.querySelectorAll('#courseAccordion .accordion-button');
        const btn = document.getElementById('toggleAllBtn');

        // Cek apakah SEMUA item sedang expanded (tidak ada yang collapsed)
        let allExpanded = true;
        accordionButtons.forEach(button => {
            if (button.classList.contains('collapsed')) {
                allExpanded = false;
            }
        });

        // Langsung manipulasi tanpa menunggu
        accordionButtons.forEach((button, index) => {
            const target = button.getAttribute('data-bs-target');
            const collapseElement = document.querySelector(target);

            if (allExpanded) {
                // COLLAPSE ALL - Tutup semua
                button.classList.add('collapsed');
                button.setAttribute('aria-expanded', 'false');
                collapseElement.classList.remove('show');
            } else {
                // EXPAND ALL - Buka semua
                button.classList.remove('collapsed');
                button.setAttribute('aria-expanded', 'true');
                collapseElement.classList.add('show');
            }
        });

        // Update button text dan icon
        if (allExpanded) {
            // Semua sudah di-collapse, tampilkan "Expand All" dengan panah DOWN ⬇️
            btn.innerHTML = '<i class="fas fa-chevron-down me-1"></i>Expand All';
        } else {
            // Semua sudah di-expand, tampilkan "Collapse All" dengan panah UP ⬆️
            btn.innerHTML = '<i class="fas fa-chevron-up me-1"></i>Collapse All';
        }
    }

    function playPreview() {
        alert('Video preview tidak tersedia');
    }

    // ✅ Add to Cart
    function addToCart(idPaket, namaKursus, harga) {
        let cart = JSON.parse(localStorage.getItem('keranjang') || '[]');
        if (cart.find(item => item.id_paket === idPaket)) {
            document.getElementById('toastMessage').textContent = `"${namaKursus}" sudah ada di keranjang`;
        } else {
            cart.push({
                id_paket: idPaket,
                nama: namaKursus,
                harga: harga,
                qty: 1
            });
            localStorage.setItem('keranjang', JSON.stringify(cart));
            document.getElementById('toastMessage').textContent = `"${namaKursus}" berhasil ditambahkan`;
        }
        new bootstrap.Toast(document.getElementById('cartToast')).show();
    }

    // ✅ Event listener untuk menutup modal dan stop video
    document.getElementById('materiVideoModal').addEventListener('hidden.bs.modal', function() {
        stopVideo();
    });
</script>

<?= $this->endSection() ?>