<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Materi - <?= esc($modul['nama_modul']); ?></h3>

            <?php $level_user = session()->get('level'); ?>

            <!-- Filter dan Tombol - Horizontal Layout -->
            <div class="box-tools pull-right">
                <div class="form-inline">
                    <?php if ($level_user == 'superadmin'): ?>

                                            <!-- Filter Tipe -->
                        <select id="filter_tipe" 
                                class="form-control input-sm"
                                onchange="applyFilter('tipe', this.value)"
                                style="width: 100px; margin-right: 5px;">
                            <option value="">-- Tipe --</option>
                            <option value="youtube" <?= (isset($filters['tipe']) && $filters['tipe'] == 'youtube') ? 'selected' : '' ?>>YouTube</option>
                            <option value="zoom" <?= (isset($filters['tipe']) && $filters['tipe'] == 'zoom') ? 'selected' : '' ?>>Zoom</option>
                            <option value="quiz" <?= (isset($filters['tipe']) && $filters['tipe'] == 'quiz') ? 'selected' : '' ?>>Quiz</option>
                            <option value="text" <?= (isset($filters['tipe']) && $filters['tipe'] == 'text') ? 'selected' : '' ?>>Text</option>
                        </select>

                        <!-- Filter Preview -->
                        <select id="filter_preview" 
                                class="form-control input-sm"
                                onchange="applyFilter('preview', this.value)"
                                style="width: 100px; margin-right: 5px;">
                            <option value="">-- Preview --</option>
                            <option value="1" <?= (isset($filters['preview']) && $filters['preview'] == '1') ? 'selected' : '' ?>>Ya</option>
                            <option value="0" <?= (isset($filters['preview']) && $filters['preview'] == '0') ? 'selected' : '' ?>>Tidak</option>
                        </select>
                                           
                        <!-- ✅ Reset Button: Link langsung ke URL bersih -->
                        <a href="<?= base_url('home_superadmin/materi/' . $modul['id_modul']) ?>" 
                           class="btn btn-sm btn-default">
                            <i class="fa fa-refresh"></i> Reset
                        </a>
                        
                        <!-- Kembali ke Modul -->
                        <a href="<?= base_url('home_superadmin/modul/' . $kursus['id_kursus']) ?>" 
                           class="btn btn-sm btn-warning">
                            <i class="fa fa-arrow-left"></i> Kembali
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
            <?php if (isset($filters) && (!empty($filters['search']) || !empty($filters['tipe']) || !empty($filters['preview']))): ?>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><i class="fa fa-filter"></i> Filter Aktif:</strong>
                    <?php
                    $activeFilters = [];
                    if (!empty($filters['search'])) $activeFilters[] = "Cari: <b>" . ucfirst($filters['search']) . "</b>";
                    if (!empty($filters['tipe'])) $activeFilters[] = "Tipe: <b>" . ucfirst($filters['tipe']) . "</b>";
                    if (!empty($filters['preview'])) $activeFilters[] = "Preview: <b>" . (($filters['preview'] == '1') ? 'Ya' : 'Tidak') . "</b>";
                    echo implode(", ", $activeFilters);
                    ?>
                    <a href="<?= base_url('home_superadmin/materi/' . $modul['id_modul']) ?>" 
                       class="alert-link" 
                       style="margin-left:10px;">Reset</a>
                </div>
            <?php endif; ?>

            <!-- Info Modul -->
            <div class="alert alert-info">
                <h6><i class="fa fa-info-circle me-2"></i>Info Modul</h6>
                <p class="mb-1">
                    <strong>Kursus:</strong> <?= esc($kursus['nama_kursus']); ?>
                </p>
                <p class="mb-0">
                    <strong>Modul:</strong> <?= esc($modul['nama_modul']); ?>
                    <?php if (!empty($modul['deskripsi'])): ?>
                        <br><small><?= esc($modul['deskripsi']); ?></small>
                    <?php endif; ?>
                </p>
            </div>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-gray">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="25%">Judul Materi</th>
                            <th width="10%" class="text-center">Tipe</th>
                            <th width="30%">Deskripsi</th>
                            <th width="8%" class="text-center">Urutan</th>
                            <th width="10%" class="text-center">Preview</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($materi) && is_array($materi)): ?>
                            <?php $no = 1;
                            foreach ($materi as $item): ?>
                                <?php if (!is_array($item)) continue; ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <?= esc($item['judul_materi'] ?? '') ?>
                                        <br>
                                        <small class="text-muted">ID: <?= $item['id_materi'] ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $badgeClass = [
                                            'youtube' => 'label-danger',
                                            'zoom' => 'label-info',
                                            'quiz' => 'label-success',
                                            'text' => 'label-default'
                                        ];
                                        $icon = [
                                            'youtube' => 'fa-play',
                                            'zoom' => 'fa-video',
                                            'quiz' => 'fa-question-circle',
                                            'text' => 'fa-file-alt'
                                        ];
                                        ?>
                                        <span class="label <?= $badgeClass[$item['tipe_materi']] ?? 'label-default'; ?>">
                                            <i class="fa <?= $icon[$item['tipe_materi']] ?? 'fa-file'; ?> me-1"></i>
                                            <?= ucfirst($item['tipe_materi']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= !empty($item['deskripsi_materi']) ? esc(substr($item['deskripsi_materi'], 0, 100)) . '...' : '-' ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-primary"><?= $item['urutan'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['is_preview'] == 1): ?>
                                            <span class="label label-success">
                                                <i class="fa fa-eye me-1"></i>Ya
                                            </span>
                                        <?php else: ?>
                                            <span class="label label-default">
                                                <i class="fa fa-eye-slash me-1"></i>Tidak
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <?php if ($level_user == 'superadmin'): ?>
                                        <td class="text-center">
                                            <!-- ✅ Edit Button: URL BERSIH (tanpa filter params) -->
                                            <a href="<?= base_url('home_superadmin/edit_materi/' . $item['id_materi']) ?>"
                                                class="btn btn-xs btn-warning"
                                                title="Edit"
                                                style="margin-bottom: 5px; display: inline-block;">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            
                                            <!-- ✅ Delete Button: Redirect ke list TANPA filter -->
                                            <button class="btn btn-danger btn-xs deleted-btn"
                                                data-id="<?= $item['id_materi'] ?>"
                                                data-nama="<?= esc($item['judul_materi'] ?? 'materi') ?>"
                                                title="Hapus">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="fa fa-file-alt text-muted"></i> Belum ada data materi.
                                    <br>
                                    <a href="<?= base_url('home_superadmin/add_materi/' . $modul['id_modul']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus"></i> Tambah Materi Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-6">
                    <small class="text-muted">
                        <i class="fa fa-info-circle"></i>
                        Modul: <strong><?= esc($modul['nama_modul']); ?></strong>
                    </small>
                </div>
                <div class="col-sm-6 text-right">
                    <small class="text-muted">
                        Total Materi: <strong><?= count($materi); ?></strong>
                    </small>
                </div>
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
            const deleteUrl = `<?= base_url("home_superadmin/delete_materi/") ?>${id}`;

            Swal.fire({
                title: 'Hapus materi?',
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
</script>

<?= $this->endSection() ?>