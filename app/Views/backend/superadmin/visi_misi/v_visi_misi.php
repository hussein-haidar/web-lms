<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-bullseye"></i> Data <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/create_visi_misi') ?>" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Tambah Visi/Misi
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

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Konten</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($visimisi)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($visimisi as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if ($item['jenis'] == 'visi'): ?>
                                            <span class="badge bg-primary">Visi</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Misi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['konten']) ?></td>
                                    <td><?= $item['urutan'] ?></td>
                                    <td>
                                        <?php if ($item['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                            <a href="<?= base_url('home_superadmin/edit_visi_misi/' . $item['id_visimisi']) ?>"
                                               class="btn btn-warning btn-sm btn-block">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('home_superadmin/delete_visi_misi/' . $item['id_visimisi']) ?>"
                                               class="btn btn-danger btn-sm btn-block delete-btn"
                                               data-id="<?= $item['id_visimisi'] ?>"
                                               data-nama="<?= esc($item['jenis'] . ' - ' . $item['konten']) ?>">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        Belum ada data visi & misi
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
