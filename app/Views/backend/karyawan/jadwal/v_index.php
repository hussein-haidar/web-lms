<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-calendar"></i> Daftar Jadwal / Kalender Akademik
            <div class="box-tools pull-right">
                <a href="<?= base_url('staf/jadwal/create') ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Jadwal
                </a>
            </div>
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

            <?php if (!empty($jadwal)): ?>
            <table id="jadwalTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Judul</th>
                        <th>Kursus</th>
                        <th>Pengajar</th>
                        <th>Periode</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $i => $j): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:<?= esc($j['warna'] ?: '#3c8dbc') ?>;margin-right:5px;"></span>
                            <strong><?= esc($j['judul']) ?></strong>
                            <?php if (!empty($j['deskripsi'])): ?>
                                <br><small class="text-muted"><?= esc(character_limiter($j['deskripsi'], 80)) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($j['nama_kursus'] ?? 'Umum') ?></td>
                        <td><?= esc($j['nama_pengajar'] ?? '-') ?></td>
                        <td>
                            <?= date('d M Y', strtotime($j['tanggal_mulai'])) ?>
                            s.d.
                            <?= date('d M Y', strtotime($j['tanggal_selesai'])) ?>
                        </td>
                        <td><span class="label label-default"><?= esc(ucfirst($j['tipe'])) ?></span></td>
                        <td>
                            <?php if ($j['status'] === 'aktif'): ?>
                                <span class="label label-success">Aktif</span>
                            <?php else: ?>
                                <span class="label label-danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url('staf/jadwal/edit/' . $j['id_jadwal']) ?>" class="btn btn-warning btn-xs" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="<?= base_url('staf/jadwal/toggle/' . $j['id_jadwal']) ?>" class="btn btn-<?= $j['status'] === 'aktif' ? 'danger' : 'success' ?> btn-xs"
                                   title="<?= $j['status'] === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' ?>"
                                   onclick="return confirm('Ubah status jadwal ini?')">
                                    <i class="fa fa-power-off"></i>
                                </a>
                                <a href="<?= base_url('staf/jadwal/delete/' . $j['id_jadwal']) ?>" class="btn btn-danger btn-xs" title="Hapus"
                                   onclick="return confirm('Hapus jadwal ini? Tindakan tidak dapat dibatalkan.')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> Belum ada jadwal. Klik <strong>Tambah Jadwal</strong> untuk membuat jadwal baru.
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<script>
$(function () {
    $('#jadwalTable').DataTable({
        'responsive': true,
        'autoWidth': false
    });
});
</script>

<?= $this->endSection() ?>
