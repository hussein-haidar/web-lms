<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="container-fluid bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3">Hasil Pencarian: "<?= esc($keyword) ?>"</h1>
                <p class="lead opacity-75">Menemukan <?= count($postingan) ?> hasil untuk pencarian Anda</p>
            </div>
            <div class="col-lg-4">
                <div class="bg-white bg-opacity-10 rounded-3 p-4">
                    <h5 class="fw-bold mb-3">Cari Lagi</h5>
                    <form action="<?= base_url('postingan/search') ?>" method="GET">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Ketik kata kunci..." value="<?= esc($keyword) ?>">
                            <button class="btn btn-warning" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Results -->
<div class="container py-5">
    <div class="row">
        <!-- Results List -->
        <div class="col-lg-8">
            <?php if (!empty($postingan)): ?>
                <div class="row g-4">
                    <?php foreach ($postingan as $post): ?>
                        <div class="col-md-6">
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
                                        <span class="badge bg-success bg-opacity-10 text-success me-2">
                                            <i class="fas fa-eye me-1"></i><?= number_format($post['views']) ?>
                                        </span>
                                    </div>
                                    
                                    <h5 class="card-title fw-bold">
                                        <a href="<?= base_url('postingan/detail/' . $post['slug']) ?>" 
                                           class="text-decoration-none text-dark">
                                            <?= esc($post['judul_postingan']) ?>
                                        </a>
                                    </h5>
                                    
                                    <p class="card-text text-muted flex-grow-1">
                                        <?= esc($post['excerpt']) ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            <?= date('d M Y', strtotime($post['created_at'])) ?>
                                        </small>
                                        <a href="<?= base_url('postingan/detail/' . $post['slug']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="fw-bold text-muted">Tidak ada hasil untuk "<?= esc($keyword) ?>"</h4>
                    <p class="text-muted">Coba gunakan kata kunci lain atau lihat semua postingan.</p>
                    <a href="<?= base_url('postingan') ?>" class="btn btn-primary mt-3">
                        <i class="fas fa-list me-2"></i>Lihat Semua Postingan
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Search Tips -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-lightbulb me-2"></i>Tips Pencarian</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gunakan kata kunci spesifik</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Coba variasi kata kunci</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Gunakan istilah yang relevan</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Cari berdasarkan kategori</li>
                    </ul>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-clock me-2"></i>Postingan Terbaru</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentPosts)): ?>
                        <?php foreach ($recentPosts as $recent): ?>
                            <div class="d-flex mb-3">
                                <?php if (!empty($recent['gambar_postingan'])): ?>
                                    <img src="<?= base_url('uploads/postingan/' . $recent['gambar_postingan']) ?>" 
                                         class="rounded me-3" 
                                         alt="<?= esc($recent['judul_postingan']) ?>"
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?= base_url('postingan/detail/' . $recent['slug']) ?>" 
                                           class="text-decoration-none text-dark">
                                            <?= esc(substr($recent['judul_postingan'], 0, 40) . (strlen($recent['judul_postingan']) > 40 ? '...' : '')) ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="far fa-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($recent['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada postingan terbaru</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Categories -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-tags me-2"></i>Kategori Populer</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('postingan/search?keyword=Tips+Karir') ?>" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-angle-right me-2"></i>Tips Karir
                        </a>
                        <a href="<?= base_url('postingan/search?keyword=Teknologi') ?>" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-angle-right me-2"></i>Teknologi
                        </a>
                        <a href="<?= base_url('postingan/search?keyword=Pendidikan') ?>" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-angle-right me-2"></i>Pendidikan
                        </a>
                        <a href="<?= base_url('postingan/search?keyword=Alumni') ?>" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-angle-right me-2"></i>Alumni
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
