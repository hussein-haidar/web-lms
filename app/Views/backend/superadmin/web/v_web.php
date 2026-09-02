<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <a href="<?= base_url('home_superadmin/add_web') ?>" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data
            </a>
                  </div>

        <div class="box-body">
            <!-- Alert sukses -->
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">No</th>
                                <th>Nama Website</th>
                                <th>Logo Website</th>
                                <th>Banner Website</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Email Kontak</th>
                                <th>Jam Kerja</th>
                                <th>URL YouTube</th>
                                <th scope="col" width="auto">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($web) && is_array($web)): ?>
                                <?php $no = 1;
                                foreach ($web as $item): ?>
                                    <?php if (!is_array($item)) continue; // jaga-jaga jika ada data rusak 
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($item['nama_website'] ?? '') ?></td>
                                        <td>
                                            <img src="<?= base_url('logo/' . ($item['logo'] ?? 'default.png')) ?>"
                                                class="img-circle" width="80" height="80" alt="Logo">
                                        </td>
                                        <td>
                                            <img src="<?= base_url('banner/' . ($item['banner_utama'] ?? 'default-banner.png')) ?>"
                                                class="img-fluid" width="200" height="80" alt="Banner">
                                        </td>
                                        <td><?= esc($item['alamat'] ?? '') ?></td>
                                        <td><?= esc($item['no_telepon'] ?? '') ?></td>
                                        <td><?= esc($item['email'] ?? '') ?></td>
                                        <td><?= esc($item['jam_kerja'] ?? '') ?></td>
                                        <td>
                                            <?php if (!empty($item['url_yt']) && $item['url_yt'] !== 'www.youtube'): ?>
                                                <a href="<?= esc($item['url_yt']) ?>" target="_blank" rel="noopener noreferrer">
                                                    Lihat
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('home_superadmin/edit_web/' . ($item['id_setting'] ?? '')) ?>"
                                                class="btn btn-xs btn-warning"
                                                <?= !isset($item['id_setting']) ? 'disabled' : '' ?>>
                                                <i class="fa fa-fw fa-edit"></i> Edit
                                            </a>
                                            <?php if (isset($item['id_setting'])): ?>
                                                <button class="btn btn-danger btn-sm btn-xs deleted-btn"
                                                    data-id="<?= $item['id_setting'] ?>"
                                                    data-nama="<?= esc($item['nama_website'] ?? 'Item') ?>">
                                                    <i class="fa fa-fw fa-trash"></i> deleted
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data profil website.</td>
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
        const deletedButtons = document.querySelectorAll('.deleted-btn');
        deletedButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    html: `Anda akan menghapus data profil:<br><strong>${nama}</strong>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('home_superadmin/deleted_web/') ?>' + id;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>