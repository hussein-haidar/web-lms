<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Program Banner - Carousel dengan Gambar -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('/gambar_kursus/tf.png') ?>"
                class="d-block w-100"
                alt="Program Profesi 1 Tahun"
                style="height: 450px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
        </div>
    </div>
    <div class="carousel-indicators">
    </div>
</div>

<!-- === IMPROVED GALLERY SECTION === -->
<section class="py-4" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-white mb-3">Galeri Produk Kami</h2>
        </div>

        <!-- Filter Buttons -->
        <div class="text-center mb-4">
            <button class="btn btn-light text-primary fw-bold me-2 mb-2 filter-btn active border-white shadow-sm"
                data-filter="all"
                style="background: rgba(255,255,255,0.95);">
                Semua Produk
            </button>
            <button class="btn btn-light text-primary fw-bold me-2 mb-2 filter-btn border-white shadow-sm"
                data-filter="kaos"
                style="background: rgba(255,255,255,0.95);">
                Kaos Custom
            </button>
            <button class="btn btn-light text-primary fw-bold me-2 mb-2 filter-btn border-white shadow-sm"
                data-filter="banner"
                style="background: rgba(255,255,255,0.95);">
                Banner & MMT
            </button>
            <button class="btn btn-light text-primary fw-bold me-2 mb-2 filter-btn border-white shadow-sm"
                data-filter="cetak"
                style="background: rgba(255,255,255,0.95);">
                Cetak & Desain
            </button>
            <button class="btn btn-light text-primary fw-bold me-2 mb-2 filter-btn border-white shadow-sm"
                data-filter="foto"
                style="background: rgba(255,255,255,0.95);">
                Foto Studio
            </button>
        </div>

        <!-- Gallery Grid -->
        <div class="row g-4" id="galleryGrid">
            <!-- Item 1: Kaos Custom -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="kaos">
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=600"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;"
                            alt="Kaos Custom"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-primary px-3 py-2">Kaos Custom</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3 text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modal1">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Kaos Custom Komunitas</h5>
                        <p class="card-text text-muted small">Sablon kaos untuk komunitas dengan desain custom dan kualitas premium</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>3-5 Hari</small>
                            <span class="badge bg-success">Mulai Rp 75.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 2: Banner -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="banner">
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=600"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;"
                            alt="Banner"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger px-3 py-2">Banner Outdoor</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3 text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modal2">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Banner Promosi Outdoor</h5>
                        <p class="card-text text-muted small">Banner tahan cuaca untuk promosi outdoor dengan bahan berkualitas</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>1-2 Hari</small>
                            <span class="badge bg-success">Mulai Rp 50.000/m²</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 3: Kartu Nama -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="cetak">
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=600"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;"
                            alt="Kartu Nama"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-info px-3 py-2">Kartu Nama</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3 text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modal3">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Kartu Nama Premium</h5>
                        <p class="card-text text-muted small">Kartu nama dengan berbagai pilihan kertas dan finishing elegan</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>2-3 Hari</small>
                            <span class="badge bg-success">Mulai Rp 100.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 4: Stiker -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="cetak">
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1560439514-4e9645039924?w=600"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;"
                            alt="Stiker"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-warning text-dark px-3 py-2">Stiker</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3 text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modal4">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Stiker Label Produk</h5>
                        <p class="card-text text-muted small">Stiker custom untuk label produk, kemasan, dan branding</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>2-3 Hari</small>
                            <span class="badge bg-success">Mulai Rp 5.000/lembar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 5: Kemasan Produk -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="cetak">
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1634940615575-64ae0aa66069?w=600"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;"
                            alt="Kemasan Produk"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success px-3 py-2">Kemasan</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3 text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modal5">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Kemasan Produk UMKM</h5>
                        <p class="card-text text-muted small">Desain dan cetak kemasan menarik untuk produk UMKM Anda</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>5-7 Hari</small>
                            <span class="badge bg-success">Custom Price</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item 6: Foto Studio -->
            <div class="col-lg-4 col-md-6 gallery-item" data-category="foto">
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="https://images.unsplash.com/photo-1542038784450-9d1d9e192f1b?w=600"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;"
                            alt="Foto Studio"
                            onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-purple px-3 py-2" style="background-color: #6f42c1;">Foto Studio</span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3 text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modal6">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Foto Produk Profesional</h5>
                        <p class="card-text text-muted small">Jasa foto produk dengan lighting profesional untuk katalog & online shop</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>1-2 Hari</small>
                            <span class="badge bg-success">Mulai Rp 150.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wave Divider -->
