<?php $this->extend('backend/template_user/main'); ?>
<?php $this->section('content'); ?>
<div class="container-fluid">
    <h1><?= esc($title2) ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active">Deadline Tugas</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <strong>⏰ Tugas dengan Deadline</strong>
        </div>
        <div class="card-body">
            <?php if (empty($deadlines)): ?>
                <p class="text-muted">Tidak ada tugas dengan deadline.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Kursus</th>
                                <th>Deadline</th>
                                <th>Sisa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($deadlines as $d): 
                                $sisa = (strtotime($d['tanggal_deadline']) - time()) / 86400;
                            ?>
                                <tr class="<?= $sisa < 2 ? 'table-danger' : '' ?>">
                                    <td><strong><?= esc($d['judul_tugas']) ?></strong></td>
                                    <td><?= esc($d['nama_kursus']) ?></td>
                                    <td><?= esc($d['tanggal_deadline']) ?></td>
                                    <td><?= esc(round($sisa, 1)) ?> hari</td>
                                    <td>
                                        <?php if ($sisa <= 2): ?>
                                            <span class="badge badge-danger">Mendekat!</span>
                                        <?php endif; ?>
                                        <a href="<?= base_url('home_karyawan/tugas') ?>" class="btn btn-sm btn-outline-primary">Kelola</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>
