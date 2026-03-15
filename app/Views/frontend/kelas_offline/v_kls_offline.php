<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php $paketList = $paket ?? []; ?>

<!-- Program Banner -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <?php
            $bannerImg = (!empty($paketList) && !empty($paketList[0]['gambar_utama']))
                ? base_url('kursus/materi/' . $paketList[0]['gambar_utama'])
                : base_url('gambar_paket/as.png');
            ?>
            <img src="<?= $bannerImg ?>"
                class="d-block w-100"
                alt="Program Kelas Offline"
                style="height: 450px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x450/0056b3/ffffff?text=LPK+INASABA'">
        </div>
    </div>
</div>

<!-- ✅ WAVE DIVIDER - Tetap Ditampilkan -->
<div class="position-relative" style="height: 80px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; transform: scaleY(-1);">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Content -->
<div class="container mb-5" id="allpaket">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Kelas Offline</h4>
            </div>

            <?php
            $totalPaket = count($paketList);
            $visibleCount = min(4, $totalPaket);

            if ($visibleCount == 1) {
                $colClass = 'col-12 col-sm-8 col-md-6 col-lg-4';
            } elseif ($visibleCount == 2) {
                $colClass = 'col-12 col-sm-6 col-md-6 col-lg-4';
            } elseif ($visibleCount == 3) {
                $colClass = 'col-12 col-sm-6 col-md-4 col-lg-4';
            } else {
                $colClass = 'col-12 col-sm-6 col-md-4 col-lg-3';
            }
            ?>

            <div class="row g-4 justify-content-center">
                <?php if (!empty($paketList) && is_array($paketList)): ?>
                    <?php foreach ($paketList as $index => $p):
                        $gambar = !empty($p['gambar_detail_a']) ? $p['gambar_detail_a'] : 
                                 (!empty($p['gambar_detail_b']) ? $p['gambar_detail_b'] : 
                                 (!empty($p['gambar_detail_c']) ? $p['gambar_detail_c'] : 
                                 (!empty($p['gambar_utama']) ? $p['gambar_utama'] : 'default.jpg')));

                        $title = (string) ($p['nama_paket'] ?? $p['nama_kursus'] ?? 'Tanpa Judul');
                        $duration = ((int) ($p['total_pertemuan'] ?? 0)) . 'x @' . ((int) ($p['durasi_per_pertemuan_jam'] ?? 1)) . ' jam';
                        $price_reguler = $p['harga_reguler'] ?? null;
                        $price_intensive = $p['harga_intensive'] ?? null;
                        $price_private = $p['harga_private'] ?? null;
                        $rating = (float) ($p['rating'] ?? 4.5);
                    ?>
                        <div class="<?= $colClass ?> paket-item <?= ($index >= 4) ? 'extra-paket' : '' ?>"
                            style="<?= ($index >= 4) ? 'display: none;' : '' ?>">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="position-relative overflow-hidden" style="height: 250px;">
                                    <a href="<?= base_url('home_website/detail_offline/' . ($p['id_paket'] ?? '')) ?>" class="d-block h-100">
                                        <img src="<?= base_url('kursus/materi/' . $gambar) ?>"
                                            alt="<?= esc($title) ?>"
                                            class="w-100 h-100"
                                            style="object-fit: contain; background-color: #f8f9fa;"
                                            onerror="this.src='https://via.placeholder.com/400x300/6c757d/ffffff?text=<?= urlencode($title) ?>'">
                                    </a>
                                </div>

                                <div class="card-body p-3 d-flex flex-column">
                                    <div class="d-flex gap-2 mb-2">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-clock me-1"></i><?= esc($duration) ?>
                                        </span>
                                        <span class="badge bg-success">
                                            <i class="fas fa-building me-1"></i>Offline
                                        </span>
                                    </div>

                                    <h6 class="card-title fw-bold mb-2">
                                        <a href="<?= base_url('home_website/detail_offline/' . ($p['id_paket'] ?? '')) ?>"
                                            class="text-decoration-none text-dark">
                                            <?= esc($title) ?>
                                        </a>
                                    </h6>

                                    <div class="mb-3">
                                        <?php if ($price_reguler): ?>
                                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded bg-primary bg-opacity-10">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">
                                                    <i class="fas fa-check-circle me-1"></i>Reguler
                                                </span>
                                                <div class="text-end">
                                                    <div class="fw-bold text-dark">Rp<?= number_format((float)$price_reguler, 0, ',', '.') ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($price_intensive): ?>
                                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded" style="background-color: rgba(111, 66, 193, 0.05);">
                                                <span class="badge" style="background-color: rgba(111, 66, 193, 0.1); color: #6f42c1; border: 1px solid #6f42c1; font-size: 0.75rem;">
                                                    <i class="fas fa-clock me-1"></i>Intensive
                                                </span>
                                                <div class="text-end">
                                                    <div class="fw-bold text-dark">Rp<?= number_format((float)$price_intensive, 0, ',', '.') ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($price_private): ?>
                                            <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: rgba(255, 193, 7, 0.05);">
                                                <span class="badge" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid #ffc107; font-size: 0.75rem;">
                                                    <i class="fas fa-user-friends me-1"></i>Private
                                                </span>
                                                <div class="text-end">
                                                    <div class="fw-bold text-dark">Rp<?= number_format((float)$price_private, 0, ',', '.') ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex align-items-center mb-2">
                                        <div class="text-warning">
                                            <?php
                                            $full_stars = floor($rating);
                                            $half_star = ($rating - $full_stars) >= 0.5;
                                            $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                                            for ($i = 0; $i < $full_stars; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                                            <?php if ($half_star): ?><i class="fas fa-star-half-alt"></i><?php endif; ?>
                                            <?php for ($i = 0; $i < $empty_stars; $i++): ?><i class="far fa-star"></i><?php endfor; ?>
                                        </div>
                                        <small class="text-muted ms-2">(<?= number_format($rating, 1) ?>)</small>
                                    </div>

                                    <a href="<?= base_url('auth_login/register_paket?id_paket=' . ($p['id_paket'] ?? '')) ?>"
                                        class="btn btn-sm btn-primary w-100 mt-auto"
                                        style="position: relative; z-index: 2;"
                                        onclick="event.stopPropagation();">
                                        <i class="fas fa-info-circle me-1"></i>Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>Belum ada paket offline yang tersedia.
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Toggle Buttons -->
            <?php if (!empty($paket) && is_array($paket) && count($paket) > 4): ?>
                <div class="text-center mt-4">
                    <button id="btnShowAll" class="btn btn-outline-primary btn-lg" onclick="togglepaket();">
                        <i class="fas fa-plus me-2"></i>Lihat Semua
                    </button>
                    <button id="btnHide" class="btn btn-outline-secondary btn-lg" onclick="togglepaket();" style="display: none;">
                        <i class="fas fa-minus me-2"></i>Sembunyikan
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function togglepaket() {
        var extrapaket = document.querySelectorAll('.extra-paket');
        var btnShow = document.getElementById('btnShowAll');
        var btnHide = document.getElementById('btnHide');

        extrapaket.forEach(function(paket) {
            if (paket.style.display === 'none') {
                paket.style.display = 'block';
            } else {
                paket.style.display = 'none';
            }
        });

        if (extrapaket[0] && extrapaket[0].style.display === 'none') {
            btnShow.style.display = 'inline-block';
            btnHide.style.display = 'none';
        } else {
            btnShow.style.display = 'none';
            btnHide.style.display = 'inline-block';
        }
    }
</script>

<?= $this->endSection() ?>