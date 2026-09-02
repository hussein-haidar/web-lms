<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-users"></i> Data <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/create_manajemen') ?>" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Tambah Manajemen
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
                            <th>Foto</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($manajemen)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($manajemen as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($item['foto'])): ?>
                                            <img src="<?= base_url('uploads/manajemen/' . $item['foto']) ?>" 
                                                 alt="<?= $item['nama_lengkap'] ?>" 
                                                 class="img-circle" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/dist/img/user2-160x160.jpg') ?>" 
                                                 alt="No Image" 
                                                 class="img-circle" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item['nama_lengkap'] ?></td>
                                    <td><?= $item['jabatan'] ?></td>
                                    <td><?= $item['email'] ?? '-' ?></td>
                                    <td><?= $item['no_telepon'] ?? '-' ?></td>
                                    <td><?= $item['urutan'] ?></td>
                                    <td>
                                        <?php if ($item['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('home_superadmin/edit_manajemen/' . $item['id_manajemen']) ?>" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete('<?= $item['nama_lengkap'] ?>', '<?= base_url('home_superadmin/delete_manajemen/' . $item['id_manajemen']) ?>')" 
                                                class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
function confirmDelete(nama, url) {
    if (confirm('Apakah Anda yakin ingin menghapus data "' + nama + '"?')) {
        window.location.href = url;
    }
}
</script>

<?= $this->endSection() ?>
