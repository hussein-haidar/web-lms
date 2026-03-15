<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <div class="text-center mb-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-block p-3 mb-3">
                        <i class="fas fa-clock fa-3x text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Status Pembayaran</h3>
                    <p class="text-muted">Silakan selesaikan pembayaran Anda dalam batas waktu yang ditentukan</p>
                </div>

                <?php
                $filtered_pembayaran = [];
                foreach ($pembayaran as $row) {
                    $status_pembayaran = $row['status_pembayaran'] ?? 'pending';

                    // HANYA tampilkan pending, processing, dan failed
                    // EXCLUDE success (sudah selesai)
                    if (in_array($status_pembayaran, ['pending', 'processing', 'failed'])) {
                        $filtered_pembayaran[] = $row;
                    }
                }
                ?>

                <?php if (empty($filtered_pembayaran)): ?>
                    <div class="text-center py-5 border rounded-3 bg-light">
                        <h5>Tidak ada pembayaran tertunda</h5>
                        <p class="text-muted small">Semua tagihan Anda telah terbayar atau Anda belum melakukan pembelian.</p>
                        <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-primary mt-2">Lihat Kursus</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kursus / Paket</th>
                                    <th class="text-end">Total Bayar</th>
                                    <th class="text-center">Status Pembayaran</th>
                                    <th class="text-center">Batas Waktu</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($filtered_pembayaran as $row):
                                    // Hitung batas waktu 2 jam dari tanggal pembayaran
                                    $deadlineTime = strtotime($row['tanggal_transaksi']) + (2 * 3600);
                                    $now = time();
                                    $isExpired = ($now > $deadlineTime) && ($row['status_pembayaran'] ?? $row['status_pembayaran'] ?? 'pending') === 'pending';

                                    // Tentukan status & badge
                                    $status_pembayaran = $row['status_pembayaran'] ?? $row['status_pembayaran'] ?? 'pending';
                                    $alasan_penolakan = $row['alasan_penolakan'] ?? '';

                                    if ($isExpired && $status_pembayaran === 'pending') {
                                        $statusLabel = 'Expired';
                                        $statusBadge = 'bg-danger';
                                        $statusIcon = 'fas fa-times-circle';
                                    } elseif ($status_pembayaran === 'processing') {
                                        $statusLabel = 'Menunggu Pembayaran';
                                        $statusBadge = 'bg-warning text-dark';
                                        $statusIcon = 'fas fa-clock';
                                    } elseif ($status_pembayaran === 'success') {
                                        $statusLabel = 'Dikonfirmasi';
                                        $statusBadge = 'bg-success';
                                        $statusIcon = 'fas fa-check-circle';
                                    } elseif ($status_pembayaran === 'failed') {
                                        $statusLabel = 'Ditolak';
                                        $statusBadge = 'bg-danger';
                                        $statusIcon = 'fas fa-times-circle';
                                    } else {
                                        $statusLabel = ucfirst($status_pembayaran);
                                        $statusBadge = 'bg-secondary';
                                        $statusIcon = 'fas fa-info-circle';
                                    }
                                ?>
                                    <tr id="payment-<?= $row['id_pembayaran'] ?>" data-deadline="<?= date('Y-m-d\TH:i:s', $deadlineTime) ?>">
                                        <td><?= $no++ ?></td>
                                        <td><small><?= date('d M Y, H:i', strtotime($row['tanggal_transaksi'])) ?></small></td>
                                        <td>
                                            <div class="fw-bold"><?= $row['nama_kursus'] ?></div>
                                            <small class="text-muted">
                                                <?php 
                                                // Handle multiple courses from GROUP_CONCAT
                                                $nama_kursus_array = explode(',', $row['nama_kursus'] ?? '');
                                                $nama_paket_array = explode(',', $row['nama_paket'] ?? '');
                                                
                                                if (count($nama_kursus_array) > 1) {
                                                    echo count($nama_kursus_array) . ' Kursus';
                                                    foreach ($nama_kursus_array as $i => $kursus) {
                                                        echo '<br>• ' . trim($kursus);
                                                    }
                                                } else {
                                                    echo 'Paket: ' . ($row['nama_paket'] ?? 'Tidak ada paket') . ' (' . ucfirst($row['nama_program'] ?? 'Kelas Online') . ')';
                                                }
                                                ?>
                                            </small>
                                            <?php if ($status_pembayaran === 'failed' && !empty($alasan_penolakan)): ?>
                                                <div class="alert alert-danger small mt-2 mb-0">
                                                    <div class="d-flex align-items-start">
                                                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                                        <div>
                                                            <strong>Pembayaran Ditolak!</strong><br>
                                                            <span class="small">Alasan: <?= esc($alasan_penolakan) ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end fw-bold text-primary">Rp<?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <span class="badge <?= $statusBadge ?> rounded-pill px-3 py-2">
                                                <i class="<?= $statusIcon ?> me-1"></i><?= $statusLabel ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if (($status_pembayaran === 'pending' || $status_pembayaran === 'failed') && !$isExpired): ?>
                                                <div class="small text-muted mb-1">Batas: <?= date('d M Y, H:i', $deadlineTime) ?></div>
                                                <div class="countdown-timer fw-bold text-danger" data-deadline="<?= date('Y-m-d\TH:i:s', $deadlineTime) ?>">
                                                    <i class="fas fa-hourglass-half me-1"></i>
                                                    <span class="countdown-text">Menghitung...</span>
                                                </div>
                                            <?php elseif ($isExpired): ?>
                                                <small class="text-danger fw-bold" title="Waktu upload bukti telah lewat"><i class="fas fa-clock me-1"></i>Batas: <?= date('d M Y, H:i', $deadlineTime) ?></small>
                                            <?php else: ?>
                                                <small class="text-muted">-</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($status_pembayaran === 'pending' && !$isExpired): ?>
                                                <a href="<?= base_url('home_siswa/upload_bukti/' . $row['id_pembayaran']) ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-upload me-1"></i>Upload Bukti
                                                </a>
                                            <?php elseif ($status_pembayaran === 'failed'): ?>
                                                <div class="d-flex flex-column gap-1">
                                                    <a href="<?= base_url('home_siswa/upload_bukti/' . $row['id_pembayaran']) ?>" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-redo me-1"></i>Upload Ulang
                                                    </a>
                                                    <small class="text-muted">Perbaiki dan upload ulang bukti</small>
                                                </div>
                                            <?php elseif ($isExpired): ?>
                                                <span class="text-muted small">Tidak tersedia</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted">Menunggu Konfirmasi</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="bg-primary bg-opacity-10 border border-primary rounded-3 p-4 mt-4 mb-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Petunjuk Pembayaran</h6>
                    <ol class="small mb-0">
                        <li class="mb-2">Batas waktu pembayaran adalah <strong>2 jam</strong> dari waktu pembelian.</li>
                        <li class="mb-2">Transfer ke rekening bank kami: <strong>BCA 1234567890</strong> a.n LPK INASADA</li>
                        <li class="mb-2">Gunakan Nama Lengkap atau No. Telepon Anda sebagai referensi transfer.</li>
                        <li class="mb-2">Jika sudah transfer, klik tombol <strong>"Upload Bukti"</strong> di atas.</li>
                        <li>Akses kursus akan terbuka otomatis setelah pembayaran dikonfirmasi oleh admin.</li>
                    </ol>
                </div>
            </div>

            <div class="text-center">
                <a href="<?= base_url('home_siswa/riwayat_beli') ?>" class="text-decoration-none">
                    <i class="fas fa-history me-1"></i>Lihat Semua Riwayat Pembelian
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Countdown timer untuk batas waktu pembayaran
    function updateCountdowns() {
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(timer => {
            const deadline = new Date(timer.dataset.deadline).getTime();
            const now = new Date().getTime();
            const diff = deadline - now;

            const textEl = timer.querySelector('.countdown-text');

            if (diff <= 0) {
                textEl.innerHTML = '<span class="text-danger">Batas waktu terlewati</span>';
                
                // Sembunyikan baris tabel yang sudah expired
                const tableRow = timer.closest('tr');
                if (tableRow) {
                    // Tambahkan efek fade out lalu sembunyikan
                    tableRow.style.transition = 'opacity 0.5s ease-out';
                    tableRow.style.opacity = '0.5';
                    
                    // Sembunyikan setelah 1 detik
                    setTimeout(() => {
                        tableRow.style.display = 'none';
                        
                        // Cek apakah masih ada pembayaran yang aktif
                        checkEmptyTable();
                    }, 1000);
                }
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            const pad = n => String(n).padStart(2, '0');
            textEl.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;

            // Warna berubah jika kurang dari 30 menit
            if (diff < 30 * 60 * 1000) {
                timer.classList.add('text-danger');
                timer.classList.remove('text-warning');
            } else {
                timer.classList.add('text-warning');
                timer.classList.remove('text-danger');
            }
        });
    }
    
    // Fungsi untuk menampilkan pesan jika tabel kosong
    function checkEmptyTable() {
        const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');
        const tableContainer = document.querySelector('.table-responsive');
        const emptyMessage = tableContainer?.previousElementSibling;
        
        if (visibleRows.length === 0 && emptyMessage && emptyMessage.classList.contains('text-center')) {
            // Sembunyikan tabel dan tampilkan pesan kosong
            tableContainer.style.display = 'none';
            emptyMessage.style.display = 'block';
        }
    }

    // Auto-check payment status dari admin
    let lastStatusCheck = Date.now();
    let statusCheckInterval;
    let processedInvoices = new Set(); // Track invoices that have shown alerts

    function checkPaymentStatus() {
        // Fetch current status via AJAX
        fetch('<?= base_url('home_siswa/check_payment_status') ?>', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.has_updates && data.status_data && data.status_data.length > 0) {
                    // Process each updated payment
                    data.status_data.forEach(payment => {
                        const invoiceKey = payment.kode_invoice;
                        
                        // Only show alert if we haven't processed this invoice before
                        if (!processedInvoices.has(invoiceKey)) {
                            processedInvoices.add(invoiceKey);
                            
                            // Determine message based on status
                            let title, message, icon;
                            if (payment.status_pembayaran === 'success') {
                                title = 'Pembayaran Dikonfirmasi!';
                                message = `
                                    <div class="text-center">
                                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                        <p class="mb-2">Pembayaran Anda telah <strong>dikonfirmasi</strong> oleh admin!</p>
                                        <p class="text-muted small">Status telah diperbarui secara real-time.</p>
                                    </div>
                                `;
                                icon = 'success';
                            } else if (payment.status_pembayaran === 'failed') {
                                title = 'Pembayaran Ditolak!';
                                message = `
                                    <div class="text-center">
                                        <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
                                        <p class="mb-2">Pembayaran Anda <strong>ditolak</strong> oleh admin!</p>
                                        <p class="text-muted small">Silakan upload ulang bukti pembayaran.</p>
                                        ${payment.alasan_penolakan ? `<p class="text-danger small"><strong>Alasan:</strong> ${payment.alasan_penolakan}</p>` : ''}
                                    </div>
                                `;
                                icon = 'error';
                            }
                            
                            // Tampilkan notifikasi SweetAlert2
                            Swal.fire({
                                title: title,
                                html: message,
                                icon: icon,
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                timer: 5000,
                                timerProgressBar: true
                            }).then((result) => {
                                // Reload page after user closes alert to refresh the data
                                if (result.isConfirmed || result.isDismissed) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
                    
                    // Update UI tanpa reload
                    updatePaymentUI(data.status_data);
                }
            })
            .catch(error => {
                console.log('Error checking payment status:', error);
            });
    }

    // Fungsi untuk update UI secara real-time
    function updatePaymentUI(statusData) {
        if (!statusData || !Array.isArray(statusData)) return;
        
        statusData.forEach(payment => {
            // Cari baris tabel berdasarkan kode invoice atau ID pembayaran
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 4) {
                    const paymentCell = cells[3]; // Kolom status pembayaran
                    const actionCell = cells[5]; // Kolom aksi
                    const deadlineCell = cells[4]; // Kolom batas waktu
                    
                    // Update status badge
                    const badge = paymentCell.querySelector('.badge');
                    if (badge && payment.status_pembayaran === 'success') {
                        badge.className = 'badge bg-success rounded-pill px-3 py-2';
                        badge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Dikonfirmasi';
                    }
                    
                    // Update kolom aksi
                    if (actionCell && payment.status_pembayaran === 'success') {
                        actionCell.innerHTML = '<span class="badge bg-light text-muted">Menunggu Konfirmasi</span>';
                    }
                    
                    // Update kolom deadline untuk status success
                    if (deadlineCell && payment.status_pembayaran === 'success') {
                        deadlineCell.innerHTML = '<small class="text-muted">-</small>';
                    }
                }
            });
        });
    }

    // Mulai auto-check hanya jika ada pembayaran pending/failed
    function startAutoCheck() {
        const pendingPayments = document.querySelectorAll('.badge.bg-warning, .badge.bg-danger');
        if (pendingPayments.length > 0) {
            // Check setiap 30 detik (lebih reasonable)
            statusCheckInterval = setInterval(checkPaymentStatus, 30000);
            
            // Gunakan EventSource atau WebSocket untuk real-time yang lebih baik
            // Fallback ke polling setiap 60 detik
            setInterval(() => {
                if (Date.now() - lastStatusCheck > 60000) {
                    checkPaymentStatus();
                    lastStatusCheck = Date.now();
                }
            }, 60000);
        }
    }

    // Update setiap detik
    updateCountdowns();
    setInterval(updateCountdowns, 1000);

    // Mulai auto-check setelah halaman loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Reset payment tracking when page loads to prevent duplicate alerts
        fetch('<?= base_url('home_siswa/reset_payment_tracking') ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              console.log('Payment tracking reset:', data);
          })
          .catch(error => {
              console.log('Error resetting payment tracking:', error);
          });

        // Load SweetAlert2 jika belum ada
        if (typeof Swal === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            script.onload = startAutoCheck;
            document.head.appendChild(script);
        } else {
            startAutoCheck();
        }
    });

    // Stop auto-check ketika user meninggalkan halaman
    window.addEventListener('beforeunload', function() {
        if (statusCheckInterval) {
            clearInterval(statusCheckInterval);
        }
    });
</script>

<?= $this->endSection() ?>