<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus-circle"></i> Buat Diskusi Baru</h3>
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul style="margin:0; padding-left:15px;">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('siswa/diskusi/simpan') ?>">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kursus" value="<?= $kursus['id_kursus'] ?>">

                    <div class="box-body">
                        <div class="form-group">
                            <label>Judul Diskusi <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Bagaimana cara menyelesaikan tugas modul 3?" required maxlength="200" value="<?= old('judul') ?>">
                        </div>

                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-control" required>
                                <option value="pertanyaan" <?= old('kategori') == 'pertanyaan' ? 'selected' : '' ?>>Pertanyaan</option>
                                <option value="diskusi" <?= old('kategori') == 'diskusi' ? 'selected' : '' ?>>Diskusi</option>
                                <option value="pengumuman" <?= old('kategori') == 'pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Isi Diskusi <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control" rows="8" placeholder="Jelaskan pertanyaan atau topik diskusi Anda secara detail..." required minlength="10"><?= old('konten') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tags (opsional)</label>
                            <input type="text" name="tags" class="form-control" placeholder="Contoh: modul3, tugas, php" value="<?= old('tags') ?>">
                            <small class="text-muted">Pisahkan dengan koma</small>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="<?= base_url('siswa/diskusi/' . $kursus['id_kursus']) ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-paper-plane"></i> Kirim Diskusi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
