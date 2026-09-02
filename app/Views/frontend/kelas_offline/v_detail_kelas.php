<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<?php
$kursus = $kursus ?? [];

$gambarBanner = !empty($kursus['gambar_utama']) ? $kursus['gambar_utama'] : 'as.png';
$gambarThumbnail = !empty($kursus['gambar_detail_a']) ? $kursus['gambar_detail_a'] : (!empty($kursus['gambar_detail_b']) ? $kursus['gambar_detail_b'] : (!empty($kursus['gambar_detail_c']) ? $kursus['gambar_detail_c'] : (!empty($kursus['gambar_utama']) ? $kursus['gambar_utama'] : 'as.png')));

$judulAsli = !empty($kursus['nama_paket']) ? (string) $kursus['nama_paket'] : (!empty($kursus['nama_kursus']) ? (string) $kursus['nama_kursus'] : 'Program Pelatihan');
$judulPaket = preg_replace('/\s*-\s*\d+\s*Pertemuan/i', '', $judulAsli);
$judulPaket = trim($judulPaket);

$deskripsi  = !empty($kursus['deskripsi_singkat']) ? (string) $kursus['deskripsi_singkat'] : '';
$materi     = !empty($kursus['materi_yang_dipelajari']) ? (string) $kursus['materi_yang_dipelajari'] : '';
$syarat     = !empty($kursus['syarat_pendaftaran']) ? (string) $kursus['syarat_pendaftaran'] : '';

$totalPertemuan = !empty($kursus['total_pertemuan']) ? (int) $kursus['total_pertemuan'] : 25;
$durasiJam      = !empty($kursus['durasi_per_pertemuan_jam']) ? (int) $kursus['durasi_per_pertemuan_jam'] : 2;
$hargaReguler   = !empty($kursus['harga_reguler']) ? (float) $kursus['harga_reguler'] : 0;
$hargaIntensive = !empty($kursus['harga_intensive']) ? (float) $kursus['harga_intensive'] : 0;
$hargaPrivate   = !empty($kursus['harga_private']) ? (float) $kursus['harga_private'] : 0;
$idPaket        = $kursus['id_paket'] ?? '';

$instruktur = !empty($kursus['nama_pengajar']) ? (string) $kursus['nama_pengajar'] : '';
$instrukturFoto = !empty($kursus['foto_pengajar']) ? $kursus['foto_pengajar'] : '';
$instrukturName = !empty($instruktur) ? $instruktur : 'Professional Trainer';

if (!empty($instrukturFoto)) {
    $instrukturAvatar = base_url('fotoprofil/' . $instrukturFoto);
} else {
    $instrukturAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($instrukturName) . '&background=1976d2&color=fff&size=120';
}
?>

<!-- Program Banner -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('kursus/materi/' . $gambarBanner) ?>"
                class="d-block w-100"
                alt="<?= esc($judulPaket) ?>"
                style="height: 300px; object-fit: contain; background: linear-gradient(135deg, #0056b3, #00b4d8);"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x450/0056b3/ffffff?text=<?= urlencode($judulPaket) ?>'">
        </div>
    </div>
</div>

<!-- ✅ WAVE DIVIDER - Tetap Ditampilkan -->
<div class="position-relative" style="height: 80px; background: linear-gradient(to right, #0056b3, #00b4d8);">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; transform: scaleY(-1);">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#ffffff"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#ffffff"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
    </svg>
</div>

