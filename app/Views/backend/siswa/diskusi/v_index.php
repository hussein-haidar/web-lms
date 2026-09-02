<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-comments"></i> Diskusi Kursus: <?= esc($kursus['nama_kursus'] ?? '') ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('siswa/diskusi/buat/' . $kursus['id_kursus']) ?>" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Buat Diskusi
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <!-- Filter & Search -->
                    <form method="GET" class="form-inline" style="margin-bottom:15px;">
                        <div class="form-group">
                            <select name="kategori" class="form-control input-sm">
                                <option value="all" <?= ($filter['kategori'] ?? '') == 'all' ? 'selected' : '' ?>>Semua Kategori</option>
                                <option value="pertanyaan" <?= ($filter['kategori'] ?? '') == 'pertanyaan' ? 'selected' : '' ?>>Pertanyaan</option>
                                <option value="diskusi" <?= ($filter['kategori'] ?? '') == 'diskusi' ? 'selected' : '' ?>>Diskusi</option>
                                <option value="pengumuman" <?= ($filter['kategori'] ?? '') == 'pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="sort" class="form-control input-sm">
                                <option value="terbaru" <?= ($filter['sort'] ?? '') == 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                                <option value="teraktif" <?= ($filter['sort'] ?? '') == 'teraktif' ? 'selected' : '' ?>>Teraktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="search" class="form-control input-sm" placeholder="Cari diskusi..." value="<?= esc($filter['search'] ?? '') ?>">
                        </div>
                        <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                    </form>

                    <?php if (empty($diskusi)): ?>
                        <div class="callout callout-info">
                            <p><i class="fa fa-info-circle"></i> Belum ada diskusi. Jadilah yang pertama memulai diskusi!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($diskusi as $item): ?>
                            <div class="post" style="border-bottom: 1px solid #f4f4f4; padding-bottom: 10px;">
                                <div class="user-block">
                                    <?php
                                    $avatar = !empty($item['user_avatar']) ? 'fotosiswa/' . $item['user_avatar'] : 'assets/img/default-avatar.png';
                                    ?>
                                    <img class="img-circle" src="<?= base_url($avatar) ?>" alt="Avatar" style="width:35px;height:35px;">
                                    <span class="username">
                                        <a href="<?= base_url('siswa/diskusi/view/' . $item['slug']) ?>">
                                            <?= esc($item['judul']) ?>
                                        </a>
                                        <?php if ($item['is_pinned']): ?>
                                            <span class="label label-warning"><i class="fa fa-thumb-tack"></i> Pin</span>
                                        <?php endif; ?>
                                        <?php if ($item['status'] == 'answered'): ?>
                                            <span class="label label-success"><i class="fa fa-check"></i> Terjawab</span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="description">
                                        oleh <?= esc($item['user_name']) ?> &middot;
                                        <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                        &middot; <span class="label label-<?= $item['kategori'] == 'pertanyaan' ? 'danger' : ($item['kategori'] == 'pengumuman' ? 'info' : 'default') ?>">
                                            <?= ucfirst($item['kategori']) ?>
                                        </span>
                                    </span>
                                </div>
                                <p style="margin-top:5px; color:#555;"><?= mb_strimwidth(strip_tags($item['konten']), 0, 200, '...') ?></p>
                                <ul class="list-inline" style="font-size:12px; color:#999;">
                                    <li><i class="fa fa-eye"></i> <?= $item['total_views'] ?? 0 ?></li>
                                    <li><i class="fa fa-comment"></i> <?= $item['total_comments'] ?? 0 ?></li>
                                    <li><i class="fa fa-heart"></i> <?= $item['total_likes'] ?? 0 ?></li>
                                </ul>
                            </div>
                        <?php endforeach; ?>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <div class="text-center">
                                <ul class="pagination pagination-sm">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="<?= $i == $page ? 'active' : '' ?>">
                                            <a href="?page=<?= $i ?>&kategori=<?= $filter['kategori'] ?? 'all' ?>&sort=<?= $filter['sort'] ?? 'terbaru' ?>&search=<?= $filter['search'] ?? '' ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Info Diskusi</h3>
                </div>
                <div class="box-body">
                    <p><strong>Total Diskusi:</strong> <?= $total ?></p>
                    <p><strong>Panduan Diskusi:</strong></p>
                    <ul style="font-size:13px;">
                        <li>Berikan judul yang jelas dandeskriptif</li>
                        <li>Pilih kategori yang tepat</li>
                        <li>Sertakan detail yang cukup</li>
                        <li>Hormati pendapat pengguna lain</li>
                    </ul>
                    <a href="<?= base_url('siswa/diskusi/buat/' . $kursus['id_kursus']) ?>" class="btn btn-primary btn-block">
                        <i class="fa fa-plus"></i> Buat Diskusi Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
