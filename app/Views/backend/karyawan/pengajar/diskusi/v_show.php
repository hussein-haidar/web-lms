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

    <!-- Diskusi Detail -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Diskusi</h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('home_karyawan/diskusi/' . $diskusi['id_kursus']) ?>" class="btn btn-sm btn-default">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <!-- Main Diskusi -->
                    <div class="post">
                        <div class="user-block">
                            <span class="username">
                                <strong><?= $diskusi['nama_lengkap'] ?></strong>
                                <?php if ($diskusi['is_pinned'] == 1): ?>
                                    <span class="label label-warning">Dipin</span>
                                <?php endif; ?>
                                <?php if ($diskusi['is_locked'] == 1): ?>
                                    <span class="label label-danger">Dikunci</span>
                                <?php endif; ?>
                            </span>
                            <span class="description"><?= date('d M Y, H:i', strtotime($diskusi['tanggal_buat'])) ?></span>
                        </div>
                        <p>
                            <strong><?= $diskusi['judul_diskusi'] ?></strong>
                        </p>
                        <p><?= $diskusi['isi_diskusi'] ?></p>
                        
                        <!-- Action Buttons -->
                        <div class="post-footer">
                            <a href="<?= base_url('home_karyawan/diskusi/pin/' . $diskusi['id_diskusi']) ?>" class="btn btn-sm btn-warning">
                                <i class="fa fa-thumb-tack"></i> <?= $diskusi['is_pinned'] == 1 ? 'Unpin' : 'Pin' ?>
                            </a>
                            <a href="<?= base_url('home_karyawan/diskusi/lock/' . $diskusi['id_diskusi']) ?>" class="btn btn-sm btn-danger">
                                <i class="fa fa-lock"></i> <?= $diskusi['is_locked'] == 1 ? 'Unlock' : 'Lock' ?>
                            </a>
                        </div>
                    </div>

                    <!-- Komentar Section -->
                    <hr>
                    <h4>Komentar (<?= count($komentar) ?>)</h4>
                    
                    <!-- Add Komentar Form -->
                    <div class="box box-success">
                        <div class="box-header">
                            <h4 class="box-title">Tambah Komentar</h4>
                        </div>
                        <div class="box-body">
                            <form action="<?= base_url('home_karyawan/diskusi/komentar/' . $diskusi['id_diskusi']) ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="isi_komentar">Komentar</label>
                                    <textarea class="form-control" id="isi_komentar" name="isi_komentar" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-comment"></i> Tambah Komentar
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- List Komentar -->
                    <?php if (!empty($komentar)): ?>
                        <?php foreach ($komentar as $item): ?>
                            <div class="post clearfix">
                                <div class="user-block">
                                    <span class="username">
                                        <strong><?= $item['nama_lengkap'] ?></strong>
                                        <?php if ($item['is_solution'] == 1): ?>
                                            <span class="label label-success">Solusi</span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="description"><?= date('d M Y, H:i', strtotime($item['tanggal_buat'])) ?></span>
                                </div>
                                <p><?= $item['isi_komentar'] ?></p>
                                
                                <!-- Komentar Actions -->
                                <div class="post-footer">
                                    <a href="<?= base_url('home_karyawan/diskusi/like/' . $item['id_komentar'] . '/' . $diskusi['id_diskusi']) ?>" class="btn btn-sm btn-info">
                                        <i class="fa fa-thumbs-up"></i> Like
                                    </a>
                                    <a href="<?= base_url('home_karyawan/diskusi/solution/' . $item['id_komentar'] . '/' . $diskusi['id_diskusi']) ?>" class="btn btn-sm btn-success">
                                        <i class="fa fa-check"></i> <?= $item['is_solution'] == 1 ? 'Hapus Solusi' : 'Set Solusi' ?>
                                    </a>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Belum ada komentar untuk diskusi ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
