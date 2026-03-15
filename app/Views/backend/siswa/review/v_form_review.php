<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php
$pendaftaran = $pendaftaran ?? [];
$namaKursus = $pendaftaran['nama_kursus'] ?? 'Kursus';
$progress = $pendaftaran['progress'] ?? 0;
?>

<!-- Header -->
<div style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= base_url('home_siswa') ?>" class="text-white-50 text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Beri Review</li>
            </ol>
        </nav>
        <h3 class="text-white fw-bold mb-1"><i class="fas fa-star me-2"></i>Beri Review</h3>
        <p class="text-white-50 mb-0"><?= esc($namaKursus) ?></p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px;">
                        <i class="fas fa-book-open fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1"><?= esc($namaKursus) ?></h5>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-success rounded-pill"><?= $progress ?>% selesai</span>
                            <small class="text-muted"><?= esc($pendaftaran['tipe_paket'] ?? 'reguler') ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Review -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-primary"></i>Tulis Review Anda</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('home_siswa/review/simpan') ?>" method="post" id="reviewForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_pendaftaran" value="<?= $pendaftaran['id_pendaftaran'] ?? '' ?>">

                        <!-- Star Ratings -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Rating Keseluruhan <span class="text-danger">*</span></label>
                                <div class="star-rating" data-target="rating_overall">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="far fa-star star-icon" data-value="<?= $i ?>" style="font-size: 1.8rem; cursor: pointer; color: #ffc107; transition: all 0.2s;"></i>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="rating_overall" id="rating_overall" value="<?= old('rating_overall', '') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Rating Materi <span class="text-danger">*</span></label>
                                <div class="star-rating" data-target="rating_materi">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="far fa-star star-icon" data-value="<?= $i ?>" style="font-size: 1.8rem; cursor: pointer; color: #ffc107; transition: all 0.2s;"></i>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="rating_materi" id="rating_materi" value="<?= old('rating_materi', '') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Rating Mentor <span class="text-danger">*</span></label>
                                <div class="star-rating" data-target="rating_mentor">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="far fa-star star-icon" data-value="<?= $i ?>" style="font-size: 1.8rem; cursor: pointer; color: #ffc107; transition: all 0.2s;"></i>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="rating_mentor" id="rating_mentor" value="<?= old('rating_mentor', '') ?>" required>
                            </div>
                        </div>

                        <!-- Judul Review -->
                        <div class="mb-3">
                            <label for="review_title" class="form-label fw-semibold">Judul Review <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="review_title" name="review_title"
                                placeholder="Contoh: Kursus Sangat Membantu!" maxlength="200"
                                value="<?= old('review_title', '') ?>" required>
                        </div>

                        <!-- Teks Review -->
                        <div class="mb-3">
                            <label for="review_text" class="form-label fw-semibold">Review Anda <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="review_text" name="review_text" rows="4"
                                placeholder="Ceritakan pengalaman Anda mengikuti kursus ini..." maxlength="2000"
                                required><?= old('review_text', '') ?></textarea>
                            <div class="form-text"><span id="charCount">0</span>/2000 karakter</div>
                        </div>

                        <!-- Pros -->
                        <div class="mb-3">
                            <label for="pros" class="form-label fw-semibold"><i class="fas fa-thumbs-up text-success me-1"></i>Kelebihan (opsional)</label>
                            <textarea class="form-control" id="pros" name="pros" rows="2"
                                placeholder="Apa yang Anda suka dari kursus ini?"><?= old('pros', '') ?></textarea>
                        </div>

                        <!-- Cons -->
                        <div class="mb-3">
                            <label for="cons" class="form-label fw-semibold"><i class="fas fa-thumbs-down text-danger me-1"></i>Kekurangan (opsional)</label>
                            <textarea class="form-control" id="cons" name="cons" rows="2"
                                placeholder="Apa yang bisa diperbaiki?"><?= old('cons', '') ?></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" id="submitBtn">
                                <i class="fas fa-paper-plane me-1"></i>Kirim Review
                            </button>
                            <a href="<?= base_url('home_siswa') ?>" class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ✅ Star Rating - Interactive Click
    document.querySelectorAll('.star-rating').forEach(container => {
        const targetId = container.dataset.target;
        const stars = container.querySelectorAll('.star-icon');
        const hiddenInput = document.getElementById(targetId);

        // Set initial value from old input
        if (hiddenInput.value) {
            updateStars(stars, parseInt(hiddenInput.value));
        }

        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                updateStars(stars, parseInt(this.dataset.value));
            });

            star.addEventListener('click', function() {
                const val = parseInt(this.dataset.value);
                hiddenInput.value = val;
                updateStars(stars, val);
            });
        });

        container.addEventListener('mouseleave', function() {
            const val = parseInt(hiddenInput.value) || 0;
            updateStars(stars, val);
        });
    });

    function updateStars(stars, value) {
        stars.forEach(star => {
            const v = parseInt(star.dataset.value);
            if (v <= value) {
                star.classList.remove('far');
                star.classList.add('fas');
                star.style.transform = 'scale(1.1)';
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
                star.style.transform = 'scale(1)';
            }
        });
    }

    // ✅ Character counter
    const reviewText = document.getElementById('review_text');
    const charCount = document.getElementById('charCount');
    reviewText.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
    charCount.textContent = reviewText.value.length;

    // ✅ Form validation before submit
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        const ratings = ['rating_overall', 'rating_materi', 'rating_mentor'];
        for (const r of ratings) {
            if (!document.getElementById(r).value) {
                e.preventDefault();
                alert('Silakan berikan rating untuk semua kategori!');
                return;
            }
        }
    });
</script>

<?= $this->endSection() ?>