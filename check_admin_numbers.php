<?php
// Check admin WhatsApp numbers
require_once 'vendor/autoload.php';

$db = \Config\Database::connect();
$admins = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, no_telepon, level, status')
    ->where('level', 'staf_admin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

echo "<h2>Admin WhatsApp Numbers</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Nama</th><th>No Telepon</th><th>Level</th><th>Status</th></tr>";

foreach($admins as $admin) {
    echo "<tr>";
    echo "<td>{$admin['id_karyawan']}</td>";
    echo "<td>{$admin['nama_lengkap']}</td>";
    echo "<td>{$admin['no_telepon']}</td>";
    echo "<td>{$admin['level']}</td>";
    echo "<td>{$admin['status']}</td>";
    echo "</tr>";
}
echo "</table>";

// Check if there are any superadmin too
$superadmins = $db->table('karyawan')
    ->select('id_karyawan, nama_lengkap, no_telepon, level, status')
    ->where('level', 'superadmin')
    ->where('status', 'aktif')
    ->get()
    ->getResultArray();

echo "<h2>Superadmin WhatsApp Numbers</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Nama</th><th>No Telepon</th><th>Level</th><th>Status</th></tr>";

foreach($superadmins as $admin) {
    echo "<tr>";
    echo "<td>{$admin['id_karyawan']}</td>";
    echo "<td>{$admin['nama_lengkap']}</td>";
    echo "<td>{$admin['no_telepon']}</td>";
    echo "<td>{$admin['level']}</td>";
    echo "<td>{$admin['status']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
