<?php
// Test WhatsApp notification system
require_once 'vendor/autoload.php';

// Simulate payment data
$testPembayaran = [
    'kode_transaksi' => 'TRX-20250315-0001',
    'kode_invoice' => 'INV-20250315-001',
    'bank_tujuan' => 'BCA',
    'nama_pengirim' => 'Test User',
    'jumlah_bayar' => 1500000,
    'tanggal_transaksi' => date('Y-m-d H:i:s'),
    'status_pembayaran' => 'pending'
];

// Simulate student data
$testSiswa = [
    'nama_lengkap' => 'Test Siswa',
    'email' => 'test@student.com',
    'no_telepon' => '08123456789'
];

$fileName = 'test_bukti_12345.jpg';

echo "<h2>Test WhatsApp Notification System</h2>";

// Test 1: Check admin numbers
$db = \Config\Database::connect();

$adminWAs = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, no_telepon')
    ->where('level', 'staf_admin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();
    
$superadminWAs = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, no_telepon')
    ->where('level', 'superadmin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

$allAdmins = array_merge($adminWAs, $superadminWAs);

echo "<h3>Admin Target List:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Nama</th><th>No Telepon</th><th>Formatted WA</th></tr>";

foreach ($allAdmins as $admin) {
    $nomorWA = '62' . substr($admin['no_telepon'], 1);
    echo "<tr>";
    echo "<td>{$admin['nama_lengkap']}</td>";
    echo "<td>{$admin['no_telepon']}</td>";
    echo "<td>$nomorWA</td>";
    echo "</tr>";
}
echo "</table>";

// Test 2: Show message format
echo "<h3>Sample WhatsApp Message:</h3>";
echo "<pre style='background: #f0f0f0; padding: 10px; border-radius: 5px;'>";

$sampleAdmin = [
    'nama_lengkap' => 'Admin Test'
];

$namaAdmin = $sampleAdmin['nama_lengkap'];

$pesan = "👋 Hai *{$namaAdmin}*,

📸 *BUKTI PEMBAYARAN BARU - LPK INASABA* 📸

Ada siswa yang baru saja upload bukti pembayaran, mohon segera dicek ya:

📄 *Detail Pembayaran:*
• Kode Transaksi: `{$testPembayaran['kode_transaksi']}`
• Invoice: `{$testPembayaran['kode_invoice']}`
• Bank Tujuan: {$testPembayaran['bank_tujuan']}
• Nama Pengirim: {$testPembayaran['nama_pengirim']}
• Jumlah: Rp " . number_format($testPembayaran['jumlah_bayar'], 0, ',', '.') . "
• Waktu Upload: " . date('d/m/Y H:i', strtotime($testPembayaran['tanggal_transaksi'])) . "
• Status: *MENUNGGU VERIFIKASI* ⏰

👤 *Data Siswa:*
• Nama Lengkap: {$testSiswa['nama_lengkap']}
• Email: {$testSiswa['email']}
• Telepon: {$testSiswa['no_telepon']}

📎 *File Bukti Pembayaran:*
`{$fileName}`

🔗 *Link Langsung Verifikasi:*
" . base_url('home_karyawan/pembayaran') . "

Terima kasih atas perhatiannya! 🙏

_Dikirim otomatis oleh LPK INASABA System_";

echo htmlspecialchars($pesan);
echo "</pre>";

// Test 3: Check API configuration
echo "<h3>API Configuration Check:</h3>";
echo "<ul>";
echo "<li>API Endpoint: https://api.fonnte.com/send</li>";
echo "<li>Authorization Token: 1xHSJRoHVFU2UeY3pEPb</li>";
echo "<li>Method: POST</li>";
echo "<li>Content-Type: application/x-www-form-urlencoded</li>";
echo "</ul>";

echo "<h3>Test Complete!</h3>";
echo "<p><strong>Note:</strong> To actually send WhatsApp messages, make sure:</p>";
echo "<ul>";
echo "<li>Fonnte API token is valid and has credits</li>";
echo "<li>Admin phone numbers are correct and active on WhatsApp</li>";
echo "<li>Server can make outbound HTTP requests</li>";
echo "</ul>";
?>
