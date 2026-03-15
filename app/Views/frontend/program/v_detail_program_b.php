<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<!-- Program Banner - Carousel dengan Gambar -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('/gambar_kursus/pr-1.png') ?>"
                class="d-block w-100"
                alt="Program Profesi 1 Tahun"
                style="height: 450px; object-fit: contain; background: linear-gradient(135deg,#0056b3, #00b4d8 100%);">
        </div>
    </div>
    <div class="carousel-indicators">
    </div>
</div>

<!-- Main Content Section -->
<section class="py-5">
    <div class="container">
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
                <!-- YouTube Video Embed Langsung - FORMAT YANG BENAR -->
                <div class="ratio ratio-16x9 rounded shadow overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/0MCLNW1dHzo"
                        title="LPK INASABA Video Profile"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin">
                    </iframe>
                </div>
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