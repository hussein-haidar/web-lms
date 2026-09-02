<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-image"></i> Data <?= $title2 ?>
            <a href="<?= base_url('home_superadmin/add_slider_web') ?>" class="btn btn-sm btn-primary pull-right">
                <i class="fa fa-plus"></i> Tambah Slider
            </a>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="120">Gambar</th>
                            <th>Judul Slider</th>
                            <th>Deskripsi</th>
                            <th>Link URL</th>
                            <th width="80">Urutan</th>
                            <th width="80">Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($slider) && is_array($slider)): ?>
                            <?php foreach ($slider as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if (!empty($item['gambar_slider'])): ?>
                                            <img src="<?= base_url('uploads/slider_web/' . $item['gambar_slider']) ?>"
                                                width="100"
                                                class="img-thumbnail"
                                                alt="<?= esc($item['judul_slider']) ?>"
                                                onerror="this.src='<?= base_url('assets/img/no-image.png') ?>'">
                                        <?php else: ?>
                                            <img src="<?= base_url('assets/img/no-image.png') ?>" 
                                                width="100" 
                                                class="img-thumbnail" 
                                                alt="No Image">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['judul_slider'] ?? '') ?></td>
                                    <td><?= esc(substr($item['deskripsi'] ?? '', 0, 60)) ?>...</td>
                                    <td>
                                        <?php if (!empty($item['link_url']) && $item['link_url'] !== '#'): ?>
                                            <a href="<?= esc($item['link_url']) ?>" target="_blank" class="btn btn-xs btn-info">
                                                <i class="fa fa-link"></i> Link
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">–</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="number"
                                            class="form-control input-sm urutan-input"
                                            value="<?= $item['urutan'] ?>"
                                            data-id="<?= $item['id_slider'] ?>"
                                            min="1"
                                            style="width: 80px;">
                                    </td>
                                    <td>
                                        <?php if ($item['status'] == 'aktif'): ?>
                                            <span class="label label-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('home_superadmin/edit_slider_web/' . $item['id_slider']) ?>"
                                                class="btn btn-warning btn-xs btn-flat"
                                                title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-success btn-xs btn-flat btn-toggle-status"
                                                data-id="<?= $item['id_slider'] ?>"
                                                title="Toggle Status">
                                                <i class="fa fa-toggle-<?= ($item['status'] == 'aktif') ? 'on' : 'off' ?>"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs btn-flat deleted-btn"
                                                data-id="<?= $item['id_slider'] ?>"
                                                data-nama="<?= esc($item['judul_slider']) ?>"
                                                title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data slider web.</td>
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
        // Update urutan on change
        document.querySelectorAll('.urutan-input').forEach(input => {
            input.addEventListener('change', function() {
                const id_slider = this.dataset.id;
                const urutan = this.value;

                // Create form data for POST request
                const formData = new FormData();
                formData.append('id_slider', id_slider);
                formData.append('urutan', urutan);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                Swal.fire({
                    title: 'Perbarui Urutan?',
                    text: 'Apakah Anda yakin ingin mengubah urutan slider ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Perbarui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('<?= base_url('home_superadmin/update_order_slider_web') ?>', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire('Berhasil!', data.message, 'success');
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    Swal.fire('Gagal!', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error!', 'Terjadi kesalahan saat memperbarui urutan.', 'error');
                            });
                    } else {
                        // Reset value if cancelled
                        this.value = this.defaultValue;
                    }
                });
            });
        });

        // Toggle status
        document.querySelectorAll('.btn-toggle-status').forEach(btn => {
            btn.addEventListener('click', function() {
                const id_slider = this.dataset.id;

                // Create form data for POST request
                const formData = new FormData();
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= base_url('home_superadmin/toggle_status_slider_web/') ?>' + id_slider, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil!', data.message, 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan saat mengubah status.', 'error');
                    });
            });
        });

        // Delete slider
        document.querySelectorAll('.deleted-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                Swal.fire({
                    title: 'Hapus Slider?',
                    html: `Yakin hapus slider <strong>${nama}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('home_superadmin/deleted_slider_web/') ?>' + id;
                    }
                });
            });
        });
    });
</script>

<?= $this->endSection() ?>
