<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title) ?>
        <small><?= esc($title2) ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('home_siswa') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sertifikat</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <?php if (!empty($certificates)): ?>
            <?php foreach ($certificates as $c): ?>
                <div class="col-md-4 mb-4">
                    <div class="cert-card">
                        <div class="cert-header <?= $c['is_active'] ? 'bg-achievement' : '' ?>">
                            <i class="fas fa-award cert-icon"></i>
                        </div>
                        <div class="cert-body">
                            <h5 class="cert-title text-truncate"><?= esc($c['nama_kursus']) ?></h5>
                            <div class="cert-meta">
                                <p class="mb-1"><i class="far fa-id-badge me-2"></i> ID: <?= esc($c['nomor_sertifikat']) ?></p>
                                <p class="mb-0"><i class="far fa-calendar-alt me-2"></i> <?= date('d M Y', strtotime($c['tanggal_terbit'])) ?></p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="status-badge <?= $c['is_active'] ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                                    <?= $c['is_active'] ? 'VALID' : 'INVALID' ?>
                                </span>
                                <div class="text-warning fw-bold">
                                    Skor: <?= round($c['nilai_akhir']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="cert-footer">
                            <button class="btn btn-default btn-sm" onclick="alert('Fitur cetak akan segera hadir!')">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                            <a href="<?= base_url('sertifikat/view/' . $c['id_sertifikat']) ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-info border-0 shadow-sm rounded-4 py-5">
                    <i class="fas fa-graduation-cap fa-4x mb-3 opacity-50"></i>
                    <h4>Belum ada sertifikat yang terbit.</h4>
                    <p class="mb-0">Selesaikan kursus Anda dengan progress 100% untuk mendapatkan sertifikat otomatis.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>