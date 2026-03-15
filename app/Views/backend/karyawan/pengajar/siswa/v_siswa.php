<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Siswa yang Saya Ajarkan</h3>

            <div class="pull-right" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <!-- Filter Nama Program -->
                <select id="filterProgram" class="form-control input-sm" style="width: 180px;">
                    <option value="">-- Semua Program --</option>
                    <?php if (!empty($program_list)): ?>
                        <?php foreach ($program_list as $id_program => $nama_program): ?>
                            <option value="<?= esc($id_program) ?>" <?= ($filter_program ?? '') === $id_program ? 'selected' : '' ?>>
                                <?= esc($nama_program) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <a href="<?= base_url('home_karyawan/siswa') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-refresh"></i> Reset
                </a>

                <?php if (session()->get('level') == "staf_admin"): ?>
                    <a href="<?= base_url('home_karyawan/add_siswa') ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Tambah Siswa
                    </a>
                    <!-- tombol lain tetap -->
                <?php endif; ?>
            </div>
        </div>

        <div class="box-body">

            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible"><?= session()->getFlashdata('pesan') ?></div>
            <?php endif; ?>

            <?php if (empty($grup_siswa)): ?>
                <div class="alert alert-info text-center">
                    Belum ada siswa terdaftar di kelas Anda.
                </div>
            <?php endif; ?>

            <!-- Accordion / Panel dinamis per program -->
            <?php 
            $filter_program = $filter_program ?? ''; // Add default value
            foreach ($grup_siswa as $id_program => $siswaList): 
            ?>
                <?php
                $program_info = [
                    'nama' => $program_list[$id_program] ?? 'Unknown Program',
                    'total' => $totals[$id_program] ?? 0
                ];
                $panelClass = 'primary';
                $icon = 'fa-graduation-cap';
                $collapseId = 'collapse_' . md5($id_program);
                $expanded = ($filter_program === $id_program || empty($filter_program)) ? 'in' : '';
                ?>
                <div class="panel panel-<?= $panelClass ?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#<?= $collapseId ?>" aria-expanded="<?= $expanded ? 'true' : 'false' ?>">
                                <i class="fa <?= $icon ?>"></i>
                                <?= esc($program_info['nama']) ?>
                                <span class="badge badge-<?= $panelClass ?> pull-right"><?= $program_info['total'] ?? 0 ?></span>
                            </a>
                        </h4>
                    </div>
                    <div id="<?= $collapseId ?>" class="panel-collapse collapse <?= $expanded ?>">
                        <div class="panel-body">
                            <?php if (!empty($siswaList)): ?>
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>NIS</th>
                                            <th>Nama Lengkap</th>
                                            <th>Status</th>
                                            <th>Paket Kursus</th>
                                            <th>No Telepon</th>
                                            <th>Tgl Daftar</th>
                                                                                  </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($siswaList as $item): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <img src="<?= !empty($item['foto_profil']) ? base_url('fotosiswa/' . $item['foto_profil']) : base_url('template/dist/img/user2-160x160.jpg') ?>"
                                                        class="img-circle" width="50" height="50" alt="Foto">
                                                </td>
                                                <td><?= esc($item['nis'] ?? '-') ?></td>
                                                <td><?= esc($item['nama_lengkap'] ?? '-') ?></td>
                                                <td>
                                                    <?php 
                                                    $status_class = ($item['status_aktif'] ?? '') === 'aktif' ? 'success' : 'danger';
                                                    $status_text = ($item['status_aktif'] ?? '') === 'aktif' ? 'Aktif' : 'Non-aktif';
                                                    ?>
                                                    <span class="label label-<?= $status_class ?>"><?= esc($status_text) ?></span>
                                                </td>
                                                <td>
                                                    <?= !empty($item['paket_terdaftar'])
                                                        ? esc($item['paket_terdaftar']) . ' <small>(' . ($item['jumlah_pendaftaran'] ?? 0) . ')</small>'
                                                        : '<span class="text-muted">Belum daftar paket</span>' ?>
                                                </td>
                                                <td><?= esc($item['no_telepon'] ?? '-') ?></td>
                                                <td><?= esc($item['tanggal_daftar'] ?? '-') ?></td>
                                                                                          </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info text-center">Tidak ada siswa untuk program ini.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- JavaScript untuk Filter Program -->
<script>
$(document).ready(function() {
    // Filter Program
    $('#filterProgram').on('change', function() {
        var selectedProgram = $(this).val();
        var currentUrl = new URL(window.location);
        
        if (selectedProgram) {
            currentUrl.searchParams.set('filter_program', selectedProgram);
        } else {
            currentUrl.searchParams.delete('filter_program');
        }
        
        window.location.href = currentUrl.toString();
    });
    
</script>

<?= $this->endSection() ?>