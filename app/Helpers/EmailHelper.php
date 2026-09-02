<?php

/**
 * EmailHelper - Fungsi helper untuk mengirim email notifikasi
 * 
 * Penggunaan:
 *   email_notifikasi($to, $subject, $message);
 *   email_pembayaran_disetujui($siswa, $pendaftaran, $pembayaran);
 *   email_pembayaran_ditolak($siswa, $pendaftaran, $alasan);
 *   email_pendaftaran_baru($admin_email, $siswa, $pendaftaran);
 *   email_sertifikat_siap($siswa, $sertifikat);
 */

if (!function_exists('email_notifikasi')) {
    /**
     * Kirim email notifikasi umum
     */
    function email_notifikasi($to, $subject, $message, $fromEmail = null, $fromName = null)
    {
        $config = [
            'SMTPHost'  => env('SMTP_HOST', 'smtp.gmail.com'),
            'SMTPPort'  => env('SMTP_PORT', 587),
            'SMTPCrypto' => env('SMTP_CRYPTO', 'tls'),
            'SMTPUser'  => env('SMTP_USER', ''),
            'SMTPPass'  => env('SMTP_PASS', ''),
            'mailType'  => 'html',
            'charset'   => 'utf-8',
        ];

        $email = \Config\Services::email();
        $email->initialize($config);

        $from = $fromEmail ?? env('SMTP_FROM', 'admin@lpkinasaba.com');
        $name = $fromName ?? env('SMTP_FROM_NAME', 'LPK INASABA');

        $email->setFrom($from, $name);
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            log_message('info', 'Email terkirim ke ' . $to . ': ' . $subject);
            return true;
        } else {
            log_message('error', 'Email gagal ke ' . $to . ': ' . $email->printDebugger(['headers']));
            return false;
        }
    }
}

if (!function_exists('email_pembayaran_disetujui')) {
    function email_pembayaran_disetujui($siswa, $pendaftaran, $pembayaran)
    {
        $subject = 'Pembayaran Disetujui - LPK INASABA';
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: #28a745; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
                <h2 style='margin:0;'>Pembayaran Disetujui</h2>
            </div>
            <div style='padding: 20px; border: 1px solid #ddd; border-top: none;'>
                <p>Hai <strong>{$siswa['nama_lengkap']}</strong>,</p>
                <p>Pembayaran Anda telah <strong style='color: #28a745;'>DISETUJUI</strong>.</p>
                <table style='width:100%; border-collapse: collapse; margin: 15px 0;'>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Kode Invoice</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$pembayaran['kode_invoice']}</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Kode Transaksi</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$pembayaran['kode_transaksi']}</td></tr>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Kursus</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$pendaftaran['nama_kursus']}</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Jumlah</strong></td><td style='padding:8px; border:1px solid #ddd;'>Rp " . number_format($pembayaran['jumlah_bayar'], 0, ',', '.') . "</td></tr>
                </table>
                <p>Silakan login untuk mulai belajar.</p>
                <a href='" . base_url('auth_login/login_siswa') . "' style='display:inline-block; background:#28a745; color:white; padding:10px 25px; text-decoration:none; border-radius:5px;'>Login Sekarang</a>
            </div>
            <div style='text-align:center; padding:10px; color:#999; font-size:12px;'>
                &copy; " . date('Y') . " LPK INASABA. All rights reserved.
            </div>
        </div>";

        return email_notifikasi($siswa['email'], $subject, $message);
    }
}

if (!function_exists('email_pembayaran_ditolak')) {
    function email_pembayaran_ditolak($siswa, $pendaftaran, $alasan)
    {
        $subject = 'Pembayaran Ditolak - LPK INASABA';
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
                <h2 style='margin:0;'>Pembayaran Ditolak</h2>
            </div>
            <div style='padding: 20px; border: 1px solid #ddd; border-top: none;'>
                <p>Hai <strong>{$siswa['nama_lengkap']}</strong>,</p>
                <p>Pembayaran Anda untuk kursus <strong>{$pendaftaran['nama_kursus']}</strong> <strong style='color:#dc3545;'>DITOLAK</strong>.</p>
                <p><strong>Alasan:</strong> " . htmlspecialchars($alasan) . "</p>
                <p>Silakan upload ulang bukti pembayaran yang valid.</p>
                <a href='" . base_url('home_siswa/status_bayar') . "' style='display:inline-block; background:#dc3545; color:white; padding:10px 25px; text-decoration:none; border-radius:5px;'>Upload Ulang</a>
            </div>
        </div>";

        return email_notifikasi($siswa['email'], $subject, $message);
    }
}

