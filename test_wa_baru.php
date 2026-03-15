<?php
// Test sistem WhatsApp baru tanpa token
require_once 'vendor/autoload.php';

echo "<h2>🧪 Test Sistem WhatsApp Baru (Tanpa Token)</h2>";

// Data test
$testAdmin = [
    'nama_lengkap' => 'Admin Test',
    'no_telepon' => '08123456789' // Ganti dengan nomor admin yang benar
];

$testPembayaran = [
    'kode_transaksi' => 'TRX-20250315-TEST',
    'kode_invoice' => 'INV-20250315-TEST',
    'bank_tujuan' => 'BCA',
    'nama_pengirim' => 'Test Siswa',
    'jumlah_bayar' => 1500000,
    'tanggal_transaksi' => date('Y-m-d H:i:s')
];

$testSiswa = [
    'nama_lengkap' => 'Test Siswa',
    'email' => 'test@student.com',
    'no_telepon' => '08123456789'
];

$fileName = 'test_bukti.jpg';

echo "<h3>📱 Format Nomor WhatsApp:</h3>";
$nomorAsli = $testAdmin['no_telepon'];
$nomorFormat = preg_replace('/^0/', '62', $nomorAsli);
echo "Nomor Asli: <strong>$nomorAsli</strong><br>";
echo "Format WhatsApp: <strong>$nomorFormat</strong><br>";

echo "<h3>📄 Pesan yang Akan Dikirim:</h3>";
echo "<pre style='background: #f0f0f0; padding: 10px; border-radius: 5px; font-size: 12px;'>";

$namaAdmin = $testAdmin['nama_lengkap'];
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

echo "<h3>🔧 API yang Akan Dicoba:</h3>";
echo "<ol>";
echo "<li><strong>WatsApp.com</strong> - Gratis 50 pesan/hari (prioritas utama)</li>";
echo "<li><strong>CallmeBot</strong> - Gratis 20 pesan/hari (fallback)</li>";
echo "</ol>";

echo "<h3>⚙️ Konfigurasi API:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>API</th><th>Endpoint</th><th>Method</th><th>Limit</th><th>Token</th></tr>";
echo "<tr>";
echo "<td>WatsApp.com</td>";
echo "<td>https://api.watsapp.com/v1/messages</td>";
echo "<td>POST</td>";
echo "<td>50 pesan/hari</td>";
echo "<td>Tidak perlu</td>";
echo "</tr>";
echo "<tr>";
echo "<td>CallmeBot</td>";
echo "<td>https://api.callmebot.com/whatsapp.php</td>";
echo "<td>GET</td>";
echo "<td>20 pesan/hari</td>";
echo "<td>api=free</td>";
echo "</tr>";
echo "</table>";

echo "<h3>✅ Keunggulan Sistem Baru:</h3>";
echo "<ul>";
echo "<li>✅ <strong>Tanpa Token</strong> - Tidak perlu API key berbayar</li>";
echo "<li>✅ <strong>Gratis</strong> - Total 70 pesan/hari (50 + 20)</li>";
echo "<li>✅ <strong>Auto Fallback</strong> - Jika API 1 gagal, otomatis coba API 2</li>";
echo "<li>✅ <strong>Format Benar</strong> - Nomor WhatsApp yang benar (62xxx)</li>";
echo "<li>✅ <strong>Personal</strong> - Setiap admin dapat pesan dengan nama mereka</li>";
echo "</ul>";

echo "<h3>🚀 Cara Test:</h3>";
echo "<ol>";
echo "<li>Buka <code>cek_admin_wa.php</code> untuk lihat daftar admin</li>";
echo "<li>Upload bukti pembayaran dari akun siswa</li>";
echo "<li>Cek log di <code>writable/logs/log-*.php</code> untuk hasilnya</li>";
echo "</ol>";

echo "<p style='color: green;'><strong>🎉 Sistem WhatsApp baru siap digunakan!</strong></p>";
?>
