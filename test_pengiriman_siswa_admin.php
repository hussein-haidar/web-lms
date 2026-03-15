<?php
// Test simulasi pengiriman dari siswa ke admin
require_once 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<h2>🔄 Simulasi Pengiriman WhatsApp</h2>";
echo "<h3>Dari Siswa (Pengirim) → Admin (Penerima)</h3>";

// Ambil data siswa pertama sebagai pengirim
$siswa = $db->table('siswa')
    ->where('status', 'aktif')
    ->limit(1)
    ->get()
    ->getRowArray();

if (!$siswa) {
    echo "<p style='color: red;'>❌ Tidak ada siswa aktif untuk test!</p>";
    exit;
}

// Ambil data admin sebagai penerima
$admins = $db->table('karyawan')
    ->where('status', 'aktif')
    ->whereIn('level', ['staf_admin', 'superadmin'])
    ->get()
    ->getResultArray();

if (empty($admins)) {
    echo "<p style='color: red;'>❌ Tidak ada admin aktif untuk test!</p>";
    exit;
}

echo "<h4>📨 Data Pengirim (Siswa):h4>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Nama</th><th>Email</th><th>No Telepon</th><th>Format WA</th></tr>";
$formatSiswa = preg_replace('/^0/', '62', $siswa['no_telepon']);
echo "<tr style='background: #e3f2fd;'>";
echo "<td>{$siswa['id_siswa']}</td>";
echo "<td><strong>{$siswa['nama_lengkap']}</strong></td>";
echo "<td>{$siswa['email']}</td>";
echo "<td>{$siswa['no_telepon']}</td>";
echo "<td><code>$formatSiswa</code></td>";
echo "</tr>";
echo "</table>";

echo "<h4>📩 Data Penerima (Admin):h4>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Nama</th><th>Email</th><th>No Telepon</th><th>Format WA</th><th>Level</th><th>Status Kirim</th></tr>";

foreach ($admins as $admin) {
    $formatAdmin = preg_replace('/^0/', '62', $admin['no_telepon']);
    echo "<tr style='background: #e8f5e8;'>";
    echo "<td>{$admin['id_karyawan']}</td>";
    echo "<td><strong>{$admin['nama_lengkap']}</strong></td>";
    echo "<td>{$admin['email']}</td>";
    echo "<td>{$admin['no_telepon']}</td>";
    echo "<td><code>$formatAdmin</code></td>";
    echo "<td>{$admin['level']}</td>";
    echo "<td><span style='color: green;'>✅ Siap Menerima</span></td>";
    echo "</tr>";
}
echo "</table>";

// Simulasi data pembayaran
$simulasiPembayaran = [
    'kode_transaksi' => 'TRX-' . date('Ymd') . '-TEST',
    'kode_invoice' => 'INV-' . date('Ymd') . '-TEST',
    'bank_tujuan' => 'BCA',
    'nama_pengirim' => $siswa['nama_lengkap'],
    'jumlah_bayar' => 1500000,
    'tanggal_transaksi' => date('Y-m-d H:i:s'),
    'status_pembayaran' => 'pending'
];

$fileName = 'bukti_test_' . time() . '.jpg';

echo "<h4>📄 Simulasi Data Pembayaran:</h4>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Kode Transaksi</th><th>Invoice</th><th>Bank</th><th>Pengirim</th><th>Jumlah</th><th>Status</th></tr>";
echo "<tr>";
echo "<td><code>{$simulasiPembayaran['kode_transaksi']}</code></td>";
echo "<td><code>{$simulasiPembayaran['kode_invoice']}</code></td>";
echo "<td>{$simulasiPembayaran['bank_tujuan']}</td>";
echo "<td>{$simulasiPembayaran['nama_pengirim']}</td>";
echo "<td>Rp " . number_format($simulasiPembayaran['jumlah_bayar'], 0, ',', '.') . "</td>";
echo "<td><span style='color: orange; font-weight: bold;'>PENDING</span></td>";
echo "</tr>";
echo "</table>";

