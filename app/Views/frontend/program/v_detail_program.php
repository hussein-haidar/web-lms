<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php
// Get program type from URL parameter or default to 'a'
$programType = $program_type ?? 'a';
?>

<!-- Program Banner - Carousel dengan Gambar -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php 
        // Debug: Tampilkan apakah sliders ada isinya
        // echo '<pre>'; print_r($sliders); echo '</pre>';
        
        if (!empty($sliders)): ?>
            <?php foreach ($sliders as $key => $slider): ?>
                <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('uploads/slider_web/' . $slider['gambar_slider']) ?>"
                        class="d-block w-100"
                        alt="<?= htmlspecialchars($slider['judul_slider']) ?>"
                        style="height: 300px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback image jika sliders kosong -->
            <div class="carousel-item active">
                <img src="<?= base_url('/gambar_kursus/tf.png') ?>"
                    class="d-block w-100"
                    alt="Program Profesi 1 Tahun"
                    style="height: 300px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);">
            </div>
        <?php endif; ?>
    </div>
    <div class="carousel-indicators">
        <?php if (!empty($sliders)): ?>
            <?php foreach ($sliders as $key => $slider): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $key ?>" class="<?= $key == 0 ? 'active' : '' ?>" aria-current="<?= $key == 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $key + 1 ?>"></button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Wave Divider -->
<div class="position-relative overflow-hidden" style="height: 80px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
        <path d="M0,120V73.71c47.79,-22.2,103.59,-32.17,158,-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27,-18,138.3,-24.88,209.4,-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9,-9.42,98.6,-31.56,31.77,-25.39,62.32,-62,103.63,-73,40.44,-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28,-22.88,168.9,-38.84,30.2,-8.66,59,-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48,-12.24,165.56,-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Main Content Section -->