<!-- Main Content -->
<div class="container my-5">
    <div class="row g-4 align-items-start">
        <!-- Left Side -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                <img src="<?= base_url('kursus/materi/' . $gambarThumbnail) ?>"
                    class="card-img-top"
                    alt="<?= esc($judulPaket) ?>"
                    style="height: 300px; object-fit: contain; background-color: #f8f9fa; padding: 15px;"
                    onerror="this.src='https://via.placeholder.com/400x300/6c757d/ffffff?text=<?= urlencode($judulPaket) ?>'">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary mb-3"><?= esc($judulPaket) ?></h4>

                    <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#modalJadwal">
                        <i class="fas fa-calendar-alt me-2"></i>JADWAL PELATIHAN
                    </button>

                    <div class="mb-3 p-3 bg-light rounded">
                        <small class="text-muted d-block"><i class="fas fa-clock me-1"></i>Durasi Program</small>
                        <strong><?= $totalPertemuan ?>x Pertemuan @<?= $durasiJam ?> jam</strong>
                    </div>

                    <?php if (!empty($instruktur)): ?>
                        <div class="mb-3 p-3 bg-light rounded shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= $instrukturAvatar ?>"
                                    alt="<?= esc($instrukturName) ?>"
                                    class="rounded-circle shadow-sm"
                                    style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #0056b3;">
                                <div>
                                    <small class="text-muted d-block"><i class="fas fa-chalkboard-teacher me-1"></i>Instruktur</small>
                                    <strong class="text-primary"><?= esc($instruktur) ?></strong>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mb-3 p-3 bg-light rounded">
                            <small class="text-muted d-block"><i class="fas fa-info-circle me-1"></i>Informasi</small>
                            <strong>Instruktur akan ditentukan</strong>
                        </div>
                    <?php endif; ?>

                    <a href="<?= base_url('auth_login/register_paket?id_paket=' . $idPaket) ?>"
                        class="btn btn-success w-100 py-2 fw-bold">
                        <i class="fas fa-user-plus me-2"></i>DAFTAR SEKARANG
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side: 3 Pricing Cards -->
        <div class="col-lg-8">
            <div class="row g-4">

                <!-- Kelas Reguler -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white text-center py-4 border-0">
                            <h4 class="mb-0 fw-bold">Kelas Reguler</h4>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-unstyled mb-4 small">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>Minimal 5 Peserta+ /kelas</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span><?= $totalPertemuan ?>x Pertemuan (<?= $durasiJam ?> jam/pertemuan)</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span><?= esc($materi) ?></span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>Praktik 70% Materi 30%</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>Free Modul Pembelajaran</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>Free Toolkits</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle text-primary me-2 mt-1"></i>
                                    <span>Jadwal Fleksibel</span>
                                </li>
                            </ul>
                            <div class="text-center mb-3">
                                <small class="text-muted d-block mb-1">Biaya Pendaftaran</small>
                                <?php if ($hargaReguler > 0): ?>
                                    <h3 class="text-primary fw-bold mb-0">Rp<?= number_format($hargaReguler, 0, ',', '.') ?></h3>
                                <?php else: ?>
                                    <h3 class="text-success fw-bold mb-0">Hubungi Admin</h3>
                                <?php endif; ?>
                            </div>
                            <a href="<?= base_url('auth_login/register_paket?id_paket=' . $idPaket . '&tipe=reguler') ?>"
                                class="btn btn-primary w-100 py-2 fw-bold">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kelas Intensive -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header text-white text-center py-4 border-0" style="background: linear-gradient(135deg, #ff8c00, #ffa500);">
                            <h4 class="mb-0 fw-bold">Kelas Intensive</h4>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-unstyled mb-4 small">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span>Minimal 2 - Max 4 Peserta /kelas</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span><?= $totalPertemuan ?>x Pertemuan (<?= $durasiJam ?> jam/pertemuan)</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span><?= esc($materi) ?></span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span>Praktik 70% Materi 30%</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span>Free Modul Pembelajaran</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span>Free Toolkits</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #ff8c00;"></i>
                                    <span>Jadwal Prioritas</span>
                                </li>
                            </ul>
                            <div class="text-center mb-3">
                                <small class="text-muted d-block mb-1">Biaya Pendaftaran</small>
                                <?php if ($hargaIntensive > 0): ?>
                                    <h3 class="fw-bold mb-0" style="color: #ff8c00;">Rp<?= number_format($hargaIntensive, 0, ',', '.') ?></h3>
                                <?php else: ?>
                                    <h3 class="text-success fw-bold mb-0">Hubungi Admin</h3>
                                <?php endif; ?>
                            </div>
                            <a href="<?= base_url('auth_login/register_paket?id_paket=' . $idPaket . '&tipe=intensive') ?>"
                                class="btn w-100 py-2 fw-bold" style="background: linear-gradient(135deg, #ff8c00, #ffa500); color: white; border: none;">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Kelas Private -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-header text-white text-center py-4 border-0" style="background: linear-gradient(135deg, #dc143c, #ff0000);">
                            <h4 class="mb-0 fw-bold">Kelas Private</h4>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-unstyled mb-4 small">
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span>1 Mentor 1 Peserta (Eksklusif)</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span><?= $totalPertemuan ?>x Pertemuan (<?= $durasiJam ?> jam/pertemuan)</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span><?= esc($materi) ?></span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span>Praktik 70% Materi 30%</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span>Free Modul Pembelajaran</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span>Free Toolkits</span>
                                </li>
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="fas fa-check-circle me-2 mt-1" style="color: #dc143c;"></i>
                                    <span>Jadwal Custom (Anda Tentukan)</span>
                                </li>
                            </ul>
                            <div class="text-center mb-3">
                                <small class="text-muted d-block mb-1">Biaya Pendaftaran</small>
                                <?php if ($hargaPrivate > 0): ?>
                                    <h3 class="fw-bold mb-0" style="color: #dc143c;">Rp<?= number_format($hargaPrivate, 0, ',', '.') ?></h3>
                                <?php else: ?>
                                    <h3 class="text-success fw-bold mb-0">Hubungi Admin</h3>
                                <?php endif; ?>
                            </div>
                            <a href="<?= base_url('auth_login/register_paket?id_paket=' . $idPaket . '&tipe=private') ?>"
                                class="btn w-100 py-2 fw-bold" style="background: linear-gradient(135deg, #dc143c, #ff0000); color: white; border: none;">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section: Materi & Syarat -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-lg rounded-4 p-4">
                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-book-open me-2"></i>Materi Yang Dipelajari</h5>
                    <p class="text-muted"><?= !empty($materi) ? nl2br(esc($materi)) : '-' ?></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-lg rounded-4 p-4">
                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-clipboard-list me-2"></i>Syarat Pendaftaran</h5>
                    <p class="text-muted"><?= !empty($syarat) ? nl2br(esc($syarat)) : '-' ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Kurikulum -->
<section class="py-5">
    <div class="container">
        <h2 class="h4 fw-bold mb-3 pb-2 border-bottom">Topik yang akan dibahas</h2>
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <span class="text-secondary"><strong><?= count($kurikulum) ?></strong> sections • <strong><?= array_sum(array_map(fn($section) => count($section['materi']), $kurikulum)) ?></strong> lectures</span>
            <button class="btn btn-sm btn-outline-primary" id="toggleAllBtn" onclick="toggleAllAccordion()">
                <i class="fas fa-chevron-down me-1"></i>Expand All
            </button>
        </div>
        <div class="accordion" id="courseAccordion">
            <?php foreach ($kurikulum as $index => $section): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#section<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">
                            <i class="fas fa-folder me-2"></i>
                            <div class="flex-grow-1">
                                <div><?= esc($section['judul']) ?></div>
                                <small class="text-muted"><?= count($section['materi']) ?> materi</small>
                            </div>
                        </button>
                    </h2>
                    <div id="section<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#courseAccordion">
                        <div class="accordion-body p-0">
                            <?php foreach ($section['materi'] as $materiIndex => $m): ?>
                                <div class="d-flex align-items-center justify-content-between p-3 border-bottom hover-bg-light cursor-pointer">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-2 p-2 me-3 <?= $m['tipe_materi'] === 'quiz' ? 'bg-warning bg-opacity-10 text-warning' : ($m['tipe_materi'] === 'zoom' ? 'bg-info bg-opacity-10 text-info' : 'bg-success bg-opacity-10 text-success') ?>">
                                            <i class="fas fa-<?= $m['tipe_materi'] === 'quiz' ? 'question-circle' : ($m['tipe_materi'] === 'zoom' ? 'video' : 'file-alt') ?>"></i>
                                        </div>
                                        <span class="fw-semibold"><?= esc($m['judul_materi']) ?></span>
                                        <?php if ($m['is_preview']): ?>
                                            <span class="badge bg-success ms-2" style="font-size: 0.65rem;">Preview</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted me-3"><?= esc($m['deskripsi_materi']) ?></small>
                                        <i class="fas fa-lock text-muted"></i>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal Jadwal -->
<div class="modal fade" id="modalJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-alt me-2"></i>Jadwal Pelatihan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="schedule-list">
                    <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded">
                        <span><i class="far fa-clock me-2"></i>08.00 - 10.00 (WIB)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded">
                        <span><i class="far fa-clock me-2"></i>10.00 - 12.00 (WIB)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded">
                        <span><i class="far fa-clock me-2"></i>12.00 - 14.00 (WIB)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded">
                        <span><i class="far fa-clock me-2"></i>14.00 - 16.00 (WIB)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 p-2 bg-light rounded">
                        <span><i class="far fa-clock me-2"></i>16.00 - 18.00 (WIB)</span>
                    </div>
                    <div class="d-flex justify-content-between p-2 bg-light rounded">
                        <span><i class="far fa-clock me-2"></i>19.00 - 21.00 (WIB)</span>
                    </div>
                </div>
                <div class="alert alert-info mt-3 mb-0 small">
                    <i class="fas fa-info-circle me-1"></i>
                    Jadwal dapat disesuaikan dengan ketersediaan peserta dan instruktur.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAllAccordion() {
    const accordionItems = document.querySelectorAll('#courseAccordion .accordion-collapse');
    const accordionButtons = document.querySelectorAll('#courseAccordion .accordion-button');
    const toggleBtn = document.getElementById('toggleAllBtn');
    
    const allCollapsed = Array.from(accordionItems).every(item => !item.classList.contains('show'));
    
    accordionItems.forEach((item, index) => {
        if (allCollapsed) {
            item.classList.add('show');
            accordionButtons[index].classList.remove('collapsed');
            accordionButtons[index].setAttribute('aria-expanded', 'true');
        } else {
            item.classList.remove('show');
            accordionButtons[index].classList.add('collapsed');
            accordionButtons[index].setAttribute('aria-expanded', 'false');
        }
    });
    
    // Update button text
    if (allCollapsed) {
        toggleBtn.innerHTML = '<i class="fas fa-chevron-up me-1"></i>Collapse All';
    } else {
        toggleBtn.innerHTML = '<i class="fas fa-chevron-down me-1"></i>Expand All';
    }
}
</script>

<?= $this->endSection() ?>