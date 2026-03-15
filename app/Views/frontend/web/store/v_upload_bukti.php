<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="bg-white rounded-3 shadow-sm p-4">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-block p-3 mb-3">
                        <i class="fas fa-upload fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Upload Bukti Pembayaran</h4>
                    <p class="text-muted small">Pesanan #PAY-<?= str_pad($pembayaran['id_pembayaran'], 5, '0', STR_PAD_LEFT) ?></p>
                </div>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger small mb-4">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($pembayaran && $pembayaran['status_pembayaran'] === 'pending'): ?>
                    <div class="alert alert-warning small mb-4">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Sudah ada bukti yang dikirim:</strong> Menunggu verifikasi admin. Anda tetap bisa mengirim ulang jika bukti sebelumnya salah.
                    </div>
                <?php endif; ?>

                <div class="alert alert-info small mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Pastikan bukti transfer terlihat jelas (Nama Pengirim, Nominal, dan Tanggal Transfer).
                </div>

                <form action="<?= base_url('home_siswa/proses_upload') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_pembayaran" value="<?= $pembayaran['id_pembayaran'] ?>">
                    <input type="hidden" name="bank_tujuan" value="<?= $pembayaran['bank_tujuan'] ?? 'BCA' ?>">
                    <input type="hidden" name="nama_pengirim" value="<?= $pendaftaran['nama_lengkap'] ?? 'Unknown' ?>">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih File Bukti Transfer</label>
                        <input type="file" name="bukti_bayar" class="form-control" required accept="image/*,application/pdf">
                        <div class="form-text">Format: JPG, PNG, JPEG, atau PDF. Maksimal 20MB.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-3 fw-bold">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Bukti Pembayaran
                        </button>
                        <a href="<?= base_url('home_siswa/status_bayar') ?>" class="btn btn-link text-muted mt-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>