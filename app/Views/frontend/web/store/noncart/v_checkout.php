<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <h4 class="fw-bold mb-4">Informasi Pembelian</h4>

                <!-- Contact Information -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Informasi Kontak</h6>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= $siswa['email'] ?>" readonly>
                    </div>
                </div>

                <!-- Billing Information -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Informasi Penagihan</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="<?= $siswa['nama_lengkap'] ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" value="<?= $siswa['no_telepon'] ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" checked required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a> dan
                            <a href="#" class="text-primary">Kebijakan Privasi</a>
                        </label>
                    </div>
                </div>

                <form action="<?= base_url('home_siswa/save_checkout_noncart') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_kursus" value="<?= $item_checkout['id_kursus'] ?>">
                    <input type="hidden" name="id_paket" value="<?= $item_checkout['id_paket'] ?>">
                    <input type="hidden" name="nama_paket" value="<?= $item_checkout['nama_paket'] ?>">
                    <input type="hidden" name="nama_program" value="<?= $item_checkout['nama_program'] ?>">
                    <input type="hidden" name="harga_kursus" value="<?= $item_checkout['harga_kursus'] ?>">

                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold fs-5">
                        <i class="fas fa-check-circle me-2"></i>Bayar Sekarang - Rp<?= number_format($item_checkout['harga_kursus'], 0, ',', '.') ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white rounded-3 shadow-sm p-4 sticky-top z-0" style="top: 100px;">
                <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>

                <!-- Course Items -->
                <div class="mb-3 pb-3 border-bottom">
                    <div class="row g-2 align-items-center">
                        <div class="col-9">
                            <h6 class="fw-bold small mb-1"><?= $item_checkout['nama_kursus'] ?></h6>
                            <span class="text-muted small">Paket: <?= $item_checkout['nama_paket'] ?> (<?= ucfirst($item_checkout['nama_program']) ?>)</span>
                        </div>
                        <div class="col-3 text-end">
                            <span class="fw-bold small">Rp<?= number_format($item_checkout['harga_kursus'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between border-top pt-2">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold fs-4 text-primary">Rp<?= number_format($item_checkout['harga_kursus'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <div class="alert alert-warning small mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Pembayaran akan diproses setelah Anda mengklik "Bayar Sekarang"
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>