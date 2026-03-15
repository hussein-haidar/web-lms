<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>

<div class="container py-5 mt-4">
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark">Hasil Pencarian: <span class="text-primary">"<?= esc($keyword) ?>"</span></h2>
            <p class="text-muted fs-5">Menemukan <?= count($paket) ?> hasil untuk pencarian Anda.</p>
        </div>
    </div>

    <!-- Kelas / Paket -->
    <div class="row g-4">
        <?php if (!empty($paket)): ?>
            <?php foreach ($paket as $p): ?>
                <?php
                // Automatic URL generation based on program name
                $programName = $p['nama_program'];
                
                // Generate URL slug from program name
                $urlSlug = strtolower(str_replace([' ', '-'], '_', $programName));
                
                // Determine button styling based on program type
                if (strpos(strtolower($programName), 'online') !== false) {
                    $btnClass = 'btn-success';
                    $btnText = 'Kelas Online';
                } elseif (strpos(strtolower($programName), 'offline') !== false) {
                    $btnClass = 'btn-primary';
                    $btnText = 'Kelas Offline';
                } else {
                    $btnClass = 'btn-info';
                    $btnText = 'Program Khusus';
                }
                
                $urlDetail = base_url("home_website/detail_{$urlSlug}/{$p['id_paket']}");
                ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm course-card rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="<?= base_url('kursus/materi/' . ($p['gambar_detail_a'] ?? $p['gambar_utama'] ?? 'as.png')) ?>"
                                class="card-img-top object-fit-cover"
                                alt="<?= esc($p['nama_kursus']) ?>"
                                style="height: 220px;"
                                onerror="this.src='<?= base_url('gambar_kursus/as.png') ?>'">

                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark py-2 px-3 rounded-pill shadow-sm fw-bold">
                                    <i class="fas fa-star text-danger me-1"></i> <?= esc($p['nama_program']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <h4 class="card-title fw-bold text-dark mb-3" style="font-size: 1.25rem;">
                                <?= esc($p['nama_paket'] ?? $p['nama_kursus']) ?>
                            </h4>

                            <p class="card-text text-muted small mb-4 flex-grow-1">
                                <?= esc(substr($p['deskripsi_singkat'] ?? '', 0, 100)) ?>...
                            </p>

                            <a href="<?= $urlDetail ?>" class="btn <?= $btnClass ?> w-100 py-2 rounded-3 fw-bold shadow-sm">
                                <?= $btnText ?> <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h4 class="fw-bold text-muted">Aduh, kelas tidak ditemukan.</h4>
                <p class="text-muted">Coba gunakan kata kunci lain (misalnya: "Word", "Excel", "Marketing", atau nama program).</p>
                <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-warning mt-3 rounded-pill px-4">Lihat Semua Kursus</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .course-card {
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<?= $this->endSection() ?>