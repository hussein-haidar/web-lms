<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= $title2 ?? 'Data Tugas' ?></h3>
            <a href="<?= base_url('home_siswa/kumpul_tugas') ?>" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-upload"></i> Kumpul Tugas
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tugas</th>
                            <th>Kursus</th>
                            <th>Deskripsi</th>
                            <th>Tenggat Waktu</th>
                            <th>File Tugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tugas) && is_array($tugas)): ?>
                            <?php $no = 1; foreach ($tugas as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item['nama_tugas'] ?? $item['judul_tugas'] ?? '') ?></td>
                                    <td><?= esc($item['nama_kursus'] ?? '–') ?></td>
                                    <td><?= esc(substr($item['deskripsi'] ?? '', 0, 60)) . (strlen($item['deskripsi'] ?? '') > 60 ? '...' : '') ?></td>
                                    <td><?= esc($item['tenggat_waktu'] ?? $item['deadline'] ?? '') ?></td>
                                    <td>
                                        <?php if (!empty($item['dokumen_tugas'])): ?>
                                            <a href="<?= base_url('kursus/tugas/' . ($item['dokumen_tugas'] ?? '')) ?>" target="_blank" class="btn btn-xs btn-info">
                                                <i class="fa fa-download"></i> File
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">–</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('home_siswa/tugas/detail/' . ($item['id_tugas'] ?? '')) ?>" class="btn btn-xs btn-primary">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                        <a href="<?= base_url('home_siswa/add_kumpul') ?>?id_tugas=<?= $item['id_tugas'] ?? '' ?>" class="btn btn-xs btn-success">
                                            <i class="fa fa-upload"></i> Kumpulkan
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data tugas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
