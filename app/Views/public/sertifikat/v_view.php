<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - LMS</title>
</head>
<body>
    <div style="max-width: 900px; margin: 20px auto; padding: 30px; border: 1px solid #ccc; font-family: Arial, sans-serif;">
        <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #667eea;">
            <h1 style="color: #667eea; margin-bottom: 10px;">
                📜 Sertifikat Kelulusan
            </h1>
            <div style="color: #666; font-size: 16px;">Nomor: <?= esc($sertifikat['nomor_sertifikat']) ?></div>
            <div style="margin-top: 15px;">
                <span style="background: #28a745; color: white; padding: 8px 20px; border-radius: 20px; font-weight: bold;">
                    ✓ <?= $sertifikat['is_verified'] ? 'Terverifikasi' : 'Belum Diverifikasi' ?>
                </span>
            </div>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h5>👤 Informasi Peserta</h5>
            <table width="100%" border="0" cellpadding="8">
                <tr>
                    <td width="30%" style="font-weight: bold;">Nama Peserta</td>
                    <td width="70%"><?= esc($sertifikat['nama_peserta']) ?></td>
                </tr>
                <?php if (!empty($sertifikat['nisn'])): ?>
                <tr>
                    <td style="font-weight: bold;">NISN</td>
                    <td><?= esc($sertifikat['nisn']) ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($sertifikat['nik'])): ?>
                <tr>
                    <td style="font-weight: bold;">NIK</td>
                    <td><?= esc($sertifikat['nik']) ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h5>🎓 Informasi Kursus</h5>
            <table width="100%" border="0" cellpadding="8">
                <tr>
                    <td width="30%" style="font-weight: bold;">Nama Kursus</td>
                    <td width="70%"><?= esc($sertifikat['nama_kursus']) ?></td>
                </tr>
                <?php if (!empty($sertifikat['nama_paket'])): ?>
                <tr>
                    <td style="font-weight: bold;">Paket</td>
                    <td><?= esc($sertifikat['nama_paket']) ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td style="font-weight: bold;">Predikat</td>
                    <td><?= esc($sertifikat['predikat']) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Nilai Akhir</td>
                    <td><?= esc($sertifikat['nilai_akhir']) ?></td>
                </tr>
            </table>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h5>📅 Informasi Waktu</h5>
            <table width="100%" border="0" cellpadding="8">
                <tr>
                    <td width="30%" style="font-weight: bold;">Tanggal Mulai</td>
                    <td width="70%"><?= date('d/m/Y', strtotime($sertifikat['tanggal_mulai'])) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Tanggal Selesai</td>
                    <td width="70%"><?= date('d/m/Y', strtotime($sertifikat['tanggal_selesai'])) ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Tanggal Terbit</td>
                    <td width="70%"><?= date('d/m/Y', strtotime($sertifikat['tanggal_terbit'])) ?></td>
                </tr>
            </table>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h5>🏢 Informasi Penerbit</h5>
            <table width="100%" border="0" cellpadding="8">
                <tr>
                    <td width="30%" style="font-weight: bold;">Diterbitkan oleh</td>
                    <td width="70%">
                        <?php 
                        $issuer_name = 'System';
                        if (!empty($sertifikat['issued_by']) && $sertifikat['issued_by'] > 0) {
                            // Get employee name from database
                            $db = \Config\Database::connect();
                            $karyawan = $db->table('karyawan')
                                ->select('nama_lengkap')
                                ->where('id_karyawan', $sertifikat['issued_by'])
                                ->get()
                                ->getRowArray();
                            $issuer_name = $karyawan ? $karyawan['nama_lengkap'] : 'Unknown';
                        }
                        echo esc($issuer_name);
                        ?>
                    </td>
                </tr>
                <?php if (!empty($sertifikat['nomor_ijin'])): ?>
                <tr>
                    <td style="font-weight: bold;">Nomor Ijin</td>
                    <td><?= esc($sertifikat['nomor_ijin']) ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <?php if (!empty($sertifikat['qr_code'])): ?>
        <div style="text-align: center; margin: 20px 0;">
            <h5>📱 Kode QR Verifikasi</h5>
            <div style="border: 2px dashed #ccc; width: 150px; height: 150px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                <?php 
                // Check if QR code is a URL (Google Charts) or local file
                if (strpos($sertifikat['qr_code'], 'http') === 0) {
                    // External QR code URL
                    echo '<img src="' . esc($sertifikat['qr_code']) . '" alt="QR Code" style="max-width: 150px; height: auto;">';
                } else {
                    // Local QR code file
                    $qr_path = WRITEPATH . $sertifikat['qr_code'];
                    if (file_exists($qr_path)) {
                        echo '<img src="' . base_url('writable/' . $sertifikat['qr_code']) . '" alt="QR Code" style="max-width: 150px; height: auto;">';
                    } else {
                        // Fallback to verification URL
                        echo '<div style="padding: 20px; background: #f8f9fa; border: 1px dashed #ccc; text-align: center;">';
                        echo '<p><strong>Kode Verifikasi:</strong></p>';
                        echo '<code style="background: #e9ecef; padding: 5px 10px; border-radius: 4px; display: inline-block;">' . esc($sertifikat['nomor_sertifikat']) . '</code>';
                        echo '<p style="color: #666; font-size: 12px; margin-top: 10px;">Scan QR code atau kunjungi: ' . base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']) . '</p>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 30px;">
            <a href="<?= base_url('sertifikat/verify') ?>" style="display: inline-block; padding: 12px 30px; background: #667eea; color: white; text-decoration: none; border-radius: 25px; font-weight: bold;">
                ← Kembali ke Verifikasi
            </a>
        </div>
    </div>
</body>
</html>
