<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- SweetAlert2 Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php $p = $payment ?? []; ?>
<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-file-o"></i> Detail Pembayaran
            </h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_karyawan/pembayaran') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="box-body">
            <!-- Kode Transaksi & Status Header -->
            <div class="alert alert-info" role="alert">
                <strong>Kode Transaksi:</strong> <?= esc($p['kode_transaksi'] ?? '-') ?>
                <span class="pull-right">
                    <span class="label label-<?= ($p['status_pembayaran'] ?? '') === 'success' ? 'success' : (($p['status_pembayaran'] ?? '') === 'pending' ? 'warning' : 'danger') ?>">
                        <i class="fa fa-circle"></i> <?= esc(ucfirst($p['status_pembayaran'] ?? 'pending')) ?>
                    </span>
                </span>
            </div>

            <!-- Detail Informasi Pembayaran -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-bold">Nama Pengirim</label>
                        <p class="form-control-static"><?= esc($p['nama_pengirim'] ?? '-') ?></p>
                    </div>
                    <div class="form-group">
                        <label class="text-bold">Jumlah Bayar</label>
                        <p class="form-control-static text-success">
                            <strong>Rp <?= number_format($p['jumlah_bayar'] ?? 0, 0, ',', '.') ?></strong>
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-bold">Metode Pembayaran</label>
                        <p class="form-control-static"><?= esc(ucfirst(str_replace('_', ' ', $p['metode_pembayaran'] ?? ''))) ?></p>
                    </div>
                    <div class="form-group">
                        <label class="text-bold">Tanggal Transaksi</label>
                        <p class="form-control-static"><?= !empty($p['tanggal_transaksi']) ? date('d/m/Y H:i', strtotime($p['tanggal_transaksi'])) : '-' ?></p>
                    </div>
                </div>
            </div>

            <!-- Catatan Admin -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="text-bold">Catatan Admin</label>
                        <p class="form-control-static"><?= esc($p['alasan_penolakan'] ?? '-') ?></p>
                    </div>
                </div>
            </div>

            <!-- Bukti Bayar -->
            <?php if (!empty($p['bukti_bayar'])): ?>
                <div class="form-group" style="margin-top: 20px;">
                    <label class="text-bold">Bukti Pembayaran</label>
                    <div style="margin-top: 10px;">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalBukti">
                            <i class="fa fa-image"></i> Lihat Bukti Pembayaran
                        </button>
                        <a href="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" download class="btn btn-default">
                            <i class="fa fa-download"></i> Download Bukti
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <?php if (($p['status_pembayaran'] ?? '') === 'pending'): ?>
                <hr style="margin: 30px 0;">

                <div class="form-group">
                    <label class="text-bold">Tindakan Verifikasi</label>
                    <div style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <!-- Tombol Konfirmasi -->
                        <button type="button" class="btn btn-success btn-lg" onclick="confirmPayment()">
                            <i class="fa fa-check-circle"></i> Konfirmasi Pembayaran
                        </button>

                        <!-- Tombol Tolak -->
                        <button type="button" class="btn btn-danger btn-lg" onclick="rejectPayment()">
                            <i class="fa fa-times-circle"></i> Tolak Pembayaran
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ========== MODAL LIHAT BUKTI ========== -->
<div class="modal fade" id="modalBukti" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-image"></i> Bukti Pembayaran - <?= esc($p['kode_transaksi'] ?? '') ?>
                </h4>
            </div>
            <div class="modal-body text-center">
                <?php if (!empty($p['bukti_bayar'])): ?>
                    <div style="overflow: auto; max-height: 500px;">
                        <img id="zoomImage" src="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" 
                             alt="Bukti Pembayaran" 
                             style="max-width: 100%; cursor: pointer;"
                             ondblclick="toggleZoom()">
                    </div>
                    <div style="margin-top: 15px;">
                        <button type="button" class="btn btn-sm btn-default" onclick="zoomIn()">
                            <i class="fa fa-search-plus"></i> Zoom In
                        </button>
                        <button type="button" class="btn btn-sm btn-default" onclick="zoomOut()">
                            <i class="fa fa-search-minus"></i> Zoom Out
                        </button>
                        <button type="button" class="btn btn-sm btn-default" onclick="resetZoom()">
                            <i class="fa fa-compress"></i> Reset
                        </button>
                        <span class="zoom-level text-muted" style="margin-left: 10px;">100%</span>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Tidak ada bukti pembayaran</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <?php if (!empty($p['bukti_bayar'])): ?>
                    <a href="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" download class="btn btn-info">
                        <i class="fa fa-download"></i> Download
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL TOLAK PEMBAYARAN ========== -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa fa-times-circle"></i> Tolak Pembayaran
                </h4>
            </div>

            <?= form_open('home_karyawan/konfirmasi/' . ($p['id_pembayaran'] ?? ''), ['method' => 'post']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" name="action" value="reject">

                <div class="form-group">
                    <label for="alasan_penolakan" class="text-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" rows="4" placeholder="Jelaskan alasan pembayaran ditolak..." required></textarea>
                    <small class="text-muted">Alasan ini akan dikirim ke siswa</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                    <i class="fa fa-times"></i> Tolak Pembayaran
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- ========== ZOOM JAVASCRIPT ========== -->
<script>
let currentZoom = 1;
const minZoom = 0.25;
const maxZoom = 3;
const zoomStep = 0.25;

function zoomIn() {
    if (currentZoom < maxZoom) {
        currentZoom += zoomStep;
        applyZoom();
    }
}

function zoomOut() {
    if (currentZoom > minZoom) {
        currentZoom -= zoomStep;
        applyZoom();
    }
}

function resetZoom() {
    currentZoom = 1;
    applyZoom();
}

function applyZoom() {
    const img = document.getElementById('zoomImage');
    const zoomLevel = document.querySelector('.zoom-level');
    
    if (img) {
        img.style.width = (currentZoom * 100) + '%';
        img.style.maxWidth = 'none';
        
        // Update zoom level display
        if (zoomLevel) {
            zoomLevel.textContent = Math.round(currentZoom * 100) + '%';
        }
    }
}

// Double click to toggle zoom
function toggleZoom() {
    if (currentZoom === 1) {
        currentZoom = 2;
    } else {
        resetZoom();
    }
    applyZoom();
}

// SweetAlert2 Confirmation Functions
function confirmPayment() {
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        html: `
            <p>Apakah Anda yakin ingin <strong>mengkonfirmasi</strong> pembayaran ini?</p>
            <div style="text-align: left; margin-top: 20px;">
                <strong>Kode Transaksi:</strong> <?= esc($p['kode_transaksi'] ?? '') ?><br>
                <strong>Nama Pengirim:</strong> <?= esc($p['nama_pengirim'] ?? '') ?><br>
                <strong>Jumlah:</strong> Rp <?= number_format($p['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
            </div>
        `,
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Konfirmasi!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form untuk konfirmasi
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('home_karyawan/konfirmasi/' . ($p['id_pembayaran'] ?? '')) ?>';
            
            // Add CSRF token
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '<?= csrf_token() ?>';
            csrf.value = '<?= csrf_hash() ?>';
            form.appendChild(csrf);
            
            // Add action
            const action = document.createElement('input');
            action.type = 'hidden';
            action.name = 'action';
            action.value = 'confirm';
            form.appendChild(action);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectPayment() {
    Swal.fire({
        title: 'Tolak Pembayaran',
        html: `
            <p>Apakah Anda yakin ingin <strong>menolak</strong> pembayaran ini?</p>
            <div style="text-align: left; margin-top: 20px;">
                <strong>Kode Transaksi:</strong> <?= esc($p['kode_transaksi'] ?? '') ?><br>
                <strong>Nama Pengirim:</strong> <?= esc($p['nama_pengirim'] ?? '') ?><br>
                <strong>Jumlah:</strong> Rp <?= number_format($p['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show input for reason
            Swal.fire({
                title: 'Alasan Penolakan',
                input: 'textarea',
                inputLabel: 'Alasan penolakan akan dikirim ke siswa',
                inputPlaceholder: 'Jelaskan alasan pembayaran ditolak...',
                inputAttributes: {
                    'aria-label': 'Alasan penolakan',
                    'required': 'true'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Kirim Penolakan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan penolakan harus diisi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form untuk penolakan dengan alasan
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '<?= base_url('home_karyawan/konfirmasi/' . ($p['id_pembayaran'] ?? '')) ?>';
                    
                    // Add CSRF token
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '<?= csrf_token() ?>';
                    csrf.value = '<?= csrf_hash() ?>';
                    form.appendChild(csrf);
                    
                    // Add action
                    const action = document.createElement('input');
                    action.type = 'hidden';
                    action.name = 'action';
                    action.value = 'reject';
                    form.appendChild(action);
                    
                    // Add reason
                    const reason = document.createElement('input');
                    reason.type = 'hidden';
                    reason.name = 'alasan_penolakan';
                    reason.value = result.value;
                    form.appendChild(reason);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    });
}
</script>

<?= $this->endSection() ?>