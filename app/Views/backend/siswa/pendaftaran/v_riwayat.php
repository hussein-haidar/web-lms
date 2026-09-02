<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Riwayat Pendaftaran') ?>
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
            <h3 class="box-title"><i class="fa fa-history"></i> Riwayat Pendaftaran</h3>
        </div>
        <div class="box-body">
            <?php if (empty($pendaftaran)): ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Belum ada riwayat pendaftaran.</p>
                </div>
            <?php else: ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Invoice</th>
                            <th>Kursus</th>
                            <th>Paket</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($pendaftaran as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['kode_invoice'] ?? '-') ?></td>
                                <td><?= esc($row['nama_kursus'] ?? '-') ?></td>
                                <td><?= esc($row['nama_paket'] ?? '-') ?></td>
                                <td>Rp <?= number_format($row['harga_kursus'] ?? 0, 0, ',', '.') ?></td>
                                <td><span class="label label-<?= ($row['status'] ?? '') == 'aktif' ? 'success' : (($row['status'] ?? '') == 'selesai' ? 'primary' : 'warning') ?>"><?= esc($row['status'] ?? '-') ?></span></td>
                                <td><?= esc($row['tanggal_pendaftaran'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
