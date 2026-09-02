<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
            <?php if ($kursus_aktif): ?>
                Bank Soal - <?= esc($kursus_aktif['nama_kursus']) ?>
            <?php else: ?>
                Bank Soal (Semua Kursus)
            <?php endif; ?>
        </h3>
        <div class="box-tools pull-right">
            <?php if ($kursus_aktif): ?>
                <a href="<?= base_url('home_superadmin/add_bank_soal/' . $kursus_aktif['id_kursus']) ?>" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Tambah Soal
                </a>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fa fa-upload"></i> Import JSON
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="box-body">
        <!-- Filter by Kursus -->
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-4">
                <label>Filter Kursus:</label>
                <select id="filterKursus" class="form-control" onchange="window.location.href=this.value">
                    <option value="<?= base_url('home_superadmin/bank_soal') ?>" <?= !$kursus_aktif ? 'selected' : '' ?>>Semua Kursus</option>
                    <?php foreach ($kursus_list as $k): ?>
                        <option value="<?= base_url('home_superadmin/bank_soal/' . $k['id_kursus']) ?>" <?= ($kursus_aktif && $kursus_aktif['id_kursus'] == $k['id_kursus']) ? 'selected' : '' ?>>
                            <?= esc($k['nama_kursus']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if (!empty($stats)): ?>
            <div class="col-md-8">
                <div class="row">
                    <?php
                    $total_all = 0;
                    foreach ($stats as $s) $total_all += $s['jumlah'];
                    ?>
                    <div class="col-md-3">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-list"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Soal</span>
                                <span class="info-box-number"><?= $total_all ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                    $tipe_count = [];
                    foreach ($stats as $s) {
                        $tipe_label = str_replace('_', ' ', ucfirst($s['tipe_soal']));
                        echo '<div class="col-md-3"><div class="info-box bg-green"><span class="info-box-icon"><i class="fa fa-check"></i></span><div class="info-box-content"><span class="info-box-text">' . $tipe_label . '</span><span class="info-box-number">' . $s['jumlah'] . '</span></div></div></div>';
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <table id="soalTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Tipe</th>
                    <th>Pertanyaan</th>
                    <th>Kategori</th>
                    <th>Level</th>
                    <th>Bobot</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($soal)): ?>
                    <?php foreach ($soal as $idx => $s): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <?php
                                $tipe_colors = ['pilihan_ganda' => 'primary', 'essay' => 'warning', 'fill_blank' => 'info', 'matching' => 'purple', 'true_false' => 'success'];
                                $color = $tipe_colors[$s['tipe_soal']] ?? 'gray';
                                ?>
                                <span class="label label-<?= $color ?>"><?= str_replace('_', ' ', ucfirst($s['tipe_soal'])) ?></span>
                            </td>
                            <td><?= esc(substr($s['pertanyaan'], 0, 100)) ?>...</td>
                            <td><?= esc($s['kategori'] ?? '-') ?></td>
                            <td>
                                <?php
                                $level_badges = ['mudah' => 'success', 'sedang' => 'warning', 'sulit' => 'danger'];
                                ?>
                                <span class="label label-<?= $level_badges[$s['level']] ?? 'default' ?>"><?= ucfirst($s['level']) ?></span>
                            </td>
                            <td><?= $s['bobot'] ?></td>
                            <td>
                                <a href="<?= base_url('home_superadmin/edit_bank_soal/' . $s['id_soal']) ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('home_superadmin/delete_bank_soal/' . $s['id_soal']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus soal ini?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('home_superadmin/import_bank_soal') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_kursus" value="<?= $kursus_aktif['id_kursus'] ?? '' ?>">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Import Soal dari JSON</h4>
                </div>
                <div class="modal-body">
                    <p>Format JSON: Array of objects dengan keys: <code>pertanyaan, tipe_soal, jawaban_benar, pilihan (objek), bobot, level</code></p>
                    <textarea name="json_data" class="form-control" rows="15" placeholder='[{"pertanyaan":"...","tipe_soal":"pilihan_ganda","pilihan":{"A":"...","B":"...","C":"...","D":"..."},"jawaban_benar":"A","bobot":1,"level":"sedang"}]'></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#soalTable').DataTable({
        "pageLength": 25,
        "order": [[0, "asc"]]
    });
});
</script>

<?= $this->endSection() ?>
