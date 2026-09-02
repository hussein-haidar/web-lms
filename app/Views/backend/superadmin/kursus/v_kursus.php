<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-folder"></i> Data <?= $title2 ?>

            <?php $level_user = session()->get('level'); ?>

            <!-- Filter dan Tombol - Horizontal Layout -->
            <div class="box-tools pull-right">
                <div class="form-inline">
                    <?php if ($level_user == 'superadmin'): ?>

                        <?php foreach ($filterConfig as $key => $cfg): ?>
                            <select id="filter_<?= esc($key) ?>"
                                class="form-control input-sm"
                                onchange="applyFilter('<?= esc($key) ?>', this.value)"
                                style="width: 130px; margin-right: 5px;">
                                <option value="">-- Pilih <?= esc($cfg['label']) ?> --</option>
                                <?php foreach ($cfg['options'] as $opt): ?>
                                    <?php $val = $opt['value'] ?? $opt[$cfg['column']] ?? ''; ?>
                                    <?php $label = $opt['label'] ?? $opt['nama_program'] ?? $val; ?>
                                    <option value="<?= esc($val) ?>"
                                        <?= (isset($filters[$key]) && $filters[$key] == $val) ? 'selected' : '' ?>>
                                        <?= esc(ucfirst($label)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endforeach; ?>

                        <!-- ✅ Tombol Tambah: URL BERSIH (tanpa filter params) -->
                        <a href="<?= base_url('home_superadmin/add_kursus') ?>"
                            class="btn btn-sm btn-primary" style="margin-right: 5px;">
                            <i class="fa fa-plus-circle"></i> Tambah
                        </a>

                        <!-- ✅ Lihat Data Dihapus -->
                        <a href="<?= base_url('home_superadmin/kursus_deleted') ?>"
                            class="btn btn-sm btn-secondary" style="margin-right: 5px;">
                            <i class="fa fa-trash"></i> Data Dihapus
                        </a>

                        <!-- ✅ Reset Button: Link langsung ke URL bersih -->
                        <a href="<?= base_url('home_superadmin/kursus') ?>"
                            class="btn btn-sm btn-default">
                            <i class="fa fa-refresh"></i> Reset
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php $errors = session()->getFlashdata('errors');
            if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
                </div>
            <?php endif; ?>

            <!-- Info Filter Aktif -->
            <?php if (!empty($filters['program']) || !empty($filters['nama_program']) || !empty($filters['search'])): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><i class="fa fa-filter"></i> Filter Aktif:</strong>
                    <?php
                    $activeFilters = [];
                    if (!empty($filters['program'])) $activeFilters[] = "Program: <b>" . ucfirst($filters['program']) . "</b>";
                    if (!empty($filters['nama_program'])) $activeFilters[] = "Jenis Kelas: <b>" . ucfirst($filters['nama_program']) . "</b>";
                                    echo implode(", ", $activeFilters);
                    ?>
                    <a href="<?= base_url('home_superadmin/kursus') ?>"
                        class="alert-link"
                        style="margin-left:10px;">Reset</a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-gray">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="18%">Program Kursus</th>
                            <th width="18%">Judul Kursus</th>
                            <th width="8%" class="text-center">Gambar Utama</th>
                            <th width="12%">Pengajar</th>
                            <th width="7%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Tanggal Dibuat</th>
                            <?php if ($level_user == 'superadmin'): ?>
                                <th width="9%" class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kursus) && is_array($kursus)): ?>
                            <?php $no = 1;
                            foreach ($kursus as $item): ?>
                                <?php if (!is_array($item)) continue; ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= esc($item['nama_program'] ?? '–') ?></td>
                                    <td>
                                        <?= esc($item['nama_kursus'] ?? '') ?>
                                                                         </td>

                                    <!-- GAMBAR UTAMA -->
                                    <td class="text-center">
                                        <?php if (!empty($item['gambar_utama'])): ?>
                                            <a href="<?= base_url('kursus/materi/' . $item['gambar_utama']) ?>" target="_blank" title="Lihat gambar penuh">
                                                <img src="<?= base_url('kursus/materi/' . $item['gambar_utama']) ?>"
                                                    class="img-thumbnail img-responsive" width="50" height="50" alt="Gambar utama"
                                                    style="object-fit: cover; border: 1px solid #ddd;">
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fa fa-image fa-2x"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($item['nama_pengajar'] ?? '–') ?></td>
                                    <td class="text-center">
                                        <?php if (isset($item['status'])): ?>
                                            <span class="label label-<?= ($item['status'] == 'aktif') ? 'success' : 'danger' ?>">
                                                <?= ucfirst($item['status']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="label label-default">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center small"><?= esc(date('d/m/Y', strtotime($item['tanggal_dibuat'] ?? ''))) ?></td>

                                    <?php if ($level_user == 'superadmin'): ?>
                                        <td class="text-center">
                                            <!-- ✅ Edit Button: URL BERSIH (tanpa filter params) -->
                                            <a href="<?= base_url('home_superadmin/edit_kursus/' . $item['id_kursus']) ?>"
                                                class="btn btn-xs btn-warning"
                                                title="Edit"
                                                style="margin-bottom: 5px; display: inline-block;">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                            <!-- ✅ Modul Button -->
                                            <a href="<?= base_url('home_superadmin/modul/' . $item['id_kursus']) ?>"
                                                class="btn btn-xs btn-info"
                                                title="Kelola Modul"
                                                style="margin-bottom: 5px; display: inline-block;">
                                                <i class="fa fa-book"></i> Modul
                                            </a>

                                            <!-- ✅ Add Modul Button -->
                                            <a href="<?= base_url('home_superadmin/add_modul/' . $item['id_kursus']) ?>"
                                                class="btn btn-xs btn-success"
                                                title="Tambah Modul Baru"
                                                style="margin-bottom: 5px; display: inline-block;">
                                                <i class="fa fa-plus"></i> +Modul
                                            </a>

                                            <!-- ✅ Delete Button: Redirect ke list TANPA filter -->
                                            <button class="btn btn-danger btn-xs deleted-btn"
                                                data-id="<?= $item['id_kursus'] ?>"
                                                data-nama="<?= esc($item['nama_kursus'] ?? 'kursus') ?>"
                                                title="Hapus">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= ($level_user == 'superadmin') ? '12' : '11' ?>" class="text-center">
                                    <i class="fa fa-folder-open text-muted"></i> Belum ada data kursus.
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
    // ✅ Simple filter: langsung redirect dengan URL params (tanpa storage)
    function applyFilter(key, value) {
        let url = new URL(window.location.href);

        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }

        // Redirect langsung
        window.location.href = url.toString();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // 🗑️ Delete Confirmation: Redirect ke list TANPA filter
        document.querySelectorAll('.deleted-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                // ✅ URL delete redirect ke list bersih (tanpa filter params)
                const deleteUrl = `<?= base_url("home_superadmin/deleted_kursus/") ?>${id}`;

                Swal.fire({
                    title: 'Hapus kursus?',
                    html: `Yakin hapus <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    reverseButtons: true
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });

        // 🎬 Pause YouTube saat modal ditutup
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                const iframe = this.querySelector('iframe');
                if (iframe) iframe.src = iframe.src;
            });
        });
    });
</script>

<?= $this->endSection() ?>