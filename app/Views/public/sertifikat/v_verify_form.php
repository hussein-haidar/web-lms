<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat - LMS</title>
</head>
<body>
    <div style="max-width: 500px; margin: 50px auto; padding: 30px; border: 1px solid #ccc; font-family: Arial, sans-serif;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 48px; color: #667eea; margin-bottom: 10px;">📜</div>
            <h2>Verifikasi Sertifikat</h2>
            <p style="color: #666;">Masukkan nomor sertifikat untuk verifikasi keabsahan</p>
        </div>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
                <strong>⚠️ Error:</strong> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?= base_url('sertifikat/verify') ?>">
            <?= csrf_field() ?>
            <div style="margin-bottom: 20px;">
                <label for="kode" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    📊 Nomor Sertifikat
                </label>
                <input type="text" name="kode" id="kode" 
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;"
                       placeholder="Contoh: CERT/2024/COURSE/000001" required>
                <div style="font-size: 12px; color: #666; margin-top: 5px;">
                    Masukkan nomor sertifikat yang tertera di dokumen
                </div>
            </div>
            
            <div style="text-align: center;">
                <button type="submit" style="background: #667eea; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">
                    🔍 Verifikasi Sertifikat
                </button>
            </div>
        </form>
        
        <div style="text-align: center; margin-top: 30px;">
            <small style="color: #666;">
                ℹ️ Verifikasi ini untuk memastikan keabsahan sertifikat yang diterbitkan oleh LMS
            </small>
        </div>
        
        <div style="text-align: center; margin-top: 15px;">
            <a href="<?= base_url() ?>" style="color: #667eea; text-decoration: none;">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
