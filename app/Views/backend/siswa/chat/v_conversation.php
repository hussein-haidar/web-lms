<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary direct-chat">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-comments"></i> Chat dengan <?= esc($other['nama_lengkap'] ?? 'Pengajar') ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('siswa/chat') ?>" class="btn btn-box-tool" title="Kembali">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="box-body" style="padding:10px;">
                    <!-- Chat Messages -->
                    <div class="direct-chat-messages" id="chatMessages" style="height:400px; overflow-y:auto;">
                        <?php foreach ($messages as $msg): ?>
                            <?php $is_me = ($msg['id_pengirim'] == session()->get('id_siswa')); ?>
                            <div class="direct-chat-msg <?= $is_me ? 'right' : '' ?>" style="margin-bottom:10px;">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-<?= $is_me ? 'right' : 'left' ?>">
                                        <?= $is_me ? 'Anda' : esc($other['nama_lengkap'] ?? 'Pengajar') ?>
                                    </span>
                                    <span class="direct-chat-timestamp pull-<?= $is_me ? 'left' : 'right' ?>">
                                        <?= date('H:i', strtotime($msg['created_at'])) ?>
                                    </span>
                                </div>
                                <div class="direct-chat-text" style="background:<?= $is_me ? '#3c8dbc' : '#d2d6de' ?>; color:<?= $is_me ? '#fff' : '#444' ?>; border-radius:10px; padding:8px 12px; max-width:75%; float:<?= $is_me ? 'right' : 'left' ?>;">
                                    <?= nl2br(esc($msg['pesan'])) ?>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($messages)): ?>
                            <div class="text-center text-muted" style="padding:60px 0;">
                                <i class="fa fa-comments-o fa-3x"></i>
                                <p style="margin-top:10px;">Mulai percakapan dengan <?= esc($other['nama_lengkap'] ?? 'Pengajar') ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="box-footer" style="border-top:1px solid #f4f4f4;">
                    <form id="chatForm" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penerima" value="<?= $other_id ?>">
                        <input type="hidden" name="role_penerima" value="<?= $other_role ?>">
                        <div class="input-group">
                            <input type="text" name="pesan" id="chatInput" class="form-control" placeholder="Ketik pesan..." autocomplete="off" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat" id="btnSend">
                                    <i class="fa fa-paper-plane"></i> Kirim
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-user"></i> Profil</h3>
                </div>
                <div class="box-body text-center">
                    <?php
                    $avatar = !empty($other['foto_profil']) ? base_url('fotokaryawan/' . $other['foto_profil']) : base_url('assets/img/default-avatar.png');
                    ?>
                    <img src="<?= $avatar ?>" alt="Avatar" class="img-circle" style="width:80px;height:80px;object-fit:cover;margin-bottom:10px;">
                    <h5><?= esc($other['nama_lengkap'] ?? '') ?></h5>
                    <p class="text-muted" style="font-size:12px;">
                        <span class="label label-primary"><?= ucfirst(str_replace('_', ' ', $other_role)) ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Auto-scroll & AJAX Chat -->
<script>
$(document).ready(function() {
    var chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;

    var lastMessageId = <?= !empty($messages) ? end($messages)['id'] : 0 ?>;
    var otherId = <?= $other_id ?>;
    var pollInterval;

    // Polling setiap 3 detik
    function pollMessages() {
        $.ajax({
            url: '<?= base_url('api/siswa/chat/messages/' . $other_id) ?>',
            type: 'GET',
            data: { last_id: lastMessageId },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success' && response.messages.length > 0) {
                    response.messages.forEach(function(msg) {
                        var isMe = (msg.id_pengirim == <?= session()->get('id_siswa') ?>);
                        var msgHtml = '<div class="direct-chat-msg ' + (isMe ? 'right' : '') + '" style="margin-bottom:10px;">' +
                            '<div class="direct-chat-info clearfix">' +
                            '<span class="direct-chat-name pull-' + (isMe ? 'right' : 'left') + '">' + (isMe ? 'Anda' : '<?= esc($other['nama_lengkap'] ?? 'Pengajar') ?>') + '</span>' +
                            '<span class="direct-chat-timestamp pull-' + (isMe ? 'left' : 'right') + '">' + msg.created_at.substring(11, 16) + '</span>' +
                            '</div>' +
                            '<div class="direct-chat-text" style="background:' + (isMe ? '#3c8dbc' : '#d2d6de') + '; color:' + (isMe ? '#fff' : '#444') + '; border-radius:10px; padding:8px 12px; max-width:75%; float:' + (isMe ? 'right' : 'left') + ';">' +
                            msg.pesan.replace(/\n/g, '<br>') +
                            '</div><div style="clear:both;"></div></div>';
                        $('#chatMessages').append(msgHtml);
                        lastMessageId = msg.id;
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        });
    }

    pollInterval = setInterval(pollMessages, 3000);

    // Kirim pesan
    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        var pesan = $('#chatInput').val().trim();
        if (!pesan) return;

        $.ajax({
            url: '<?= base_url('api/siswa/chat/send') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    $('#chatInput').val('');
                    pollMessages();
                } else {
                    alert(response.message || 'Gagal mengirim pesan');
                }
            }
        });
    });
});
</script>

<style>
.direct-chat-messages::-webkit-scrollbar { width:6px; }
.direct-chat-messages::-webkit-scrollbar-thumb { background:#ccc; border-radius:3px; }
.direct-chat-msg.right .direct-chat-text { float:right; }
.direct-chat-msg.left .direct-chat-text { float:left; }
</style>

<?= $this->endSection() ?>
