    <?= $this->extend('frontend/template_web/main') ?>
    <?= $this->section('content') ?>

    <!-- Stats Section Tambahan (Dibungkus Card) -->
    <section class="py-5 text-center" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
        <div class="container">
            <h1 class="display-5 fw-bold text-white">Galeri LPK INASABA</h1>
            <div class="container my-4">

                <section class="mb-5">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Kartu 1 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="position-relative overflow-hidden rounded shadow-sm ratio ratio-4x3">
                                        <img src="<?= base_url('/galeri/bd(1).png') ?>" class="w-100 h-100 object-fit-cover" alt="Studio Broadcast WPITV">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-3">
                                        </div>
                                    </div>
                                </div>

                                <!-- Kartu 2 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="position-relative overflow-hidden rounded shadow-sm ratio ratio-4x3">
                                        <img src="<?= base_url('/galeri/bd(2).png') ?>" class="w-100 h-100 object-fit-cover" alt="Perpustakaan">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-3">

                                        </div>
                                    </div>
                                </div>

                                <!-- Kartu 3 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="position-relative overflow-hidden rounded shadow-sm ratio ratio-4x3">
                                        <img src="<?= base_url('/galeri/bd(3).png') ?>" class="w-100 h-100 object-fit-cover" alt="Tempat Parkir">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-3">

                                        </div>
                                    </div>
                                </div>

                                <!-- Kartu 4 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="position-relative overflow-hidden rounded shadow-sm ratio ratio-4x3">
                                        <img src="<?= base_url('/galeri/bd(4).png') ?>" class="w-100 h-100 object-fit-cover" alt="Ruang Kelas Teori">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-3">

                                        </div>
                                    </div>
                                </div>

                                <!-- Kartu 5 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="position-relative overflow-hidden rounded shadow-sm ratio ratio-4x3">
                                        <img src="<?= base_url('/galeri/bd(5).png') ?>" class="w-100 h-100 object-fit-cover" alt="Laboratorium Komputer">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-3">

                                        </div>
                                    </div>
                                </div>

                                <!-- Kartu 6 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="position-relative overflow-hidden rounded shadow-sm ratio ratio-4x3">
                                        <img src="<?= base_url('/galeri/bd(6).png') ?>" class="w-100 h-100 object-fit-cover" alt="Laboratorium Jaringan">
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 p-3">
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </section>

    <!-- === WAVE DIVIDER DI BAWAH HERO SECTION (OMBANG DIBALIK LANGSUNG DI SVG) === -->
    <div class="position-relative overflow-hidden" style="height: 100px; background: linear-gradient(to right, #0056b3, #00b4d8);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
            <path d="M0,120V73.71c47.79,-22.2,103.59,-32.17,158,-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27,-18,138.3,-24.88,209.4,-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
            <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9,-9.42,98.6,-31.56,31.77,-25.39,62.32,-62,103.63,-73,40.44,-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28,-22.88,168.9,-38.84,30.2,-8.66,59,-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
            <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48,-12.24,165.56,-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
        </svg>
    </div>
    <!-- WAVE DIVIDER SUDAH DIHAPUS SESUAI INSTRUKSI -->

    <?= $this->endSection() ?>