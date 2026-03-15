<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold mb-4">Riwayat Pembelian</h4>

            <?php if (empty($pendaftaran)): ?>
                <div class="bg-white rounded-3 shadow-sm p-5 text-center">
                    <i class="fas fa-history fa-4x text-muted mb-3"></i>
                    <h5>Belum Ada Riwayat Pembelian</h5>
                    <p class="text-muted">Anda belum mendaftar di kursus online manapun.</p>
                    <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-primary mt-2">Mulai Belajar Sekarang</a>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-3 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">No. Order</th>
                                    <th>Tanggal</th>
                                    <th>Kursus / Paket</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendaftaran as $row): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold">#ORD-<?= str_pad($row['id_pendaftaran'], 5, '0', STR_PAD_LEFT) ?></td>
                                        <td><small><?= date('d M Y, H:i', strtotime($row['tanggal_pendaftaran'])) ?></small></td>
                                        <td>
                                            <div class="fw-bold"><?= $row['nama_kursus'] ?></div>
                                            <small class="text-muted"><?= $row['nama_paket'] ?> (<?= ucfirst($row['nama_program'] ?? 'Unknown') ?>)</small>
                                        </td>
                                        <td class="fw-bold text-primary">Rp<?= number_format($row['total_bayar'] ?? 0, 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>
                                            <?php elseif ($row['status'] == 'aktif'): ?>
                                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif</span>
                                            <?php elseif ($row['status'] == 'selesai'): ?>
                                                <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i>Selesai</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="fas fa-times me-1"></i><?= ucfirst($row['status'] ?? 'Unknown') ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center pe-4">
                                            <?php if ($row['status'] == 'pending'): ?>
                                                <a href="<?= base_url('home_karyawan/upload_bukti/' . ($row['id_pendaftaran'] ?? 0)) ?>" class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="fas fa-upload me-1"></i>Upload Bukti
                                                </a>
                                            <?php elseif ($row['status'] == 'aktif'): ?>
                                                <a href="<?= base_url('home_siswa/kursus/akses/' . ($row['id_pendaftaran'] ?? 0)) ?>" class="btn btn-sm btn-primary mb-1">
                                                    <i class="fas fa-play-circle me-1"></i>Mulai Belajar
                                                </a>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-detail" data-id="<?= $row['id_pendaftaran'] ?>">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-4 text-center">
                <a href="<?= base_url('home_siswa/cart') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-shopping-cart me-1"></i>Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title" id="modalDetailLabel"><i class="fas fa-info-circle me-2"></i>Detail Pembelian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-detail').on('click', function() {
            var idPendaftaran = $(this).data('id');
            var modal = new bootstrap.Modal(document.getElementById('modalDetail'));

            $('#detailContent').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Memuat data...</p></div>');
            modal.show();

            $.ajax({
                url: "<?= base_url('home_siswa/pendaftaran/riwayat') ?>/" + idPendaftaran,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        $('#detailContent').html('<div class="alert alert-danger">' + response.error + '</div>');
                    } else if (response.html) {
                        $('#detailContent').html(response.html);
                    } else {
                        $('#detailContent').html('<div class="alert alert-danger">Invalid response format</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#detailContent').html('<div class="alert alert-danger">Terjadi kesalahan saat memuat data: ' + error + '</div>');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>