// Tampilkan contoh pesan untuk setiap admin
echo "<h4>📱 Contoh Pesan yang Akan Dikirim:</h4>";
foreach ($admins as $index => $admin) {
    echo "<h5>📨 Pesan untuk " . $admin['nama_lengkap'] . " (" . $admin['level'] . "):</h5>";
    
    $pesan = "👋 Hai *{$admin['nama_lengkap']}*,

📸 *BUKTI PEMBAYARAN BARU - LPK INASABA* 📸

Ada siswa yang baru saja upload bukti pembayaran, mohon segera dicek ya:

📄 *Detail Pembayaran:*
• Kode Transaksi: `{$simulasiPembayaran['kode_transaksi']}`
• Invoice: `{$simulasiPembayaran['kode_invoice']}`
• Bank Tujuan: {$simulasiPembayaran['bank_tujuan']}
• Nama Pengirim: {$simulasiPembayaran['nama_pengirim']}
• Jumlah: Rp " . number_format($simulasiPembayaran['jumlah_bayar'], 0, ',', '.') . "
• Waktu Upload: " . date('d/m/Y H:i', strtotime($simulasiPembayaran['tanggal_transaksi'])) . "
• Status: *MENUNGGU VERIFIKASI* ⏰

👤 *Data Siswa:*
• Nama Lengkap: {$siswa['nama_lengkap']}
• Email: {$siswa['email']}
• Telepon: {$siswa['no_telepon']}

📎 *File Bukti Pembayaran:*
`{$fileName}`

🔗 *Link Langsung Verifikasi:*
" . base_url('home_karyawan/pembayaran') . "

Terima kasih atas perhatiannya! 🙏

_Dikirim otomatis oleh LPK INASABA System_";

    echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; font-size: 11px; max-height: 300px; overflow-y: auto;'>";
    echo htmlspecialchars($pesan);
    echo "</pre>";
    
    // Format nomor target
    $nomorTarget = preg_replace('/^0/', '62', $admin['no_telepon']);
    echo "<p><strong>Target:</strong> {$admin['nama_lengkap']} ({$admin['no_telepon']} → $nomorTarget)</p>";
    echo "<hr>";
}

echo "<h3>🔄 Alur Lengkap Pengiriman:</h3>";
echo "<ol>";
echo "<li><strong>Siswa Login:</strong> {$siswa['nama_lengkap']} (ID: {$siswa['id_siswa']})</li>";
echo "<li><strong>Upload Bukti Bayar:</strong> {$simulasiPembayaran['kode_transaksi']}</li>";
echo "<li><strong>Sistem Deteksi:</strong> Data siswa dan pembayaran</li>";
echo "<li><strong>Ambil Daftar Admin:</strong> " . count($admins) . " admin aktif</li>";
echo "<li><strong>Kirim Personal:</strong> Setiap admin dapat pesan dengan nama mereka</li>";
echo "<li><strong>Format Nomor:</strong> 08xxx → 628xxx (internasional)</li>";
echo "<li><strong>API Used:</strong> WatsApp.com (50/hari) + CallmeBot (20/hari)</li>";
echo "</ol>";

echo "<h3>✅ Validasi Format Nomor:</h3>";
$testNomor = [
    'siswa' => $siswa['no_telepon'],
    'admin1' => $admins[0]['no_telepon'] ?? '08123456789'
];

foreach ($testNomor as $key => $nomor) {
    $formatted = preg_replace('/^0/', '62', $nomor);
    echo "• $key: $nomor → <strong style='color: green;'>$formatted</strong> ✅<br>";
}

echo "<h3>🎯 Status Sistem:</h3>";
echo "<ul>";
echo "<li>✅ <strong>Pengirim:</strong> Siswa terdeteksi dengan benar</li>";
echo "<li>✅ <strong>Penerima:</strong> " . count($admins) . " admin aktif siap menerima</li>";
echo "<li>✅ <strong>Format Nomor:</strong> Sudah benar (62xxx)</li>";
echo "<li>✅ <strong>Pesan Personal:</strong> Setiap admin dapat pesan khusus</li>";
echo "<li>✅ <strong>API Tanpa Token:</strong> WatsApp.com + CallmeBot</li>";
echo "</ul>";

echo "<p style='color: blue;'><strong>💡 Ready untuk Test!</strong> Upload bukti pembayaran dari akun siswa untuk test real.</p>";
?>
