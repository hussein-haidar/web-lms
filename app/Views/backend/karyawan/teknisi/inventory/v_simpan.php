<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Inventory</h3>
            
            <div class="pull-right" style="display: flex; gap: 10px; align-items: center;">
                <!-- Filter Kondisi -->
                <div class="form-group" style="margin-bottom: 0;">
                    <select id="filterKondisi" class="form-control input-sm" style="width: auto;">
                        <option value="">-- Semua Kondisi --</option>
                        <option value="baik" <?= (isset($filter) && $filter == 'baik') ? 'selected' : '' ?>>Baik</option>
                        <option value="rusak_ringan" <?= (isset($filter) && $filter == 'rusak_ringan') ? 'selected' : '' ?>>Rusak Ringan</option>
                        <option value="rusak_berat" <?= (isset($filter) && $filter == 'rusak_berat') ? 'selected' : '' ?>>Rusak Berat</option>
                    </select>
                </div>

                <!-- Tombol Tambah Inventory -->
                <a href="<?= base_url('home_karyawan/add_inventory') ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> Tambah Inventory
                </a>

                <!-- Tombol Data Dihapus -->
                <a href="<?= base_url('home_karyawan/data_dihapus_inventory') ?>" class="btn btn-sm btn-secondary">
                    Lihat Data Dihapus
                </a>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <?php if (isset($filter) && $filter): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><i class="fa fa-filter"></i> Filter Aktif:</strong>
                    Menampilkan inventory dengan kondisi <strong><?= str_replace('_', ' ', $filter) ?></strong>.
                    <a href="<?= base_url('home_karyawan/inventory') ?>" class="alert-link">Hapus filter</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            <th>Tgl Perbaikan</th>
                            <th>Tgl Pengecekan</th>
                            <th>Kondisi</th>
                            <th>ID Karyawan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($inventory) && is_array($inventory)): ?>
                            <?php $no = 1;
                            foreach ($inventory as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= esc($item['nama_barang'] ?? '') ?></strong></td>
                                    <td><?= esc($item['jumlah_barang'] ?? '0') ?></td>
                                    <td><?= !empty($item['tanggal_masuk']) ? date('d-m-Y', strtotime($item['tanggal_masuk'])) : '-' ?></td>
                                    <td><?= !empty($item['tanggal_keluar']) ? date('d-m-Y', strtotime($item['tanggal_keluar'])) : '-' ?></td>
                                    <td><?= !empty($item['tanggal_perbaikan']) ? date('d-m-Y', strtotime($item['tanggal_perbaikan'])) : '-' ?></td>
                                    <td><?= !empty($item['tanggal_pengecekan']) ? date('d-m-Y H:i', strtotime($item['tanggal_pengecekan'])) : '-' ?></td>
                                    <td>
                                        <?php 
                                        $kondisi_class = '';
                                        $kondisi_text = '';
                                        switch($item['kondisi'] ?? '') {
                                            case 'baik':
                                                $kondisi_class = 'success';
                                                $kondisi_text = 'Baik';
                                                break;
                                            case 'rusak_ringan':
                                                $kondisi_class = 'warning';
                                                $kondisi_text = 'Rusak Ringan';
                                                break;
                                            case 'rusak_berat':
                                                $kondisi_class = 'danger';
                                                $kondisi_text = 'Rusak Berat';
                                                break;
                                            default:
                                                $kondisi_class = 'default';
                                                $kondisi_text = '-';
                                        }
                                        ?>
                                        <span class="label label-<?= $kondisi_class ?>">
                                            <?= $kondisi_text ?>
                                        </span>
                                    </td>
                                    <td><?= esc($item['id_karyawan'] ?? '') ?></td>
                                    <td>
                                        <a href="<?= base_url('home_karyawan/edit_inventory/' . ($item['id_simpan'] ?? '')) ?>"
                                            class="btn btn-xs btn-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-xs delete-btn"
                                            data-id="<?= $item['id_simpan'] ?>"
                                            data-nama="<?= esc($item['nama_barang']) ?>"
                                            title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a href="<?= base_url('home_karyawan/detail_inventory/' . ($item['id_simpan'] ?? '')) ?>"
                                            class="btn btn-info btn-xs" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data inventory.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter Kondisi
        const filterSelect = document.getElementById('filterKondisi');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const filterValue = this.value;
                if (filterValue) {
                    window.location.href = '<?= base_url('home_karyawan/inventory') ?>?filter=' + filterValue;
                } else {
                    window.location.href = '<?= base_url('home_karyawan/inventory') ?>';
                }
            });
        }

        // Delete Button
        const deleteButtons = document.querySelectorAll('.delete-btn');
        if (deleteButtons.length > 0) {
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    Swal.fire({
                        title: 'Hapus Inventory?',
                        html: `Yakin hapus barang <strong>${nama}</strong>?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6'
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url('home_karyawan/deleted_inventory/') ?>' + id;
                        }
                    });
                });
            });
        }
    });
</script>

<?= $this->endSection() ?>