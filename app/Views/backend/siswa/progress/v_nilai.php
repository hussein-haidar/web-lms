<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Nilai Siswa') ?>
        <small><?= esc($title2 ?? '') ?></small>
    </h1>
</section>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Daftar Nilai</h3>
        </div>
        <div class="box-body">
            <?php if (empty($pendaftaran)): ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Belum ada data nilai.</p>
                </div>
            <?php else: ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kursus</th>
                            <th>Paket</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($pendaftaran as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['nama_kursus'] ?? '-') ?></td>
                                <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                                <td><?= ($row['progress'] ?? 0) ?>%</td>
                                <td><span class="label label-<?= ($row['status'] ?? '') == 'aktif' ? 'success' : (($row['status'] ?? '') == 'selesai' ? 'primary' : 'warning') ?>"><?= esc($row['status'] ?? '-') ?></span></td>
                                <td><a href="<?= base_url('home_siswa/detail_nilai/' . $row['id_pendaftaran']) ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
