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
                alt="Program Kelas Online"
                style="height: 450px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x450/0056b3/ffffff?text=LPK+INASABA'">
        </div>
    </div>
</div>

<!-- Wave Divider -->
<div class="position-relative" style="height: 80px; background: #0056b3;">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; transform: scaleY(-1);">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Main Content -->
<div class="container my-5">
    <!-- Section Header -->
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold mb-3">Pilih Kelas Anda</h2>
        <p class="lead text-muted">Temukan kelas yang sesuai dengan kebutuhan dan minat Anda</p>
    </div>
    <div class="container py-5 border-top">
        <div class="row">
            <?php if (!empty($paketList)): ?>
                <?php foreach ($paketList as $r): ?>
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

    <?= $this->endSection() ?>