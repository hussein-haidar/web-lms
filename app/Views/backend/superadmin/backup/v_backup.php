<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<div class="box">
    <div class="box-header">

    </div>

    <!-- /.box-header -->
    <div class="box-body">
        <!-- Alert Windows Success -->
        <?php
        // Menampilkan pesan sukses
        if (session()->getFlashdata('success')) {
            echo '<div class="alert alert-success alert-dismissible" role="alert">';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span></button>';
            echo session()->getFlashdata('success');
            echo '</div>';
        }

        // Menampilkan pesan error
        if (session()->getFlashdata('error')) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span></button>';
            echo session()->getFlashdata('error');
            echo '</div>';
        }
        ?>


        <!-- Info tambahan -->
        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle"></i>
            Backup akan disimpan di folder: <code>writable/backups/</code><br>
            Format file: <code>backup_YYYY-MM-DD_HH-MM-SS.sql</code>
        </div>

        <!-- Form untuk trigger proses backup -->
        <form id="backup-form" action="<?= base_url('home_superadmin/proses_db') ?>" method="post">
            <!-- CSRF TOKEN -->
            <?= csrf_field() ?>

            <button type="submit" class="btn btn-sm btn-success" onclick="return confirmBackupDatabase()">
                <i class="fa fa-database" aria-hidden="true"></i> Backup Database
            </button>
        </form>

        <!-- Daftar Backup yang Sudah Ada -->
        <?php
        $backupPath = WRITEPATH . 'backups/';
        if (is_dir($backupPath)) {
            $files = array_diff(scandir($backupPath), ['.', '..']);
            $files = array_reverse($files); // Urutkan dari yang terbaru

            if (!empty($files)) {
                echo '<h4 class="mt-4">Backup yang Tersedia:</h4>';
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>No</th>';
                echo '<th>Nama File</th>';
                echo '<th>Ukuran</th>';
                echo '<th>Tanggal</th>';
                echo '<th>Aksi</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $no = 1;
                foreach ($files as $file) {
                    if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                        $filePath = $backupPath . $file;
                        $fileSize = filesize($filePath);
                        $fileDate = date('d/m/Y H:i:s', filemtime($filePath));

                        echo '<tr>';
                        echo '<td>' . $no++ . '</td>';
                        echo '<td>' . $file . '</td>';
                        echo '<td>' . formatBytes($fileSize) . '</td>';
                        echo '<td>' . $fileDate . '</td>';
                        echo '<td>';
                        echo '<a href="' . base_url('home_superadmin/download_backup/' . urlencode($file)) . '" class="btn btn-sm btn-primary" title="Download">';
                        echo '<i class="fa fa-download"></i>';
                        echo '</a> ';
                        echo '<a href="' . base_url('home_superadmin/deleted_backup/' . urlencode($file)) . '" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm(\'Hapus backup ini?\')">';
                        echo '<i class="fa fa-trash"></i>';
                        echo '</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-warning mt-4">';
                echo '<i class="fa fa-warning"></i> Belum ada backup database.';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<?= $this->endSection() ?>

<!-- SweetAlert2 CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmBackupDatabase() {
    Swal.fire({
        title: 'Konfirmasi Backup Database',
        text: 'Apakah Anda yakin ingin melakukan backup database? Backup akan disimpan di folder writable/backups/',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Backup!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('backup-form').submit();
        }
    });
}

function confirmDeleteBackup(filename) {
    Swal.fire({
        title: 'Konfirmasi Hapus Backup',
        text: 'Apakah Anda yakin ingin menghapus file backup "' + filename + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url('home_superadmin/deleted_backup/') ?>' + encodeURIComponent(filename);
        }
    });
}
</script>

<?php
// Helper function untuk format bytes
function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>