<div class="position-relative overflow-hidden" style="height: 80px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
        <path d="M0,120V73.71c47.79,-22.2,103.59,-32.17,158,-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27,-18,138.3,-24.88,209.4,-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9,-9.42,98.6,-31.56,31.77,-25.39,62.32,-62,103.63,-73,40.44,-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28,-22.88,168.9,-38.84,30.2,-8.66,59,-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48,-12.24,165.56,-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- === KEUNGGULAN SECTION === -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center display-6 fw-bold mb-5 text-primary">Mengapa Memilih Ruang Printing LPK INASABA?</h2>
        <div class="row g-4">

            <div class="col-md-3 text-center">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="fs-1 text-primary mb-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="fw-bold">Kualitas Terjamin</h5>
                        <p class="text-muted">Menggunakan mesin modern dan bahan berkualitas tinggi untuk hasil yang maksimal.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="fs-1 text-primary mb-3">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h5 class="fw-bold">Proses Cepat</h5>
                        <p class="text-muted">Pengerjaan cepat tanpa mengorbankan kualitas, sesuai deadline yang ditentukan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="fs-1 text-primary mb-3">
                            <i class="fas fa-tag"></i>
                        </div>
                        <h5 class="fw-bold">Harga Kompetitif</h5>
                        <p class="text-muted">Harga terjangkau dengan kualitas premium, cocok untuk semua kalangan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <div class="card service-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="fs-1 text-primary mb-3">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="fw-bold">Layanan Prima</h5>
                        <p class="text-muted">Tim profesional siap membantu dari konsultasi hingga pengiriman produk.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Modals untuk Detail Produk -->
<!-- Modal 1 -->
<div class="modal fade" id="modal1" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary">Kaos Custom Komunitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=800" class="img-fluid rounded mb-3" alt="Kaos Custom">
                <p><strong>Deskripsi:</strong> Layanan sablon kaos custom untuk komunitas, event, perusahaan, atau kebutuhan pribadi dengan berbagai teknik sablon (plastisol, rubber, discharge) dan kualitas premium.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Minimal order 12 pcs</li>
                    <li><i class="fas fa-check text-success me-2"></i>Bahan cotton combed 20s/30s</li>
                    <li><i class="fas fa-check text-success me-2"></i>Gratis desain sederhana</li>
                    <li><i class="fas fa-check text-success me-2"></i>Pengerjaan 3-5 hari</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://wa.me/6285796740800" class="btn btn-success"><i class="fab fa-whatsapp me-2"></i>Pesan Sekarang</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="modal2" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary">Banner Promosi Outdoor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800" class="img-fluid rounded mb-3" alt="Banner">
                <p><strong>Deskripsi:</strong> Pembuatan banner outdoor dan indoor dengan bahan flexi China/Korea, spanduk, roll banner, dan X-banner untuk kebutuhan promosi Anda.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Bahan flexi berkualitas</li>
                    <li><i class="fas fa-check text-success me-2"></i>Ukuran custom sesuai kebutuhan</li>
                    <li><i class="fas fa-check text-success me-2"></i>Tahan cuaca outdoor</li>
                    <li><i class="fas fa-check text-success me-2"></i>Pengerjaan cepat 1-2 hari</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://wa.me/6285796740800" class="btn btn-success"><i class="fab fa-whatsapp me-2"></i>Pesan Sekarang</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3 -->
<div class="modal fade" id="modal3" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary">Kartu Nama Premium</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=800" class="img-fluid rounded mb-3" alt="Kartu Nama">
                <p><strong>Deskripsi:</strong> Cetak kartu nama profesional dengan berbagai pilihan kertas (Art Carton, BC, Linen) dan finishing (Laminasi Doff/Glossy, Spot UV, Emboss).</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Ukuran standar 9x5.5 cm</li>
                    <li><i class="fas fa-check text-success me-2"></i>Minimal order 1 box (100 lbr)</li>
                    <li><i class="fas fa-check text-success me-2"></i>Gratis desain</li>
                    <li><i class="fas fa-check text-success me-2"></i>Pengerjaan 2-3 hari</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://wa.me/6285796740800" class="btn btn-success"><i class="fab fa-whatsapp me-2"></i>Pesan Sekarang</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4 -->
<div class="modal fade" id="modal4" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary">Stiker Label Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1560439514-4e9645039924?w=800" class="img-fluid rounded mb-3" alt="Stiker">
                <p><strong>Deskripsi:</strong> Produksi stiker custom untuk label produk, kemasan, branding, dan berbagai kebutuhan promosi dengan bahan vinyl, HVS, atau transparan.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Berbagai bentuk (bulat, kotak, custom)</li>
                    <li><i class="fas fa-check text-success me-2"></i>Bahan waterproof tersedia</li>
                    <li><i class="fas fa-check text-success me-2"></i>Minimal order 50 lembar</li>
                    <li><i class="fas fa-check text-success me-2"></i>Pengerjaan 2-3 hari</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://wa.me/6285796740800" class="btn btn-success"><i class="fab fa-whatsapp me-2"></i>Pesan Sekarang</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal 5 -->
