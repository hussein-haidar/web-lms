<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-folder"></i> Data <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/add_lulusan') ?>" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Tambah Alumni
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?= esc($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Filter -->
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-control input-sm">
                            <option value="">Semua Status</option>
                            <option value="aktif" <?= isset($_GET['status']) && $_GET['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= isset($_GET['status']) && $_GET['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kategori" class="form-control input-sm">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategori_list as $kategori): ?>
                                <option value="<?= $kategori ?>" <?= isset($_GET['kategori']) && $_GET['kategori'] == $kategori ? 'selected' : '' ?>><?= $kategori ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-default btn-sm">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($alumni as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <?php if (!empty($item['foto_profil'])): ?>
                                        <img src="<?= base_url('uploads/alumni/profil/' . $item['foto_profil']) ?>" 
                                             alt="<?= $item['nama'] ?>" 
                                             class="img-circle" 
                                             width="40" 
                                             height="40"
                                             style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="img-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: <?= $item['warna_tema'] ?>; color: white; font-size: 12px; font-weight: bold;">
                                            <?= strtoupper(substr($item['nama'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= $item['nama'] ?></strong><br>
                                    <small class="text-muted"><?= (strlen($item['deskripsi']) > 50) ? substr($item['deskripsi'], 0, 50) . '...' : $item['deskripsi'] ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= $item['kategori'] ?></span>
                                </td>
                                <td><?= $item['lokasi'] ?: '-' ?></td>
                                <td>
                                    <?php
                                    $badgeColor = $item['status'] == 'aktif' ? 'bg-green' : 'bg-red';
                                    $statusText = $item['status'] == 'aktif' ? 'Aktif' : 'Nonaktif';
                                    ?>
                                    <span class="label <?= $badgeColor ?>" style="font-size: 11px;">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                        <a href="<?= base_url('home_superadmin/edit_lulusan/' . $item['id_lulusan']) ?>" 
                                           class="btn btn-warning btn-sm btn-block">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('home_superadmin/view_lulusan/' . $item['id_lulusan']) ?>" 
                                           class="btn btn-info btn-sm btn-block">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="<?= base_url('home_superadmin/deleted_lulusan/' . $item['id_lulusan']) ?>" 
                                           class="btn btn-danger btn-sm delete-btn btn-block"
                                           data-id="<?= $item['id_lulusan'] ?>"
                                           data-nama="<?= esc($item['nama']) ?>">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($alumni)): ?>
                <div class="text-center py-5">
                    <i class="fa fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data alumni</h5>
                    <p class="text-muted">Tambahkan data alumni untuk mulai menampilkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Delete button functionality
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const deleteUrl = `<?= base_url("home_superadmin/deleted_lulusan/") ?>${id}`;

            Swal.fire({
                title: 'Hapus Alumni?',
                html: `Yakin hapus alumni <strong>${nama}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
