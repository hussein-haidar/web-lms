<?php $this->extend('backend/template_user/main'); ?>
<?php $this->section('content'); ?>
<div class="container-fluid">
    <h1><?= esc($title2) ?></h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= esc($title2) ?></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Notifikasi</strong>
            <button class="btn btn-sm btn-outline-primary" onclick="markAllRead()">Tandai Semua Dibaca</button>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
            <?php endif; ?>
            <div id="notifikasi-list">
                <?php if (empty($notifikasi)): ?>
                    <p class="text-muted">Tidak ada notifikasi.</p>
                <?php else: ?>
                    <?php foreach ($notifikasi as $n): ?>
                        <div class="alert alert-<?= esc($n['tipe'] ?? 'info') ?> <?= $n['is_read'] ? 'alert-secondary' : '' ?> mb-2" id="notif-<?= esc($n['id_notifikasi']) ?>">
                            <strong><?= esc($n['judul']) ?></strong><br>
                            <?= esc($n['pesan']) ?>
                            <?php if ($n['link']): ?>
                                <br><a href="<?= esc($n['link']) ?>" class="btn btn-sm btn-outline-primary mt-1">Lihat</a>
                            <?php endif; ?>
                            <small class="text-muted d-block mt-1"><?= esc($n['created_at']) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
function markAllRead() {
    fetch('<?= base_url('home_siswa/notifikasi/mark-all-read') ?>', { method: 'POST' })
        .then(r => r.json()).then(data => {
            if (data.status === 'success') location.reload();
        });
}
function markRead(id) {
    fetch('<?= base_url('home_siswa/notifikasi/mark-read/') ?>' + id)
        .then(r => r.json()).then(data => {
            if (data.status === 'success') document.getElementById('notif-' + id).classList.remove('alert-info');
        });
}
</script>
<?php $this->endSection(); ?>
