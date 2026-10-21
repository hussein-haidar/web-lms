<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary direct-chat">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-users"></i> <?= esc($group['nama_group'] ?? 'Group') ?>
                        <small class="text-muted">(<?= count($members ?? []) ?> anggota)</small>
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('siswa/chat/groups') ?>" class="btn btn-box-tool" title="Kembali">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="box-body" style="padding:10px;">
                    <div class="direct-chat-messages" id="chatMessages" style="height:400px; overflow-y:auto;">
                        <?php foreach ($messages as $msg): ?>
                            <?php $is_me = ($msg['id_pengirim'] == session()->get('id_siswa')); ?>
                            <div class="direct-chat-msg <?= $is_me ? 'right' : '' ?>" style="margin-bottom:10px;" data-id="<?= $msg['id'] ?>">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-<?= $is_me ? 'right' : 'left' ?>">
                                        <?= $is_me ? 'Anda' : esc($msg['sender_name'] ?? 'Anggota') ?>
                                    </span>
                                    <span class="direct-chat-timestamp pull-<?= $is_me ? 'left' : 'right' ?>">
                                        <?= date('H:i', strtotime($msg['created_at'])) ?>
                                    </span>
                                </div>
                                <div class="direct-chat-text" style="background:<?= $is_me ? '#3c8dbc' : '#d2d6de' ?>; color:<?= $is_me ? '#fff' : '#444' ?>; border-radius:10px; padding:8px 12px; max-width:75%; float:<?= $is_me ? 'right' : 'left' ?>; word-wrap:break-word;">
                                    <?= nl2br(esc($msg['pesan'])) ?>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($messages)): ?>
                            <div class="text-center text-muted" style="padding:60px 0;">
                                <i class="fa fa-comments-o fa-3x"></i>
                                <p style="margin-top:10px;">Mulai percakapan di group ini</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="box-footer" style="border-top:1px solid #f4f4f4;">
                    <form id="groupChatForm" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_group" value="<?= $id_group ?>">
                        <div class="input-group">
                            <input type="text" name="pesan" id="groupChatInput" class="form-control" placeholder="Ketik pesan group..." autocomplete="off" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-flat">
                                    <i class="fa fa-paper-plane"></i> Kirim
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar: Members -->
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-users"></i> Anggota (<?= count($members ?? []) ?>)</h3>
                </div>
                <div class="box-body">
                    <?php foreach ($members as $m): ?>
                        <div style="margin-bottom:10px; display:flex; align-items:center;">
                            <img src="<?= !empty($m['foto_profil']) ? base_url('fotokaryawan/' . $m['foto_profil']) : base_url('assets/img/default-avatar.png') ?>" class="img-circle" style="width:32px;height:32px;object-fit:cover;margin-right:8px;">
                            <div>
                                <strong><?= esc($m['nama_lengkap']) ?></strong>
                                <?php if ($m['role'] == 'admin'): ?>
                                    <span class="label label-warning">Admin</span>
                                <?php endif; ?>
                                <?php if ($m['id_siswa'] == session()->get('id_siswa')): ?>
                                    <span class="label label-info">Anda</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    var chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;

    var lastMessageId = <?= !empty($messages) ? end($messages)['id'] : 0 ?>;
    var groupId = <?= $id_group ?>;

    function pollGroupMessages() {
        $.ajax({
            url: '<?= base_url('siswa/chat/groups/ajax/' . $id_group) ?>',
            type: 'GET',
            data: { last_id: lastMessageId },
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success' && response.messages.length > 0) {
                    response.messages.forEach(function(msg) {
                        var isMe = (msg.id_pengirim == <?= session()->get('id_siswa') ?>);
                        var msgHtml = '<div class="direct-chat-msg ' + (isMe ? 'right' : '') + '" style="margin-bottom:10px;" data-id="' + msg.id + '">' +
                            '<div class="direct-chat-info clearfix">' +
                            '<span class="direct-chat-name pull-' + (isMe ? 'right' : 'left') + '">' + (isMe ? 'Anda' : (msg.sender_name || 'Anggota')) + '</span>' +
                            '<span class="direct-chat-timestamp pull-' + (isMe ? 'left' : 'right') + '">' + msg.created_at.substring(11, 16) + '</span>' +
                            '</div>' +
                            '<div class="direct-chat-text" style="background:' + (isMe ? '#3c8dbc' : '#d2d6de') + '; color:' + (isMe ? '#fff' : '#444') + '; border-radius:10px; padding:8px 12px; max-width:75%; float:' + (isMe ? 'right' : 'left') + '; word-wrap:break-word;">' +
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

    setInterval(pollGroupMessages, 3000);

    $('#groupChatForm').on('submit', function(e) {
        e.preventDefault();
        var pesan = $('#groupChatInput').val().trim();
        if (!pesan) return;

        $.ajax({
            url: '<?= base_url('siswa/chat/groups/send') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    $('#groupChatInput').val('');
                    pollGroupMessages();
                } else {
                    alert(response.message || 'Gagal mengirim');
                }
            }
        });
    });
});
</script>

<style>
.direct-chat-messages::-webkit-scrollbar { width:6px; }
.direct-chat-messages::-webkit-scrollbar-thumb { background:#ccc; border-radius:3px; }
</style>

<?= $this->endSection() ?>