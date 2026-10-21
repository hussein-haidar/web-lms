<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary direct-chat">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-comments"></i> Chat dengan <?= esc($other['nama_lengkap'] ?? 'Pengajar') ?>
                        <span id="onlineStatus" class="label label-default" style="font-size:11px; margin-left:5px;">Offline</span>
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" id="btnSearch" title="Cari pesan"><i class="fa fa-search"></i></button>
                        <button class="btn btn-box-tool" id="btnExport" title="Export chat"><i class="fa fa-download"></i></button>
                        <a href="<?= base_url('siswa/chat') ?>" class="btn btn-box-tool" title="Kembali">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Search Bar -->
                <div id="searchBar" style="display:none; padding:10px; border-bottom:1px solid #f4f4f4;">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari pesan...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="btnDoSearch"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                    <div id="searchResults" style="max-height:150px; overflow-y:auto; margin-top:5px;"></div>
                </div>

                <div class="box-body" style="padding:10px;">
                    <!-- Typing Indicator -->
                    <div id="typingIndicator" style="display:none; padding:5px 10px; color:#999; font-size:12px; font-style:italic;">
                        <i class="fa fa-pencil"></i> Sedang mengetik...
                    </div>

                    <!-- Chat Messages -->
                    <div class="direct-chat-messages" id="chatMessages" style="height:400px; overflow-y:auto;">
                        <?php foreach ($messages as $msg): ?>
                            <?php $is_me = ($msg['id_pengirim'] == session()->get('id_siswa')); ?>
                            <div class="direct-chat-msg <?= $is_me ? 'right' : '' ?>" id="msg-<?= $msg['id'] ?>" style="margin-bottom:10px;" data-id="<?= $msg['id'] ?>">
                                <div class="direct-chat-info clearfix">
                                    <span class="direct-chat-name pull-<?= $is_me ? 'right' : 'left' ?>">
                                        <?= $is_me ? 'Anda' : esc($other['nama_lengkap'] ?? 'Pengajar') ?>
                                        <?php if ($msg['is_edited'] ?? 0): ?>
                                            <small class="text-muted">(diedit)</small>
                                        <?php endif; ?>
                                        <?php if ($msg['is_pinned'] ?? 0): ?>
                                            <i class="fa fa-thumb-tack" style="color:#f39c12; font-size:10px;"></i>
                                        <?php endif; ?>
                                    </span>
                                    <span class="direct-chat-timestamp pull-<?= $is_me ? 'left' : 'right' ?>">
                                        <?= date('H:i', strtotime($msg['created_at'])) ?>
                                        <?php if ($is_me && ($msg['is_read'] ?? 0)): ?>
                                            <i class="fa fa-check-double" style="color:#3c8dbc; font-size:10px;" title="Dibaca"></i>
                                        <?php elseif ($is_me): ?>
                                            <i class="fa fa-check" style="color:#999; font-size:10px;" title="Terkirim"></i>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($msg['reply_to'])): ?>
                                    <div style="font-size:11px; color:#999; padding:2px 8px; margin-bottom:2px; border-left:2px solid #ccc;">
                                        <i class="fa fa-reply"></i> Membalas pesan #<?= $msg['reply_to'] ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="direct-chat-text" style="background:<?= $is_me ? '#3c8dbc' : '#d2d6de' ?>; color:<?= $is_me ? '#fff' : '#444' ?>; border-radius:10px; padding:8px 12px; max-width:75%; float:<?= $is_me ? 'right' : 'left' ?>; word-wrap:break-word;">
                                    <?php if (!empty($msg['file_name'])): ?>
                                        <?php if (strpos($msg['file_type'] ?? '', 'image/') === 0): ?>
                                            <img src="<?= base_url('uploads/chat/' . $msg['file_name']) ?>" style="max-width:200px; border-radius:5px; margin-bottom:5px;" alt="Image">
                                            <br>
                                        <?php else: ?>
                                            <a href="<?= base_url('uploads/chat/' . $msg['file_name']) ?>" target="_blank" style="color:<?= $is_me ? '#fff' : '#333' ?>;">
                                                <i class="fa fa-file"></i> <?= esc($msg['file_name']) ?>
                                            </a>
                                            <br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?= nl2br(esc($msg['pesan'])) ?>
                                </div>
                                
                                <!-- Message Actions -->
                                <div style="clear:both; text-align:<?= $is_me ? 'right' : 'left' ?>; margin-top:2px;">
                                    <div class="btn-group btn-group-xs" style="opacity:0.7;">
                                        <button class="btn btn-default btn-xs" onclick="reactMessage(<?= $msg['id'] ?>, '👍')" title="Like">👍</button>
                                        <button class="btn btn-default btn-xs" onclick="reactMessage(<?= $msg['id'] ?>, '❤️')" title="Love">❤️</button>
                                        <button class="btn btn-default btn-xs" onclick="replyMessage(<?= $msg['id'] ?>)" title="Reply"><i class="fa fa-reply"></i></button>
                                        <button class="btn btn-default btn-xs" onclick="pinMessage(<?= $msg['id'] ?>)" title="Pin"><i class="fa fa-thumb-tack"></i></button>
                                        <?php if ($is_me): ?>
                                            <button class="btn btn-default btn-xs" onclick="editMessage(<?= $msg['id'] ?>)" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button class="btn btn-default btn-xs" onclick="deleteMessage(<?= $msg['id'] ?>)" title="Hapus"><i class="fa fa-trash"></i></button>
                                        <?php endif; ?>
                                    </div>
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
                    <div id="replyPreview" style="display:none; padding:5px 10px; background:#f8f9fa; border-left:3px solid #3c8dbc; margin-bottom:5px; font-size:12px;">
                        <span id="replyText"></span>
                        <button class="btn btn-xs btn-default pull-right" onclick="cancelReply()"><i class="fa fa-times"></i></button>
                    </div>
                    <form id="chatForm" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penerima" value="<?= $other_id ?>">
                        <input type="hidden" name="role_penerima" value="<?= $other_role ?>">
                        <input type="hidden" name="reply_to" id="replyTo" value="">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label class="btn btn-default btn-flat" style="margin:0;">
                                    <i class="fa fa-paperclip"></i>
                                    <input type="file" name="file" id="fileInput" style="display:none;" accept="image/*,.pdf,.doc,.docx">
                                </label>
                            </span>
                            <input type="text" name="pesan" id="chatInput" class="form-control" placeholder="Ketik pesan..." autocomplete="off">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-flat" id="btnEmoji" title="Emoji">😊</button>
                                <button type="submit" class="btn btn-primary btn-flat" id="btnSend">
                                    <i class="fa fa-paper-plane"></i> Kirim
                                </button>
                            </span>
                        </div>
                        <div id="filePreview" style="display:none; margin-top:5px; font-size:12px; color:#666;"></div>
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
                        <span id="onlineStatusSidebar" class="label label-default">Offline</span>
                    </p>
                    <button class="btn btn-xs btn-default" onclick="exportChat()"><i class="fa fa-download"></i> Export Chat</button>
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
    var isTyping = false;
    var typingTimer;

    // Online status check
    function checkOnlineStatus() {
        $.get('<?= base_url('api/siswa/chat/online/' . $other_id) ?>', function(res) {
            var status = res.online ? 'Online' : 'Offline';
            var cls = res.online ? 'label-success' : 'label-default';
            $('#onlineStatus, #onlineStatusSidebar').text(status).removeClass('label-success label-default').addClass(cls);
        });
    }
    checkOnlineStatus();
    setInterval(checkOnlineStatus, 30000);

    // Typing indicator check
    function checkTyping() {
        $.get('<?= base_url('api/siswa/chat/typing/' . $other_id) ?>', function(res) {
            $('#typingIndicator').toggle(res.is_typing);
            if (res.is_typing) chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }
    setInterval(checkTyping, 2000);

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
                        var msgHtml = buildMessageHtml(msg, isMe);
                        $('#chatMessages').append(msgHtml);
                        lastMessageId = msg.id;
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        });
    }

    function buildMessageHtml(msg, isMe) {
        var html = '<div class="direct-chat-msg ' + (isMe ? 'right' : '') + '" id="msg-' + msg.id + '" style="margin-bottom:10px;" data-id="' + msg.id + '">';
        html += '<div class="direct-chat-info clearfix">';
        html += '<span class="direct-chat-name pull-' + (isMe ? 'right' : 'left') + '">' + (isMe ? 'Anda' : '<?= esc($other['nama_lengkap'] ?? 'Pengajar') ?>') + (msg.is_edited ? ' <small class="text-muted">(diedit)</small>' : '') + (msg.is_pinned ? ' <i class="fa fa-thumb-tack" style="color:#f39c12;font-size:10px;"></i>' : '') + '</span>';
        html += '<span class="direct-chat-timestamp pull-' + (isMe ? 'left' : 'right') + '">' + msg.created_at.substring(11, 16);
        if (isMe) {
            html += msg.is_read ? ' <i class="fa fa-check-double" style="color:#3c8dbc;font-size:10px;" title="Dibaca"></i>' : ' <i class="fa fa-check" style="color:#999;font-size:10px;" title="Terkirim"></i>';
        }
        html += '</span></div>';
        
        if (msg.reply_to) {
            html += '<div style="font-size:11px;color:#999;padding:2px 8px;margin-bottom:2px;border-left:2px solid #ccc;"><i class="fa fa-reply"></i> Membalas pesan #' + msg.reply_to + '</div>';
        }
        
        html += '<div class="direct-chat-text" style="background:' + (isMe ? '#3c8dbc' : '#d2d6de') + '; color:' + (isMe ? '#fff' : '#444') + '; border-radius:10px; padding:8px 12px; max-width:75%; float:' + (isMe ? 'right' : 'left') + '; word-wrap:break-word;">';
        if (msg.file_name) {
            if (msg.file_type && msg.file_type.indexOf('image/') === 0) {
                html += '<img src="<?= base_url('uploads/chat/') ?>' + msg.file_name + '" style="max-width:200px;border-radius:5px;margin-bottom:5px;" alt="Image"><br>';
            } else {
                html += '<a href="<?= base_url('uploads/chat/') ?>' + msg.file_name + '" target="_blank" style="color:' + (isMe ? '#fff' : '#333') + ';"><i class="fa fa-file"></i> ' + msg.file_name + '</a><br>';
            }
        }
        html += msg.pesan.replace(/\n/g, '<br>') + '</div>';
        
        html += '<div style="clear:both; text-align:' + (isMe ? 'right' : 'left') + '; margin-top:2px;">';
        html += '<div class="btn-group btn-group-xs" style="opacity:0.7;">';
        html += '<button class="btn btn-default btn-xs" onclick="reactMessage(' + msg.id + ', \'👍\')" title="Like">👍</button>';
        html += '<button class="btn btn-default btn-xs" onclick="reactMessage(' + msg.id + ', \'❤️\')" title="Love">❤️</button>';
        html += '<button class="btn btn-default btn-xs" onclick="replyMessage(' + msg.id + ')" title="Reply"><i class="fa fa-reply"></i></button>';
        html += '<button class="btn btn-default btn-xs" onclick="pinMessage(' + msg.id + ')" title="Pin"><i class="fa fa-thumb-tack"></i></button>';
        if (isMe) {
            html += '<button class="btn btn-default btn-xs" onclick="editMessage(' + msg.id + ')" title="Edit"><i class="fa fa-pencil"></i></button>';
            html += '<button class="btn btn-default btn-xs" onclick="deleteMessage(' + msg.id + ')" title="Hapus"><i class="fa fa-trash"></i></button>';
        }
        html += '</div></div><div style="clear:both;"></div></div>';
        return html;
    }

    pollInterval = setInterval(pollMessages, 3000);

    // Kirim pesan
    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        var pesan = $('#chatInput').val().trim();
        var file = $('#fileInput')[0].files[0];
        if (!pesan && !file) return;

        var formData = new FormData(this);
        $.ajax({
            url: '<?= base_url('api/siswa/chat/send') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    $('#chatInput').val('');
                    $('#fileInput').val('');
                    $('#filePreview').hide();
                    $('#replyTo').val('');
                    $('#replyPreview').hide();
                    pollMessages();
                } else {
                    alert(response.message || 'Gagal mengirim pesan');
                }
            }
        });
    });

    // Typing indicator
    $('#chatInput').on('input', function() {
        if (!isTyping) {
            isTyping = true;
            $.post('<?= base_url('api/siswa/chat/typing') ?>', {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                other_id: otherId,
                is_typing: 1
            });
        }
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            isTyping = false;
            $.post('<?= base_url('api/siswa/chat/typing') ?>', {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                other_id: otherId,
                is_typing: 0
            });
        }, 2000);
    });

    // File preview
    $('#fileInput').on('change', function() {
        var file = this.files[0];
        if (file) {
            $('#filePreview').text('📎 ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)').show();
        } else {
            $('#filePreview').hide();
        }
    });

    // Search
    $('#btnSearch').click(function() {
        $('#searchBar').toggle();
    });
    $('#btnDoSearch').click(function() {
        var keyword = $('#searchInput').val().trim();
        if (!keyword) return;
        $.get('<?= base_url('api/siswa/chat/search') ?>', { keyword: keyword, other_id: otherId }, function(res) {
            var html = '';
            if (res.status == 'success' && res.messages.length > 0) {
                res.messages.forEach(function(m) {
                    html += '<div style="padding:3px 5px; border-bottom:1px solid #eee; font-size:12px;">' +
                        '<strong>' + (m.id_pengirim == <?= session()->get('id_siswa') ?> ? 'Anda' : '<?= esc($other['nama_lengkap'] ?? 'Pengajar') ?>') + ':</strong> ' +
                        m.pesan.substring(0, 60) + '...' +
                        '<small class="text-muted pull-right">' + m.created_at.substring(0, 16) + '</small></div>';
                });
            } else {
                html = '<div class="text-muted" style="padding:5px;">Tidak ditemukan</div>';
            }
            $('#searchResults').html(html);
        });
    });

    // Export
    $('#btnExport').click(function() {
        window.location.href = '<?= base_url('api/siswa/chat/export/' . $other_id) ?>';
    });

    // Emoji picker
    $('#btnEmoji').click(function() {
        var emojis = ['😀','😂','😍','👍','❤️','🎉','🔥','😎','🤔','😢'];
        var html = '<div style="position:absolute; bottom:60px; right:10px; background:white; border:1px solid #ccc; border-radius:5px; padding:5px; z-index:1000;">';
        emojis.forEach(function(e) {
            html += '<button class="btn btn-xs btn-default" style="font-size:18px; margin:2px;" onclick="insertEmoji(\'' + e + '\')">' + e + '</button>';
        });
        html += '</div>';
        if ($('#emojiPicker').length) {
            $('#emojiPicker').remove();
        } else {
            $('body').append('<div id="emojiPicker">' + html + '</div>');
        }
    });

    function insertEmoji(emoji) {
        $('#chatInput').val($('#chatInput').val() + emoji);
        $('#emojiPicker').remove();
        $('#chatInput').focus();
    }

    // Reply
    var replyToId = null;
    function replyMessage(id) {
        replyToId = id;
        $('#replyTo').val(id);
        $('#replyText').text('Membalas pesan #' + id);
        $('#replyPreview').show();
        $('#chatInput').focus();
    }
    function cancelReply() {
        replyToId = null;
        $('#replyTo').val('');
        $('#replyPreview').hide();
    }

    // Pin
    function pinMessage(id) {
        $.post('<?= base_url('api/siswa/chat/pin/') ?>' + id, { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }, function(res) {
            if (res.status == 'success') {
                $('#msg-' + id).find('.fa-thumb-tack').toggle(res.is_pinned);
            }
        });
    }

    // React
    function reactMessage(id, emoji) {
        $.post('<?= base_url('api/siswa/chat/react/') ?>' + id, {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            emoji: emoji
        }, function(res) {
            if (res.status == 'success') {
                // Could show reaction count
            }
        });
    }

    // Edit
    function editMessage(id) {
        var newText = prompt('Edit pesan:');
        if (!newText) return;
        $.post('<?= base_url('api/siswa/chat/edit/') ?>' + id, {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            pesan: newText
        }, function(res) {
            if (res.status == 'success') {
                $('#msg-' + id).find('.direct-chat-text').last().html(newText.replace(/\n/g, '<br>'));
            } else {
                alert(res.message);
            }
        });
    }

    // Delete
    function deleteMessage(id) {
        if (!confirm('Hapus pesan ini?')) return;
        $.post('<?= base_url('api/siswa/chat/delete/') ?>' + id, { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }, function(res) {
            if (res.status == 'success') {
                $('#msg-' + id).fadeOut(300, function() { $(this).remove(); });
            } else {
                alert(res.message);
            }
        });
    }

    // Update online status
    setInterval(function() {
        $.post('<?= base_url('api/siswa/chat/online') ?>', { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' });
    }, 60000);

    // Close emoji picker when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('#emojiPicker, #btnEmoji').length) {
            $('#emojiPicker').remove();
        }
    });
});
</script>

<style>
.direct-chat-messages::-webkit-scrollbar { width:6px; }
.direct-chat-messages::-webkit-scrollbar-thumb { background:#ccc; border-radius:3px; }
.direct-chat-msg.right .direct-chat-text { float:right; }
.direct-chat-msg.left .direct-chat-text { float:left; }
#emojiPicker { position:fixed; z-index:9999; }
</style>

<?= $this->endSection() ?>