<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <!-- Pending Certificates -->
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-clock"></i> Sertifikat Pending (Menunggu Terbit)
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if (!empty($pending)): ?>
            <form id="bulkForm" method="post" action="<?= base_url('sertifikat/admin/bulk-create') ?>">
                <?= csrf_field() ?>
                <table id="pendingTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Siswa</th>
                            <th>Kursus</th>
                            <th>Progress</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $item): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="pendaftaran_ids[]" 
                                       value="<?= $item['id_pendaftaran'] ?>" 
                                       class="form-check-input row-checkbox">
                            </td>
                            <td>
                                <?= esc($item['nama_lengkap']) ?>
                                <br>
                                <small class="text-muted">ID: <?= $item['id_pendaftaran'] ?></small>
                            </td>
                            <td><?= esc($item['nama_kursus']) ?></td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: <?= $item['progress'] ?>%">
                                        <?= $item['progress'] ?>%
                                    </div>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($item['tanggal_selesai'])) ?></td>
                            <td>
                                <a href="<?= base_url('sertifikat/admin/create/' . $item['id_pendaftaran']) ?>" 
                                   class="btn btn-success btn-xs"
                                   onclick="return confirm('Terbitkan sertifikat untuk siswa ini?')">
                                    <i class="fa fa-certificate"></i> Terbitkan
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Terbitkan semua sertifikat yang dipilih?')">
                        <i class="fa fa-file-pdf"></i> Terbitkan yang Dipilih
                    </button>
                    <span class="ml-3 text-muted">
                        <span id="selectedCount">0</span> sertifikat dipilih
                    </span>
                </div>
            </form>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="fa fa-check-circle"></i> Tidak ada sertifikat yang pending
            </div>
            <?php endif; ?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- Issued Certificates -->
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-award"></i> Sertifikat Telah Diterbitkan
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php if (!empty($issued)): ?>
            <table id="issuedTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nomor Sertifikat</th>
                        <th>Nama Peserta</th>
                        <th>Kursus</th>
                        <th>Predikat</th>
                        <th>Tanggal Terbit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($issued as $cert): ?>
                    <tr>
                        <td>
                            <code><?= esc($cert['nomor_sertifikat']) ?></code>
                        </td>
                        <td><?= esc($cert['nama_peserta']) ?></td>
                        <td><?= esc($cert['nama_kursus']) ?></td>
                        <td>
                            <span class="badge badge-<?= getPredikatBadge($cert['predikat']) ?>">
                                <?= esc($cert['predikat']) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($cert['tanggal_terbit'])) ?></td>
                        <td>
                            <?php if ($cert['is_active']): ?>
                                <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Non-aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url('sertifikat/view/' . $cert['id_sertifikat']) ?>" 
                                   class="btn btn-info btn-xs" target="_blank">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <?php if (!empty($cert['file_pdf'])): ?>
                                <a href="<?= base_url('sertifikat/download/' . $cert['id_sertifikat']) ?>" 
                                   class="btn btn-success btn-xs">
                                    <i class="fa fa-download"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?= base_url('sertifikat/verify/' . $cert['nomor_sertifikat']) ?>" 
                                   class="btn btn-warning btn-xs" target="_blank">
                                    <i class="fa fa-qrcode"></i>
                                </a>
                                <a href="<?= base_url('sertifikat/admin/delete/' . $cert['id_sertifikat']) ?>" 
                                   class="btn btn-danger btn-xs"
                                   onclick="return confirm('Hapus sertifikat ini? Tindakan tidak dapat dibatalkan.')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-warning">
                <i class="fa fa-info-circle"></i> Belum ada sertifikat yang diterbitkan
            </div>
            <?php endif; ?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->

<script>
$(function () {
    // Initialize DataTables
    $('#pendingTable').DataTable({
        'responsive': true,
        'lengthChange': false,
        'autoWidth': false,
        'ordering': true,
        'info': true,
        'paging': true
    });
    
    $('#issuedTable').DataTable({
        'responsive': true,
        'lengthChange': false,
        'autoWidth': false,
        'ordering': true,
        'info': true,
        'paging': true
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    
    // Select all functionality
    selectAll.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });
    
    // Individual checkbox change
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    function updateSelectedCount() {
        const checked = document.querySelectorAll('.row-checkbox:checked').length;
        selectedCount.textContent = checked;
        
        // Update select all state
        if (checked === rowCheckboxes.length) {
            selectAll.checked = true;
            selectAll.indeterminate = false;
        } else if (checked === 0) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        } else {
            selectAll.checked = false;
            selectAll.indeterminate = true;
        }
    }
    
    updateSelectedCount();
});
</script>

<?php
// Helper function for badge colors
function getPredikatBadge($predikat) {
    switch($predikat) {
        case 'Excellent': return 'success';
        case 'Very Good': return 'info';
        case 'Good': return 'primary';
        case 'Pass': return 'warning';
        default: return 'secondary';
    }
}
?>

<?= $this->endSection() ?>