<section class="py-5">
    <div class="container">
        <!-- Program Selection Tabs -->
        <div class="row mb-4">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center" id="programTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $programType == 'a' ? 'active' : '' ?>"
                            id="program-a-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#program-a"
                            type="button"
                            role="tab"
                            aria-controls="program-a"
                            aria-selected="<?= $programType == 'a' ? 'true' : 'false' ?>">
                            Program Sekretaris & Administrasi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $programType == 'b' ? 'active' : '' ?>"
                            id="program-b-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#program-b"
                            type="button"
                            role="tab"
                            aria-controls="program-b"
                            aria-selected="<?= $programType == 'b' ? 'true' : 'false' ?>">
                            Program Desain Grafis
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="programTabContent">
            <!-- Program A Content -->
            <div class="tab-pane fade <?= $programType == 'a' ? 'show active' : '' ?>"
                id="program-a"
                role="tabpanel"
                aria-labelledby="program-a-tab">
                <!-- Intro Section -->
                <div class="row mb-5">
                    <div class="col-lg-6 mb-4">
                        <h2 class="fw-bold mb-3" style="color: #0056b3;">Program Sekretaris & Administrasi Perkantoran</h2>
                        <p class="text-muted mb-3">
                            Program pelatihan kerja yang dirancang khusus untuk meningkatkan kompetensi dan keterampilan
                            peserta dalam bidang administrasi perkantoran, kesekretariatan, dan manajemen bisnis.
                        </p>
                        <p class="text-muted mb-3">
                            Program ini diselenggarakan oleh LPK INASABA yang telah berpengalaman dalam menyelenggarakan
                            pelatihan kerja dan telah menghasilkan lulusan-lulusan yang kompeten dan siap kerja.
                        </p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Daftar Sekarang</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Video section removed -->
                    </div>
                </div>

                <!-- Data Pendidikan Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <!-- Header Text -->
                        <h3 class="text-center fw-bold mb-2" style="color: #333;">Program unggulan yang dirancang khusus dengan materi</h3>
                        <h4 class="text-center fw-bold mb-5">
                            yang sesuai dengan kebutuhan
                            <span style="color: #0056b3;">Dunia Kerja,</span>
                            <span style="color: #0056b3;">Dunia Industri</span> dan
                            <span style="color: #0056b3;">Dunia Usaha</span>
                        </h4>

                        <div class="row g-4">
                            <!-- Left Side - Materi List -->
                            <div class="col-lg-4">
                                <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(180deg, #0056b3 0%, #00b4d8 100%);">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <span class="badge bg-white text-primary px-4 py-2 rounded-pill fw-bold">Materi</span>
                                        </div>
                                        <h5 class="text-white text-center fw-bold mb-4">SEKRETARIS & ADMINISTRASI PERKANTORAN</h5>

                                        <ol class="list-unstyled text-white" style="font-size: 0.9rem;">
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">1. COMPUTER BASIC SKILL</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">2. KEYBOARD SKILL</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">3. BUSINESS APPLICATION</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">4. ACCOUNTING</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">5. ENGLISH FOR SECRETARY</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">6. SERVICE EXCELLENT</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">7. PUBLIC SPEAKER</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">8. COMPLAIN MANAGEMENT</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">9. PROFESIONAL ETHIC & ENTREPRENEUSHIP</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">10. STUDY BANDING</li>
                                            <li class="mb-2">11. TUGAS AKHIR</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Biaya dan Sudah Termasuk -->
                            <div class="col-lg-8">
                                <!-- BIAYA PENDIDIKAN - Menggunakan Gambar -->
                                <h5 class="text-center fw-bold mb-4" style="color: #333;">BIAYA PENDIDIKAN</h5>

                                <!-- Pricing Image -->
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('/gambar_kursus/csx.png') ?>"
                                        class="img-fluid rounded shadow w-100"
                                        alt="Biaya Pendidikan"
                                        style="max-width: 100%; height: auto;">
                                </div>

                                <!-- JARAK ANTAR KONTEN -->
                                <div class="mb-4"></div>

                                <!-- SUDAH TERMASUK - Text yang lebih besar dan rapi -->
                                <div class="card border-2 shadow-lg"
                                    style="border-style: dashed !important; 
                                            border-color: #333 !important; 
                                            border-radius: 15px;
                                            border-width: 3px !important;">
                                    <div class="card-body p-5">
                                        <h4 class="text-center fw-bold mb-4"
                                            style="color: #333; font-size: 2rem; letter-spacing: 1px;">
                                            SUDAH TERMASUK :
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Modul Pembelajaran
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Toolkits
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Seragam
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Uji Kompetensi dari LSK TIK
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Kegiatan seminar
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Kegiatan Kewirausahaan
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Kegiatan Lapangan
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program B Content -->
            <div class="tab-pane fade <?= $programType == 'b' ? 'show active' : '' ?>"
                id="program-b"
                role="tabpanel"
                aria-labelledby="program-b-tab">
                <!-- Intro Section -->
                <div class="row mb-5">
                    <div class="col-lg-6 mb-4">
                        <h2 class="fw-bold mb-3" style="color: #0056b3;">Program Desain Grafis</h2>
                        <p class="text-muted mb-3">
                            Program pelatihan kerja yang dirancang khusus untuk meningkatkan kompetensi dan keterampilan
                            peserta dalam bidang desain komunikasi visual, multimedia, dan kreativitas digital.
                        </p>
                        <p class="text-muted mb-3">
                            Program ini diselenggarakan oleh LPK INASABA yang telah berpengalaman dalam menyelenggarakan
                            pelatihan kerja dan telah menghasilkan lulusan-lulusan yang kompeten dan siap kerja.
                        </p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Daftar Sekarang</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Video section removed -->
                    </div>
                </div>

                <!-- Data Pendidikan Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <!-- Header Text -->
                        <h3 class="text-center fw-bold mb-2" style="color: #333;">Program unggulan yang dirancang khusus dengan materi</h3>
                        <h4 class="text-center fw-bold mb-5">
                            yang sesuai dengan kebutuhan
                            <span style="color: #0056b3;">Dunia Kerja,</span>
                            <span style="color: #0056b3;">Dunia Industri</span> dan
                            <span style="color: #0056b3;">Dunia Usaha</span>
                        </h4>

                        <div class="row g-4">
                            <!-- Left Side - Materi List -->
                            <div class="col-lg-4">
                                <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(180deg, #0056b3 0%, #00b4d8 100%);">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <span class="badge bg-white text-primary px-4 py-2 rounded-pill fw-bold">Materi</span>
                                        </div>
                                        <h5 class="text-white text-center fw-bold mb-4">DKV (DESAIN KOMUNIKASI VISUAL)</h5>

                                        <ol class="list-unstyled text-white" style="font-size: 0.9rem;">
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">1. COMPUTER BASIC SKILL</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">2. KEYBOARD SKILL</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">3. CORELDRAW</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">4. ADOBE PHOTOSHOP</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">5. ADOBE ILLUSTRATOR</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">6. VIDEO EDITING</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">7. DIGITAL PHOTOGRAPHY</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">8. WEB DESIGN</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">9. PROFESIONAL ETHIC & ENTREPRENEUSHIP</li>
                                            <li class="mb-2 pb-2 border-bottom border-white border-opacity-25">10. STUDY BANDING</li>
                                            <li class="mb-2">11. TUGAS AKHIR</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Biaya dan Sudah Termasuk -->
                            <div class="col-lg-8">
                                <!-- BIAYA PENDIDIKAN - Menggunakan Gambar -->
                                <h5 class="text-center fw-bold mb-4" style="color: #333;">BIAYA PENDIDIKAN</h5>

                                <!-- Pricing Image -->
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('/gambar_kursus/csx.png') ?>"
                                        class="img-fluid rounded shadow w-100"
                                        alt="Biaya Pendidikan"
                                        style="max-width: 100%; height: auto;">
                                </div>

                                <!-- JARAK ANTAR KONTEN -->
                                <div class="mb-4"></div>

                                <!-- SUDAH TERMASUK - Text yang lebih besar dan rapi -->
                                <div class="card border-2 shadow-lg"
                                    style="border-style: dashed !important; 
                                            border-color: #333 !important; 
                                            border-radius: 15px;
                                            border-width: 3px !important;">
                                    <div class="card-body p-5">
                                        <h4 class="text-center fw-bold mb-4"
                                            style="color: #333; font-size: 2rem; letter-spacing: 1px;">
                                            SUDAH TERMASUK :
                                        </h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Modul Pembelajaran
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Toolkits
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Seragam
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Uji Kompetensi dari LSK TIK
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Kegiatan seminar
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Kegiatan Kewirausahaan
                                                    </li>
                                                    <li class="mb-4" style="color: #333; font-size: 1.4rem; font-weight: 500; line-height: 1.6;">
                                                        <i class="fas fa-minus text-primary me-3" style="font-size: 1.2rem;"></i>Kegiatan Lapangan
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Sections (Common for both programs) -->
        <div class="mb-5"></div>

        <!-- Gallery Section 1 -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow" style="background: linear-gradient(135deg, #0056b3, #00b4d8);">
                    <div class="card-body p-4">
                        <h4 class="text-white fw-bold mb-3">DOKUMENTASI KEGIATAN</h4>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/9.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/10.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/11.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/12.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section 2 -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow" style="background: linear-gradient(135deg, #0056b3, #00b4d8);">
                    <div class="card-body p-4">
                        <h4 class="text-white fw-bold mb-3">KEGIATAN PRAKTIK</h4>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/13.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/14.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/15.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/16.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section 3 -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow" style="background: linear-gradient(135deg, #0056b3, #00b4d8);">
                    <div class="card-body p-4">
                        <h4 class="text-white fw-bold mb-3">KEGIATAN SEMINAR & WORKSHOP</h4>
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/17.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/18.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/19.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-3 col-6">
                                <img src="<?= base_url('/galeri/20.jpg') ?>"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>