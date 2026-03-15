<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($title) ?></h3>
        </div>
        <div class="box-body">
            <?php if (!empty($payments) && is_array($payments)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kursus</th>
                                <th>Paket</th>
                                <th>Kode Transaksi</th>
                                <th>Jumlah Bayar</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($payments as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($p['nama_kursus'] ?? '-') ?></td>
                                    <td><?= esc($p['nama_paket'] ?? '-') ?></td>
                                    <td><?= esc($p['kode_transaksi'] ?? '-') ?></td>
                                    <td><?= esc($p['jumlah_bayar'] ?? '-') ?></td>
                                    <td><?= esc(ucfirst($p['status_pembayaran'] ?? '-')) ?></td>
                                    <td><?= esc($p['tanggal_transaksi'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">Belum ada riwayat pembayaran.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
