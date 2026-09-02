<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - <?= esc($sertifikat['nama_peserta']) ?></title>
    <style>
        @page { size: landscape; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: white;
        }
        .certificate {
            width: 1056px; /* 11 inches landscape */
            height: 816px; /* 8.5 inches landscape */
            margin: 0 auto;
            padding: 60px 80px;
            position: relative;
            border: 12px solid #1a5276;
            outline: 3px solid #c0a050;
        }
        .border-inner {
            position: absolute;
            top: 15px; left: 15px; right: 15px; bottom: 15px;
            border: 2px solid #c0a050;
        }
        .header { text-align: center; margin-bottom: 20px; position: relative; z-index: 1; }
        .header h1 {
            font-size: 18px; color: #1a5276; letter-spacing: 3px;
            text-transform: uppercase; margin-bottom: 5px;
        }
        .header h2 {
            font-size: 36px; color: #1a5276; font-weight: bold;
            letter-spacing: 6px; text-transform: uppercase;
        }
        .divider {
            width: 200px; height: 3px; background: #c0a050;
            margin: 15px auto;
        }
        .subtitle { font-size: 14px; color: #555; margin-bottom: 25px; letter-spacing: 2px; }
        .recipient-name {
            font-size: 32px; color: #1a5276; font-weight: bold;
            text-decoration: underline; margin: 15px 0;
            font-style: italic;
        }
        .description {
            font-size: 15px; color: #333; line-height: 1.8;
            max-width: 700px; margin: 0 auto 20px;
            text-align: center;
        }
        .course-info {
            font-size: 18px; color: #1a5276; font-weight: bold;
            margin: 10px 0;
        }
        .details-table {
            width: 60%; margin: 15px auto;
            font-size: 13px; color: #555;
        }
        .details-table td { padding: 3px 15px; }
        .details-table .label { font-weight: bold; color: #333; text-align: right; }
        .details-table .value { text-align: left; }
        .footer {
            position: absolute; bottom: 50px; left: 0; right: 0;
            display: flex; justify-content: space-around;
            padding: 0 120px;
        }
        .signature { text-align: center; }
        .signature .name { font-size: 14px; font-weight: bold; color: #333; margin-top: 5px; }
        .signature .role { font-size: 11px; color: #777; }
        .signature-line {
            width: 150px; border-bottom: 1px solid #333; margin: 0 auto 5px;
        }
        .qr-code {
            position: absolute; bottom: 45px; right: 80px;
            text-align: center;
        }
        .qr-code img { width: 70px; height: 70px; }
        .qr-code .label { font-size: 9px; color: #999; margin-top: 2px; }
        .cert-number {
            position: absolute; bottom: 30px; left: 0; right: 0;
            text-align: center; font-size: 10px; color: #999;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .certificate { border: 12px solid #1a5276; }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print" style="text-align:center; padding:20px; background:#f5f5f5;">
        <button onclick="window.print()" style="padding:12px 30px; background:#1a5276; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
            🖨️ Cetak / Save as PDF
        </button>
        <p style="margin-top:10px; color:#666; font-size:13px;">Tekan Ctrl+P → Pilih "Save as PDF" → Landscape → No margins</p>
    </div>

    <div class="certificate">
        <div class="border-inner"></div>

        <div class="header">
            <h1>LPK INASABA</h1>
            <h2>SERTIFIKAT KELULUSAN</h2>
            <div class="divider"></div>
            <div class="subtitle">CERTIFICATE OF COMPLETION</div>
        </div>

        <div style="text-align:center; position:relative; z-index:1;">
            <p style="font-size:14px; color:#555;">Dengan ini menyatakan bahwa</p>
            <div class="recipient-name"><?= esc($sertifikat['nama_peserta']) ?></div>

            <div class="description">
                Telah berhasil menyelesaikan program pelatihan
            </div>

            <div class="course-info">
                <?= esc($sertifikat['nama_kursus']) ?>
                <?php if (!empty($sertifikat['nama_paket'])): ?>
                    <br><span style="font-size:14px; font-weight:normal; color:#555;">Paket: <?= esc($sertifikat['nama_paket']) ?></span>
                <?php endif; ?>
            </div>

            <table class="details-table">
                <tr>
                    <td class="label">Nomor Sertifikat:</td>
                    <td class="value"><?= esc($sertifikat['nomor_sertifikat']) ?></td>
                    <td class="label" style="padding-left:30px;">Predikat:</td>
                    <td class="value"><strong><?= esc($sertifikat['predikat']) ?></strong></td>
                </tr>
                <tr>
                    <td class="label">Periode:</td>
                    <td class="value">
                        <?= date('d F Y', strtotime($sertifikat['tanggal_mulai'])) ?> -
                        <?= date('d F Y', strtotime($sertifikat['tanggal_selesai'])) ?>
                    </td>
                    <td class="label" style="padding-left:30px;">Nilai Akhir:</td>
                    <td class="value"><strong><?= number_format($sertifikat['nilai_akhir'], 1) ?></strong></td>
                </tr>
                <tr>
                    <td class="label">Tanggal Terbit:</td>
                    <td class="value"><?= date('d F Y', strtotime($sertifikat['tanggal_terbit'])) ?></td>
                    <td></td><td></td>
                </tr>
            </table>
        </div>

        <!-- QR Code -->
        <?php if (!empty($sertifikat['qr_code'])): ?>
        <div class="qr-code">
            <?php
            if (strpos($sertifikat['qr_code'], 'http') === 0) {
                echo '<img src="' . esc($sertifikat['qr_code']) . '" alt="QR">';
            } else {
                $qr_path = WRITEPATH . $sertifikat['qr_code'];
                if (file_exists($qr_path)) {
                    echo '<img src="' . base_url('writable/' . $sertifikat['qr_code']) . '" alt="QR">';
                }
            }
            ?>
            <div class="label">Scan untuk Verifikasi</div>
        </div>
        <?php endif; ?>

        <!-- Signatures -->
        <div class="footer">
            <div class="signature">
                <div class="signature-line"></div>
                <div class="name">Mengetahui,</div>
                <div class="role">Kepala LPK INASABA</div>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <div class="name"><?= esc($sertifikat['nama_peserta']) ?></div>
                <div class="role">Peserta</div>
            </div>
        </div>

        <div class="cert-number">
            Nomor: <?= esc($sertifikat['nomor_sertifikat']) ?> | Verifikasi: <?= base_url('sertifikat/verify/' . $sertifikat['nomor_sertifikat']) ?>
        </div>
    </div>
</body>
</html>
