<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<section class="py-5 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-primary mb-3">
                <i class="fas fa-graduation-cap me-3"></i>Kursus yang Diikuti
            </h1>
            <p class="lead text-muted">Jelajahi kursus-kursus yang sedang Anda ikuti dan lanjutkan pembelajaran</p>
        </div>

        <!-- Alert Message -->
        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Course Cards -->
        <?php if (!empty($kursus) && is_array($kursus)): ?>
            <div class="row g-4">
                <?php foreach ($kursus as $item): ?>
                    <?php if (!is_array($item)) continue; ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden hover-lift">
                            <!-- Course Image -->
                            <div class="position-relative">
                                <?php if (!empty($item['gambar_detail_a'])): ?>
                                    <img src="<?= base_url('kursus/materi/' . ($item['gambar_detail_a'] ?? 'as.png')) ?>"
                                        class="img-fluid rounded"
                                        alt="<?= $item['nama_kursus'] ?>"
                                        onerror="this.src='<?= base_url('kursus/materi/as.png') ?>'">
                                <?php elseif (!empty($item['gambar_utama'])): ?>
                                    <img src="<?= base_url('kursus/materi/' . ($item['gambar_utama'] ?? 'as.png')) ?>"
                                        class="card-img-top" alt="Gambar Kursus"
                                        style="height: 200px; object-fit: cover; width: 100%;">
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                        style="height: 200px;">
                                        <i class="fas fa-book fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Status Badge -->
                                <div class="position-absolute top-0 end-0 p-3">
                                    <span class="badge <?= $item['status'] == 'aktif' ? 'bg-success' : 'bg-danger' ?> rounded-pill">
                                        <i class="fas fa-circle me-1" style="font-size: 6px;"></i>
                                        <?= $item['status'] == 'aktif' ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2">
                                    <?= esc($item['nama_kursus'] ?? 'Tidak ada judul') ?>
                                </h5>

                                <div class="mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1">
                                        <i class="fas fa-tag me-1"></i>
                                        <?= esc($item['nama_program'] ?? 'Program') ?>
                                    </span>
                                </div>

                                <!-- Course Details -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-list me-1"></i> <?= esc($item['nama_program'] ?? '–') ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i> <?= esc($item['nama_instruktur'] ?? '–') ?>
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-box me-1"></i> <?= esc($item['nama_paket'] ?? '–') ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i> <?= esc(ucfirst($item['jenis_kursus'] ?? '')) ?>
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i> <?= esc($item['total_pertemuan'] ?? '') ?> x
                                        </small>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-auto">
                                    <div class="d-grid gap-2">
                                        <a href="<?= base_url('home_siswa/detail_kursus/' . $item['id_kursus']) ?>"
                                            class="btn btn-outline-primary btn-sm rounded-pill">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>
                                        <a href="<?= base_url('home_siswa/belajar/' . ($item['id_pendaftaran'] ?? $item['id_kursus'])) ?>"
                                            class="btn btn-success btn-sm rounded-pill">
                                            <i class="fas fa-play me-1"></i> Mulai Belajar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-inbox fa-5x text-muted"></i>
                </div>
                <h3 class="text-muted mb-3">Belum ada kursus yang diikuti</h3>
                <p class="text-muted mb-4">Anda belum terdaftar dalam kursus apapun. Silahkan daftar kursus terlebih dahulu.</p>
                <a href="<?= base_url('home_website/kls_online') ?>"
                    class="btn btn-primary btn-lg rounded-pill px-4">
                    <i class="fas fa-search me-2"></i> Jelajahi Kursus
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>

<?= $this->endSection() ?>