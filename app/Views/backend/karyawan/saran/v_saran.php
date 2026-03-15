<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Pesan Masuk</h3>
            <a href="<?= base_url('home_superadmin/data_dihapus_pesan') ?>" class="btn btn-sm btn-secondary float-right">
                <i class="fa fa-recycle"></i> Lihat Data Dihapus
            </a>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($saran) && is_array($saran)): ?>
                            <?php $no = 1; foreach ($saran as $item): ?>
                                <?php if (!is_array($item)) continue; ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item['nama'] ?? '-') ?></td>
                                    <td><?= esc($item['email'] ?? '-') ?></td>
                                    <td><?= esc(strlen($item['pesan'] ?? '') > 50 ? substr($item['pesan'], 0, 50) . '...' : ($item['pesan'] ?? '-')) ?></td>
                                    <td><?= esc(!empty($item['tanggal']) ? date('d M Y H:i', strtotime($item['tanggal'])) : '-') ?></td>
                                                                 </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fa fa-inbox fa-2x text-muted d-block mb-2"></i>
                                    <span class="text-muted">Belum ada pesan masuk</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>