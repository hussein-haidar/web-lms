<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Course Image & Info -->
            <div class="col-lg-4 col-md-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                            <?php if (!empty($kursus['gambar_detail_a'])): ?>
                    <img src="<?= base_url('kursus/materi/' . ($kursus['gambar_detail_a'] ?? 'as.png')) ?>"
                        class="img-fluid rounded"
                        alt="<?= $kursus['nama_kursus'] ?>"
                        onerror="this.src='<?= base_url('kursus/materi/as.png') ?>'">
                <?php else: ?>
                                                 <div class="bg-light rounded p-4 mb-3">
                                <i class="fas fa-book fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>

                        <h4 class="fw-bold mb-2"><?= esc($kursus['nama_kursus'] ?? 'Unknown Course') ?></h4>
                        <p class="text-muted mb-3"><?= esc($kursus['nama_program'] ?? '-') ?></p>

                        <div class="list-group list-group-flush text-start">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-user-tie me-2"></i>Instruktur</span>
                                <span class="badge bg-primary rounded-pill"><?= esc($kursus['nama_pengajar'] ?? '–') ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-info-circle me-2"></i>Status</span>
                                <span class="badge bg-success rounded-pill">Enrolled</span>
                            </div>
                        </div>

                        <?php if (!empty($pendaftaran)): ?>
                            <a href="<?= base_url('home_siswa/belajar/' . $pendaftaran['id_pendaftaran']) ?>" 
                               class="btn btn-success btn-lg w-100 rounded-pill">
                                <i class="fas fa-play-circle me-2"></i> MULAI BELAJAR
                            </a>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Anda belum terdaftar di kursus ini.
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($materials)): ?>
                            <div class="mt-4">
                                <h5 class="mb-3"><i class="fas fa-book me-2"></i>Materi Pembelajaran</h5>
                                <div class="list-group">
                                    <?php foreach ($materials as $material): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge badge-<?= $material['tipe_materi'] == 'youtube' ? 'danger' : ($material['tipe_materi'] == 'zoom' ? 'info' : 'secondary') ?>">
                                                    <?= ucfirst($material['tipe_materi']) ?>
                                                </span>
                                                <strong><?= esc($material['judul_materi']) ?></strong>
                                                <?php if ($material['durasi']): ?>
                                                    <small class="text-muted"> (<?= $material['durasi'] ?> menit)</small>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <?php if ($material['is_completed']): ?>
                                                    <span class="badge bg-success">Selesai</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Belum</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Course Content Tabs -->
            <div class="col-lg-8 col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                    <i class="fas fa-info-circle me-2"></i>Deskripsi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#syllabus" type="button" role="tab">
                                    <i class="fas fa-book-open me-2"></i>Materi
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <h4 class="fw-bold mb-3"><i class="fas fa-graduation-cap me-2"></i>Tentang Kursus</h4>
                                <div class="prose">
                                    <?= (!empty($kursus['deskripsi_singkat']) && is_string($kursus['deskripsi_singkat'])) ? nl2br(esc($kursus['deskripsi_singkat'])) : 'Tidak ada deskripsi tersedia.' ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="syllabus" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                                <i class="fas fa-book-open fa-lg"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1">Materi Yang Dipelajari</h5>
                                                <p class="text-muted mb-0">Konten pembelajaran utama</p>
                                            </div>
                                        </div>
                                        <p class="mb-0">
                                            <?= (!empty($kursus['materi_yang_dipelajari']) && is_string($kursus['materi_yang_dipelajari'])) ? nl2br(esc($kursus['materi_yang_dipelajari'])) : '<span class="text-muted">Belum ada informasi materi</span>' ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3">
                                                <i class="fas fa-clipboard-list fa-lg"></i>
                                            </div>
                                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="text-center mt-4">
            <a href="<?= base_url('home_siswa/index') ?>" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>