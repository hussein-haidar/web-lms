<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>
  
<!-- === HERO SECTION === -->
<section class="py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0056b3 0%, #00b4d8 100%);">
    <div class="container position-relative z-1">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="mb-4">
                    <i class="fas fa-envelope-open-text display-2 text-white opacity-75"></i>
                </div>
                <h1 class="display-4 fw-bold text-white mb-3">
                    Kontak & Saran LPK INASABA
                </h1>
                <p class="lead text-white-50 mb-0">Kami siap melayani pertanyaan dan saran Anda untuk perbaikan layanan</p>
            </div>
        </div>
    </div>
</section>

<!-- === KONTEN UTAMA === -->
<div class="container py-5">
    <div class="row g-4">
        <!-- Kolom Kiri - Form Saran (Lebih Lebar) -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
                <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-lightbulb text-white fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="text-white mb-1 fw-bold">Kotak Saran & Masukan</h3>
                            <p class="text-white-50 mb-0 small">Bantu kami menjadi lebih baik dengan saran Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2 fs-5"></i>
                            <div><?= session()->getFlashdata('success') ?></div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Ada kesalahan:</h6>
                            <ul class="mb-0 ps-3">
                                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Info Box -->
                    <div class="alert alert-info d-flex align-items-center mb-4 border-0" role="alert" style="background: #e3f2fd;">
                        <i class="fas fa-shield-alt me-3 fs-3 text-primary"></i>
                        <div>
                            <strong class="text-primary">Privasi Terjamin!</strong><br>
                            <small class="text-muted">Data dan saran Anda akan kami jaga kerahasiaannya</small>
                        </div>
                    </div>
                    
                    <form action="<?= base_url('home_website/simpan_saran') ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-bold text-dark">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        class="form-control border-start-0 <?= session('errors.nama') ? 'is-invalid' : '' ?>" 
                                        id="nama" 
                                        name="nama" 
                                        value="<?= old('nama') ?>" 
                                        placeholder="Nama lengkap Anda"
                                        required
                                    >
                                </div>
                                <?php if (session('errors.nama')): ?>
                                    <div class="invalid-feedback d-block"><?= session('errors.nama') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold text-dark">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input 
                                        type="email" 
                                        class="form-control border-start-0 <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                        id="email" 
                                        name="email" 
                                        value="<?= old('email') ?>" 
                                        placeholder="nama@email.com"
                                        required
                                    >
                                </div>
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback d-block"><?= session('errors.email') ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-12">
                                <label for="pesan" class="form-label fw-bold text-dark">
                                    <i class="fas fa-comment-dots me-2 text-primary"></i>Saran & Masukan Anda
                                </label>
                                <textarea 
                                    class="form-control <?= session('errors.pesan') ? 'is-invalid' : '' ?>" 
                                    id="pesan" 
                                    name="pesan" 
                                    rows="5" 
                                    placeholder="Tuliskan saran, kritik, atau masukan Anda untuk perbaikan layanan kami..."
                                    required
                                ><?= old('pesan') ?></textarea>
                                <?php if (session('errors.pesan')): ?>
                                    <div class="invalid-feedback"><?= session('errors.pesan') ?></div>
                                <?php endif; ?>
                                <div class="form-text text-muted"><i class="fas fa-info-circle me-1"></i>Minimal 10 karakter</div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success btn-lg w-100 py-3 fw-bold shadow-sm hover-shadow">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Saran
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light py-3 text-center border-0">
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>Form ini dilindungi oleh sistem keamanan
                    </small>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Info & Maps -->
        <div class="col-lg-5">
            <!-- Detailed Contact Info -->
            <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
                <div class="card-header border-0 py-3" style="background: linear-gradient(135deg, #0056b3 0%, #00b4d8 100%);">
                    <h5 class="text-white mb-0 fw-bold">
                        <i class="fas fa-address-card me-2"></i>Informasi Kontak
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                                <i class="fas fa-map-marker-alt fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-bold mb-1">Alamat Lengkap</h6>
                            <p class="text-muted mb-0 small">Jl. Teratai No.94, Poncol, Kec. Pekalongan Tim., Kota Pekalongan, Jawa Tengah 511122</p>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                                <i class="fas fa-phone-alt fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-bold mb-1">Telepon / WhatsApp</h6>
                            <p class="text-primary mb-0 fw-bold">08156912222</p>
                            <small class="text-success"><i class="fab fa-whatsapp me-1"></i>Respons cepat via WhatsApp</small>
                        </div>
                    </div>
                    
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                                <i class="fas fa-envelope fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-bold mb-1">Email</h6>
                            <p class="text-muted mb-0">lpkinasaba@gmail.com</p>
                            <small class="text-muted">Balas dalam 1x24 jam</small>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                                <i class="fas fa-clock fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fw-bold mb-1">Jam Operasional</h6>
                            <p class="text-muted mb-0">Senin - Sabtu: 08.00 - 16.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Google Maps -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header border-0 py-3 bg-white">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-map-marked-alt me-2"></i>Lokasi Kami
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="ratio ratio-4x3">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.566937252556!2d109.63449927456435!3d-6.894439393296347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e702836642e29b3%3A0xc882625412e32e42!2sLPK%20INASABA!5e0!3m2!1sid!2sid!4v1740000000000!5m2!1sid!2sid" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-0">
                    <a href="https://maps.google.com/?q=LPK+INASABA+Pekalongan" target="_blank" class="btn btn-outline-primary w-100">
                        <i class="fas fa-directions me-2"></i>Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
.transition-all {
    transition: all 0.3s ease;
}
</style>

<?= $this->endSection() ?>