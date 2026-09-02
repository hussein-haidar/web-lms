<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Program Banner -->
<div style="background: linear-gradient(135deg, #0056b3, #00b4d8); padding: 60px 0;">
    <div class="container text-center text-white">
        <h1 class="fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Sertifikat Uji Kompetensi</h1>
        <p class="fs-5" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Tingkatkan kemampuan dan dapatkan sertifikat profesional</p>
    </div>
</div>

<!-- Programs Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Program Tersedia</h2>
        
        <?php if (!empty($uji_kompetensi) && is_array($uji_kompetensi)): ?>
            <div class="row g-4">
                <?php foreach ($uji_kompetensi as $item): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <?php if (!empty($item['gambar']) && file_exists(FCPATH . 'public/gambar_kursus/' . $item['gambar'])): ?>
                                <img src="<?= base_url('gambar_kursus/' . $item['gambar']) ?>" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover;"
                                     alt="<?= esc($item['nama_uji_kompetensi']) ?>"
                                     onerror="this.src='https://via.placeholder.com/400x200/0056b3/ffffff?text=<?= urlencode($item['nama_uji_kompetensi']) ?>'">
                            <?php else: ?>
                                <div class="bg-primary text-white d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <div class="text-center p-3">
                                        <i class="fas fa-certificate fa-3x mb-2"></i>
                                        <h5><?= esc($item['nama_uji_kompetensi']) ?></h5>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary"><?= esc($item['nama_uji_kompetensi']) ?></h5>
                                <p class="card-text text-muted"><?= esc(substr($item['deskripsi'], 0, 120)) ?>...</p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary fs-6">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i><?= esc($item['durasi'] ?? '3 bulan') ?>
                                    </small>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-info-circle me-1"></i> Detail Program
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Belum ada program uji kompetensi yang tersedia saat ini.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
