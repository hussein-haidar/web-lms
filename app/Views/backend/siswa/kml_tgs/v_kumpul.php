 <?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
                    </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>File Tugas</th>
                            <th>File Kirim Tugas</th>
                            <th>Catatan Siswa</th>
                            <th>Nilai</th>
                            <th>Status Penilaian</th>
                            <th>Tanggal Kirim</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kumpul) && is_array($kumpul)): ?>
                            <?php $no = 1;
                            foreach ($kumpul as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($item['dokumen_tugas'])): ?>
                                            <a href="<?= base_url('kursus/tugas/' . ($item['dokumen_tugas'] ?? '')) ?>" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-download"></i> File Tugas
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">–</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['file_tugas'])): ?>
                                            <a href="<?= base_url('kursus/tugassiswa/' . ($item['file_tugas'] ?? '')) ?>" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-download"></i> File Saya
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">–</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['catatan_siswa'] ?? '–') ?></td>
                                    <td><?= esc($item['nilai'] ?? '–') ?></td>
                                    <td>
                                        <?php if ($item['status_penilaian'] == 'sudah_dinilai'): ?>
                                            <span class="badge bg-success">Sudah Dinilai</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Menunggu Penilaian</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['tanggal_kirim'] ?? '–') ?></td>
                                    <td>
                                        <a href="<?= base_url('home_siswa/edit_kumpul/' . ($item['id_kumpul'] ?? '')) ?>"
                                            class="btn btn-xs btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-danger btn-xs deleted-btn"
                                            data-id="<?= $item['id_kumpul'] ?>"
                                            data-nama="Pengumpulan ID <?= $item['id_kumpul'] ?>">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data pengumpulan tugas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
                    title: 'Hapus Data?',
                    html: `Yakin hapus <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('home_siswa/deleted_kumpul_tugas/') ?>' + id;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>