if (!function_exists('email_pendaftaran_baru')) {
    function email_pendaftaran_baru($adminEmail, $siswa, $pendaftaran)
    {
        $subject = 'Pendaftaran Baru - LPK INASABA';
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
                <h2 style='margin:0;'>Pendaftaran Baru</h2>
            </div>
            <div style='padding: 20px; border: 1px solid #ddd; border-top: none;'>
                <p>Ada pendaftaran baru dari <strong>{$siswa['nama_lengkap']}</strong></p>
                <table style='width:100%; border-collapse: collapse; margin: 15px 0;'>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Kursus</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$pendaftaran['nama_kursus']}</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Paket</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$pendaftaran['nama_paket']}</td></tr>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Harga</strong></td><td style='padding:8px; border:1px solid #ddd;'>Rp " . number_format($pendaftaran['harga_kursus'], 0, ',', '.') . "</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Invoice</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$pendaftaran['kode_invoice']}</td></tr>
                </table>
                <a href='" . base_url('home_karyawan/pembayaran') . "' style='display:inline-block; background:#007bff; color:white; padding:10px 25px; text-decoration:none; border-radius:5px;'>Lihat Pembayaran</a>
            </div>
        </div>";

        return email_notifikasi($adminEmail, $subject, $message);
    }
}

if (!function_exists('email_sertifikat_siap')) {
    function email_sertifikat_siap($siswa, $sertifikat)
    {
        $subject = 'Sertifikat Anda Siap - LPK INASABA';
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: #ffc107; color: #333; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
                <h2 style='margin:0;'>Sertifikat Siap Diambil</h2>
            </div>
            <div style='padding: 20px; border: 1px solid #ddd; border-top: none;'>
                <p>Hai <strong>{$siswa['nama_lengkap']}</strong>,</p>
                <p>Selamat! Sertifikat Anda untuk kursus <strong>{$sertifikat['nama_kursus']}</strong> sudah siap.</p>
                <p><strong>Kode Sertifikat:</strong> {$sertifikat['kode_sertifikat']}</p>
                <a href='" . base_url('sertifikat/') . "' style='display:inline-block; background:#ffc107; color:#333; padding:10px 25px; text-decoration:none; border-radius:5px;'>Lihat Sertifikat</a>
            </div>
        </div>";

        return email_notifikasi($siswa['email'], $subject, $message);
    }
}

if (!function_exists('email_hasil_quiz')) {
    function email_hasil_quiz($siswa, $quiz, $hasil, $is_lulus)
    {
        $status = $is_lulus ? 'LULUS' : 'TIDAK LULUS';
        $color = $is_lulus ? '#28a745' : '#dc3545';
        $subject = 'Hasil Quiz: ' . $status . ' - LPK INASABA';
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: {$color}; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
                <h2 style='margin:0;'>Hasil Quiz: {$status}</h2>
            </div>
            <div style='padding: 20px; border: 1px solid #ddd; border-top: none;'>
                <p>Hai <strong>{$siswa['nama_lengkap']}</strong>,</p>
                <p>Berikut hasil quiz Anda:</p>
                <table style='width:100%; border-collapse: collapse; margin: 15px 0;'>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Quiz</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$quiz['judul']}</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Nilai</strong></td><td style='padding:8px; border:1px solid #ddd;'><strong>" . round($hasil['total_nilai'], 1) . "%</strong></td></tr>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Benar</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$hasil['total_benar']}</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Salah</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$hasil['total_salah']}</td></tr>
                    <tr style='background:#f9f9f9;'><td style='padding:8px; border:1px solid #ddd;'><strong>Passing Grade</strong></td><td style='padding:8px; border:1px solid #ddd;'>{$quiz['passing_grade']}%</td></tr>
                    <tr><td style='padding:8px; border:1px solid #ddd;'><strong>Status</strong></td><td style='padding:8px; border:1px solid #ddd;'><span style='color:{$color}; font-weight:bold;'>{$status}</span></td></tr>
                </table>
                <a href='" . base_url('home_siswa/belajar/' . $hasil['id_pendaftaran']) . "' style='display:inline-block; background:#007bff; color:white; padding:10px 25px; text-decoration:none; border-radius:5px;'>Kembali ke Kursus</a>
            </div>
        </div>";

        return email_notifikasi($siswa['email'], $subject, $message);
    }
}
