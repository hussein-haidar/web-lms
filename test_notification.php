<?php
// Test script untuk memverifikasi notifikasi Status Pembayaran
// Simpan file ini di root project dan akses via browser untuk testing

include_once 'app/Config/Database.php';
include_once 'app/Models/M_pembayaran.php';

$db = \Config\Database::connect();
$paymentModel = new \App\Models\M_pembayaran();

echo "<h2>Test Notifikasi Status Pembayaran</h2>";

// Test 1: Cek semua pembayaran pending
echo "<h3>1. Semua Pembayaran Pending:</h3>";
$allPending = $paymentModel->getPendingPayments();
echo "Jumlah: " . count($allPending) . "<br>";
foreach ($allPending as $p) {
    echo "- {$p['nama_lengkap']} - {$p['kode_transaksi']} - {$p['status_pembayaran']}<br>";
}

// Test 2: Cek pembayaran pending per siswa (contoh id_siswa = 1)
echo "<h3>2. Pembayaran Pending per Siswa (ID=1):</h3>";
$pendingBySiswa = $db->table('pendaftaran')
    ->join('pembayaran', 'pembayaran.kode_invoice = pendaftaran.kode_invoice', 'inner')
    ->where('pendaftaran.id_siswa', 1)
    ->whereIn('pembayaran.status_pembayaran', ['pending', 'failed'])
    ->get()
    ->getResultArray();

echo "Jumlah: " . count($pendingBySiswa) . "<br>";
foreach ($pendingBySiswa as $p) {
    echo "- {$p['kode_invoice']} - {$p['status_pembayaran']}<br>";
}

// Test 3: Cek semua siswa yang punya pembayaran pending
echo "<h3>3. Daftar Siswa dengan Pembayaran Pending:</h3>";
$siswaPending = $db->table('pendaftaran')
    ->select('pendaftaran.id_siswa, siswa.nama_lengkap, COUNT(pembayaran.id_pembayaran) as count_pending')
    ->join('pembayaran', 'pembayaran.kode_invoice = pendaftaran.kode_invoice', 'inner')
    ->join('siswa', 'siswa.id_siswa = pendaftaran.id_siswa')
    ->whereIn('pembayaran.status_pembayaran', ['pending', 'failed'])
    ->groupBy('pendaftaran.id_siswa')
    ->get()
    ->getResultArray();

foreach ($siswaPending as $siswa) {
    echo "- {$siswa['nama_lengkap']} (ID: {$siswa['id_siswa']}) = {$siswa['count_pending']} notifikasi<br>";
}

echo "<h3>Test Selesai!</h3>";
?>
