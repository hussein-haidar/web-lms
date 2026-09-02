<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-folder"></i> Data <?= $title2 ?>
            </h3>

            <!-- Filter dan Tombol -->
            <div class="box-tools pull-right">
                <div class="form-inline">
                    <?php if (isset($filterConfig['nama_program'])): ?>
                        <select id="filter_nama_program"
                            class="form-control input-sm"
                            onchange="applyFilter('nama_program', this.value)"
                            style="width: 220px; margin-right: 5px;">
                            <option value="">-- Pilih Jenis Kelas --</option>
                            <?php foreach ($filterConfig['nama_program']['options'] as $opt): ?>
                                <?php
                                $val = $opt['value'] ?? $opt[$filterConfig['nama_program']['column']] ?? '';
                                ?>
                                <option value="<?= esc($val) ?>"
                                    <?= (isset($filters['nama_program']) && $filters['nama_program'] == $val) ? 'selected' : '' ?>>
                                    <?= esc(ucfirst($val)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <!-- Tombol Tambah -->
                    <a href="<?= base_url('home_superadmin/add_paket') ?>"
                        class="btn btn-sm btn-primary" style="margin-right: 5px;">
                        <i class="fa fa-plus-circle"></i> Tambah
                    </a>

                    <!-- Lihat Data Dihapus -->
                    <a href="<?= base_url('home_superadmin/paket_kursus_deleted') ?>"
                        class="btn btn-sm btn-secondary" style="margin-right: 5px;">
                        <i class="fa fa-trash"></i> Data Dihapus
                    </a>

                    <!-- Reset Button -->
                    <a href="<?= base_url('home_superadmin/paket_kursus') ?>"
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
            <?php if (!empty($filters['nama_program'])): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><i class="fa fa-filter"></i> Filter Aktif:</strong>
                    Program <?= esc(ucfirst($filters['nama_program'])) ?>.
                    <?php
                    $currentFilter = strtolower($filters['nama_program']);
                    if (in_array($currentFilter, ['kelas online', 'profesi 1 tahun'])) {
                        echo '<br><small><i class="fa fa-info-circle"></i> <strong>Hanya Paket A yang tersedia</strong> untuk jenis kelas ini.</small>';
                    }
                    ?>
                    <a href="<?= base_url('home_superadmin/paket_kursus') ?>"
                        class="alert-link"
                        style="margin-left:10px;">Reset</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <?php 
                // Check if any item has Paket B or C data
                $hasPaketB = false;
                $hasPaketC = false;
                if (!empty($paket) && is_array($paket)) {
                    foreach ($paket as $item) {
                        if (!empty($item['paket_b']) && !empty($item['deskripsi_b']) && !empty($item['harga_intensive'])) {
                            $hasPaketB = true;
                        }
                        if (!empty($item['paket_c']) && !empty($item['deskripsi_c']) && !empty($item['harga_private'])) {
                            $hasPaketC = true;
                        }
                    }
                }
                
                $currentFilter = $filters['nama_program'] ?? '';
                $hidePaketBC = in_array(strtolower($currentFilter), ['kelas online', 'profesi 1 tahun']);
                
                // Calculate colspan for empty state
                $colspan = 6; // No, Nama Paket, Jenis Kelas, Total Pertemuan, Durasi, Paket A, Aksi
                if ($hasPaketB && !$hidePaketBC) $colspan++;
                if ($hasPaketC && !$hidePaketBC) $colspan++;
                ?>
                
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Jenis Kelas</th>
                            <th>Total Pertemuan</th>
                            <th>Durasi</th>
                            <th>Paket A (Reguler)</th>
                            <?php if ($hasPaketB && !$hidePaketBC): ?>
                                <th>Paket B (Intensive)</th>
                            <?php endif; ?>
                            <?php if ($hasPaketC && !$hidePaketBC): ?>
                                <th>Paket C (Private)</th>
                            <?php endif; ?>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($paket) && is_array($paket)): ?>
                            <?php $no = 1;
                            foreach ($paket as $item): ?>
                                <?php
                                // Filter condition: skip items with null data for kelas online and profesi 1 tahun
                                $jenisKelas = strtolower($item['nama_program'] ?? '');
                                $shouldSkip = false;

                                if (in_array($jenisKelas, ['kelas online', 'profesi 1 tahun'])) {
                                    // Check if essential data is null/empty
                                    if (empty($item['paket_a']) || empty($item['deskripsi_a']) || empty($item['harga_reguler'])) {
                                        $shouldSkip = true;
                                    }
                                }

                                // Skip this item if it should be filtered out
                                if ($shouldSkip) {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= esc($item['nama_paket']) ?></strong>
                                    </td>
                                    <td>
                                        <?php
                                        $isOnlineOrProfesi = ($jenisKelas === 'kelas online' || $jenisKelas === 'profesi 1 tahun');
                                        $badgeColor = $isOnlineOrProfesi ? 'bg-aqua' : 'bg-maroon';
                                        $icon = $isOnlineOrProfesi ? 'wifi' : 'desktop';
                                        ?>
                                        <span class="label <?= $badgeColor ?>" style="font-size: 11px;">
                                            <i class="fa fa-<?= $icon ?>"></i>
                                            <?= esc(ucfirst($item['nama_program'] ?? '')) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($item['total_pertemuan']) ?>x</td>
                                    <td><?= esc($item['durasi_per_pertemuan_jam']) ?> jam</td>
                                    <td>
                                        <div style="min-width: 200px;">
                                            <strong style="color: #3498db;"><?= esc($item['paket_a']) ?></strong><br>
                                            <small style="color: #666;">
                                                <?php
                                                $descA = explode("\n", $item['deskripsi_a'] ?? '');
                                                $shortDesc = substr(implode(' ', array_slice($descA, 0, 2)), 0, 50);
                                                echo esc($shortDesc) . (strlen($shortDesc) >= 50 ? '...' : '');
                                                ?>
                                            </small><br>
                                            <strong style="color: #3498db;">Rp <?= number_format($item['harga_reguler'] ?? 0, 0, ',', '.') ?></strong>
                                        </div>
                                    </td>
                                    <?php if ($hasPaketB && !$hidePaketBC): ?>
                                        <td>
                                            <?php if (!empty($item['paket_b']) && !empty($item['deskripsi_b']) && !empty($item['harga_intensive'])): ?>
                                                <div style="min-width: 200px;">
                                                    <strong style="color: #f39c12;"><?= esc($item['paket_b']) ?></strong><br>
                                                    <small style="color: #666;">
                                                        <?php
                                                        $descB = explode("\n", $item['deskripsi_b'] ?? '');
                                                        $shortDesc = substr(implode(' ', array_slice($descB, 0, 2)), 0, 50);
                                                        echo esc($shortDesc) . (strlen($shortDesc) >= 50 ? '...' : '');
                                                        ?>
                                                    </small><br>
                                                    <strong style="color: #f39c12;">Rp <?= number_format($item['harga_intensive'] ?? 0, 0, ',', '.') ?></strong>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if ($hasPaketC && !$hidePaketBC): ?>
                                        <td>
                                            <?php if (!empty($item['paket_c']) && !empty($item['deskripsi_c']) && !empty($item['harga_private'])): ?>
                                                <div style="min-width: 200px;">
                                                    <strong style="color: #e74c3c;"><?= esc($item['paket_c']) ?></strong><br>
                                                    <small style="color: #666;">
                                                        <?php
                                                        $descC = explode("\n", $item['deskripsi_c'] ?? '');
                                                        $shortDesc = substr(implode(' ', array_slice($descC, 0, 2)), 0, 50);
                                                        echo esc($shortDesc) . (strlen($shortDesc) >= 50 ? '...' : '');
                                                        ?>
                                                    </small><br>
                                                    <strong style="color: #e74c3c;">Rp <?= number_format($item['harga_private'] ?? 0, 0, ',', '.') ?></strong>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                            <a href="<?= base_url('home_superadmin/edit_paket/' . $item['id_paket']) ?>" class="btn btn-warning btn-sm btn-block">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm delete-btn btn-block"
                                                data-id="<?= $item['id_paket'] ?>"
                                                data-nama="<?= esc($item['nama_paket']) ?>">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= $colspan ?>" class="text-center" style="padding: 40px;">
                                    <i class="fa fa-folder-open-o fa-3x text-muted"></i><br>
                                    <p class="mt-2">Belum ada data paket <?= !empty($filters['nama_program']) ? 'untuk program <b>' . esc(ucfirst($filters['nama_program'])) . '</b>' : '' ?>.</p>
                                    <?php if (!empty($filters['nama_program'])): ?>
                                        <a href="<?= base_url('home_superadmin/paket_kursus') ?>" class="btn btn-sm btn-default">Tampilkan Semua</a>
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Delete button functionality
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const deleteUrl = `<?= base_url("home_superadmin/deleted_paket/") ?>${id}`;

            Swal.fire({
                title: 'Hapus Paket?',
                html: `Yakin hapus paket <strong>${nama}</strong>?`,
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
    });

    // Filter function for program type
    function applyFilter(key, value) {
        let url = new URL(window.location.href);
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
        window.location.href = url.toString();
    }
</script>

<?= $this->endSection() ?>