<?php
// Cek konfigurasi admin WhatsApp
require_once 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<h2>📋 Analisis Konfigurasi Admin WhatsApp</h2>";

// Cek staf_admin
$adminWAs = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, no_telepon, level, status')
    ->where('level', 'staf_admin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

echo "<h3>👨‍💼 Staf Admin Aktif:</h3>";
if (empty($adminWAs)) {
    echo "<p style='color: red;'>❌ Tidak ada staf admin aktif!</p>";
} else {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Nama</th><th>No Telepon</th><th>Format WA</th><th>Level</th></tr>";
    foreach ($adminWAs as $admin) {
        $formatWA = '62' . substr($admin['no_telepon'], 1);
        echo "<tr>";
        echo "<td>{$admin['id_karyawan']}</td>";
        echo "<td><strong>{$admin['nama_lengkap']}</strong></td>";
        echo "<td>{$admin['no_telepon']}</td>";
        echo "<td><code>$formatWA</code></td>";
        echo "<td>{$admin['level']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Cek superadmin
$superadminWAs = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, no_telepon, level, status')
    ->where('level', 'superadmin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

echo "<h3>👑 Superadmin Aktif:</h3>";
if (empty($superadminWAs)) {
    echo "<p style='color: red;'>❌ Tidak ada superadmin aktif!</p>";
} else {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Nama</th><th>No Telepon</th><th>Format WA</th><th>Level</th></tr>";
    foreach ($superadminWAs as $admin) {
        $formatWA = '62' . substr($admin['no_telepon'], 1);
        echo "<tr>";
        echo "<td>{$admin['id_karyawan']}</td>";
        echo "<td><strong>{$admin['nama_lengkap']}</strong></td>";
        echo "<td>{$admin['no_telepon']}</td>";
        echo "<td><code>$formatWA</code></td>";
        echo "<td>{$admin['level']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Total admin yang akan menerima notifikasi
$totalAdmins = count($adminWAs) + count($superadminWAs);
echo "<h3>📊 Summary:</h3>";
echo "<ul>";
echo "<li>Total Admin Aktif: <strong>$totalAdmins</strong> orang</li>";
echo "<li>Staf Admin: " . count($adminWAs) . " orang</li>";
echo "<li>Superadmin: " . count($superadminWAs) . " orang</li>";
echo "</ul>";

echo "<h3>🔧 Rekomendasi Solusi WhatsApp Tanpa Token:</h3>";
echo "<ol>";
echo "<li><strong>WhatsApp Business API (Resmi)</strong> - Stabil tapi berbayar</li>";
echo "<li><strong>WatsApp.com</strong> - Gratis 50 pesan/hari tanpa token</li>";
echo "<li><strong>CallmeBot</strong> - Gratis 20 pesan/hari tanpa token</li>";
echo "<li><strong>TextMagic</strong> - Trial gratis, kemudian berbayar</li>";
echo "</ol>";

echo "<p style='color: green;'><strong>✅ Solusi yang saya rekomendasikan: WatsApp.com</strong></p>";
echo "<p>Alasan: Gratis 50 pesan/hari, tidak perlu token, mudah diimplementasikan</p>";
?>
