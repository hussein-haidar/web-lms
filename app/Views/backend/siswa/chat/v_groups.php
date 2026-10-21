<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-users"></i> Group Chat</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createGroupModal">
                            <i class="fa fa-plus"></i> Buat Group
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <?php if (empty($groups)): ?>
                        <div class="callout callout-info">
                            <p><i class="fa fa-info-circle"></i> Belum ada group chat.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($groups as $g): ?>
                            <div class="user-block" style="margin-bottom:15px; padding-bottom:15px; border-bottom:1px solid #f4f4f4;">
                                <img class="img-circle" src="<?= base_url('assets/img/default-avatar.png') ?>" alt="Group" style="width:40px;height:40px;object-fit:cover;">
                                <span class="username">
                                    <a href="<?= base_url('siswa/chat/groups/' . $g['id_group']) ?>"><?= esc($g['nama_group']) ?></a>
                                    <?php if ($g['unread_count'] > 0): ?>
                                        <span class="label label-success"><?= $g['unread_count'] ?> baru</span>
                                    <?php endif; ?>
                                </span>
                                <span class="description" style="margin-top:5px;">
                                    <?= esc(mb_strimwidth($g['last_message'] ?? '', 0, 60, '...')) ?>
                                    <?php if ($g['last_time']): ?>
                                        &middot; <?= date('d M, H:i', strtotime($g['last_time'])) ?>
                                    <?php endif; ?>
                                </span>
                                <div style="margin-top:8px;">
                                    <small class="text-muted"><?= $g['member_count'] ?> anggota</small>
                                    <?php if ($g['role'] == 'admin'): ?>
                                        <span class="label label-warning">Admin</span>
                                    <?php endif; ?>
                                    <a href="<?= base_url('siswa/chat/groups/' . $g['id_group']) ?>" class="btn btn-xs btn-primary pull-right">
                                        <i class="fa fa-comments"></i> Buka
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Create Group Modal -->
<div class="modal fade" id="createGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Buat Group Baru</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Group</label>
                    <input type="text" id="groupName" class="form-control" placeholder="Nama group...">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="groupDesc" class="form-control" rows="2" placeholder="Deskripsi group..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnCreateGroup">Buat Group</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#btnCreateGroup').click(function() {
    var nama = $('#groupName').val().trim();
    var deskripsi = $('#groupDesc').val().trim();
    if (!nama) { alert('Nama group wajib diisi'); return; }
    
    $.post('<?= base_url('siswa/chat/groups/create') ?>', {
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
        nama_group: nama,
        deskripsi: deskripsi
    }, function(res) {
        if (res.status == 'success') {
            location.reload();
        } else {
            alert(res.message || 'Gagal membuat group');
        }
    }, 'json');
});
</script>

<?= $this->endSection() ?>