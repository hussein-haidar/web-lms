<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Karyawan Dihapus Sementara</h3>
            
            <div class="box-tools pull-right">
                <!-- Kembali ke Karyawan Aktif -->
                <a href="<?= base_url('home_superadmin/karyawan') ?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-arrow-left"></i> Kembali ke Karyawan Aktif
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
                                <th width="5%">Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Dihapus</th>
                                <th scope="col" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($karyawan) && is_array($karyawan)): ?>
                                <?php $no = 1;
                                foreach ($karyawan as $item): ?>
                                    <?php if (!is_array($item)) continue; // jaga-jaga jika ada data rusak 
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if (!empty($item['foto_profil'])): ?>
                                                <img src="<?= base_url('fotoprofil/' . $item['foto_profil']) ?>"
                                                     class="img-circle" width="50" height="50" alt="Foto Profil"
                                                     style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= esc($item['nama_lengkap'] ?? '') ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                ID: <?= $item['id_karyawan'] ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?= esc($item['email'] ?? '') ?>
                                        </td>
                                        <td>
                                            <?php
                                            $levelClass = '';
                                            $levelText = $item['level'] ?? '';
                                            switch ($item['level']) {
                                                case 'superadmin':
                                                    $levelClass = 'bg-danger';
                                                    break;
                                                case 'staf_admin':
                                                    $levelClass = 'bg-primary';
                                                    break;
                                                case 'teknisi':
                                                    $levelClass = 'bg-info';
                                                    break;
                                                default:
                                                    $levelClass = 'bg-secondary';
                                            }
                                            ?>
                                            <span class="badge <?= $levelClass ?>">
                                                <?= esc(ucwords(str_replace('_', ' ', $levelText))) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= esc($item['no_telepon'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($item['deleted_at'] ?? 'now')) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical btn-group-sm" style="width: 100px;">
                                                <!-- Restore Button -->
                                                <a href="<?= base_url('home_superadmin/restore_karyawan/' . $item['id_karyawan']) ?>"
                                                   class="btn btn-success btn-sm btn-block"
                                                   title="Pulihkan"
                                                   onclick="return confirm('Pulihkan karyawan ini?')">
                                                    <i class="fa fa-undo"></i> Pulihkan
                                                </a>
                                                
                                                <!-- Force Delete Button -->
                                                <button class="btn btn-danger btn-sm delete-btn btn-block"
                                                        data-id="<?= $item['id_karyawan'] ?>"
                                                        data-nama="<?= esc($item['nama_lengkap'] ?? 'Item') ?>"
                                                        title="Hapus Permanen">
                                                    <i class="fa fa-trash"></i> Hapus Permanen
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <i class="fa fa-trash text-muted"></i> Belum ada data karyawan yang dihapus sementara.
                                        <br>
                                        <a href="<?= base_url('home_superadmin/karyawan') ?>" class="btn btn-sm btn-primary">
                                            <i class="fa fa-users"></i> Lihat Karyawan Aktif
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
                    html: `Anda akan menghapus permanen karyawan:<br><strong>${nama}</strong><br><small class="text-danger">Tindakan ini tidak dapat dibatalkan!</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('home_superadmin/force_delete_karyawan/') ?>' + id;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>
