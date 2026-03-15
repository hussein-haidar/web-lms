<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Program Banner - Carousel dengan Gambar -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('/public/gambar_kursus/ab.png') ?>"
                class="d-block w-100"
                alt="Program Profesi 1 Tahun"
                style="height: 450px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
        </div>
    </div>
    <div class="carousel-indicators">
</div>

<!-- Pilihan Program Sertifikasi -->
<section class="py-4" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
    <div class="container">
        <!-- Heading -->
        <h3 class="text-center fw-bold text-white mb-4">Sertifikat Uji Kompetensi</h3>
        
        <!-- Gallery Grid -->
        <div class="row g-4">
            <?php if (!empty($uji_kompetensi) && is_array($uji_kompetensi)): ?>
                <?php foreach ($uji_kompetensi as $index => $item): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="position-relative overflow-hidden" style="height: 250px; cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#imageModal<?= $index + 1 ?>">
                                <?php if (!empty($item['gambar'])): ?>
                                    <img src="<?= base_url('/public/gambar_kursus/' . $item['gambar']) ?>"
                                        onerror="this.src='https://via.placeholder.com/400x300/0056b3/ffffff?text=<?= urlencode($item['nama_uji_kompetensi']) ?>'"
                                        alt="<?= esc($item['nama_uji_kompetensi']) ?>"
                                        class="w-100 h-100"
                                        style="object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/400x300/0056b3/ffffff?text=<?= urlencode($item['nama_uji_kompetensi']) ?>"
                                        alt="<?= esc($item['nama_uji_kompetensi']) ?>"
                                        class="w-100 h-100"
                                        style="object-fit: cover;">
                                <?php endif; ?>
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                    style="background: rgba(0,86,179,0.7); opacity: 0; transition: opacity 0.3s;"
                                    onmouseover="this.style.opacity='1'"
                                    onmouseout="this.style.opacity='0'">
                                    <div class="d-flex align-items-center justify-content-center h-100 text-white">
                                        <div class="text-center">
                                            <h6 class="mb-2"><?= esc($item['nama_uji_kompetensi']) ?></h6>
                                            <p class="mb-2 small"><?= esc(substr($item['deskripsi'], 0, 100)) ?>...</p>
                                            <span class="badge bg-primary">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Belum ada program uji kompetensi yang tersedia saat ini.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
