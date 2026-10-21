<?php $this->extend('backend/template_user/main'); ?>
<?php $this->section('content'); ?>
<div class="container-fluid">
    <h1><?= esc($title2) ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active">Analytics</li>
        </ol>
    </nav>
    <?php if (!empty($analytics)): ?>
        <div class="row">
            <?php foreach ($analytics as $a): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <strong><?= esc($a['judul_quiz']) ?></strong>
                            <br><small><?= esc($a['nama_kursus']) ?></small>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <h3><?= esc($a['total_attempts'] ?? 0) ?></h3>
                                    <small>Attempts</small>
                                </div>
                                <div class="col-4">
                                    <h3 class="text-primary"><?= esc($a['avg_score'] ?? 0) ?>%</h3>
                                    <small>Avg Score</small>
                                </div>
                                <div class="col-4">
                                    <h3 class="text-success"><?= esc($a['passed_count'] ?? 0) ?></h3>
                                    <small>Passed</small>
                                </div>
                            </div>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-success" style="width: <?= esc($a['passed_count'] ?? 0) ?>%"></div>
                                <div class="progress-bar bg-danger" style="width: <?= esc($a['failed_count'] ?? 0) ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center">
                <h4>Belum ada data analytics</h4>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
