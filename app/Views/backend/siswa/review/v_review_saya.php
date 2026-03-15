<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php $reviews = $reviews ?? []; ?>

<!-- Header -->
<div style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url('home_siswa') ?>" class="text-white-50 text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Review Saya</li>
            </ol>
        </nav>
        <h3 class="text-white fw-bold mb-1"><i class="fas fa-star me-2"></i>Review Saya</h3>
        <p class="text-white-50 mb-0">Daftar review yang pernah Anda berikan</p>
    </div>
</div>

<div class="container py-5">

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($reviews)): ?>
        <div class="row g-4">
            <?php foreach ($reviews as $r): ?>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body p-4">
                            <!-- Course Info -->
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="<?= base_url('kursus/materi/' . ($r['gambar_utama'] ?: 'as.png')) ?>"
                                    alt="<?= esc($r['nama_kursus'] ?? '') ?>"
                                    class="rounded-2" style="width: 50px; height: 50px; object-fit: cover;"
                                    onerror="this.src='<?= base_url('gambar_kursus/as.png') ?>'">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-0"><?= esc($r['nama_kursus'] ?? 'Kursus') ?></h6>
                                    <small class="text-muted"><?= date('d M Y', strtotime($r['created_at'])) ?></small>
                                </div>
                            </div>

                            <!-- Ratings -->
                            <div class="d-flex gap-3 mb-3 flex-wrap">
                                <div>
                                    <small class="text-muted d-block">Overall</small>
                                    <div class="text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="<?= $i <= $r['rating_overall'] ? 'fas' : 'far' ?> fa-star" style="font-size: 0.85rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Materi</small>
                                    <div class="text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="<?= $i <= $r['rating_materi'] ? 'fas' : 'far' ?> fa-star" style="font-size: 0.85rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Mentor</small>
                                    <div class="text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="<?= $i <= $r['rating_mentor'] ? 'fas' : 'far' ?> fa-star" style="font-size: 0.85rem;"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <h6 class="fw-bold"><?= esc($r['review_title']) ?></h6>
                            <p class="text-secondary mb-2" style="font-size: 0.9rem;"><?= esc($r['review_text']) ?></p>

                            <?php if (!empty($r['pros'])): ?>
                                <p class="mb-1 small"><i class="fas fa-thumbs-up text-success me-1"></i><strong>Kelebihan:</strong> <?= esc($r['pros']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($r['cons'])): ?>
                                <p class="mb-0 small"><i class="fas fa-thumbs-down text-danger me-1"></i><strong>Kekurangan:</strong> <?= esc($r['cons']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-white border-top py-2 px-4">
                            <span class="badge <?= $r['is_visible'] ? 'bg-success' : 'bg-secondary' ?> rounded-pill">
                                <?= $r['is_visible'] ? 'Ditampilkan' : 'Disembunyikan' ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada review</h5>
            <p class="text-muted">Anda belum memberikan review untuk kursus manapun.</p>
            <a href="<?= base_url('home_siswa') ?>" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>