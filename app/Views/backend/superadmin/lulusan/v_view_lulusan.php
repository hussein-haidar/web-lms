<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-eye"></i> <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/edit_lulusan/' . $alumni['id_lulusan']) ?>" class="btn btn-warning btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="<?= base_url('home_superadmin/lulusan') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        <?php if (!empty($alumni['foto_profil'])): ?>
                            <img src="<?= base_url('uploads/lulusan/' . $alumni['foto_profil']) ?>" 
                                 alt="<?= $alumni['nama'] ?>" 
                                 class="img-circle mb-3" 
                                 width="150" 
                                 height="150"
                                 style="object-fit: cover; border: 4px solid <?= $alumni['warna_tema'] ?>;">
                        <?php else: ?>
                            <div class="img-circle mb-3 d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 150px; height: 150px; background: <?= $alumni['warna_tema'] ?>; color: white; font-size: 3rem; font-weight: bold;">
                                <?= strtoupper(substr($alumni['nama'], 0, 2)) ?>
                            </div>
                        <?php endif; ?>

                        <h4 class="mb-2" style="color: <?= $alumni['warna_tema'] ?>;"><?= $alumni['nama'] ?></h4>
                        <span class="badge bg-info mb-3"><?= $alumni['kategori'] ?></span>

                        <?php if ($alumni['status'] == 'aktif'): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Alumni</h5>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td><?= $alumni['nama'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td><?= $alumni['kategori'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td><?= $alumni['lokasi'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <?php if ($alumni['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3">Deskripsi</h5>
                            <p><?= nl2br($alumni['deskripsi']) ?></p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Media Sosial</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($alumni['facebook_url'])): ?>
                                    <a href="<?= $alumni['facebook_url'] ?>" class="btn btn-primary btn-sm" target="_blank">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($alumni['tiktok_url'])): ?>
                                    <a href="<?= $alumni['tiktok_url'] ?>" class="btn btn-dark btn-sm" target="_blank">
                                        <i class="fab fa-tiktok"></i> TikTok
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($alumni['whatsapp_url'])): ?>
                                    <a href="<?= $alumni['whatsapp_url'] ?>" class="btn btn-success btn-sm" target="_blank">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                <?php endif; ?>

                                <?php if (empty($alumni['facebook_url']) && empty($alumni['tiktok_url']) && empty($alumni['whatsapp_url'])): ?>
                                    <span class="text-muted">Tidak ada media sosial yang ditambahkan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($alumni['galeri'])): ?>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">Galeri Foto</h5>
                                <div class="row">
                                    <?php 
                                    $galeri = json_decode($alumni['galeri'], true) ?: []; 
                                    foreach ($galeri as $index => $foto): ?>
                                        <div class="col-md-3 col-6">
                                            <div class="card">
                                                <img src="<?= base_url('uploads/lulusan/galeri/' . $foto['foto']) ?>" 
                                                     alt="<?= $foto['keterangan'] ?? 'Gambar ' . ($index + 1) ?>"
                                                     class="card-img-top"
                                                     style="height: 150px; object-fit: cover;">
                                                <div class="card-body p-2">
                                                    <small class="text-muted"><?= $foto['keterangan'] ?? 'Tanpa keterangan' ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<?= $this->endSection() ?>
