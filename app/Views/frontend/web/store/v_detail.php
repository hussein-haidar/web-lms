<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <h4 class="fw-bold mb-0">Detail Pendaftaran</h4>
                    <span class="text-muted">#ORD-<?= str_pad($pendaftaran['id_pendaftaran'], 5, '0', STR_PAD_LEFT) ?></span>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <img src="<?= base_url('kursus/' . $pendaftaran['gambar_utama']) ?>" class="img-fluid rounded-3 shadow-sm" alt="<?= $pendaftaran['nama_kursus'] ?>">
                    </div>
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-1"><?= $pendaftaran['nama_kursus'] ?></h5>
                        <p class="text-muted mb-3">Paket: <strong><?= $pendaftaran['nama_paket'] ?></strong> (<?= ucfirst($pendaftaran['tipe_paket'] ?? 'reguler') ?>)</p>

                        <div class="d-flex align-items-center mb-3">
                            <span class="me-2 text-muted">Status:</span>
                            <?php if ($pendaftaran['status'] == 'pending'): ?>
                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu Pembayaran</span>
                            <?php elseif ($pendaftaran['status'] == 'aktif'): ?>
                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Aktif / Terdaftar</span>
                            <?php elseif ($pendaftaran['status'] == 'selesai'): ?>
                                <span class="badge bg-info"><i class="fas fa-graduation-cap me-1"></i>Selesai</span>
                            <?php else: ?>
                                <span class="badge bg-danger"><i class="fas fa-times me-1"></i><?= ucfirst($pendaftaran['status']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="bg-light p-3 rounded-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Tanggal Daftar</span>
                                <span class="small fw-bold"><?= date('d F Y, H:i', strtotime($pendaftaran['tanggal_pendaftaran'])) ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">Total Biaya</span>
                                <span class="small fw-bold text-primary">Rp<?= number_format($pendaftaran['total_bayar'] ?? 0, 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($pendaftaran['status'] == 'pending'): ?>
                    <div class="mt-4 pt-4 border-top">
                        <div class="alert alert-warning d-flex align-items-center mb-0">
                            <i class="fas fa-exclamation-circle me-3 fa-2x"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Pembayaran Belum Diterima</h6>
                                <p class="small mb-2">Silakan transfer ke rekening BCA 1234567890 a.n LPK INASADA dan upload bukti pembayaran untuk memulai belajar.</p>
                                <a href="<?= base_url('home_karyawan/upload_bukti/' . $pendaftaran['id_pendaftaran']) ?>" class="btn btn-sm btn-primary fw-bold">
                                    <i class="fas fa-upload me-1"></i>Upload Bukti Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <a href="<?= base_url('home_siswa/riwayat_beli') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>