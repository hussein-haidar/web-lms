<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Siswa Kursus</h3>

            <!-- Filter dan Tombol -->
            <div class="box-tools pull-right">
                <div class="form-inline">
                    <?php if (isset($filterConfig['status'])): ?>
                        <select id="filter_status"
                            class="form-control input-sm"
                            onchange="applyFilter('status', this.value)"
                            style="width: 220px; margin-right:5px;">
                            <option value="">-- Pilih Status --</option>
                            <?php foreach ($filterConfig['status']['options'] as $opt): ?>
                                <?php
                                $val = $opt['value'] ?? $opt[$filterConfig['status']['column']] ?? '';
                                ?>
                                <option value="<?= esc($val) ?>"
                                    <?= (isset($filters['status']) && $filters['status'] == $val) ? 'selected' : '' ?>>
                                    <?= esc(ucfirst($val)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <!-- Tombol Tambah -->
                    <a href="<?= base_url('home_karyawan/add_siswa') ?>"
                        class="btn btn-sm btn-primary" style="margin-right:5px;">
                        <i class="fa fa-plus-circle"></i> Tambah
                    </a>

                    <!-- Reset Button -->
                    <a href="<?= base_url('home_karyawan/siswa') ?>"
                        class="btn btn-sm btn-default">
                        <i class="fa fa-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?= esc($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- INFO FILTER AKTIF -->
            <?php if (!empty($filters['status'])): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fa fa-filter"></i> Filter Aktif:</strong>
                    Status <?= esc(ucfirst($filters['status'])) ?>.
                    <a href="<?= base_url('home_karyawan/siswa') ?>"
                        class="alert-link"
                        style="margin-left:10px;">Reset</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="8%">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>No Telepon</th>
                            <th>Paket Kursus</th>
                            <th>Info LPK</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($siswa) && is_array($siswa)): ?>
                            <?php $no = 1;
                            foreach ($siswa as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <img src="<?= !empty($item['foto_profil']) ? base_url('fotosiswa/' . $item['foto_profil']) : base_url('template/dist/img/user2-160x160.jpg') ?>"
                                            class="img-circle" width="40" height="40" alt="Foto">
                                    </td>
                                    <td><strong><?= esc($item['nama_lengkap']) ?></strong></td>
                                    <td><?= esc($item['no_telepon'] ?? '-') ?></td>
                                    <td>
                                        <?php if (!empty($item['nama_kursus'])): ?>
                                            <span class="label label-primary"><?= esc($item['nama_kursus']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Belum ada kursus</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['paket_terdaftar'])): ?>
                                            <small><?= esc($item['paket_terdaftar']) ?></small>
                                            <?php if (!empty($item['jumlah_pendaftaran'])): ?>
                                                <br><span class="text-muted">(<?= $item['jumlah_pendaftaran'] ?> Paket)</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['total_bayar'])): ?>
                                            <strong>Rp <?= number_format($item['total_bayar'], 0, ',', '.') ?></strong>
                                        <?php else: ?>
                                            <span class="text-muted">Rp 0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $status = strtolower($item['status'] ?? 'aktif');
                                        if ($status == 'aktif'): ?>
                                            <span class="label label-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($item['tanggal_daftar'])) ?></td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                            <a href="<?= base_url('home_karyawan/detail_siswa/' . $item['id_siswa']) ?>" class="btn btn-info btn-sm btn-block">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>
                                            <a href="<?= base_url('home_karyawan/edit_siswa/' . $item['id_siswa']) ?>" class="btn btn-warning btn-sm btn-block">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm delete-btn btn-block"
                                                data-id="<?= $item['id_siswa'] ?>"
                                                data-nama="<?= esc($item['nama_lengkap']) ?>">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center" style="padding: 40px;">
                                    <i class="fa fa-folder-open-o fa-3x text-muted"></i><br>
                                    <p class="mt-2">Belum ada data siswa <?= !empty($filters['status']) ? 'untuk status <b>' . esc(ucfirst($filters['status'])) . '</b>' : '' ?>.</p>
                                    <?php if (!empty($filters['status'])): ?>
                                        <a href="<?= base_url('home_karyawan/siswa') ?>" class="btn btn-sm btn-default">Tampilkan Semua</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- DataTables JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        // Delete button functionality
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const deleteUrl = `<?= base_url("home_karyawan/deleted_siswa/") ?>${id}`;

            Swal.fire({
                title: 'Hapus Siswa?',
                html: `Yakin hapus siswa <strong>${nama}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });

        // Filter function for status
        function applyFilter(key, value) {
            let url = new URL(window.location.href);
            if (value) {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
            window.location.href = url.toString();
        }
    });
</script>

<?= $this->endSection() ?>