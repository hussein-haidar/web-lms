<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Daftar Modul - <?= esc($kursus['nama_kursus']); ?></h3>

            <?php $level_user = session()->get('level'); ?>

            <!-- Filter dan Tombol - Horizontal Layout -->
            <div class="box-tools pull-right">
                <div class="form-inline">
                    <?php if ($level_user == 'superadmin'): ?>
                                          <!-- Kembali ke Kursus -->
                        <a href="<?= base_url('home_superadmin/kursus') ?>"
                            class="btn btn-sm btn-warning">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="box-body">
        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>

        <?php $errors = session()->getFlashdata('errors');
        if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead class="bg-gray">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="25%">Nama Modul</th>
                        <th width="35%">Deskripsi</th>
                        <th width="8%" class="text-center">Urutan</th>
                        <th width="12%" class="text-center">Jumlah Materi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($modul) && is_array($modul)): ?>
                        <?php $no = 1;
                        foreach ($modul as $item): ?>
                            <?php if (!is_array($item)) continue; ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <?= esc($item['nama_modul'] ?? '') ?>
                                    <br>
                                    <small class="text-muted">ID: <?= $item['id_modul'] ?></small>
                                </td>
                                <td>
                                    <?= !empty($item['deskripsi']) ? esc(substr($item['deskripsi'], 0, 100)) . '...' : '-' ?>
                                </td>
                                <td class="text-center">
                                    <span class="label label-primary"><?= $item['urutan'] ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="label label-info">
                                        <?= $item['jumlah_materi'] ?? 0 ?>
                                        materi
                                    </span>
                                </td>

                                <?php if ($level_user == 'superadmin'): ?>
                                    <td class="text-center">
                                        <!-- ✅ Materi Button -->
                                        <a href="<?= base_url('home_superadmin/materi/' . $item['id_modul']) ?>"
                                            class="btn btn-xs btn-info"
                                            title="Kelola Materi"
                                            style="margin-bottom: 5px; display: inline-block;">
                                            <i class="fa fa-list"></i> Materi
                                        </a>

                                        <!-- ✅ Tambah Materi Button -->
                                        <a href="<?= base_url('home_superadmin/add_materi/' . $item['id_modul']) ?>"
                                            class="btn btn-xs btn-success"
                                            title="Tambah Materi"
                                            style="margin-bottom: 5px; display: inline-block;">
                                            <i class="fa fa-plus"></i> +Materi
                                        </a>

                                        <!-- ✅ Edit Button: URL BERSIH (tanpa filter params) -->
                                        <a href="<?= base_url('home_superadmin/edit_modul/' . $item['id_modul']) ?>"
                                            class="btn btn-xs btn-warning"
                                            title="Edit"
                                            style="margin-bottom: 5px; display: inline-block;">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- ✅ Delete Button: Redirect ke list TANPA filter -->
                                        <button class="btn btn-danger btn-xs deleted-btn"
                                            data-id="<?= $item['id_modul'] ?>"
                                            data-nama="<?= esc($item['nama_modul'] ?? 'modul') ?>"
                                            title="Hapus">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                <i class="fa fa-folder-open text-muted"></i> Belum ada data modul.
                                <br>
                                <small class="text-muted">
                                    Kursus: <?= esc($kursus['nama_kursus'] ?? 'Unknown') ?> (ID: <?= $kursus['id_kursus'] ?? 'N/A' ?>)
                                </small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

        <div class="box-footer">
            <div class="row">
                <div class="col-sm-6">
                    <small class="text-muted">
                        <i class="fa fa-info-circle"></i>
                        Kursus: <strong><?= esc($kursus['nama_kursus']); ?></strong>
                    </small>
                </div>
                <div class="col-sm-6 text-right">
                    <small class="text-muted">
                        Total Modul: <strong><?= count($modul); ?></strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ✅ Simple filter: langsung redirect dengan URL params (tanpa storage)
    function applyFilter(key, value) {
        let url = new URL(window.location.href);

        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }

        // Redirect langsung
        window.location.href = url.toString();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // 🗑️ Delete Confirmation: Redirect ke list TANPA filter
        document.querySelectorAll('.deleted-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                // ✅ URL delete redirect ke list bersih (tanpa filter params)
                const deleteUrl = `<?= base_url("home_superadmin/delete_modul/") ?>${id}`;

                Swal.fire({
                    title: 'Hapus modul?',
                    html: `Yakin hapus <strong>${nama}</strong>?<br><small>Semua materi di dalam modul ini juga akan dihapus.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
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