<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <!-- ✅ Filter tombol berdasarkan level -->
            <?php $level_user = session()->get('level'); ?>
            <?php if ($level_user == 'pengajar'): // Hanya staf admin yang bisa tambah ?>
                <a href="<?= base_url('home_karyawan/add_tugas') ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Tugas
                </a>
            <?php endif; ?>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tugas</th>
                                <th>Kursus</th>
                                <th>Deskripsi</th>
                                <th>Tenggat Waktu</th>
                                <th>File Tugas</th>
                                <?php if ($level_user == 'pengajar'): // Hanya staf admin yang bisa aksi ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tugas) && is_array($tugas)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($tugas as $item): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($item['judul_tugas'] ?? '') ?></td>
                                        <td><?= esc($item['nama_kursus'] ?? '–') ?></td>
                                        <td>
                                            <?php 
                                            $deskripsi = $item['deskripsi'] ?? '';
                                            echo esc(substr($deskripsi, 0, 50)) . (strlen($deskripsi) > 50 ? '...' : '');
                                            ?>
                                        </td>
                                        <td><?= esc($item['deadline'] ?? '') ?></td>
                                        <td>
                                            <?php if (!empty($item['dokumen_tugas'])): ?>
                                                <a href="<?= base_url('kursus/tugas/' . $item['dokumen_tugas']) ?>" 
                                                   target="_blank" 
                                                   class="btn btn-xs btn-info">
                                                    <i class="fa fa-file"></i> Lihat File
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">–</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if ($level_user == 'pengajar'): ?>
                                            <td>
                                                <a href="<?= base_url('home_karyawan/edit_tugas/' . ($item['id_tugas'] ?? '')) ?>"
                                                    class="btn btn-xs btn-warning">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <button class="btn btn-danger btn-xs deleted-btn"
                                                    data-id="<?= $item['id_tugas'] ?>"
                                                    data-nama="<?= esc($item['judul_tugas'] ?? 'tugas') ?>">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= ($level_user == 'pengajar') ? '7' : '6' ?>" class="text-center">Belum ada data tugas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleted-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;

            Swal.fire({
                title: 'Hapus Tugas?',
                html: `Yakin hapus tugas <strong>${nama}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('home_karyawan/deleted_tugas/') ?>' + id;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>