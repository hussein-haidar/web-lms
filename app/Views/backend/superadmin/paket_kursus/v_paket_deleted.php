<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-trash"></i> <?= $title ?>

            <?php $level_user = session()->get('level'); ?>

            <!-- Back to Main -->
            <div class="box-tools pull-right">
                <?php if ($level_user == 'superadmin'): ?>
                    <a href="<?= base_url('home_superadmin/paket_kursus') ?>" 
                       class="btn btn-sm btn-warning">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($paket)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Paket</th>
                            <th width="20%">Total Pertemuan</th>
                            <th width="15%">Durasi</th>
                            <th width="15%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($paket as $item): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <?= esc($item['nama_paket']) ?>
                                    <br>
                                    <small class="text-muted">ID: <?= $item['id_paket'] ?></small>
                                </td>
                                <td class="text-center">
                                    <?= $item['total_pertemuan'] ?? 0 ?> pertemuan
                                </td>
                                <td class="text-center">
                                    <?= $item['durasi_per_pertemuan_jam'] ?? 0 ?> jam
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($item['deleted_at'])): ?>
                                        <span class="label label-danger">Dihapus</span>
                                        <br>
                                        <small><?= date('d M Y', strtotime($item['deleted_at'])) ?></small>
                                    <?php else: ?>
                                        <span class="label label-success">Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($level_user == 'superadmin'): ?>
                                        <!-- Restore Button -->
                                        <a href="<?= base_url('home_superadmin/restore_paket/' . $item['id_paket']) ?>" 
                                           class="btn btn-xs btn-success"
                                           title="Pulihkan">
                                            <i class="fa fa-undo"></i> Pulihkan
                                        </a>

                                        <!-- Force Delete Button -->
                                        <button class="btn btn-xs btn-danger force-delete-btn"
                                                data-id="<?= $item['id_paket'] ?>"
                                                data-nama="<?= esc($item['nama_paket']) ?>"
                                                title="Hapus Permanen">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Belum ada data paket yang dihapus.</strong>
                    <br>
                    <small>Data paket yang dihapus akan muncul di sini.</small>
                </div>
            <?php endif; ?>
        </div>

        <div class="box-footer">
            <div class="row">
                <div class="col-sm-6">
                    <small class="text-muted">
                        <i class="fa fa-info-circle"></i>
                        Total Paket Dihapus: <strong><?= count($paket); ?></strong>
                    </small>
                </div>
                <div class="col-sm-6 text-right">
                    <small class="text-muted">
                        <i class="fa fa-clock-o"></i>
                        Data diperbarui: <?= date('d M Y H:i') ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Force Delete Confirmation
        document.querySelectorAll('.force-delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Hapus Permanen?',
                    html: `Yakin hapus permanen <strong>${nama}</strong>?<br><small>Tindakan ini tidak dapat dibatalkan!</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `<?= base_url("home_superadmin/force_delete_paket/") ?>${id}`;
                    }
                });
            });
        });
    });
</script>
