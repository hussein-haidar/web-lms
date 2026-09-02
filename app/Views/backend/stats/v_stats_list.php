<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Statistik</h1>
        <a href="<?= base_url('home_superadmin/stats/add') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Statistik
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Statistik</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($stats)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Nilai</th>
                                <th>Suffix</th>
                                <th>Baris</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($stats as $stat): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($stat['judul_stats']) ?></td>
                                    <td><?= number_format($stat['nilai_stats'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($stat['suffix_stats'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge badge-<?= $stat['baris_stats'] == 1 ? 'primary' : 'info' ?>">
                                            Baris <?= $stat['baris_stats'] ?>
                                        </span>
                                    </td>
                                    <td><?= $stat['urutan_stats'] ?></td>
                                    <td>
                                        <span class="badge badge-<?= $stat['is_active'] ? 'success' : 'secondary' ?>">
                                            <?= $stat['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('home_superadmin/stats/edit/' . $stat['id_stats']) ?>" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('home_superadmin/stats/toggle/' . $stat['id_stats']) ?>" 
                                               class="btn btn-sm btn-<?= $stat['is_active'] ? 'secondary' : 'success' ?>" 
                                               title="<?= $stat['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>"
                                               onclick="return confirm('Apakah Anda yakin ingin mengubah status statistik ini?')">
                                                <i class="fas fa-<?= $stat['is_active'] ? 'eye-slash' : 'eye' ?>"></i>
                                            </a>
                                            <a href="<?= base_url('home_superadmin/stats/delete/' . $stat['id_stats']) ?>" 
                                               class="btn btn-sm btn-danger" title="Hapus"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus statistik ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <i class="fas fa-chart-bar fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada data statistik</p>
                    <a href="<?= base_url('home_superadmin/stats/add') ?>" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Statistik
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
