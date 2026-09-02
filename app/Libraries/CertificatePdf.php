<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Generator sertifikat PDF (dompdf) + thumbnail JPG (GD).
 *
 * Struktur file:
 *   writable/uploads/certificates/{tahun}/CERT_xxx.pdf          (PDF asli)
 *   writable/uploads/certificates/thumbs/{tahun}/CERT_xxx_thumb.jpg (preview)
 *   writable/certificates/qr_codes/qr_xxx.png                   (QR verifikasi)
 */
class CertificatePdf
{
    /**
     * Generate PDF + thumbnail untuk satu sertifikat.
     *
     * @param array $s Row tabel sertifikat.
     * @return array{file_pdf:string, file_thumb:string|null} Path relatif terhadap writable/uploads/certificates/
     */
    public static function generate(array $s): array
    {
        $safeNo    = strtoupper(str_replace(['/', '-'], '_', $s['nomor_sertifikat']));
        $filename  = 'CERT_' . $safeNo . '.pdf';
        $year      = date('Y', strtotime($s['tanggal_terbit'] ?? 'now'));

        $certDir   = WRITEPATH . 'uploads/certificates/' . $year;
        $thumbDir  = WRITEPATH . 'uploads/certificates/thumbs/' . $year;

        if (!is_dir($certDir)) {
            mkdir($certDir, 0755, true);
        }
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir, 0755, true);
        }

        self::ensureQrPng($s);
        $qrDataUri = self::qrDataUri($s);

        $html = self::buildHtml($s, $qrDataUri);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('isPhpEnabled', false);
        $options->set('chroot', realpath(WRITEPATH));

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        file_put_contents($certDir . '/' . $filename, $dompdf->output());

        $thumbFile = 'CERT_' . $safeNo . '_thumb.jpg';
        $thumbPath = null;
        if (function_exists('imagecreatetruecolor')) {
            try {
                self::generateThumb(
                    $thumbDir . '/' . $thumbFile,
                    $s,
                    $qrDataUri
                );
                $thumbPath = 'thumbs/' . $year . '/' . $thumbFile;
            } catch (\Throwable $e) {
                log_message('warning', 'Gagal membuat thumbnail sertifikat: ' . $e->getMessage());
            }
        }

        return [
            'file_pdf'   => $year . '/' . $filename,
            'file_thumb' => $thumbPath,
        ];
    }

    /**
     * Path absolut PDF dari nilai kolom file_pdf.
     */
    public static function pdfAbsolutePath(string $relativeFilePdf): string
    {
        return WRITEPATH . 'uploads/certificates/' . ltrim($relativeFilePdf, '/\\');
    }

    /**
     * Path absolut thumbnail dari nilai kolom file_thumb.
     */
    public static function thumbAbsolutePath(?string $relativeFileThumb): string
    {
        if (empty($relativeFileThumb)) {
            return '';
        }
        return WRITEPATH . 'uploads/certificates/' . ltrim($relativeFileThumb, '/\\');
    }

    /**
     * Nama file QR PNG mengikuti konvensi controller (qr_NOMOR.png).
     */
    public static function qrFileName(string $nomorSertifikat): string
    {
        return 'qr_' . str_replace(['/', '-'], '_', $nomorSertifikat) . '.png';
    }

    public static function qrDir(): string
    {
        return WRITEPATH . 'certificates/qr_codes';
    }

    /**
     * Pastikan QR PNG tersimpan di disk (generate bila belum ada).
     */
    private static function ensureQrPng(array $s): void
    {
        $dir  = self::qrDir();
        $file = $dir . '/' . self::qrFileName($s['nomor_sertifikat']);

        if (is_file($file)) {
            return;
        }
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $bytes = self::renderQrBytes((string) $s['verification_url']);
        if ($bytes !== null) {
            file_put_contents($file, $bytes);
        }
    }

    private static function renderQrBytes(string $url): ?string
    {
        try {
            if (class_exists('\Endroid\QrCode\QrCode')) {
                $qrCode = new \Endroid\QrCode\QrCode(
                    $url,
                    size: 220,
                    margin: 8
                );
                $writer  = new \Endroid\QrCode\Writer\PngWriter();
                $result  = $writer->write($qrCode);
                return $result->getString();
            }
        } catch (\Throwable $e) {
            log_message('warning', 'Gagal render QR Endroid: ' . $e->getMessage());
        }

        try {
            if (class_exists('\App\Libraries\QRCodeGenerator')
                && method_exists('\App\Libraries\QRCodeGenerator', 'generateSVG')) {
                return null; // SVG tidak bisa ditanam sebagai PNG di dompdf
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return null;
    }

    private static function qrDataUri(array $s): string
    {
        $file = self::qrDir() . '/' . self::qrFileName($s['nomor_sertifikat']);
        if (!is_file($file)) {
            return '';
        }
        $bytes = @file_get_contents($file);
        if ($bytes === false) {
            return '';
        }
        return 'data:image/png;base64,' . base64_encode($bytes);
    }

    private static function buildHtml(array $s, string $qrDataUri): string
    {
        $namaPeserta  = esc($s['nama_peserta']);
        $namaKursus   = esc($s['nama_kursus']);
        $paket        = esc($s['nama_paket'] ?? '');
        $predikat     = esc($s['predikat']);
        $nilai        = number_format((float) $s['nilai_akhir'], 2);
        $nomor        = esc($s['nomor_sertifikat']);
        $verifyUrl    = esc((string) $s['verification_url']);

        $tglMulai   = date('d F Y', strtotime($s['tanggal_mulai']));
        $tglSelesai = date('d F Y', strtotime($s['tanggal_selesai']));
        $tglTerbit  = date('d F Y', strtotime($s['tanggal_terbit']));

        $paketRow = '';
        if ($paket !== '') {
            $paketRow = '<div class="paket">Paket: ' . $paket . '</div>';
        }

        $qrBlock = '';
        if ($qrDataUri !== '') {
            $qrBlock = '
            <table class="qr" cellpadding="0" cellspacing="0">
                <tr><td><img src="' . $qrDataUri . '" width="78" height="78" alt="QR"></td></tr>
                <tr><td class="qr-label">Scan untuk Verifikasi</td></tr>
            </table>';
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sertifikat {$nomor}</title>
<style>
    @page { margin: 0; }
    body { margin: 0; padding: 0; font-family: times, "Times-Roman", serif; color: #22262a; }

    .page { width: 100%; height: 100%; position: relative; }

    .frame-outer {
        position: absolute; top: 14px; left: 14px; right: 14px; bottom: 14px;
        border: 10px solid #1a5276;
    }
    .frame-inner {
        position: absolute; top: 30px; left: 30px; right: 30px; bottom: 30px;
        border: 2px solid #c0a050;
    }

    .header { text-align: center; margin-top: 58px; }
    .org { font-size: 15px; letter-spacing: 4px; color: #1a5276; text-transform: uppercase; }
    .title { font-size: 34px; font-weight: bold; letter-spacing: 8px; color: #1a5276; text-transform: uppercase; margin-top: 4px; }
    .divider { width: 180px; height: 3px; background-color: #c0a050; margin: 12px auto; }
    .subtitle { font-size: 11px; letter-spacing: 3px; color: #666666; }

    .intro { text-align: center; font-size: 13px; color: #444444; margin-top: 26px; }

    .recipient { text-align: center; font-size: 28px; font-style: italic; font-weight: bold; color: #1a5276; text-decoration: underline; margin: 14px auto 0; width: 80%; }

    .desc { text-align: center; font-size: 12px; color: #444444; margin-top: 14px; }

    .course { text-align: center; font-size: 18px; font-weight: bold; color: #1a5276; margin-top: 8px; }
    .paket { text-align: center; font-size: 12px; color: #555555; margin-top: 2px; }

    table.details { width: 70%; margin: 16px auto 0; border-collapse: collapse; font-size: 11.5px; color: #444444; }
    table.details td { padding: 3px 10px; vertical-align: top; }
    td.label { text-align: right; font-weight: bold; color: #333333; width: 22%; }
    td.value { text-align: left; width: 28%; }
    td.gap { width: 4%; }

    table.signatures { width: 76%; margin-top: 46px; border-collapse: collapse; }
    table.signatures td { text-align: center; width: 33%; }
    .sig-line { width: 150px; border-bottom: 1px solid #333333; margin: 0 auto 5px; height: 40px; }
    .sig-name { font-size: 12.5px; font-weight: bold; color: #333333; }
    .sig-role { font-size: 10.5px; color: #777777; }

    table.qr { position: absolute; right: 60px; bottom: 52px; border-collapse: collapse; }
    table.qr td { text-align: center; }
    .qr-label { font-size: 8px; color: #999999; margin-top: 2px; }

    .cert-number { position: absolute; bottom: 24px; left: 0; width: 100%; text-align: center; font-size: 9px; color: #999999; }
</style>
</head>
<body>
<div class="page">
    <div class="frame-outer"></div>
    <div class="frame-inner"></div>

    <div class="header">
        <div class="org">LPK INASABA</div>
        <div class="title">Sertifikat Kelulusan</div>
        <div class="divider"></div>
        <div class="subtitle">CERTIFICATE OF COMPLETION</div>
    </div>

    <div class="intro">Dengan ini menyatakan bahwa</div>
    <div class="recipient">{$namaPeserta}</div>
    <div class="desc">Telah berhasil menyelesaikan program pelatihan</div>
    <div class="course">{$namaKursus}</div>
    {$paketRow}

    <table class="details">
        <tr>
            <td class="label">Nomor Sertifikat</td><td class="value">: {$nomor}</td>
            <td class="gap"></td>
            <td class="label">Predikat</td><td class="value">: <b>{$predikat}</b></td>
        </tr>
        <tr>
            <td class="label">Periode</td><td class="value">: {$tglMulai} s.d. {$tglSelesai}</td>
            <td class="gap"></td>
            <td class="label">Nilai Akhir</td><td class="value">: <b>{$nilai}</b></td>
        </tr>
        <tr>
            <td class="label">Tanggal Terbit</td><td class="value">: {$tglTerbit}</td>
            <td class="gap"></td>
            <td class="label"></td><td class="value"></td>
        </tr>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <div class="sig-line"></div>
                <div class="sig-name">Mengetahui,</div>
                <div class="sig-role">Kepala LPK INASABA</div>
            </td>
            <td></td>
            <td>
                <div class="sig-line"></div>
                <div class="sig-name">{$namaPeserta}</div>
                <div class="sig-role">Peserta</div>
            </td>
        </tr>
    </table>

    {$qrBlock}

    <div class="cert-number">Nomor: {$nomor} &nbsp;|&nbsp; Verifikasi: {$verifyUrl}</div>
</div>
</body>
</html>
HTML;
    }

    /**
     * Thumbnail preview JPG digambar langsung dengan GD
     * (tanpa dependensi Ghostscript/Imagick).
     */
    private static function generateThumb(string $target, array $s, string $qrDataUri): void
    {
        $w = 640;
        $h = 452;

        $img = imagecreatetruecolor($w, $h);

        $white   = (int) imagecolorallocate($img, 255, 255, 255);
        $navy    = (int) imagecolorallocate($img, 26, 82, 118);
        $gold    = (int) imagecolorallocate($img, 192, 160, 80);
        $dark    = (int) imagecolorallocate($img, 51, 51, 51);
        $grey    = (int) imagecolorallocate($img, 120, 120, 120);

        imagefill($img, 0, 0, $white);
        imagerectangle($img, 8, 8, $w - 9, $h - 9, $navy);
        imagerectangle($img, 17, 17, $w - 18, $h - 18, $gold);

        $cx = (int) ($w / 2);

        self::centerText($img, $cx, 48, 'LPK INASABA', 3, $navy);
        self::centerText($img, $cx, 78, 'SERTIFIKAT KELULUSAN', 5, $navy);
        imagefilledrectangle($img, $cx - 90, 106, $cx + 90, 109, $gold);
        self::centerText($img, $cx, 122, 'CERTIFICATE OF COMPLETION', 1, $grey);

        self::centerText($img, $cx, 158, 'Dengan ini menyatakan bahwa', 2, $dark);
        self::centerText($img, $cx, 182, self::toAscii($s['nama_peserta']), 5, $navy);

        self::centerText($img, $cx, 226, 'Telah berhasil menyelesaikan program pelatihan', 2, $dark);
        self::centerText($img, $cx, 250, self::truncate(self::toAscii($s['nama_kursus']), 55), 4, $navy);

        $line1 = 'Nomor: ' . self::toAscii($s['nomor_sertifikat'])
               . '   |   Predikat: ' . self::toAscii($s['predikat'])
               . '   |   Nilai: ' . number_format((float) $s['nilai_akhir'], 2);
        self::centerText($img, $cx, 300, self::truncate($line1, 72), 2, $dark);

        $line2 = 'Periode: ' . date('d/m/Y', strtotime($s['tanggal_mulai']))
               . ' - ' . date('d/m/Y', strtotime($s['tanggal_selesai']))
               . '   |   Terbit: ' . date('d/m/Y', strtotime($s['tanggal_terbit']));
        self::centerText($img, $cx, 322, self::truncate($line2, 72), 2, $grey);

        imagerectangle($img, 90, $h - 92, 230, $h - 92, $dark);
        self::centerTextAt($img, 160, $h - 84, 'Kepala LPK', 2, $dark);
        imagerectangle($img, $w - 230, $h - 92, $w - 90, $h - 92, $dark);
        self::centerTextAt($img, $w - 160, $h - 84, 'Peserta', 2, $dark);

        if ($qrDataUri !== '') {
            $raw = base64_decode(substr($qrDataUri, strlen('data:image/png;base64,')), true);
            $qr  = $raw ? @imagecreatefromstring($raw) : false;
            if ($qr !== false) {
                $qw = imagesx($qr);
                $qh = imagesy($qr);
                imagecopyresampled($img, $qr, $w - 108, $h - 108, 0, 0, 68, 68, $qw, $qh);
                imagedestroy($qr);
            }
        }

        self::centerText($img, $cx, $h - 42, self::truncate('Verifikasi: ' . self::toAscii((string) $s['verification_url']), 80), 1, $grey);

        imagejpeg($img, $target, 88);
        imagedestroy($img);
    }

    private static function centerText($img, int $cx, int $y, string $text, int $font, int $color): void
    {
        self::centerTextAt($img, $cx, $y, $text, $font, $color);
    }

    private static function centerTextAt($img, int $cx, int $y, string $text, int $font, int $color): void
    {
        $width = (int) imagefontwidth($font) * strlen($text);
        imagestring($img, $font, $cx - (int) ($width / 2), $y, $text, $color);
    }

    private static function truncate(string $text, int $max): string
    {
        return mb_strlen($text) > $max ? mb_substr($text, 0, $max - 3) . '...' : $text;
    }

    /**
     * Built-in font GD hanya latin1 — buang karakter non-ASCII agar aman dirender.
     */
    private static function toAscii(string $text): string
    {
        $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        return $converted === false ? preg_replace('/[^\x20-\x7E]/', '', $text) : $converted;
    }
}