<div class="modal fade" id="modal5" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary">Kemasan Produk UMKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1634940615575-64ae0aa66069?w=800" class="img-fluid rounded mb-3" alt="Kemasan">
                <p><strong>Deskripsi:</strong> Desain dan cetak kemasan produk untuk UMKM seperti box, pouch, standing pouch, label, dan packaging lainnya dengan desain menarik.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Desain custom sesuai produk</li>
                    <li><i class="fas fa-check text-success me-2"></i>Berbagai ukuran tersedia</li>
                    <li><i class="fas fa-check text-success me-2"></i>Bahan food grade tersedia</li>
                    <li><i class="fas fa-check text-success me-2"></i>Konsultasi gratis</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://wa.me/6285796740800" class="btn btn-success"><i class="fab fa-whatsapp me-2"></i>Konsultasi Sekarang</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal 6 -->
<div class="modal fade" id="modal6" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-primary">Foto Produk Profesional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1542038784450-9d1d9e192f1b?w=800" class="img-fluid rounded mb-3" alt="Foto Studio">
                <p><strong>Deskripsi:</strong> Jasa pemotretan produk profesional dengan lighting studio untuk kebutuhan katalog, e-commerce, marketplace, dan media sosial.</p>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Studio dengan lighting profesional</li>
                    <li><i class="fas fa-check text-success me-2"></i>Editing & retouching included</li>
                    <li><i class="fas fa-check text-success me-2"></i>Bisa outdoor shooting</li>
                    <li><i class="fas fa-check text-success me-2"></i>Hasil high resolution</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://wa.me/6285796740800" class="btn btn-success"><i class="fab fa-whatsapp me-2"></i>Booking Jadwal</a>
            </div>
        </div>
    </div>
</div>

<!-- === CARA PEMESANAN SECTION (IMPROVED - BLUE CENTERED) === -->
<section class="py-5" style="background: linear-gradient(135deg, #0056b3 0%, #00b4d8 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-white mb-3">Cara Pemesanan</h2>
            <p class="lead text-white-50">Proses mudah dan cepat untuk mendapatkan produk impian Anda</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Step 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95);">
                    <div class="card-body text-center p-4">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">1</div>
                        <div class="mb-3">
                            <i class="fas fa-comments fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Konsultasi</h5>
                        <p class="text-muted mb-0">Hubungi kami via WhatsApp atau datang langsung untuk konsultasi kebutuhan Anda secara gratis</p>
                        <div class="mt-3">
                            <a href="https://wa.me/6285796740800" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-whatsapp me-2"></i>Chat WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95);">
                    <div class="card-body text-center p-4">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">2</div>
                        <div class="mb-3">
                            <i class="fas fa-paint-brush fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Desain & Quote</h5>
                        <p class="text-muted mb-0">Kami buatkan desain konsep dan penawaran harga sesuai permintaan Anda</p>
                        <div class="mt-3">
                            <span class="badge bg-primary px-3 py-2">Gratis Desain</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95);">
                    <div class="card-body text-center p-4">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">3</div>
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Konfirmasi</h5>
                        <p class="text-muted mb-0">Setujui desain dan lakukan pembayaran DP untuk memulai produksi</p>
                        <div class="mt-3">
                            <span class="badge bg-success px-3 py-2">DP 50%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95);">
                    <div class="card-body text-center p-4">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">4</div>
                        <div class="mb-3">
                            <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold text-primary mb-3">Selesai & Kirim</h5>
                        <p class="text-muted mb-0">Produk selesai dan siap diambil atau dikirim ke alamat Anda</p>
                        <div class="mt-3">
                            <span class="badge bg-info px-3 py-2">Cepat & Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- === CTA SECTION === -->
<section class="py-5" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
    <div class="container text-center text-white">
        <h2 class="display-5 fw-bold mb-4">Siap Memulai Proyek Anda?</h2>
        <p class="lead mb-4">Hubungi kami sekarang dan dapatkan konsultasi GRATIS untuk kebutuhan percetakan dan desain Anda!</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="https://wa.me/6285796740800" class="btn btn-warning btn-lg px-5">
                <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
            </a>
            <a href="pages/kontak.html" class="btn btn-light btn-lg px-5">
                <i class="fas fa-map-marker-alt me-2"></i>Kunjungi Kami
            </a>
        </div>
    </div>
</section>

<!-- Filter Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                        // Add animation
                        item.style.animation = 'fadeIn 0.5s ease';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });

    // Add fadeIn animation
    const style = document.createElement('style');
    style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
`;
    document.head.appendChild(style);
</script>

<?= $this->endSection() ?>