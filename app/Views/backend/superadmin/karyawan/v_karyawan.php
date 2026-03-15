<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box">
            <div class="box-header with-border">
                <i class="fa fa-folder"></i> Data <?= $title2 ?>
                <div class="box-tools pull-right">

                    <!-- ✅ FILTER SECTION -->
                    <div class="pull-right">
                        <form id="filterForm" class="form-inline">
                            <!-- Filter Status -->
                            <select name="status" id="filterStatus" class="form-control input-sm mr-2" onchange="applyFilter()">
                                <option value="">Semua Status</option>
                                <option value="aktif" <?= ($filter_status ?? '') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= ($filter_status ?? '') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>

                            <!-- Filter Level -->
                            <select name="level" id="filterLevel" class="form-control input-sm mr-2" onchange="applyFilter()">
                                <option value="">Semua Level</option>
                                <option value="staf_admin" <?= ($filter_level ?? '') === 'staf_admin' ? 'selected' : '' ?>>Staf Admin</option>
                                <option value="pengajar" <?= ($filter_level ?? '') === 'pengajar' ? 'selected' : '' ?>>Pengajar</option>
                                <option value="teknisi" <?= ($filter_level ?? '') === 'teknisi' ? 'selected' : '' ?>>Teknisi</option>
                            </select>

                            <a href="<?= base_url('home_superadmin/add_karyawan') ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-plus-circle"></i> Tambah Data
                            </a>

                            <!-- Lihat Data Dihapus -->
                            <a href="<?= base_url('home_superadmin/karyawan_deleted') ?>" class="btn btn-sm btn-secondary">
                                <i class="fa fa-trash"></i> Data Dihapus
                            </a>

                            <!-- Reset Filter -->
                            <a href="<?= base_url('home_superadmin/karyawan') ?>"
                                class="btn btn-sm btn-default"
                                onclick="clearFilterStorage(); return true;"
                                title="Reset semua filter">
                                <i class="fa fa-refresh"></i> Reset
                            </a>

                        </form>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Info Filter Aktif -->
                    <?php if (!empty($filter_status) || !empty($filter_level)): ?>
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong><i class="fa fa-filter"></i> Filter Aktif:</strong>
                            <?php
                            $activeFilters = [];
                            if (!empty($filter_status)) $activeFilters[] = "Status: <b>" . ucfirst($filter_status) . "</b>";
                            if (!empty($filter_level) && $filter_level !== 'all') $activeFilters[] = "Level: <b>" . ucfirst(str_replace('_', ' ', $filter_level)) . "</b>";
                            echo implode(", ", $activeFilters);
                            ?>
                            <a href="<?= base_url('home_superadmin/karyawan') ?>"
                                class="alert-link"
                                style="margin-left:10px;"
                                onclick="clearFilterStorage(); return true;">
                                Reset Filter
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="8%">Foto</th>
                                        <th width="20%">Nama Lengkap</th>
                                        <th width="12%">NIP</th>
                                        <th width="15%">Email</th>
                                        <th width="12%">No Telepon</th>
                                        <th width="10%">Level</th>
                                        <th width="8%">Status</th>
                                        <th width="12%">Tanggal Daftar</th>
                                        <th width="8%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($kn) && is_array($kn)): ?>
                                        <?php $no = 1;
                                        foreach ($kn as $item): ?>
                                            <?php if (!is_array($item)) continue; ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class="text-center">
                                                    <img src="<?= base_url('fotoprofil/' . ($item['foto_profil'] ?? 'default.png')) ?>"
                                                        class="img-circle" width="40" height="40" alt="Foto"
                                                        onerror="this.src='<?= base_url('template/dist/img/user2-160x160.jpg') ?>'">
                                                </td>
                                                <td><?= esc($item['nama_lengkap'] ?? '') ?></td>
                                                <td><?= esc($item['nip'] ?? '') ?></td>
                                                <td><?= esc($item['email'] ?? '') ?></td>
                                                <td><?= esc($item['no_telepon'] ?? '') ?></td>
                                                <td class="text-center">
                                                    <span class="badge 
                                                <?php
                                                switch ($item['level'] ?? '') {
                                                    case 'staf_admin':
                                                        echo 'bg-info';
                                                        break;
                                                    case 'pengajar':
                                                        echo 'bg-success';
                                                        break;
                                                    case 'teknisi':
                                                        echo 'bg-warning text-dark';
                                                        break;
                                                    default:
                                                        echo 'bg-secondary';
                                                }
                                                ?>">
                                                        <?= esc(ucwords(str_replace('_', ' ', $item['level'] ?? ''))) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($item['status'])): ?>
                                                        <span class="label label-<?= ($item['status'] == 'aktif') ? 'success' : 'danger' ?>">
                                                            <?= ucfirst($item['status']) ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="label label-default">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center"><?= esc(date('d/m/Y', strtotime($item['tanggal_daftar'] ?? ''))) ?></td>
                                                <td class="text-center" style="padding: 8px 5px;">
                                                    <!-- ✅ Edit Button -->
                                                    <a href="<?= base_url('home_superadmin/edit_karyawan/' . ($item['id_karyawan'] ?? '')) ?>"
                                                        class="btn btn-xs btn-warning"
                                                        title="Edit"
                                                        style="margin-bottom: 5px; display: inline-block; min-width: 55px;">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <!-- ✅ Delete Button -->
                                                    <button class="btn btn-danger btn-xs deleted-btn"
                                                        data-id="<?= $item['id_karyawan'] ?>"
                                                        data-nama="<?= esc($item['nama_lengkap'] ?? 'Karyawan') ?>"
                                                        title="Hapus"
                                                        style="display: inline-block; min-width: 55px;">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">Belum ada data karyawan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Apply filter - langsung redirect dengan URL params
    function applyFilter() {
        const status = document.getElementById('filterStatus').value;
        const level = document.getElementById('filterLevel').value;

        let url = new URL(window.location.href);

        // Update atau hapus params
        status ? url.searchParams.set('status', status) : url.searchParams.delete('status');
        level ? url.searchParams.set('level', level) : url.searchParams.delete('level');

        // Redirect langsung (tanpa localStorage)
        window.location.href = url.toString();
    }

    // Reset filter
    function clearFilterStorage() {
        window.location.href = '<?= base_url('home_superadmin/karyawan') ?>';
    }

    // Confirmation Dialog untuk Delete
    document.addEventListener('DOMContentLoaded', function() {
        // Sync dropdown dengan URL params
        const urlParams = new URLSearchParams(window.location.search);

        const filterStatus = document.getElementById('filterStatus');
        const filterLevel = document.getElementById('filterLevel');

        if (filterStatus && urlParams.get('status')) {
            filterStatus.value = urlParams.get('status');
        }

        if (filterLevel && urlParams.get('level')) {
            filterLevel.value = urlParams.get('level');
        }

        // Attach delete listeners
        attachDeleteListeners();
    });

    // Delete button dengan SweetAlert
    function attachDeleteListeners() {
        document.querySelectorAll('.deleted-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                // Preserve filter params
                const filterParams = new URLSearchParams(window.location.search).toString();
                const deleteUrl = '<?= base_url("home_superadmin/deleted_karyawan/") ?>' + id +
                    (filterParams ? '?' + filterParams : '');

                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    html: `
                        <p>Apakah Anda yakin ingin menghapus data karyawan:</p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 10px 0;">
                            <strong>${nama}</strong>
                        </div>
                        <p style="color: #6c757d; font-size: 14px;">
                            <i class="fa fa-info-circle"></i> Data akan dihapus secara <strong>temporary</strong> dan bisa dipulihkan kembali.
                        </p>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
                    cancelButtonText: '<i class="fa fa-times"></i> Batal',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    }
</script>

<?= $this->endSection() ?>