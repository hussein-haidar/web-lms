<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-folder"></i> Data <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/postingan_deleted') ?>" class="btn btn-sm btn-warning" style="margin-right: 5px;">
                    <i class="fa fa-trash"></i> Tempat Sampah
                </a>
                <a href="<?= base_url('home_superadmin/postingan_create') ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> Tambah Postingan
                </a>
            </div>
        </div>

        <div class="box-body">
            <!-- Filter Status -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <form method="GET" action="<?= base_url('home_superadmin/postingan_admin') ?>">
                        <div class="form-group mb-3">
                            <div class="input-group input-group-sm">
                                <select name="status" class="form-control" style="max-width: 200px;" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="draft" <?= $status == 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= $status == 'published' ? 'selected' : '' ?>>Published</option>
                                    <option value="archived" <?= $status == 'archived' ? 'selected' : '' ?>>Archived</option>
                                </select>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default btn-sm">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 text-right">
                    <small class="text-muted">
                        Total: <?= count($postingan) ?> postingan
                    </small>
                </div>
            </div>

            <?php if (session()->getFlashdata('success') || session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible mb-3">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <?= session()->getFlashdata('pesan') ?: session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible mb-3">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive mt-3">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="80">Gambar</th>
                            <th>Judul Postingan</th>
                            <th width="120">Kategori</th>
                            <th width="120">Penulis</th>
                            <th width="120">Status</th>
                            <th width="80">Views</th>
                            <th width="120">Tanggal</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($postingan)): ?>
                            <?php $no = 1; foreach ($postingan as $post): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($post['gambar_postingan'])): ?>
                                            <img src="<?= base_url('uploads/postingan/' . $post['gambar_postingan']) ?>"
                                                width="60"
                                                class="img-thumbnail"
                                                alt="<?= esc($post['judul_postingan']) ?>">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                                <i class="fa fa-newspaper text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?= esc(substr($post['judul_postingan'], 0, 50) . (strlen($post['judul_postingan']) > 50 ? '...' : '')) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <?= base_url('postingan/detail/' . $post['slug']) ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= esc($post['kategori']) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($post['penulis']) ?></td>
                                    <td class="text-center">
                                        <?php
                                        $statusClass = '';
                                        $statusIcon = '';
                                        switch ($post['status']) {
                                            case 'published':
                                                $statusClass = 'label-success';
                                                $statusIcon = 'fa-check-circle';
                                                break;
                                            case 'draft':
                                                $statusClass = 'label-warning';
                                                $statusIcon = 'fa-edit';
                                                break;
                                            case 'archived':
                                                $statusClass = 'label-default';
                                                $statusIcon = 'fa-archive';
                                                break;
                                        }
                                        ?>
                                        <span class="label <?= $statusClass ?>">
                                            <i class="fa <?= $statusIcon ?>"></i> <?= ucfirst($post['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <i class="fa fa-eye"></i> <?= number_format($post['views']) ?>
                                    </td>
                                    <td>
                                        <small>
                                            <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                                            <br>
                                            <span class="text-muted"><?= date('H:i', strtotime($post['created_at'])) ?></span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('postingan/detail/' . $post['slug']) ?>"
                                                    class="btn btn-primary btn-xs btn-flat me-1"
                                                    title="Lihat Postingan"
                                                    target="_blank">
                                                    <i class="fa fa-eye"></i> Lihat
                                                </a>
                                                <a href="<?= base_url('home_superadmin/postingan_edit/' . $post['id_postingan']) ?>"
                                                    class="btn btn-warning btn-xs btn-flat me-1"
                                                    title="Edit">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php if ($post['deleted_at']): ?>
                                                    <button onclick="confirmRestore('<?= $post['id_postingan'] ?>')"
                                                        class="btn btn-success btn-xs btn-flat"
                                                        title="Restore">
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                    <button onclick="confirmPermanentDelete('<?= $post['id_postingan'] ?>', '<?= esc($post['judul_postingan']) ?>')"
                                                        class="btn btn-danger btn-xs btn-flat ms-1"
                                                        title="Hapus Permanen">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                <?php else: ?>
                                                    <button onclick="confirmDelete('<?= $post['id_postingan'] ?>', '<?= esc($post['judul_postingan']) ?>')"
                                                        class="btn btn-danger btn-xs btn-flat"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">
                                    <i class="fa fa-newspaper fa-3x text-muted mb-3"></i><br>
                                    <h5 class="text-muted">Belum ada postingan</h5>
                                    <p class="text-muted">
                                        <?php if ($status): ?>
                                            Tidak ada postingan dengan status "<?= ucfirst($status) ?>"
                                        <?php else: ?>
                                            Belum ada postingan sama sekali
                                        <?php endif; ?>
                                    </p>
                                    <a href="<?= base_url('home_superadmin/postingan_create') ?>" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Tambah Postingan Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Confirmation Modals -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Hapus</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus postingan "<strong id="deleteTitle"></strong>"?</p>
                <p class="text-muted">Postingan akan dipindahkan ke trash dan dapat dipulihkan kembali.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="permanentDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Hapus Permanen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus permanen postingan "<strong id="permanentDeleteTitle"></strong>"?</p>
                <p class="text-danger"><strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmPermanentDeleteBtn">Hapus Permanen</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="restoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Pulihkan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin memulihkan postingan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmRestoreBtn">Pulihkan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Hapus Postingan?',
            html: `Yakin hapus postingan <strong>${title}</strong>?`,
            text: 'Postingan akan dipindahkan ke trash dan dapat dipulihkan kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('home_superadmin/postingan_delete/') ?>' + id;
            }
        });
    }

    function confirmPermanentDelete(id, title) {
        Swal.fire({
            title: 'Hapus Permanen?',
            html: `Yakin hapus permanen postingan <strong>${title}</strong>?`,
            text: 'Peringatan: Tindakan ini tidak dapat dibatalkan!',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('home_superadmin/postingan_permanent_delete/') ?>' + id;
            }
        });
    }

    function confirmRestore(id) {
        Swal.fire({
            title: 'Pulihkan Postingan?',
            text: 'Apakah Anda yakin ingin memulihkan postingan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Pulihkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('home_superadmin/postingan_restore/') ?>' + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>
