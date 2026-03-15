<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Kursus Dihapus Sementara</h3>
            
            <div class="box-tools pull-right">
                <!-- Kembali ke Kursus Aktif -->
                <a href="<?= base_url('home_superadmin/kursus') ?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-arrow-left"></i> Kembali ke Kursus Aktif
                </a>
            </div>
        </div>

        <div class="box-body">
            <!-- Alert sukses -->
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <!-- Alert warning -->
            <?php if (session()->getFlashdata('pesan_warning')): ?>
                <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashdata('pesan_warning'); ?>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">No</th>
                                <th>Gambar</th>
                                <th>Nama Kursus</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Tanggal Dihapus</th>
                                <th scope="col" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kursus) && is_array($kursus)): ?>
                                <?php $no = 1;
                                foreach ($kursus as $item): ?>
                                    <?php if (!is_array($item)) continue; // jaga-jaga jika ada data rusak 
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if (!empty($item['gambar_utama'])): ?>
                                                <img src="<?= base_url('kursus/materi/' . $item['gambar_utama']) ?>"
                                                     class="img-circle" width="60" height="60" alt="Gambar"
                                                     style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-graduation-cap text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= esc($item['nama_kursus'] ?? '') ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                ID: <?= $item['id_kursus'] ?>
                                            </small>
                                        </td>
                                        <td>
                                            <small>
                                                <?= esc(substr($item['deskripsi_singkat'] ?? '', 0, 100) . (strlen($item['deskripsi_singkat'] ?? '') > 100 ? '...' : '')) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['harga'])): ?>
                                                <span class="badge bg-success">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Gratis</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($item['deleted_at'] ?? 'now')) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                                <!-- Restore Button -->
                                                <a href="<?= base_url('home_superadmin/restore_kursus/' . $item['id_kursus']) ?>"
                                                   class="btn btn-success btn-sm btn-block"
                                                   title="Pulihkan"
                                                   onclick="return confirm('Pulihkan kursus ini?')">
                                                    <i class="fa fa-undo"></i> Pulihkan
                                                </a>
                                                
                                                <!-- Force Delete Button -->
                                                <button class="btn btn-danger btn-sm delete-btn btn-block"
                                                        data-id="<?= $item['id_kursus'] ?>"
                                                        data-nama="<?= esc($item['nama_kursus'] ?? 'Item') ?>"
                                                        title="Hapus Permanen">
                                                    <i class="fa fa-trash"></i> Hapus Permanen
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <i class="fa fa-trash text-muted"></i> Belum ada data kursus yang dihapus sementara.
                                        <br>
                                        <a href="<?= base_url('home_superadmin/kursus') ?>" class="btn btn-sm btn-primary">
                                            <i class="fa fa-list"></i> Lihat Kursus Aktif
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus Permanen?',
                    html: `Anda akan menghapus permanen kursus:<br><strong>${nama}</strong><br><small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('home_superadmin/force_delete_kursus/') ?>' + id;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>
