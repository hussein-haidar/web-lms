<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-folder"></i> Data <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/add_mitra_kerja') ?>" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Tambah Mitra Kerja
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <?= session()->getFlashdata('errors') ?>
                </div>
            <?php endif ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Logo</th>
                            <th>Nama Mitra</th>
                            <th>Website</th>
                            <th>Deskripsi</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mitra)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($mitra as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($item['logo_mitra'])): ?>
                                            <img src="<?= base_url('slider/' . $item['logo_mitra']) ?>" 
                                                 alt="<?= esc($item['nama_mitra']) ?>" 
                                                 style="max-width: 50px; max-height: 50px; object-fit: cover; border-radius:5px;">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada logo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['nama_mitra']) ?></td>
                                    <td>
                                        <?php if (!empty($item['url_website'])): ?>
                                            <a href="<?= $item['url_website'] ?>" target="_blank" class="text-primary">
                                                <?= esc($item['url_website']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['deskripsi'])): ?>
                                            <span title="<?= esc($item['deskripsi']) ?>">
                                                <?= strlen(esc($item['deskripsi'])) > 50 ? substr(esc($item['deskripsi']), 0, 50) . '...' : esc($item['deskripsi']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item['urutan'] ?? '-' ?></td>
                                    <td>
                                        <?php if ($item['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                            <a href="<?= base_url('home_superadmin/edit_mitra_kerja/' . $item['id_mitra']) ?>" 
                                               class="btn btn-warning btn-sm btn-block">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('home_superadmin/deleted_mitra_kerja/' . $item['id_mitra']) ?>" 
                                               class="btn btn-danger btn-sm btn-block delete-btn"
                                               data-id="<?= $item['id_mitra'] ?>"
                                               data-nama="<?= esc($item['nama_mitra']) ?>">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        Belum ada data mitra kerja
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>

<?= $this->endSection() ?>
