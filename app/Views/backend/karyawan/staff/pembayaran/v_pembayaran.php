<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= $title2 ?? 'Verifikasi Pembayaran' ?></h3>
        </div>
        <div class="box-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('warning')): ?>
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('warning') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama / Email</th>
                            <th>Kursus</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payments) && is_array($payments)): ?>
                            <?php $no = 1; foreach ($payments as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['kode_transaksi'] ?? '-') ?></td>
                                    <td>
                                        <strong><?= esc($row['nama_lengkap'] ?? '-') ?></strong><br>
                                        <small><?= esc($row['email'] ?? '') ?></small>
                                    </td>
                                    <td><?= esc($row['nama_kursus'] ?? '-') ?></td>
                                    <td>Rp <?= number_format($row['jumlah_bayar'] ?? 0, 0, ',', '.') ?></td>
                                    <td><?= esc(ucfirst(str_replace('_', ' ', $row['metode_pembayaran'] ?? ''))) ?></td>
                                    <td><?= !empty($row['tanggal_transaksi']) ? date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])) : '-' ?></td>
                                    <td>
                                        <a href="<?= base_url('home_karyawan/pembayaran/detail/' . ($row['id_pembayaran'] ?? '')) ?>" class="btn btn-xs btn-info">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada pembayaran menunggu verifikasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Real-time Payment Status Update -->
<script>
    // Auto-check payment status updates
    let lastStatusCheck = Date.now();
    let statusCheckInterval;

    function checkPaymentUpdates() {
        fetch('<?= base_url('home_karyawan/check_payment_updates') ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.has_updates) {
                // Update UI untuk pembayaran yang berubah
                updatePaymentRows(data.updated_payments);
                
                // Tampilkan notifikasi
                showNotification(data.updated_payments);
            }
        })
        .catch(error => {
            console.log('Error checking payment updates:', error);
        });
    }

    // Fungsi untuk update baris pembayaran
    function updatePaymentRows(updatedPayments) {
        updatedPayments.forEach(payment => {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 7) {
                    const kodeTransaksi = cells[1].textContent.trim();
                    
                    // Cocokkan dengan kode transaksi
                    if (kodeTransaksi === payment.kode_transaksi) {
                        const actionCell = cells[7]; // Kolom aksi
                        
                        // Update status badge di baris
                        updateRowStatus(row, payment.status_pembayaran);
                        
                        // Update tombol aksi
                        if (actionCell && payment.status_pembayaran === 'success') {
                            actionCell.innerHTML = `
                                <span class="badge bg-success me-1">
                                    <i class="fa fa-check"></i> Dikonfirmasi
                                </span>
                                <a href="<?= base_url('home_karyawan/pembayaran/detail/' . ($row['id_pembayaran'] ?? '')) ?>" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                            `;
                        }
                    }
                }
            });
        });
    }

    // Fungsi untuk update status baris
    function updateRowStatus(row, status) {
        const statusMap = {
            'pending': { badge: 'bg-warning', icon: 'fa-clock', text: 'Pending' },
            'processing': { badge: 'bg-info', icon: 'fa-spinner', text: 'Processing' },
            'success': { badge: 'bg-success', icon: 'fa-check', text: 'Dikonfirmasi' },
            'failed': { badge: 'bg-danger', icon: 'fa-times', text: 'Ditolak' }
        };

        const statusInfo = statusMap[status] || statusMap['pending'];
        
        // Update kelas baris berdasarkan status
        row.className = row.className.replace(/bg-\w+|bg-\w+/g, '');
        
        if (status === 'success') {
            row.classList.add('table-success');
        } else if (status === 'failed') {
            row.classList.add('table-danger');
        } else if (status === 'processing') {
            row.classList.add('table-info');
        }
    }

    // Fungsi untuk menampilkan notifikasi
    function showNotification(updatedPayments) {
        updatedPayments.forEach(payment => {
            if (payment.status_pembayaran === 'success') {
                // Tampilkan toast notification
                showToast(`Pembayaran ${payment.kode_transaksi} telah dikonfirmasi!`, 'success');
            } else if (payment.status_pembayaran === 'failed') {
                showToast(`Pembayaran ${payment.kode_transaksi} ditolak!`, 'error');
            }
        });
    }

    // Fungsi toast notification
    function showToast(message, type = 'info') {
        // Buat toast container jika belum ada
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
            `;
            document.body.appendChild(toastContainer);
        }

        // Buat toast element
        const toast = document.createElement('div');
        toast.className = `toast alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'}`;
        toast.style.cssText = `
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
            color: white;
            padding: 12px 20px;
            margin-bottom: 10px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 300px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        `;
        toast.innerHTML = `
            <div style="display: flex; align-items: center;">
                <i class="fa ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'}" style="margin-right: 10px;"></i>
                ${message}
            </div>
        `;

        toastContainer.appendChild(toast);

        // Animasi muncul
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove setelah 5 detik
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);
    }

    // Mulai auto-check
    function startAutoCheck() {
        // Check setiap 45 detik untuk admin (lebih reasonable)
        statusCheckInterval = setInterval(checkPaymentUpdates, 45000);
        
        // Juga check setiap 2 menit dengan sedikit delay
        setInterval(() => {
            if (Date.now() - lastStatusCheck > 120000) {
                checkPaymentUpdates();
                lastStatusCheck = Date.now();
            }
        }, 120000);
    }

    // Mulai setelah halaman loaded
    document.addEventListener('DOMContentLoaded', function() {
        startAutoCheck();
    });

    // Stop auto-check ketika user meninggalkan halaman
    window.addEventListener('beforeunload', function() {
        if (statusCheckInterval) {
            clearInterval(statusCheckInterval);
        }
    });
</script>

<?= $this->endSection() ?>
