<?php
// Cek nomor siswa (pengirim) dan admin (penerima)
require_once 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<h2>📋 Cek Nomor Pengirim & Penerima WhatsApp</h2>";

// Cek data siswa (pengirim)
echo "<h3>👨‍🎓 Data Siswa (Pengirim Bukti Bayar):h3>";
$siswaAktif = $db->table('siswa')
    ->select('id_siswa, nama_lengkap, email, no_telepon, status')
    ->where('status', 'aktif')
    ->limit(5) // Tampilkan 5 siswa terakhir
    ->get()
    ->getResultArray();

if (empty($siswaAktif)) {
    echo "<p style='color: red;'>❌ Tidak ada siswa aktif!</p>";
} else {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background: #e3f2fd;'><th>ID</th><th>Nama Lengkap</th><th>Email</th><th>No Telepon</th><th>Format WA</th><th>Status</th></tr>";
    foreach ($siswaAktif as $siswa) {
        $formatWA = preg_replace('/^0/', '62', $siswa['no_telepon']);
        echo "<tr>";
        echo "<td>{$siswa['id_siswa']}</td>";
        echo "<td><strong>{$siswa['nama_lengkap']}</strong></td>";
        echo "<td>{$siswa['email']}</td>";
        echo "<td>{$siswa['no_telepon']}</td>";
        echo "<td><code style='background: #f0f0f0;'>$formatWA</code></td>";
        echo "<td>{$siswa['status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Cek data admin (penerima)
echo "<h3>👨‍💼 Data Admin (Penerima Notifikasi):h3>";

// Staf Admin
$adminWAs = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, email, no_telepon, level, status')
    ->where('level', 'staf_admin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

if (!empty($adminWAs)) {
    echo "<h4>📋 Staf Admin:</h4>";
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background: #e8f5e8;'><th>ID</th><th>Nama Lengkap</th><th>Email</th><th>No Telepon</th><th>Format WA</th><th>Level</th></tr>";
    foreach ($adminWAs as $admin) {
        $formatWA = preg_replace('/^0/', '62', $admin['no_telepon']);
        echo "<tr>";
        echo "<td>{$admin['id_karyawan']}</td>";
        echo "<td><strong>{$admin['nama_lengkap']}</strong></td>";
        echo "<td>{$admin['email']}</td>";
        echo "<td>{$admin['no_telepon']}</td>";
        echo "<td><code style='background: #f0f0f0;'>$formatWA</code></td>";
        echo "<td>{$admin['level']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Superadmin
$superadminWAs = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, email, no_telepon, level, status')
    ->where('level', 'superadmin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

if (!empty($superadminWAs)) {
    echo "<h4>👑 Superadmin:</h4>";
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background: #fff3e0;'><th>ID</th><th>Nama Lengkap</th><th>Email</th><th>No Telepon</th><th>Format WA</th><th>Level</th></tr>";
    foreach ($superadminWAs as $admin) {
        $formatWA = preg_replace('/^0/', '62', $admin['no_telepon']);
        echo "<tr>";
        echo "<td>{$admin['id_karyawan']}</td>";
        echo "<td><strong>{$admin['nama_lengkap']}</strong></td>";
        echo "<td>{$admin['email']}</td>";
        echo "<td>{$admin['no_telepon']}</td>";
        echo "<td><code style='background: #f0f0f0;'>$formatWA</code></td>";
        echo "<td>{$admin['level']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

if (empty($adminWAs) && empty($superadminWAs)) {
    echo "<p style='color: red;'>❌ Tidak ada admin aktif!</p>";
}

// Summary
echo "<h3>📊 Summary:</h3>";
$totalSiswa = count($siswaAktif);
$totalAdmin = count($adminWAs) + count($superadminWAs);
echo "<ul>";
echo "<li><strong>Total Siswa Aktif:</strong> $totalSiswa orang</li>";
echo "<li><strong>Staf Admin:</strong> " . count($adminWAs) . " orang</li>";
echo "<li><strong>Superadmin:</strong> " . count($superadminWAs) . " orang</li>";
echo "<li><strong>Total Penerima Notifikasi:</strong> $totalAdmin orang</li>";
echo "</ul>";

// Test alur pengiriman
echo "<h3>🔄 Alur Pengiriman Notifikasi:</h3>";
echo "<ol>";
echo "<li><strong>Siswa Upload Bukti Bayar</strong> → Sistem dapat data siswa (pengirim)</li>";
echo "<li><strong>Format Nomor Siswa:</strong> 08123456789 → 628123456789</li>";
echo "<li><strong>Ambil Data Admin:</strong> Semua admin aktif (penerima)</li>";
echo "<li><strong>Format Nomor Admin:</strong> 08567890123 → 628567890123</li>";
echo "<li><strong>Kirim Pesan:</strong> Setiap admin dapat pesan personal</li>";
echo "</ol>";

echo "<h3>📱 Contoh Format Nomor:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Asli</th><th>Format WhatsApp</th><th>Keterangan</th></tr>";
echo "<tr><td>08123456789</td><td><code>628123456789</code></td><td>Format internasional Indonesia</td></tr>";
echo "<tr><td>08567890123</td><td><code>628567890123</code></td><td>Format internasional Indonesia</td></tr>";
echo "<tr><td>08213456789</td><td><code>628213456789</code></td><td>Format internasional Indonesia</td></tr>";
echo "</table>";

echo "<h3>✅ Validasi Format:</h3>";
$testNumbers = ['08123456789', '08567890123', '08213456789'];
foreach ($testNumbers as $num) {
    $formatted = preg_replace('/^0/', '62', $num);
    echo "• $num → <strong style='color: green;'>$formatted</strong> ✅<br>";
}

echo "<h3>🔍 Cara Test:</h3>";
echo "<ol>";
echo "<li>Pastikan ada siswa dan admin aktif</li>";
echo "<li>Login sebagai siswa</li>";
echo "<li>Upload bukti pembayaran</li>";
echo "<li>Cek WhatsApp admin apakah menerima notifikasi</li>";
echo "<li>Cek log di <code>writable/logs/log-*.php</code></li>";
echo "</ol>";

echo "<p style='color: blue;'><strong>💡 Catatan:</strong> Pastikan nomor WhatsApp admin dan siswa valid dan aktif!</p>";
?>
