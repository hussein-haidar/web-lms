<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>
<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-folder"></i> Data <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/add_program') ?>" class="btn btn-sm btn-primary" style="margin-right: 5px;">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Program Kursus
                </a>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Nama Program</th>
                            <th>Deskripsi</th>
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($program) && is_array($program)): ?>
                            <?php foreach ($program as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($item['nama_program'] ?? '') ?></td>
                                    <td><?= esc(($item['deskripsi'] ?? '')) ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('home_superadmin/edit_program/' . $item['id_program']) ?>"
                                            class="btn btn-warning btn-xs" style="margin-right: 5px;">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-danger btn-xs deleted-btn"
                                            data-id="<?= $item['id_program'] ?>"
                                            data-nama="<?= esc($item['nama_program']) ?>">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data program.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 (URL diperbaiki - hapus spasi) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script Hapus dengan SweetAlert -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.deleted-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                Swal.fire({
                    title: 'Hapus Program?',
                    html: `Yakin hapus <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('home_superadmin/deleted_program/') ?>' + id;
                    }
                });
            });
        });
    });
</script>


<?= $this->endSection() ?>