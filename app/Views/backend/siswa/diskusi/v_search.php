<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-search"></i> Pencarian Diskusi</h3>
                </div>
                <div class="box-body">
                    <form method="GET" class="form-inline" style="margin-bottom:15px;">
                        <div class="form-group" style="width:80%;">
                            <input type="text" name="keyword" class="form-control" style="width:100%;" placeholder="Cari diskusi berdasarkan judul, konten, atau tag..." value="<?= esc($keyword ?? '') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    </form>

                    <?php if (!empty($diskusi)): ?>
                        <h4>Hasil Pencarian: "<?= esc($keyword) ?>"</h4>
                        <?php foreach ($diskusi as $item): ?>
                            <div class="post" style="border-bottom: 1px solid #f4f4f4; padding-bottom: 10px;">
                                <div class="user-block">
                                    <span class="username">
                                        <a href="<?= base_url('siswa/diskusi/view/' . $item['slug']) ?>">
                                            <?= esc($item['judul']) ?>
                                        </a>
                                        <span class="label label-<?= $item['kategori'] == 'pertanyaan' ? 'danger' : 'default' ?>">
                                            <?= ucfirst($item['kategori']) ?>
                                        </span>
                                    </span>
                                    <span class="description">
                                        <?= date('d M Y', strtotime($item['created_at'])) ?>
                                        &middot; <?= $item['total_views'] ?> views
                                        &middot; <?= $item['total_comments'] ?> komentar
                                    </span>
                                </div>
                                <p style="color:#555;"><?= mb_strimwidth(strip_tags($item['konten']), 0, 150, '...') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php elseif (!empty($keyword)): ?>
                        <div class="callout callout-info">
                            <p>Tidak ada diskusi ditemukan untuk keyword "<?= esc($keyword) ?>"</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
