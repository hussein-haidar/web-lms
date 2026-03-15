<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">

    <!-- Header Section -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Manajemen Kursus</h3>

                    <?php $level_user = session()->get('level'); ?>

                    <div class="box-tools pull-right">
                        <?php if ($level_user == 'staf_admin'): ?>
                            <a href="<?= base_url('home_karyawan/add_kursus') ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Tambah Kursus Baru
                            </a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <!-- Filter Section -->
                    <?php if ($level_user == 'staf_admin'): ?>
                    <div class="row" style="margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px solid #eee;">
                        <div class="col-md-12">
                            <form method="get" action="<?= base_url('home_karyawan/v_kursus') ?>" class="form-inline">
                                <label class="control-label"><i class="fa fa-filter"></i> Filter:</label>

                                <?php foreach ($filterConfig as $key => $cfg): ?>
                                    <?php if ($cfg['label'] !== 'program'): ?>
                                        <div class="form-group" style="margin-left: 10px;">
                                            <select name="<?= esc($key) ?>" class="form-control input-sm" onchange="this.form.submit()" style="min-width: 150px;">
                                                <option value="">-- Semua <?= esc($cfg['label']) ?> --</option>
                                                <?php foreach ($cfg['options'] as $opt): ?>
                                                    <?php $val = $opt['value'] ?? $opt[$cfg['column']] ?? ''; ?>
                                                    <option value="<?= esc($val) ?>" <?= (isset($filters[$key]) && $filters[$key] == $val) ? 'selected' : '' ?>>
                                                        <?= esc(ucfirst($val)) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari</button>
                                <a href="<?= base_url('home_karyawan/kursus') ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reset</a>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Alerts -->
                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-check-circle"></i> <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>

                    <?php $errors = session()->getFlashdata('errors');
                    if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
                        </div>
                    <?php endif; ?>

                    <!-- Grid Layout for Courses -->
                    <div class="row">
                        <?php 
                        if (!empty($kursus) && is_array($kursus)): 
                            foreach ($kursus as $item): 
                                if (!is_array($item)) continue;
                                
                                // Filter for pengajar level: only show online classes
                                if ($level_user == 'pengajar') {
                                    $programName = $item['nama_program'] ?? 'NULL';
                                    if (strtolower($programName) != 'online' && strtolower($programName) != 'kelas online') {
                                        continue;
                                    }
                                }
                        ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="box box-solid" style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <!-- Card Header / Image -->
                                        <div class="box-header with-border" style="padding: 0; position: relative; height: 180px; background: #eee;">
                                            <?php if (!empty($item['gambar_detail_a'])): ?>
                                                <img src="<?= base_url('kursus/materi/' . $item['gambar_detail_a']) ?>"
                                                    class="img-responsive"
                                                    style="width: 100%; height: 180px; object-fit: cover;"
                                                    alt="<?= esc($item['nama_kursus']) ?>">
                                            <?php else: ?>
                                                <div class="flex-center-full" style="height: 100%; display: flex; align-items: center; justify-content: center; color: #aaa;">
                                                    <i class="fa fa-image fa-3x"></i>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Status Badge -->
                                            <span class="label label-<?= ($item['status'] == 'aktif') ? 'success' : 'danger' ?>"
                                                style="position: absolute; top: 10px; right: 10px; font-size: 12px;">
                                                <i class="fa fa-circle" style="font-size: 8px;"></i> <?= ucfirst($item['status']) ?>
                                            </span>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="box-body">
                                            <h4 class="box-title" style="font-size: 16px; font-weight: bold; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?= esc($item['nama_kursus']) ?>
                                            </h4>

                                            <p class="text-muted" style="font-size: 12px; margin-bottom: 10px;">
                                                <i class="fa fa-folder"></i> <?= esc($item['nama_program'] ?? 'Umum') ?>
                                            </p>

                                            <!-- Info Grid -->
                                            <div class="row" style="font-size: 11px; border-top: 1px solid #eee; padding-top: 10px;">
                                                <div class="col-xs-6">
                                                    <strong><i class="fa fa-user"></i> Pengajar:</strong><br>
                                                    <span class="text-blue"><?= esc($item['nama_pengajar'] ?? '-') ?></span>
                                                </div>
                                                <div class="col-xs-6 text-right">
                                                    <strong><i class="fa fa-calendar"></i> Dibuat:</strong><br>
                                                    <span class="text-muted"><?= esc(date('d/m/Y', strtotime($item['tanggal_dibuat'] ?? ''))) ?></span>
                                                </div>
                                            </div>
                                                        </div>

                                        <!-- Card Footer / Actions -->
                                        <div class="box-footer bg-gray" style="border-top: 1px solid #ddd;">
                                            <?php if ($level_user == 'staf_admin'): ?>
                                                <div class="btn-group btn-group-justified">
                                                    <a href="<?= base_url('home_karyawan/edit_kursus/' . $item['id_kursus']) ?>" class="btn btn-warning btn-flat btn-sm">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <button class="btn btn-danger btn-flat btn-sm deleted-btn"
                                                        data-id="<?= $item['id_kursus'] ?>"
                                                        data-nama="<?= esc($item['nama_kursus']) ?>">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <div class="btn-group btn-group-justified">
                                                    <a href="<?= base_url('home_karyawan/detail_kursus/' . $item['id_kursus']) ?>" class="btn btn-info btn-flat btn-sm">
                                                        <i class="fa fa-eye"></i> Lihat Detail
                                                    </a>
                                                    <a href="#" class="btn btn-default btn-flat btn-sm" disabled>
                                                        <i class="fa fa-lock"></i> Read Only
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xs-12 text-center" style="padding: 50px;">
                                <i class="fa fa-folder-open text-muted" style="font-size: 64px;"></i>
                                <h3 class="text-muted">Belum ada data kursus</h3>
                                <p>Silakan tambahkan kursus baru untuk memulai.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Confirmation
        document.querySelectorAll('.deleted-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const deleteUrl = `<?= base_url("home_karyawan/deleted_kursus/") ?>${id}`;

                Swal.fire({
                    title: 'Hapus kursus?',
                    html: `Yakin hapus <strong>${nama}</strong>? Data tidak bisa dikembalikan.`,
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

        // Stop Video on Modal Close
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                const iframe = this.querySelector('iframe');
                if (iframe) iframe.src = iframe.src;
            });
        });
    });
</script>

<?= $this->endSection() ?>