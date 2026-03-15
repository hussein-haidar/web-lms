<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('postingan') ?>" class="text-decoration-none">Postingan</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($post['judul_postingan']) ?></li>
        </ol>
    </div>
</nav>

<!-- Article Header -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article>
                <!-- Article Image -->
                <?php if (!empty($post['gambar_postingan'])): ?>
                    <div class="mb-4">
                        <img src="<?= base_url('uploads/postingan/' . $post['gambar_postingan']) ?>" 
                             class="img-fluid rounded-3 shadow" 
                             alt="<?= esc($post['judul_postingan']) ?>">
                    </div>
                <?php endif; ?>

                <!-- Article Meta -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary bg-opacity-10 text-primary me-2">
                            <i class="fas fa-tag me-1"></i><?= esc($post['kategori']) ?>
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success me-2">
                            <i class="fas fa-eye me-1"></i><?= number_format($post['views']) ?> views
                        </span>
                        <span class="badge bg-warning bg-opacity-10 text-dark">
                            <i class="fas fa-user me-1"></i><?= esc($post['penulis']) ?>
                        </span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-share-alt"></i> Bagikan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="shareToFacebook()"><i class="fab fa-facebook text-primary me-2"></i>Facebook</a></li>
                            <li><a class="dropdown-item" href="#" onclick="shareToTwitter()"><i class="fab fa-twitter text-info me-2"></i>Twitter</a></li>
                            <li><a class="dropdown-item" href="#" onclick="shareToWhatsApp()"><i class="fab fa-whatsapp text-success me-2"></i>WhatsApp</a></li>
                            <li><a class="dropdown-item" href="#" onclick="copyLink()"><i class="fas fa-link me-2"></i>Salin Link</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Article Title -->
                <h1 class="fw-bold mb-4"><?= esc($post['judul_postingan']) ?></h1>

                <!-- Article Date -->
                <div class="text-muted mb-4">
                    <i class="far fa-calendar me-2"></i>
                    <?= date('d F Y', strtotime($post['created_at'])) ?>
                    <?php if ($post['updated_at'] != $post['created_at']): ?>
                        <span class="ms-3"><i class="fas fa-edit me-2"></i>Diperbarui: <?= date('d F Y', strtotime($post['updated_at'])) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Article Content -->
                <div class="article-content mb-5">
                    <?= $post['konten'] ?>
                </div>

                <!-- Article Tags -->
                <?php if (!empty($post['meta_keywords'])): ?>
                    <div class="mb-5">
                        <h6 class="fw-bold mb-3">Tags:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php 
                            $tags = explode(',', $post['meta_keywords']);
                            foreach ($tags as $tag): ?>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-hashtag me-1"></i><?= trim(esc($tag)) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Share Section -->
                <div class="border-top pt-4 mb-5">
                    <h6 class="fw-bold mb-3">Bagikan artikel ini:</h6>
                    <div class="d-flex gap-2">
                        <button onclick="shareToFacebook()" class="btn btn-primary btn-sm">
                            <i class="fab fa-facebook"></i>
                        </button>
                        <button onclick="shareToTwitter()" class="btn btn-info btn-sm">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button onclick="shareToWhatsApp()" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                        <button onclick="shareToLinkedIn()" class="btn btn-primary btn-sm">
                            <i class="fab fa-linkedin"></i>
                        </button>
                        <button onclick="copyLink()" class="btn btn-secondary btn-sm">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>

                <!-- Related Posts -->
                <?php if (!empty($relatedPosts)): ?>
                    <div class="border-top pt-4">
                        <h6 class="fw-bold mb-4">Postingan Terkait:</h6>
                        <div class="row g-3">
                            <?php foreach ($relatedPosts as $related): ?>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm">
                                        <?php if (!empty($related['gambar_postingan'])): ?>
                                            <img src="<?= base_url('uploads/postingan/' . $related['gambar_postingan']) ?>" 
                                                 class="card-img-top" 
                                                 alt="<?= esc($related['judul_postingan']) ?>"
                                                 style="height: 120px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="<?= base_url('postingan/detail/' . $related['slug']) ?>" 
                                                   class="text-decoration-none text-dark">
                                                    <?= esc(substr($related['judul_postingan'], 0, 50) . (strlen($related['judul_postingan']) > 50 ? '...' : '')) ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="far fa-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($related['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Author Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-user-circle me-2"></i>Tentang Penulis</h6>
                </div>
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                    <h6 class="fw-bold"><?= esc($post['penulis']) ?></h6>
                    <p class="text-muted small">Penulis artikel di LPK INASABA</p>
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
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-tags me-2"></i>Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('postingan') ?>" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-angle-right me-2"></i>Semua Kategori
                        </a>
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

<!-- Back to Top Button -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
        class="btn btn-primary position-fixed bottom-0 end-0 m-3 rounded-circle" 
        style="width: 50px; height: 50px; z-index: 1000;">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- JavaScript untuk Share Function -->
<script>
function shareToFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('<?= esc($post['judul_postingan']) ?>');
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank');
}

function shareToTwitter() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('<?= esc($post['judul_postingan']) ?>');
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank');
}

function shareToWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('<?= esc($post['judul_postingan']) ?>');
    window.open(`https://wa.me/?text=${title}%20${url}`, '_blank');
}

function shareToLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent('<?= esc($post['judul_postingan']) ?>');
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}&title=${title}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>

<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.article-content h1, .article-content h2, .article-content h3, 
.article-content h4, .article-content h5, .article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.article-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
}

.article-content ul, .article-content ol {
    padding-left: 2rem;
    margin: 1rem 0;
}

.article-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-size: 0.9rem;
}

.article-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1rem 0;
}
</style>

<?= $this->endSection() ?>
