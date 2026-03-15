<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= $title ?></h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_karyawan/tugas') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-check"></i> <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Siswa</th>
                        <th>Judul Tugas</th>
                        <th>Tanggal Pengumpulan</th>
                        <th>File Tugas</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Catatan Pengajar</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengumpulan)): ?>
                        <?php $no = 1; foreach ($pengumpulan as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($item['nama_siswa']) ?></td>
                                <td><?= esc($item['judul_tugas']) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($item['tanggal_kirim'])) ?></td>
                                <td>
                                    <?php if ($item['file_tugas']): ?>
                                        <a href="<?= base_url('uploads/tugas/' . $item['file_tugas']) ?>" 
                                           target="_blank" class="btn btn-sm btn-info">
                                            <i class="fa fa-download"></i> Lihat File
                                        </a>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Tidak ada file</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['nilai'] !== null): ?>
                                        <span class="badge badge-success"><?= $item['nilai'] ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Belum dinilai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['status_penilaian'] == 'sudah_dinilai'): ?>
                                        <span class="label label-success">Sudah Dinilai</span>
                                    <?php else: ?>
                                        <span class="label label-warning">Belum Dinilai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['catatan_pengajar'])): ?>
                                        <span class="text-muted"><?= esc($item['catatan_pengajar']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Tombol Edit dengan data attributes -->
                                    <button type="button" class="btn btn-xs btn-warning edit-btn"
                                            data-id="<?= $item['id_kumpul'] ?>"
                                            data-nilai="<?= esc($item['nilai'] ?? '') ?>"
                                            data-catatan="<?= esc($item['catatan_pengajar'] ?? '') ?>">
                                        <i class="fa fa-edit"></i> Nilai
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data pengumpulan tugas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Edit Nilai -->
<div class="modal fade" id="modalEditNilai" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title"><i class="fa fa-edit"></i> Form Penilaian Tugas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form tanpa action (di-set via JS) + ID form -->
            <?= form_open_multipart('', ['id' => 'formEditNilai']) ?>
                <?= csrf_field() ?>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nilai <span class="text-red">*</span></label>
                        <input type="number" class="form-control" id="nilai" name="nilai"
                            placeholder="Masukkan nilai (0-100)" min="0" max="100" required>
                        <small class="text-muted">Rentang nilai: 0 - 100</small>
                    </div>

                    <div class="form-group">
                        <label>Catatan/Komentar Pengajar</label>
                        <textarea class="form-control" id="catatan_pengajar" name="catatan_pengajar"
                            rows="4" placeholder="Tulis komentar atau masukan untuk siswa..."></textarea>
                    </div>

                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        <strong>Petunjuk:</strong> Nilai wajib diisi. Komentar bersifat opsional.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-save"></i> Simpan Nilai
                    </button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
    const baseUrl = '<?= base_url() ?>';

    // Submit form via AJAX
    console.log('JavaScript loaded successfully');
    
    // Initialize DataTable
    $('#example1').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 25,
        "order": [[ 3, "desc" ]] // Sort by date column
    });

    // Event delegation untuk tombol edit (gunakan document.ready)
    $(document).on('click', '.edit-btn', function(e) {
        e.preventDefault();
        
        const btn = $(this);
        const id = btn.attr('data-id');
        const nilai = btn.attr('data-nilai') || ''; 
        const catatan = btn.attr('data-catatan') || '';

        console.log('Edit clicked - ID:', id, '| Nilai:', nilai, '| Catatan:', catatan);

        // Validasi ID
        if (!id || id === 'undefined') {
            alert('ID tidak valid!');
            return;
        }

        // Set action form sesuai ID yang diklik
        const actionUrl = baseUrl + 'home_karyawan/update_kumpul/' + id;
        $('#formEditNilai').attr('action', actionUrl);
        
        // Isi field form
        $('#nilai').val(nilai);
        $('#catatan_pengajar').val(catatan);
        
        // Debug form action
        console.log('Form action set to:', actionUrl);
        
        // Tampilkan modal
        $('#modalEditNilai').modal('show');
    });

    // Handle form submission
    $('#formEditNilai').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const action = form.attr('action');
        
        console.log('Form submitted to:', action);
        console.log('Form data:', form.serialize());
        
        // Submit form via AJAX untuk debugging
        $.ajax({
            url: action,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                console.log('Success response:', response);
                // Redirect ke halaman yang sama untuk refresh data
                window.location.href = baseUrl + 'home_karyawan/v_kumpul_tugas';
            },
            error: function(xhr, status, error) {
                console.error('Error response:', xhr.responseText);
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });

    // Reset form saat modal ditutup
    $('#modalEditNilai').on('hidden.bs.modal', function() {
        $('#formEditNilai')[0].reset();
        $('#formEditNilai').removeAttr('action');
    });
});
</script>
<?= $this->endSection() ?>