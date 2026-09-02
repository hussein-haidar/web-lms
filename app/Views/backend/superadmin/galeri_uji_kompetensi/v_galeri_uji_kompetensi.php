<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-image"></i> Data <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/add_galeri_uji_kompetensi') ?>" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Tambah Galeri
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <?= session()->getFlashdata('errors') ?>
                </div>
            <?php endif ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Uji Kompetensi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($galeri)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($galeri as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <?php if (!empty($item['gambar'])): ?>
                                            <img src="<?= base_url('uploads/galeri_uji_kompetensi/' . $item['gambar']) ?>"
                                                 alt="<?= esc($item['judul'] ?? 'Galeri') ?>"
                                                 style="max-width: 80px; max-height: 60px; object-fit: cover; border-radius: 5px;">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['judul'] ?? '-') ?></td>
                                    <td><?= esc(character_limiter(strip_tags($item['deskripsi'] ?? ''), 100)) ?></td>
                                    <td><?= esc($item['nama_uji_kompetensi'] ?? '-') ?></td>
                                    <td>
                                        <?php if (($item['status'] ?? '') == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('home_superadmin/deleted_galeri_uji_kompetensi/' . $item['id_galeri']) ?>"
                                           class="btn btn-danger btn-sm delete-btn"
                                           data-id="<?= $item['id_galeri'] ?>"
                                           data-nama="<?= esc($item['judul'] ?? 'Galeri') ?>"
                                           onclick="return confirm('Hapus galeri \'<?= esc($item['judul'] ?? 'Galeri') ?>\'?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        Belum ada data galeri uji kompetensi
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
