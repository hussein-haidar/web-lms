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
                    <h3 class="box-title"><i class="fa fa-comments"></i> Percakapan</h3>
                </div>

                <div class="box-body">
                    <?php if (empty($chats)): ?>
                        <div class="callout callout-info">
                            <p><i class="fa fa-info-circle"></i> Belum ada percakapan.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($chats as $chat): ?>
                            <?php
                            $other_name = 'Pengajar';
                            $avatar = base_url('assets/img/default-avatar.png');
                            if ($chat['other_role'] == 'pengajar' || $chat['other_role'] == 'karyawan') {
                                $other_name = $chat['nama_lengkap_karyawan'] ?? 'Pengajar';
                                if (!empty($chat['foto_karyawan'])) {
                                    $avatar = base_url('fotokaryawan/' . $chat['foto_karyawan']);
                                }
                            }
                            ?>
                            <div class="user-block" style="margin-bottom:15px; padding-bottom:15px; border-bottom:1px solid #f4f4f4;">
                                <img class="img-circle" src="<?= $avatar ?>" alt="Avatar" style="width:40px;height:40px;object-fit:cover;">
                                <span class="username">
                                    <a href="<?= base_url('siswa/chat/' . $chat['other_id']) ?>"><?= esc($other_name) ?></a>
                                    <?php if ($chat['is_read'] == 0 && $chat['id_pengirim'] != $chat['other_id']): ?>
                                        <span class="label label-success">Baru</span>
                                    <?php endif; ?>
                                </span>
                                <span class="description" style="margin-top:5px;">
                                    <?= mb_strimwidth(strip_tags($chat['pesan']), 0, 80, '...') ?>
                                    &middot; <?= date('d M, H:i', strtotime($chat['created_at'])) ?>
                                </span>
                                <div style="margin-top:8px;">
                                    <a href="<?= base_url('siswa/chat/' . $chat['other_id']) ?>" class="btn btn-xs btn-primary">
                                        <i class="fa fa-reply"></i> Buka Chat
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Info Chat</h3>
                </div>
                <div class="box-body">
                    <p><strong>Panduan Penggunaan:</strong></p>
                    <ul style="font-size:13px;">
                        <li>Pilih percakapan untuk membuka chat</li>
                        <li>Pesan baru akan ditandai dengan label "Baru"</li>
                        <li>Pesan diupdate secara otomatis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
