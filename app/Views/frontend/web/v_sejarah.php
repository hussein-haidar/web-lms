<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>


<!-- === HEADER SECTION === -->
<section class="py-4" style="background: linear-gradient(135deg, #0056b3 0%, #00b4d8 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white fw-bold mb-2" style="font-size: 2.2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                    <?= (!empty($profil) && isset($profil['judul_header'])) ? $profil['judul_header'] : 'Sejarah LPK INASABA' ?>
                </h2>
                <p class="text-white-50 mb-0"><?= (!empty($profil) && isset($profil['subjudul_header'])) ? $profil['subjudul_header'] : 'Berikut adalah sejarah berdirinya LPK INASABA' ?></p>
            </div>
        </div>
    </div>
</section>

<!-- === HERO SECTION (BIRU GRADIENT SAMA DENGAN NAVBAR) === -->
<section class="py-5 text-center" style="background: linear-gradient(to right, #0056b3, #00b4d8);">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Video Profil -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                            <?php if (!empty($profil) && isset($profil['video_url'])): ?>
                                <iframe src="<?= $profil['video_url'] ?>"
                                    title="<?= (!empty($profil) && isset($profil['video_title'])) ? $profil['video_title'] : 'Profil LPK INASABA' ?>"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            <?php else: ?>
                                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                                    title="Profil LPK INASABA"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sejarah Singkat -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <!-- Heading dengan border kiri tebal -->
                        <h3 class="text-success mb-4 pb-2 border-start border-4 border-success ps-3 fw-bold">
                            <i class="fas fa-history me-2"></i>Sejarah Singkat LPK INASABA
                        </h3>
                        <?php if (!empty($profil) && isset($profil['sejarah_singkat'])): ?>
                            <p class="text-start"><?= nl2br($profil['sejarah_singkat']) ?></p>
                        <?php else: ?>
                            <p class="text-start">
                                Cikal bakal LPK INASABA bermula dari pendirian sebuah warnet pada tahun <strong>2000</strong> dengan memiliki peralatan sebanyak: 5 unit komputer...
                            </p>
                            <p class="text-start">
                                Melihat perkembangan akan warnet dan semakin banyaknya pula permintaan kursus privat pada saat itu, muncul ide untuk membuka kursus kecil-kecilan...
                            </p>
                            <p class="text-start">
                                Dengan berbekal keberanian, tekad dan keseriusan yang tinggi, maka usaha membesarkan kegiatan kursus ini dilakukan... Sehingga sejak tanggal <strong>1 November 2001</strong> resmi Lembaga Pelatihan Komputer (INASABA) berdiri...
                            </p>
                            <p class="text-start">
                                Pada tanggal <strong>25 Oktober 2007</strong>, LPK INASABA juga telah memiliki ijin operasional dari Disnaker Kota Pekalongan...
                            </p>
                            <p class="text-start">
                                LPK INASABA kini sudah memiliki sarana dan prasarana yang memadai, serta status <strong>Terakreditasi</strong> oleh Badan Akreditasi Nasional...
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- === WAVE DIVIDER DI BAWAH HERO SECTION === -->
<div class="position-relative overflow-hidden" style="height: 100px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
        <path d="M0,120V73.71c47.79,-22.2,103.59,-32.17,158,-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27,-18,138.3,-24.88,209.4,-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9,-9.42,98.6,-31.56,31.77,-25.39,62.32,-62,103.63,-73,40.44,-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28,-22.88,168.9,-38.84,30.2,-8.66,59,-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48,-12.24,165.56,-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- === VISI & MISI === -->
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="fs-1 text-success mb-3">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Visi</h3>
                            <?php if (!empty($visi)): ?>
                                <?php foreach ($visi as $item): ?>
                                    <p class="text-muted"><?= $item['konten'] ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">
                                    Menjadi lembaga pelatihan komputer unggulan di Indonesia yang menghasilkan SDM berkualitas, siap kerja, dan berdaya saing global.
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="fs-1 text-success mb-3 text-center">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="fw-bold mb-3 text-center">Misi</h3>
                    <ul class="list-unstyled text-muted ps-3">
                        <?php if (!empty($misi)): ?>
                            <?php foreach ($misi as $item): ?>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <?= $item['konten'] ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Menyelenggarakan pelatihan berbasis kompetensi...</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Mengembangkan instruktur profesional...</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Membangun kerja sama strategis...</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Memberdayakan masyarakat melalui pendidikan vokasi...</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- === MANAJEMEN LPK INASABA === -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="text-center text-primary mb-4">Manajemen LPK INASABA</h3>

                <div class="row justify-content-center">
                    <?php if (!empty($manajemen)): ?>
                        <?php foreach ($manajemen as $item): ?>
                            <div class="col-md-2 text-center mb-4">
                                <div class="position-relative">
                                    <?php if (!empty($item['foto']) && file_exists(FCPATH . 'uploads/struktural/' . $item['foto'])): ?>
                                        <img src="<?= base_url('uploads/struktural/' . $item['foto']) ?>"
                                            class="rounded-circle shadow"
                                            alt="<?= $item['nama_lengkap'] ?>"
                                            style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #00b4d8;"
                                            onerror="this.src='<?= base_url('assets/img/default-avatar.png') ?>'">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/img/default-avatar.png') ?>"
                                            class="rounded-circle shadow"
                                            alt="<?= $item['nama_lengkap'] ?>"
                                            style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #00b4d8;">
                                    <?php endif; ?>
                                    <?php if (!empty($item['facebook'])): ?>
                                        <div class="position-absolute bottom-0 start-50 translate-middle-x bg-primary text-white rounded-circle p-1" style="width: 30px; height: 30px; line-height: 26px;">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h5 class="mt-2 fw-bold"><?= $item['nama_lengkap'] ?></h5>
                                <p class="text-muted"><?= $item['jabatan'] ?></p>
                                <div class="d-flex justify-content-center mt-2">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- === INSTRUKTUR LPK INASABA === -->
<section class="py-5">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="text-center text-primary mb-4">Instruktur LPK INASABA</h3>

                <div class="row justify-content-center">
                    <?php if (!empty($instruktur)): ?>
                        <?php foreach ($instruktur as $item): ?>
                            <div class="col-md-3 text-center mb-4">
                                <div class="position-relative">
                                    <?php if (!empty($item['foto']) && file_exists(FCPATH . 'uploads/struktural/' . $item['foto'])): ?>
                                        <img src="<?= base_url('uploads/struktural/' . $item['foto']) ?>"
                                            class="rounded-circle shadow"
                                            alt="<?= $item['nama_lengkap'] ?>"
                                            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #00b4d8;"
                                            onerror="this.src='<?= base_url('assets/img/default-avatar.png') ?>'">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/img/default-avatar.png') ?>"
                                            class="rounded-circle shadow"
                                            alt="<?= $item['nama_lengkap'] ?>"
                                            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #00b4d8;">
                                    <?php endif; ?>
                                </div>
                                <h5 class="mt-2 fw-bold"><?= $item['nama_lengkap'] ?></h5>
                                <p class="text-muted"><?= $item['keahlian'] ?></p>
                                <div class="d-flex justify-content-center mt-2">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>