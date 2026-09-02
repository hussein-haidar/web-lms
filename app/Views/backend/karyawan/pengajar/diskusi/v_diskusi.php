<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <!-- Alert sukses -->
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <!-- Alert error -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Diskusi Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Diskusi Kursus</h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('home_karyawan/diskusi/search') ?>" class="btn btn-sm btn-default">
                            <i class="fa fa-search"></i> Cari
                        </a>
                        <a href="<?= base_url('home_karyawan/mentor_unanswered') ?>" class="btn btn-sm btn-warning">
                            <i class="fa fa-question-circle"></i> Belum Dijawab
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (empty($diskusi)): ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Belum ada diskusi untuk kursus ini.
                        </div>
                    <?php else: ?>
                        <?php foreach ($diskusi as $item): ?>
                            <div class="post">
                                <div class="user-block">
                                    <span class="username">
                                        <strong><?= $item['nama_lengkap'] ?></strong>
                                        <?php if ($item['is_pinned'] == 1): ?>
                                            <span class="label label-warning">Dipin</span>
                                        <?php endif; ?>
                                        <?php if ($item['is_locked'] == 1): ?>
                                            <span class="label label-danger">Dikunci</span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="description"><?= date('d M Y, H:i', strtotime($item['tanggal_buat'])) ?></span>
                                </div>
                                <p>
                                    <strong><?= $item['judul_diskusi'] ?></strong>
                                </p>
                                <p><?= $item['isi_diskusi'] ?></p>
                                
                                <!-- Action Buttons -->
                                <div class="post-footer">
                                    <a href="<?= base_url('home_karyawan/diskusi/show/' . $item['id_diskusi']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> Lihat Detail
                                    </a>
                                    <a href="<?= base_url('home_karyawan/diskusi/pin/' . $item['id_diskusi']) ?>" class="btn btn-sm btn-warning">
                                        <i class="fa fa-thumb-tack"></i> Pin
                                    </a>
                                    <a href="<?= base_url('home_karyawan/diskusi/lock/' . $item['id_diskusi']) ?>" class="btn btn-sm btn-danger">
                                        <i class="fa fa-lock"></i> Lock
                                    </a>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
