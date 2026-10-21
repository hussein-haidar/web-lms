<?php $this->extend('backend/template_user/main'); ?>
<?php $this->section('content'); ?>
<div class="container-fluid">
    <h1><?= esc($title2) ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active">Jalur Belajar</li>
        </ol>
    </nav>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>Progress Keseluruhan: <?= esc($progress_percentage ?? 0) ?>%</strong>
                </div>
                <div class="card-body">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar <?= ($progress_percentage >= 100) ? 'bg-success' : 'bg-primary' ?>" 
                             role="progressbar" style="width: <?= esc($progress_percentage) ?>%">
                            <?= esc($progress_percentage) ?>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="<?= base_url('home_siswa/learning-path/next') ?>" class="btn btn-success mb-3">
                <i class="fas fa-forward"></i> Lanjutkan ke Materi Selanjutnya
            </a>
        </div>
    </div>
    <?php if (!empty($pendaftaran)): ?>
        <?php foreach ($pendaftaran as $p): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <strong><?= esc($p['nama_kursus'] ?? 'Kursus') ?></strong>
                    <span class="badge badge-info float-right">Status: <?= esc($p['status']) ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($modul_data)): ?>
                        <?php foreach ($modul_data as $md): ?>
                            <div class="border rounded p-3 mb-3">
                                <h5><?= esc($md['nama_modul'] ?? $md['modul']['nama_modul'] ?? 'Modul') ?></h5>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar" style="width: <?= esc($md['percentage'] ?? 0) ?>%"></div>
                                </div>
                                <small><?= esc($md['completed_materi'] ?? 0) ?>/<?= esc($md['total_materi'] ?? 0) ?> materi selesai</small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Materi belum dimulai. <a href="<?= base_url('home_siswa/learning-path/next') ?>">Mulai Belajar</a></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center">
                <h4>Belum ada kursus yang terdaftar</h4>
                <a href="<?= base_url('home_website/kursus') ?>" class="btn btn-primary">Lihat Kursus Tersedia</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
