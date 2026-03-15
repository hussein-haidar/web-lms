<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Verifikasi Sertifikat - LMS</title>
</head>
<body>
    <div style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; font-family: Arial, sans-serif;">
        <?php if (isset($is_valid) && $is_valid && !empty($sertifikat)): ?>
            <!-- VALID CERTIFICATE -->
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="background: #28a745; color: white; padding: 10px 20px; border-radius: 20px; display: inline-block; margin-bottom: 20px;">
                    <i>✓</i> SERTIFIKAT VALID
                </div>
                <h3>Verifikasi Berhasil</h3>
                <p style="color: #666;">Sertifikat ini valid dan diterbitkan oleh sistem LMS</p>
            </div>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;">
                <h5><i>📜</i> Informasi Sertifikat</h5>
                <table width="100%" border="0" cellpadding="5">
                    <tr>
                        <td width="40%" valign="top"><strong>Nomor Sertifikat:</strong></td>
                        <td width="60%" valign="top"><?= esc($sertifikat['nomor_sertifikat']) ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Nama Peserta:</strong></td>
                        <td valign="top"><?= esc($sertifikat['nama_peserta']) ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Kursus:</strong></td>
                        <td valign="top"><?= esc($sertifikat['nama_kursus']) ?></td>
                    </tr>
                    <?php if (!empty($sertifikat['nama_paket'])): ?>
                    <tr>
                        <td valign="top"><strong>Paket:</strong></td>
                        <td valign="top"><?= esc($sertifikat['nama_paket']) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td valign="top"><strong>Predikat:</strong></td>
                        <td valign="top"><?= esc($sertifikat['predikat']) ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Nilai Akhir:</strong></td>
                        <td valign="top"><?= $sertifikat['nilai_akhir'] ?>/100</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Tanggal Terbit:</strong></td>
                        <td valign="top"><?= date('d F Y', strtotime($sertifikat['tanggal_terbit'])) ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Masa Studi:</strong></td>
                        <td valign="top"><?= date('d F Y', strtotime($sertifikat['tanggal_mulai'])) ?> - <?= date('d F Y', strtotime($sertifikat['tanggal_selesai'])) ?></td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <h5><i>📱</i> Kode Verifikasi</h5>
                <div style="border: 2px dashed #ccc; width: 150px; height: 150px; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                    <i style="font-size: 48px; color: #666;">📱</i>
                </div>
                <p style="color: #666; font-size: 12px;">
                    Scan QR code untuk verifikasi cepat<br>
                    <small><?= base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']) ?></small>
                </p>
            </div>

            <div style="background: #d4edda; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;">
                <strong><i>🛡️</i> Dijamin Keasliannya:</strong> Sertifikat ini dapat diverifikasi secara online dan tercatat dalam sistem kami.
            </div>

        <?php else: ?>
            <!-- INVALID CERTIFICATE -->
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="background: #dc3545; color: white; padding: 10px 20px; border-radius: 20px; display: inline-block; margin-bottom: 20px;">
                    <i>✗</i> SERTIFIKAT TIDAK VALID
                </div>
                <h3>Verifikasi Gagal</h3>
                <p style="color: #666;">Nomor sertifikat tidak ditemukan atau tidak valid dalam sistem kami</p>
            </div>

            <div style="background: #f8d7da; padding: 15px; border-radius: 5px; border-left: 4px solid #dc3545;">
                <strong><i>⚠️</i> Kemungkinan Penyebab:</strong>
                <ul>
                    <li>Nomor sertifikat salah atau typo</li>
                    <li>Sertifikat tidak pernah diterbitkan</li>
                    <li>Sertifikat sudah dibatalkan atau dinonaktifkan</li>
                    <li>Data sertifikat rusak atau hilang</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <p style="color: #666;">Silakan periksa kembali nomor sertifikat atau hubungi admin untuk bantuan lebih lanjut.</p>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 20px;">
            <a href="<?= base_url('sertifikat/verify') ?>" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; margin-right: 10px;">
                <i>🔍</i> Verifikasi Lagi
            </a>
            <a href="<?= base_url() ?>" style="display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none;">
                <i>←</i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
