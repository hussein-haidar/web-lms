<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php if ($diskusi['is_pinned']): ?>
                            <i class="fa fa-thumb-tack text-yellow"></i>
                        <?php endif; ?>
                        <?= esc($diskusi['judul']) ?>
                    </h3>
                    <span class="label label-<?= $diskusi['kategori'] == 'pertanyaan' ? 'danger' : ($diskusi['kategori'] == 'pengumuman' ? 'info' : 'default') ?>">
                        <?= ucfirst($diskusi['kategori']) ?>
                    </span>
                    <?php if ($diskusi['status'] == 'answered'): ?>
                        <span class="label label-success"><i class="fa fa-check"></i> Terjawab</span>
                    <?php endif; ?>
                </div>

                <div class="box-body">
                    <!-- Post Author -->
                    <div class="user-block">
                        <?php
                        $avatar = !empty($diskusi['user_avatar']) ? 'fotosiswa/' . $diskusi['user_avatar'] : 'assets/img/default-avatar.png';
                        ?>
                        <img class="img-circle" src="<?= base_url($avatar) ?>" alt="Avatar" style="width:40px;height:40px;">
                        <span class="username"><?= esc($diskusi['user_name']) ?></span>
                        <span class="description">
                            <?= date('d M Y, H:i', strtotime($diskusi['created_at'])) ?>
                            &middot; <?= $diskusi['total_views'] ?> views
                        </span>
                    </div>

                    <!-- Post Content -->
                    <div style="margin-top:15px; line-height:1.8;">
                        <?= nl2br(esc($diskusi['konten'])) ?>
                    </div>

                    <?php if (!empty($diskusi['tags'])): ?>
                        <div style="margin-top:10px;">
                            <?php foreach (explode(',', $diskusi['tags']) as $tag): ?>
                                <span class="label label-default"><?= esc(trim($tag)) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <hr>

                    <!-- Comments Section -->
                    <h4><i class="fa fa-comments"></i> Komentar (<?= $diskusi['total_comments'] ?? 0 ?>)</h4>

                    <?php
                    $komentar = $diskusi['komentar'] ?? [];
                    if (!empty($komentar)):
                    ?>
                        <?php foreach ($komentar as $kmt): ?>
                            <div class="comment-item" style="border-left:3px solid #ddd; padding:10px; margin-bottom:10px; background:#fafafa;">
                                <div class="user-block" style="margin-bottom:5px;">
                                    <?php
                                    $kmtAvatar = !empty($kmt['user_avatar']) ? 'fotosiswa/' . $kmt['user_avatar'] : 'assets/img/default-avatar.png';
                                    ?>
                                    <img class="img-circle" src="<?= base_url($kmtAvatar) ?>" alt="" style="width:25px;height:25px;">
                                    <span class="username" style="font-size:13px;">
                                        <?= esc($kmt['user_name']) ?>
                                        <?php if ($kmt['user_role'] == 'mentor'): ?>
                                            <span class="label label-info" style="font-size:10px;">Mentor</span>
                                        <?php endif; ?>
                                        <?php if ($kmt['is_solution'] ?? 0): ?>
                                            <span class="label label-success" style="font-size:10px;"><i class="fa fa-check"></i> Solusi</span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="description" style="font-size:11px;"><?= date('d M Y, H:i', strtotime($kmt['created_at'])) ?></span>
                                </div>
                                <p style="margin:5px 0; font-size:14px;"><?= nl2br(esc($kmt['konten'])) ?></p>
                                <div>
                                    <a href="<?= base_url('siswa/diskusi/like/' . $diskusi['id_diskusi'] . '/' . $kmt['id']) ?>" class="btn btn-xs btn-default" title="Like">
                                        <i class="fa fa-heart"></i> <?= $kmt['total_likes'] ?? 0 ?>
                                    </a>
                                    <button class="btn btn-xs btn-default reply-btn" data-parent="<?= $kmt['id'] ?>" title="Balas">
                                        <i class="fa fa-reply"></i> Balas
                                    </button>
                                </div>

                                <!-- Nested Replies -->
                                <?php if (!empty($kmt['replies'])): ?>
                                    <?php foreach ($kmt['replies'] as $reply): ?>
                                        <div style="margin-left:30px; border-left:3px solid #3c8dbc; padding:8px; margin-top:8px; background:#f0f8ff;">
                                            <div class="user-block" style="margin-bottom:3px;">
                                                <span class="username" style="font-size:12px;">
                                                    <?= esc($reply['user_name']) ?>
                                                    <?php if (($reply['user_role'] ?? '') == 'mentor'): ?>
                                                        <span class="label label-info" style="font-size:9px;">Mentor</span>
                                                    <?php endif; ?>
                                                </span>
                                                <span class="description" style="font-size:10px;"><?= date('d M Y, H:i', strtotime($reply['created_at'])) ?></span>
                                            </div>
                                            <p style="margin:3px 0; font-size:13px;"><?= nl2br(esc($reply['konten'])) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Belum ada komentar.</p>
                    <?php endif; ?>

                    <!-- Form Komentar -->
                    <?php if ($diskusi['is_locked'] != 1): ?>
                        <hr>
                        <form method="POST" action="<?= base_url('siswa/diskusi/komentar/' . $diskusi['id_diskusi']) ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="parent_id" id="parent_id" value="">
                            <div class="form-group">
                                <textarea name="konten" class="form-control" rows="3" placeholder="Tulis komentar Anda..." required minlength="2" id="komentar-input"></textarea>
                            </div>
                            <div id="reply-indicator" style="display:none; margin-bottom:10px; padding:5px 10px; background:#e8f4f8; border-radius:4px; font-size:13px;">
                                Membalas komentar... <a href="#" id="cancel-reply" class="text-danger">Batal</a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm pull-right">
                                <i class="fa fa-paper-plane"></i> Kirim
                            </button>
                            <div class="clearfix"></div>
                        </form>
                    <?php else: ?>
                        <div class="callout callout-warning">
                            <p><i class="fa fa-lock"></i> Diskusi ini sudah dikunci. Komentar baru tidak dapat ditambahkan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <a href="<?= base_url('siswa/diskusi/' . $diskusi['id_kursus']) ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Diskusi
            </a>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Info Diskusi</h3>
                </div>
                <div class="box-body">
                    <p><strong>Status:</strong> <?= ucfirst($diskusi['status']) ?></p>
                    <p><strong>Dilihat:</strong> <?= $diskusi['total_views'] ?> kali</p>
                    <p><strong>Komentar:</strong> <?= $diskusi['total_comments'] ?></p>
                    <p><strong>Dibuat:</strong> <?= date('d M Y H:i', strtotime($diskusi['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.querySelectorAll('.reply-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var parentId = this.getAttribute('data-parent');
        document.getElementById('parent_id').value = parentId;
        document.getElementById('reply-indicator').style.display = 'block';
        document.getElementById('komentar-input').focus();
    });
});

document.getElementById('cancel-reply')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('parent_id').value = '';
    document.getElementById('reply-indicator').style.display = 'none';
});
</script>

<?= $this->endSection() ?>
