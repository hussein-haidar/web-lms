<?php

/**
 * ExportHelper - Fungsi helper untuk export data ke PDF/Excel
 */

if (!function_exists('export_to_csv')) {
    /**
     * Export array data ke CSV
     */
    function export_to_csv($data, $filename, $headers = [])
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

        $output = fopen('php://output', 'w');

        // BOM untuk UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        if (!empty($headers)) {
            fputcsv($output, $headers, ';');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ';');
        }

        fclose($output);
        exit;
    }
}

if (!function_exists('export_to_excel')) {
    /**
     * Export array data ke Excel (XLS) menggunakan simple HTML table
     */
    function export_to_excel($data, $filename, $headers = [], $title = '')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8">';
        echo '<style>table{border-collapse:collapse;} td,th{border:1px solid #ccc;padding:8px;text-align:left;} th{background:#f2f2f2;font-weight:bold;}</style>';
        echo '</head><body>';

        if ($title) {
            echo '<h2>' . $title . '</h2>';
        }

        echo '<table>';

        if (!empty($headers)) {
            echo '<tr>';
            foreach ($headers as $h) {
                echo '<th>' . htmlspecialchars($h) . '</th>';
            }
            echo '</tr>';
        }

        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>' . htmlspecialchars((string)($cell ?? '')) . '</td>';
            }
            echo '</tr>';
        }

        echo '</table></body></html>';
        exit;
    }
}

if (!function_exists('export_pembayaran_csv')) {
    function export_pembayaran_csv($pembayaran, $filename = null)
    {
        $filename = $filename ?? 'laporan_pembayaran_' . date('Y-m-d');
        $headers = ['No', 'Kode Invoice', 'Kode Transaksi', 'Nama Siswa', 'Kursus', 'Jumlah Bayar', 'Status', 'Tanggal'];

        $data = [];
        $no = 1;
        foreach ($pembayaran as $p) {
            $data[] = [
                $no++,
                $p['kode_invoice'] ?? '',
                $p['kode_transaksi'] ?? '',
                $p['nama_lengkap'] ?? '',
                $p['nama_kursus'] ?? '',
                'Rp ' . number_format($p['jumlah_bayar'] ?? 0, 0, ',', '.'),
                ucfirst($p['status_pembayaran'] ?? ''),
                $p['tanggal_transaksi'] ?? '',
            ];
        }

        export_to_csv($data, $filename, $headers);
    }
}

if (!function_exists('export_nilai_csv')) {
    function export_nilai_csv($nilai, $filename = null)
    {
        $filename = $filename ?? 'laporan_nilai_' . date('Y-m-d');
        $headers = ['No', 'Nama Siswa', 'Kursus', 'Quiz', 'Nilai', 'Status', 'Tanggal'];

        $data = [];
        $no = 1;
        foreach ($nilai as $n) {
            $data[] = [
                $no++,
                $n['nama_lengkap'] ?? '',
                $n['nama_kursus'] ?? '',
                $n['judul_quiz'] ?? '',
                $n['total_nilai'] ?? 0,
                ($n['is_lulus'] ?? 0) ? 'Lulus' : 'Tidak Lulus',
                $n['created_at'] ?? '',
            ];
        }

        export_to_csv($data, $filename, $headers);
    }
}

if (!function_exists('export_peserta_csv')) {
    function export_peserta_csv($peserta, $filename = null)
    {
        $filename = $filename ?? 'laporan_peserta_' . date('Y-m-d');
        $headers = ['No', 'Nama', 'Email', 'No Telepon', 'Kursus', 'Paket', 'Status', 'Progress'];

        $data = [];
        $no = 1;
        foreach ($peserta as $p) {
            $data[] = [
                $no++,
                $p['nama_lengkap'] ?? '',
                $p['email'] ?? '',
                $p['no_telepon'] ?? '',
                $p['nama_kursus'] ?? '',
                $p['nama_paket'] ?? '',
                ucfirst($p['status'] ?? ''),
                ($p['progress'] ?? 0) . '%',
            ];
        }

        export_to_csv($data, $filename, $headers);
    }
}
