<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Program Banner - Carousel dengan Gambar -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('/gambar_kursus/jk.png') ?>"
                class="d-block w-100"
                alt="Program Profesi 1 Tahun"
                style="height: 450px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
        </div>
    </div>
  
</div>

  <!-- === HERO SECTION (BIRU GRADIENT SAMA DENGAN NAVBAR) === -->
    <section class="py-5 text-center" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
          <div class="container">
        <!-- Heading Tengah -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white mb-0">Kenalan Program Profesi 1 Tahun Kami</h2>
        </div>
        
      <!-- Featured Courses -->
<div class="container mb-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Program Profesi 1 Tahun</h4>
                <a href="#" class="text-decoration-none text-primary">Lihat Semua →</a>
            </div>

            <div class="row g-4">
                <!-- Course 1 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="bg-secondary" style="height:140px;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold">
                            AI Course
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success">Bestseller</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border">Premium</span>
                            </div>
                            <h6 class="card-title fw-bold mb-2">AI Engineer Agentic Track: The Complete Agent & MCP Course</h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user me-1"></i>By Ed Donner and 1 other
                            </p>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-muted small ms-2">(30,805)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark">Rp109,000</div>
                                    <div class="text-decoration-line-through text-muted small">Rp149,000</div>
                                </div>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-shopping-cart me-1"></i>Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="bg-primary" style="height:140px;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold">
                            Web Dev
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Hot</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border">Premium</span>
                            </div>
                            <h6 class="card-title fw-bold mb-2">The Complete 2024 Web Development Bootcamp</h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user me-1"></i>By Angela Yu
                            </p>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-muted small ms-2">(125,342)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark">Rp129,000</div>
                                    <div class="text-decoration-line-through text-muted small">Rp199,000</div>
                                </div>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-shopping-cart me-1"></i>Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course 3 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="bg-info" style="height:140px;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold">
                            Data Science
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info">New</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border">Premium</span>
                            </div>
                            <h6 class="card-title fw-bold mb-2">Data Science A-Z: Real Exercises Included</h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user me-1"></i>By Kirill Eremenko
                            </p>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="text-muted small ms-2">(45,678)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark">Rp99,000</div>
                                    <div class="text-decoration-line-through text-muted small">Rp159,000</div>
                                </div>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-shopping-cart me-1"></i>Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course 4 -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="bg-dark" style="height:140px;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold">
                            Python
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success">Bestseller</span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border">Premium</span>
                            </div>
                            <h6 class="card-title fw-bold mb-2">100 Days of Code: The Complete Python Pro Bootcamp</h6>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user me-1"></i>By Dr. Angela Yu
                            </p>
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-muted small ms-2">(89,123)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark">Rp119,000</div>
                                    <div class="text-decoration-line-through text-muted small">Rp179,000</div>
                                </div>
                                <button class="btn btn-sm btn-primary">
                                    <i class="fas fa-shopping-cart me-1"></i>Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    </section>

<!-- Wave Divider Bawah -->
<div class="position-relative overflow-hidden" style="height: 100px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
        <path d="M0,120V73.71c47.79,-22.2,103.59,-32.17,158,-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27,-18,138.3,-24.88,209.4,-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9,-9.42,98.6,-31.56,31.77,-25.39,62.32,-62,103.63,-73,40.44,-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28,-22.88,168.9,-38.84,30.2,-8.66,59,-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48,-12.24,165.56,-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
    </svg>
</div>

<?= $this->endSection() ?>