<?= $this->extend('admin/template/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Alumni</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('/home_superadmin/alumni/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Alumni
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($alumni) && is_array($alumni)): ?>
                                    <?php foreach ($alumni as $index => $item): ?>
                                        <?php /** @var array $item */ ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <?php if (!empty($item['foto_profil'])): ?>
                                                    <img src="<?= base_url('uploads/alumni/profil/' . $item['foto_profil']) ?>" 
                                                         alt="<?= esc($item['nama']) ?>" class="img-thumbnail" width="50" height="50">
                                                <?php else: ?>
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; background: <?= esc($item['warna_tema']) ?>; color: white; font-size: 0.8rem; font-weight: bold;">
                                                        <?= strtoupper(substr((string)$item['nama'], 0, 2)) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= esc($item['nama']) ?></strong><br>
                                                <small class="text-muted"><?= substr((string)$item['deskripsi'], 0, 50) ?>...</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= esc($item['kategori']) ?></span>
                                            </td>
                                            <td><?= esc($item['lokasi'] ?? '-') ?></td>
                                            <td>
                                                <span class="badge bg-<?= $item['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst($item['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?= base_url('/alumni') ?>" class="btn btn-sm btn-info" target="_blank" title="Lihat di Frontend">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('/home_superadmin/alumni/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete(<?= $item['id'] ?>, '<?= esc($item['nama']) ?>')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="py-3">
                                                <i class="fas fa-users fa-3x text-muted mb-2"></i><br>
                                                Belum ada data alumni
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus alumni "' + nama + '"?')) {
        window.location.href = '<?= base_url('/home_superadmin/alumni/delete/') ?>' + id;
    }
}
</script>

<?= $this->endSection() ?>
