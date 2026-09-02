<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-folder"></i> Data <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/add_uji_kompetensi') ?>" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Tambah Uji Kompetensi
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
                            <th>Gambar</th>
                            <th>Nama Program</th>
                            <th>Durasi</th>
                            <th>Tipe</th>
                            <th>Sertifikat</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($uji_kompetensi)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($uji_kompetensi as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($item['gambar'])): ?>
                                            <img src="<?= base_url('uploads/uji_kompetensi/' . $item['gambar']) ?>" 
                                                 alt="<?= esc($item['nama_uji_kompetensi']) ?>" 
                                                 style="max-width: 50px; max-height: 50px; object-fit: cover; border-radius: 5px;">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['nama_uji_kompetensi']) ?></td>
                                    <td><?= esc($item['durasi']) ?></td>
                                    <td>
                                        <?php 
                                        $badgeClass = '';
                                        switch($item['tipe_pembelajaran']) {
                                            case 'Online':
                                                $badgeClass = 'bg-primary';
                                                break;
                                            case 'Offline':
                                                $badgeClass = 'bg-success';
                                                break;
                                            case 'Hybrid':
                                                $badgeClass = 'bg-info';
                                                break;
                                            default:
                                                $badgeClass = 'bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= esc($item['tipe_pembelajaran']) ?></span>
                                    </td>
                                    <td><?= esc($item['sertifikat']) ?></td>
                                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($item['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                            <a href="<?= base_url('home_superadmin/edit_uji_kompetensi/' . $item['id_uji_kompetensi']) ?>" 
                                               class="btn btn-warning btn-sm btn-block">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('home_superadmin/deleted_uji_kompetensi/' . $item['id_uji_kompetensi']) ?>" 
                                               class="btn btn-danger btn-sm btn-block delete-btn"
                                               data-id="<?= $item['id_uji_kompetensi'] ?>"
                                               data-nama="<?= esc($item['nama_uji_kompetensi']) ?>">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        Belum ada data uji kompetensi
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
