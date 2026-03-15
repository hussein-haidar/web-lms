<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($title) ?></h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_karyawan/add_quiz') ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Tambah Quiz
                </a>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Judul Quiz</th>
                            <th width="15%">Kursus</th>
                            <th width="10%">Durasi</th>
                            <th width="10%">Passing Grade</th>
                            <th width="10%">Status</th>
                            <th width="10%">Attempts</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($quizzes) && is_array($quizzes)): ?>
                            <?php $no = 1; foreach ($quizzes as $quiz): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= esc($quiz['judul_quiz']) ?></strong>
                                        <?php if (!empty($quiz['deskripsi'])): ?>
                                            <br><small class="text-muted"><?= esc(substr($quiz['deskripsi'], 0, 50)) ?>...</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($quiz['nama_kursus']) ?></td>
                                    <td class="text-center"><?= esc($quiz['durasi_menit']) ?> menit</td>
                                    <td class="text-center"><?= esc($quiz['passing_grade']) ?>%</td>
                                    <td class="text-center">
                                        <?php
                                        $statusClass = [
                                            'draft' => 'bg-warning',
                                            'aktif' => 'bg-success', 
                                            'nonaktif' => 'bg-danger'
                                        ];
                                        ?>
                                        <span class="badge <?= $statusClass[$quiz['status']] ?? 'bg-secondary' ?>">
                                            <?= ucfirst($quiz['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?= $quiz['total_attempts'] ?? 0 ?> / <?= $quiz['max_attempt'] ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('home_karyawan/quiz_stats/' . $quiz['id_quiz']) ?>" 
                                               class="btn btn-info" title="Statistik">
                                                <i class="fa fa-bar-chart"></i>
                                            </a>
                                            <a href="<?= base_url('home_karyawan/edit_quiz/' . $quiz['id_quiz']) ?>" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete('<?= base_url('home_karyawan/delete_quiz/' . $quiz['id_quiz']) ?>', '<?= esc($quiz['judul_quiz']) ?>')"
                                                class="btn btn-danger" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data quiz.</td>
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
function confirmDelete(url, namaQuiz) {
    Swal.fire({
        title: 'Konfirmasi Hapus Quiz',
        html: `
            <p>Apakah Anda yakin ingin menghapus quiz:</p>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 10px 0;">
                <strong>${namaQuiz}</strong>
            </div>
            <p style="color: #6c757d; font-size: 14px;">
                <i class="fa fa-info-circle"></i> Quiz yang sudah memiliki hasil akan dinonaktifkan.
            </p>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
        cancelButtonText: '<i class="fa fa-times"></i> Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

<?= $this->endSection() ?>
