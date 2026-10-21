<?php $this->extend('backend/template_user/main'); ?>
<?php $this->section('content'); ?>
<div class="container-fluid">
    <h1><?= esc($title2) ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active">Backup Database</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Daftar Backup</strong>
            <button class="btn btn-primary" id="btn-create-backup">
                <i class="fas fa-plus"></i> Buat Backup Baru
            </button>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-striped" id="backup-table">
                    <thead>
                        <tr>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($files)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada backup</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($files as $f): ?>
                                <tr>
                                    <td><?= esc($f['name']) ?></td>
                                    <td><?= esc($f['size']) ?></td>
                                    <td><?= esc($f['date']) ?></td>
                                    <td>
                                        <a href="<?= base_url('backup/download/' . $f['name']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete" data-file="<?= esc($f['name']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$('#btn-create-backup').click(function() {
    $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Membuat...');
    $.post('<?= base_url("backup/create") ?>', function(res) {
        $('#btn-create-backup').prop('disabled', false).html('<i class="fas fa-plus"></i> Buat Backup Baru');
        if (res.status === 'success') {
            location.reload();
        } else {
            alert('Error: ' + res.message);
        }
    }, 'json');
});
$('.btn-delete').click(function() {
    if (!confirm('Hapus backup ini?')) return;
    var btn = $(this);
    var file = btn.data('file');
    $.post('<?= base_url("backup/delete/") ?>' + file, function(res) {
        if (res.status === 'success') {
            btn.closest('tr').remove();
        }
    }, 'json');
});
</script>
<?php $this->endSection(); ?>