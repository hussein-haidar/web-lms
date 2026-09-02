<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-edit"></i> <?= $title2 ?>
            </h3>
            <a href="<?= base_url('home_superadmin/profil_lpk') ?>" class="btn btn-default btn-sm float-end">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif ?>

            <?php if (!empty($profil)): ?>
            <form action="<?= base_url('home_superadmin/update_profil_lpk/' . $profil['id_profil']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul_header">Judul Header <span class="text-danger">*</span></label>
                            <input type="text" name="judul_header" id="judul_header" class="form-control"
                                   value="<?= old('judul_header', $profil['judul_header'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="subjudul_header">Subjudul Header</label>
                            <input type="text" name="subjudul_header" id="subjudul_header" class="form-control"
                                   value="<?= old('subjudul_header', $profil['subjudul_header'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="video_url">Video URL <span class="text-danger">*</span></label>
                            <input type="url" name="video_url" id="video_url" class="form-control"
                                   value="<?= old('video_url', $profil['video_url'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="video_title">Video Title</label>
                            <input type="text" name="video_title" id="video_title" class="form-control"
                                   value="<?= old('video_title', $profil['video_title'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_berdiri">Tahun Berdiri <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_berdiri" id="tahun_berdiri" class="form-control"
                                   value="<?= old('tahun_berdiri', $profil['tahun_berdiri'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_resmi">Tanggal Resmi</label>
                            <input type="date" name="tanggal_resmi" id="tanggal_resmi" class="form-control"
                                   value="<?= old('tanggal_resmi', $profil['tanggal_resmi'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_izin">Tanggal Izin</label>
                            <input type="date" name="tanggal_izin" id="tanggal_izin" class="form-control"
                                   value="<?= old('tanggal_izin', $profil['tanggal_izin'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="status_akreditasi">Status Akreditasi</label>
                            <input type="text" name="status_akreditasi" id="status_akreditasi" class="form-control"
                                   value="<?= old('status_akreditasi', $profil['status_akreditasi'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sejarah_singkat">Sejarah Singkat <span class="text-danger">*</span></label>
                    <textarea name="sejarah_singkat" id="sejarah_singkat" class="form-control" rows="5"
                              required><?= old('sejarah_singkat', $profil['sejarah_singkat'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <a href="<?= base_url('home_superadmin/profil_lpk') ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i> Data profil tidak ditemukan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
