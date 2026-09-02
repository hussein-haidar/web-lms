<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <!-- Search Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Cari Diskusi</h3>
                </div>
                <div class="box-body">
                    <form action="<?= base_url('home_karyawan/diskusi/search') ?>" method="get">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="keyword">Kata Kunci</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" 
                                           value="<?= $this->request->getGet('keyword') ?>" 
                                           placeholder="Masukkan kata kunci pencarian...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Hasil Pencarian</h3>
                    <div class="box-tools pull-right">
                        <span class="label label-info">
                            <?= count($diskusi) ?> hasil ditemukan
                        </span>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (empty($diskusi)): ?>
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> 
                            Tidak ada diskusi yang ditemukan dengan kata kunci "<strong><?= $this->request->getGet('keyword') ?></strong>"
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
                                <p><?= substr($item['isi_diskusi'], 0, 200) ?>...</p>
                                
                                <!-- Action Buttons -->
                                <div class="post-footer">
                                    <a href="<?= base_url('home_karyawan/diskusi/show/' . $item['id_diskusi']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                        
                        <!-- Pagination -->
                        <div class="text-center">
                            <!-- Add pagination if needed -->
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
