<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-building"></i> Data <?= $title2 ?>
            </h3>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i>
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif ?>

            <?php if (!empty($profil)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">Judul Header</th>
                                <td><?= esc($profil['judul_header'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Subjudul Header</th>
                                <td><?= esc($profil['subjudul_header'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Video URL</th>
                                <td>
                                    <?php if (!empty($profil['video_url'])): ?>
                                        <a href="<?= esc($profil['video_url']) ?>" target="_blank">
                                            <?= esc($profil['video_url']) ?>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Video Title</th>
                                <td><?= esc($profil['video_title'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Tahun Berdiri</th>
                                <td><?= esc($profil['tahun_berdiri'] ?? '-') ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">Sejarah Singkat</th>
                                <td><?= nl2br(esc($profil['sejarah_singkat'] ?? '-')) ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Resmi</th>
                                <td><?= esc($profil['tanggal_resmi'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Izin</th>
                                <td><?= esc($profil['tanggal_izin'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Status Akreditasi</th>
                                <td>
                                    <?php if (!empty($profil['status_akreditasi'])): ?>
                                        <span class="badge bg-info"><?= esc($profil['status_akreditasi']) ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="<?= base_url('home_superadmin/edit_profil_lpk/' . $profil['id_profil']) ?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Profil
                    </a>
                    <a href="<?= base_url('home_superadmin/create_profil') ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Baru
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    Belum ada data profil LPK.
                    <a href="<?= base_url('home_superadmin/create_profil') ?>" class="alert-link">Tambah sekarang</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
