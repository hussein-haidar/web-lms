<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Gradebook - Rekap Nilai Siswa</h3>
    </div>
    <div class="box-body">
        <table id="gradebookTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Kursus</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Nilai Akhir</th>
                    <th width="80">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pendaftaran)): ?>
                    <?php foreach ($pendaftaran as $idx => $p): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><?= esc($p['nama_siswa'] ?? '-') ?></td>
                            <td><?= esc($p['email'] ?? '-') ?></td>
                            <td><?= esc($p['nama_kursus'] ?? '-') ?></td>
                            <td>
                                <?php
                                $status_colors = ['aktif' => 'success', 'pending' => 'warning', 'selesai' => 'info', 'dibatalkan' => 'danger'];
                                $color = $status_colors[$p['status']] ?? 'default';
                                ?>
                                <span class="label label-<?= $color ?>"><?= ucfirst($p['status']) ?></span>
                            </td>
                            <td>
                                <div class="progress progress-xs" style="width:100px; display:inline-block">
                                    <div class="progress-bar bg-success" style="width:<?= $p['progress'] ?? 0 ?>%"></div>
                                </div>
                                <?= $p['progress'] ?? 0 ?>%
                            </td>
                            <td>
                                <?php if (($p['nilai_akhir'] ?? 0) > 0): ?>
                                    <strong class="<?= ($p['nilai_akhir'] >= 70) ? 'text-success' : 'text-danger' ?>">
                                        <?= number_format($p['nilai_akhir'], 1) ?>
                                    </strong>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('home_superadmin/gradebook/' . $p['id_pendaftaran']) ?>" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function() {
    $('#gradebookTable').DataTable({
        "pageLength": 25,
        "order": [[1, "asc"]]
    });
});
</script>

<?= $this->endSection() ?>
