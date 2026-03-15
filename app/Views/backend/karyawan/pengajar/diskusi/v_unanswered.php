<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title2 ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('home_karyawan/home_pengajar') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Diskusi Perlu Dijawab</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Notifikasi Flashdata -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <!-- Info Box: Statistik Singkat -->
        <div class="row">
            <div class="col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-question"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Diskusi Belum Dijawab</span>
                        <span class="info-box-number"><?= count($diskusi) ?> <small>Topik</small></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Diskusi -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comments mr-2"></i>Daftar Pertanyaan Siswa (Kursus ID: <?= $id_kursus ?>)
                        </h3>
                        <div class="card-tools">
                            <a href="<?= base_url('home_karyawan/diskusi/' . $id_kursus) ?>" class="btn btn-sm btn-default">
                                <i class="fas fa-list"></i> Lihat Semua Diskusi
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <?php if (empty($diskusi)): ?>
                            <!-- State: Tidak ada data -->
                            <div class="text-center py-5">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                <h4 class="mt-3 text-muted">Semua diskusi sudah terjawab!</h4>
                                <p class="text-muted">Tidak ada pertanyaan pending untuk kursus ini saat ini.</p>
                                <a href="<?= base_url('home_karyawan/home_pengajar') ?>" class="btn btn-primary mt-2">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- State: Ada data diskusi -->
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <?php foreach ($diskusi as $d): ?>
                                    <li class="item">
                                        <div class="product-img">
                                            <!-- Avatar Default atau Custom -->
                                            <?php
                                            $avatar = !empty($d['user_avatar']) ? base_url('fotosiswa/' . $d['user_avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($d['user_name']) . '&background=random';
                                            ?>
                                            <img src="<?= $avatar ?>" alt="<?= esc($d['user_name']) ?>" class="img-circle img-size-50">
                                        </div>
                                        <div class="product-info">
                                            <div class="d-flex justify-content-between">
                                                <a href="<?= base_url('diskusi/' . $d['slug']) ?>" class="product-title font-weight-bold text-primary">
                                                    <?= esc($d['judul']) ?>
                                                    <?php if ($d['kategori'] == 'pertanyaan'): ?>
                                                        <span class="badge badge-warning ml-2">Pertanyaan</span>
                                                    <?php elseif ($d['kategori'] == 'diskusi'): ?>
                                                        <span class="badge badge-info ml-2">Diskusi</span>
                                                    <?php endif; ?>
                                                </a>
                                                <span class="product-price text-muted small">
                                                    <i class="far fa-clock"></i> <?= date('d M Y, H:i', strtotime($d['created_at'])) ?>
                                                </span>
                                            </div>

                                            <span class="product-description text-muted">
                                                <?= esc(substr($d['konten'], 0, 150)) ?><?= strlen($d['konten']) > 150 ? '...' : '' ?>
                                            </span>

                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-user"></i> Ditanya oleh: <strong><?= esc($d['user_name']) ?></strong>
                                                    (<?= ucfirst($d['user_role']) ?>)
                                                    &bull;
                                                    <i class="fas fa-eye"></i> <?= $d['total_views'] ?> dilihat
                                                </small>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="mt-2">
                                                <a href="<?= base_url('diskusi/' . $d['slug']) ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-reply"></i> Jawab Sekarang
                                                </a>
                                                <a href="<?= base_url('diskusi/' . $d['slug']) ?>#form-komentar" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-pen"></i> Tulis Solusi
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Divider -->
                                    <li class="divider"></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer clearfix">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Upload New Product</a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Items</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>