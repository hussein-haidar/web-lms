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
            <h2 class="fw-bold text-white mb-0">Kenalan dengan Program Kami</h2>
        </div>
        
        <!-- Cards Row -->
        <div class="row g-4">
            
            <!-- Program 1 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg rounded-3 overflow-hidden" style="background: rgba(255, 255, 255, 0.95);">
                    <div class="position-relative" style="height: 350px; overflow: hidden; background-color: #f8f9fa;">
                        <img src="<?= base_url('/gambar_kursus/kid(3).png') ?>"
                            alt="Program 1" 
                            class="w-100 h-100"
                            style="object-fit: contain; padding: 20px;">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title fw-bold text-primary text-center mb-3">Program 1</h5>
                        <p class="card-text text-muted small text-center mb-3">Program dasar untuk anak usia 4-6 tahun dengan materi dasar komputer yang interaktif dan menyenangkan.</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <span class="text-muted"><i class="fas fa-clock me-2"></i>12 sesi</span>
                            </div>
                            <button class="btn btn-primary w-100">Daftar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Program 2 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg rounded-3 overflow-hidden" style="background: rgba(255, 255, 255, 0.95);">
                    <div class="position-relative" style="height: 350px; overflow: hidden; background-color: #f8f9fa;">
                        <img src="<?= base_url('/gambar_kursus/kid(2).png') ?>"
                            alt="Program 2" 
                            class="w-100 h-100"
                            style="object-fit: contain; padding: 20px;">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title fw-bold text-primary text-center mb-3">Program 2</h5>
                        <p class="card-text text-muted small text-center mb-3">Program lanjutan untuk anak usia 7-9 tahun dengan fokus pada kreativitas dan pengembangan keterampilan dasar.</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <span class="text-muted"><i class="fas fa-clock me-2"></i>16 sesi</span>
                            </div>
                            <button class="btn btn-primary w-100">Daftar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Program 3 -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg rounded-3 overflow-hidden" style="background: rgba(255, 255, 255, 0.95);">
                    <div class="position-relative" style="height: 350px; overflow: hidden; background-color: #f8f9fa;">
                        <img src="<?= base_url('/gambar_kursus/kid(1).png') ?>"
                            alt="Program 3" 
                            class="w-100 h-100"
                            style="object-fit: contain; padding: 20px;">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title fw-bold text-primary text-center mb-3">Program 3</h5>
                        <p class="card-text text-muted small text-center mb-3">Program advanced untuk anak usia 10-12 tahun dengan fokus pada pengembangan keterampilan teknis dan kreativitas.</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <span class="text-muted"><i class="fas fa-clock me-2"></i>18 sesi</span>
                            </div>
                            <button class="btn btn-primary w-100">Daftar Sekarang</button>
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