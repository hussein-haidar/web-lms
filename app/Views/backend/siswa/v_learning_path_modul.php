<?php $this->extend('backend/template_user/main'); ?>
<?php $this->section('content'); ?>
<div class="container-fluid">
    <h1><?= esc($title2) ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('home_siswa/learning-path') ?>">Learning Path</a></li>
            <li class="breadcrumb-item active">Modul</li>
        </ol>
    </nav>
    <div class="card mb-4">
        <div class="card-header">
            <strong>Progress: <?= esc($progress_percentage ?? 0) ?>%</strong> | 
            <a href="<?= base_url('home_siswa/learning-path/next') ?>" class="btn btn-sm btn-success">Lanjutkan</a>
        </div>
    </div>
    <?php if (!empty($modul_data)): ?>
        <?php foreach ($modul_data as $md): ?>
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong><?= esc($md['modul']['nama_modul']) ?></strong>
                    <span class="badge badge-<?= ($md['percentage'] >= 100) ? 'success' : 'primary' ?>">
                        <?= esc($md['percentage']) ?>%
                    </span>
                </div>
                <div class="card-body">
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar" style="width: <?= esc($md['percentage']) ?>%"></div>
                    </div>
                    <div class="row">
                        <?php foreach ($md['materi'] as $m): 
                            $completed = false;
                            foreach ($progres ?? [] as $pg) {
                                if ($pg['id_materi'] == $m['id_materi'] && $pg['is_completed']) $completed = true;
                            }
                        ?>
                            <div class="col-md-4 mb-2">
                                <div class="alert <?= $completed ? 'alert-success' : 'alert-light' ?> py-1">
                                    <small><strong><?= esc($m['judul_materi']) ?></strong></small><br>
                                    <?php if ($completed): ?>
                                        ✅ Selesai
                                    <?php else: ?>
                                        <a href="<?= base_url('home_siswa/belajar/' . $pendaftaran['id_pendaftaran'] . '/' . $m['id_materi']) ?>" class="btn btn-sm btn-outline-primary">Mulai</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>
