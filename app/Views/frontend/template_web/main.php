<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembaga Kursus InaSaba - Program Profesi 1 Tahun</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Format ICO (paling kompatibel) -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('/icon/i.png') ?>">

    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= base_url('/manifest.json') ?>">
    <meta name="theme-color" content="#007bff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="LPK LMS">
    <link rel="apple-touch-icon" href="<?= base_url('/assets/img/icon-192.png') ?>">

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top"
        style="background: linear-gradient(to right, #0056b3, #00b4d8); box-shadow: 0 4px 15px rgba(0, 86, 179, 0.15); padding: 10px 0;">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand d-flex align-items-center text-white" href="<?= base_url('home_website/index') ?>">
                <i class="fas fa-graduation-cap me-2 fs-3"></i>
                <span class="fw-bold fs-4">InaSaba</span>
            </a>

            <!-- Tombol Mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <!-- MENU 1: PROGRAM -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="font-size: 1.05rem;">Program</a>
                        <div class="dropdown-menu p-0 border-0 shadow-lg" style="min-width: 900px; border-radius: 15px; margin-top: 10px;">
                            <div class="container p-4">
                                <div class="row">
                                    <div class="col-md-4 border-end">
                                        <div class="d-flex align-items-center mb-3 text-primary">
                                            <i class="fas fa-briefcase fa-2x me-3"></i>
                                            <h6 class="fw-bold mb-0">Program Profesi 1 Tahun</h6>
                                        </div>
                                        <!-- Program A: Sekretaris & Admin -->
                                        <a href="<?= base_url('detail_program/a') ?>"
                                            class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                            style="transition: 0.2s; border: 1px solid transparent;"
                                            onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                            <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-folder-open"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Sekretaris & Admin</h6>
                                                <small class="text-muted">Administrasi Perkantoran</small>
                                            </div>
                                        </a>

                                        <!-- Program B: Desain Grafis -->
                                        <a href="<?= base_url('detail_program/b') ?>"
                                            class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                            style="transition: 0.2s; border: 1px solid transparent;"
                                            onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-palette"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Desain Grafis</h6>
                                                <small class="text-muted">CorelDraw, Photoshop, Illustrator</small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 border-end">
                                        <div class="d-flex align-items-center mb-3 text-warning">
                                            <i class="fas fa-graduation-cap fa-2x me-3"></i>
                                            <h6 class="fw-bold mb-0">Program CFK</h6>
                                        </div>
                                        <a href="<?= base_url('home_website/program_cfk') ?>" class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                            style="transition: 0.2s; border: 1px solid transparent;"
                                            onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                            <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-child"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Computer For Kid's</h6>
                                                <small class="text-muted">Komputer untuk anak-anak</small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-3 text-primary">
                                            <i class="fas fa-clock fa-2x me-3"></i>
                                            <h6 class="fw-bold mb-0">Program Singkat</h6>
                                        </div>
                                        <a href="<?= base_url('home_website/kls_offline') ?>" class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                            style="transition: 0.2s; border: 1px solid transparent;"
                                            onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                            <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-video"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Program Singkat</h6>
                                                <small class="text-muted">Kursus kurang dari 1 tahun</small>
                                            </div>
                                        </a>

                                        <!-- Uji Kompetensi -->
                                        <a href="<?= base_url('home_website/uji_kompetensi') ?>" class="d-flex align-items-center p-3 rounded text-decoration-none text-dark"
                                            style="transition: 0.2s; border: 1px solid transparent;"
                                            onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                            onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                            <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">Uji Kompetensi</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- MENU 2: KELAS (DINAMIS - Tanpa Keterangan Pertemuan) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="font-size: 1.05rem;">
                            Kelas
                            <?php
                            $newThreshold = '-7 days';
                            $db = \Config\Database::connect();
                            $hasNewPaket = $db->table('paket_kursus pk')
                                ->join('kursus k', 'k.id_kursus = pk.id_kursus', 'left')
                                ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
                                ->whereIn('pr.nama_program', ['Kelas Online', 'Kelas Offline'])
                                ->where('k.status', 'aktif')
                                ->where('pk.deleted_at', null)
                                ->where('pk.created_at >=', date('Y-m-d H:i:s', strtotime($newThreshold)))
                                ->countAllResults() > 0;

                            if ($hasNewPaket):
                            ?>
                                <span class="badge bg-danger ms-1">New</span>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown-menu p-0 border-0 shadow-lg" style="min-width: 900px; border-radius: 15px; margin-top: 10px;">
                            <div class="container p-4">
                                <div class="row">

                                    <!-- KOLOM OFFLINE -->
                                    <div class="col-md-6 border-end">
                                        <h6 class="fw-bold text-primary mb-3">
                                            <i class="fas fa-building me-2"></i>Kelas Offline
                                        </h6>
                                        <div class="d-grid gap-2">
                                            <?php
                                            $offlineList = $db->table('paket_kursus pk')
                                                ->select('pk.id_paket, pk.nama_paket, k.id_kursus, k.nama_kursus, k.slug, k.deskripsi_singkat, pk.created_at')
                                                ->join('kursus k', 'k.id_kursus = pk.id_kursus', 'left')
                                                ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
                                                ->where('pr.nama_program', 'Kelas Offline')
                                                ->where('k.status', 'aktif')
                                                ->where('pk.deleted_at', null)
                                                ->orderBy('pk.created_at', 'DESC')
                                                ->limit(8)
                                                ->get()
                                                ->getResultArray();

                                            if (!empty($offlineList)):
                                                foreach ($offlineList as $p):
                                                    // Hapus " - X Pertemuan" dari nama
                                                    $namaPaket = $p['nama_paket'] ?? $p['nama_kursus'] ?? '';
                                                    $namaPaket = preg_replace('/\s*-\s*\d+\s*Pertemuan/i', '', $namaPaket);
                                                    $namaPaket = trim($namaPaket);

                                                    $searchText = strtolower($namaPaket . ' ' . ($p['slug'] ?? ''));
                                                    $icon = 'fa-building';
                                                    $bgClass = 'bg-primary';
                                                    $textClass = 'text-primary';
                                            ?>
                                                    <a href="<?= base_url('home_website/detail_offline/' . ($p['id_paket'] ?? '')) ?>"
                                                        class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                                        style="transition: 0.2s; border: 1px solid transparent;"
                                                        onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                                        onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                                        <div class="<?= $bgClass ?> bg-opacity-10 <?= $textClass ?> rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                            <i class="fas <?= $icon ?>"></i>
                                                        </div>
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <h6 class="fw-bold mb-0"><?= esc($namaPaket) ?></h6>
                                                                <?php if (!empty($p['created_at']) && strtotime($p['created_at']) >= strtotime($newThreshold)): ?>
                                                                    <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">New</span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <small class="text-muted"><?= esc(substr($p['deskripsi_singkat'] ?? 'Materi kursus tatap muka', 0, 40)) ?>...</small>
                                                        </div>
                                                    </a>
                                                <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <span class="text-muted small">Belum ada kelas offline</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- KOLOM ONLINE -->
                                    <div class="col-md-6">
                                        <h6 class="fw-bold text-success mb-3">
                                            <i class="fas fa-laptop me-2"></i>Kelas Online
                                        </h6>

                                        <?php
                                        $onlineList = $db->table('paket_kursus pk')
                                            ->select('pk.id_paket, pk.nama_paket, k.id_kursus, k.nama_kursus, k.slug, k.deskripsi_singkat, pk.created_at')
                                            ->join('kursus k', 'k.id_kursus = pk.id_kursus', 'left')
                                            ->join('program_kursus pr', 'pr.id_program = k.id_program', 'left')
                                            ->where('pr.nama_program', 'Kelas Online')
                                            ->where('k.status', 'aktif')
                                            ->where('pk.deleted_at', null)
                                            ->orderBy('pk.created_at', 'DESC')
                                            ->limit(8)
                                            ->get()
                                            ->getResultArray();

                                        $iconMap = [
                                            'word' => ['icon' => 'fa-file-word', 'bg' => 'bg-primary', 'text' => 'text-primary'],
                                            'excel' => ['icon' => 'fa-file-excel', 'bg' => 'bg-success', 'text' => 'text-success'],
                                            'powerpoint' => ['icon' => 'fa-file-powerpoint', 'bg' => 'bg-danger', 'text' => 'text-danger'],
                                            'ppt' => ['icon' => 'fa-file-powerpoint', 'bg' => 'bg-danger', 'text' => 'text-danger'],
                                            'ai' => ['icon' => 'fa-robot', 'bg' => 'bg-warning', 'text' => 'text-warning'],
                                            'artificial' => ['icon' => 'fa-robot', 'bg' => 'bg-warning', 'text' => 'text-warning'],
                                            'photoshop' => ['icon' => 'fa-image', 'bg' => 'bg-info', 'text' => 'text-info'],
                                            'ps' => ['icon' => 'fa-image', 'bg' => 'bg-info', 'text' => 'text-info'],
                                            'corel' => ['icon' => 'fa-pen-nib', 'bg' => 'bg-warning', 'text' => 'text-warning'],
                                            'illustrator' => ['icon' => 'fa-pen-nib', 'bg' => 'bg-warning', 'text' => 'text-warning'],
                                            'web' => ['icon' => 'fa-globe', 'bg' => 'bg-info', 'text' => 'text-info'],
                                            'marketing' => ['icon' => 'fa-bullhorn', 'bg' => 'bg-success', 'text' => 'text-success'],
                                            'programming' => ['icon' => 'fa-code', 'bg' => 'bg-primary', 'text' => 'text-primary'],
                                            'autocad' => ['icon' => 'fa-drafting-compass', 'bg' => 'bg-info', 'text' => 'text-info'],
                                        ];

                                        if (!empty($onlineList)):
                                            foreach ($onlineList as $p):
                                                // Hapus " - X Pertemuan" dari nama
                                                $namaPaket = $p['nama_paket'] ?? $p['nama_kursus'] ?? '';
                                                $namaPaket = preg_replace('/\s*-\s*\d+\s*Pertemuan/i', '', $namaPaket);
                                                $namaPaket = trim($namaPaket);

                                                $searchText = strtolower($namaPaket . ' ' . ($p['slug'] ?? ''));
                                                $icon = 'fa-file-alt';
                                                $bgClass = 'bg-info';
                                                $textClass = 'text-info';

                                                foreach ($iconMap as $keyword => $config) {
                                                    if (strpos($searchText, $keyword) !== false) {
                                                        $icon = $config['icon'];
                                                        $bgClass = $config['bg'];
                                                        $textClass = $config['text'];
                                                        break;
                                                    }
                                                }
                                        ?>
                                                <a href="<?= base_url('home_website/detail_online/' . ($p['id_paket'] ?? '')) ?>"
                                                    class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                                    style="transition: 0.2s; border: 1px solid transparent;"
                                                    onmouseover="this.style.backgroundColor='#f0f8ff'; this.style.borderColor='#e0e0e0'"
                                                    onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='transparent'">
                                                    <div class="<?= $bgClass ?> bg-opacity-10 <?= $textClass ?> rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                        <i class="fas <?= $icon ?>"></i>
                                                    </div>
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <h6 class="fw-bold mb-0"><?= esc($namaPaket) ?></h6>
                                                            <?php if (!empty($p['created_at']) && strtotime($p['created_at']) >= strtotime($newThreshold)): ?>
                                                                <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">New</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <small class="text-muted"><?= esc(substr($p['deskripsi_singkat'] ?? 'Pelajari materi lengkap', 0, 40)) ?>...</small>
                                                    </div>
                                                </a>
                                            <?php
                                            endforeach;
                                        else:
                                            ?>
                                            <span class="text-muted small">Belum ada kelas online</span>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- MENU 3: PROFIL -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown" style="font-size: 1.05rem;">Profil</a>
                        <ul class="dropdown-menu border-0 shadow-lg p-3" style="min-width: 250px; border-radius: 12px;">
                            <li>
                                <a class="d-flex align-items-center p-3 mb-2 rounded text-decoration-none text-dark"
                                    href="<?= base_url('home_website/sejarah') ?>"
                                    style="transition: 0.2s;"
                                    onmouseover="this.style.backgroundColor='#f0f8ff'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Profil INASABA</h6>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="d-flex align-items-center p-3 rounded text-decoration-none text-dark"
                                    href="<?= base_url('alumni_show') ?>"
                                    style="transition: 0.2s;"
                                    onmouseover="this.style.backgroundColor='#f0f8ff'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <div class="bg-warning bg-opacity-10 text-warning rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Alumni</h6>
                                    </div>
                                </a>
                            </li>
                                                 <li>
                                <a class="d-flex align-items-center p-3 rounded text-decoration-none text-dark"
                                    href="<?= base_url('home_website/kontak_saran') ?>"
                                    style="transition: 0.2s;"
                                    onmouseover="this.style.backgroundColor='#f0f8ff'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0">Kontak Saran</h6>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    
                </ul>

                <!-- Search Bar -->
                <form class="d-flex mx-auto my-2 my-lg-0 w-100" style="max-width: 400px;" action="<?= base_url('home_website/pencarian') ?>" method="GET" role="search">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="Cari program kursus..." style="border-radius: 30px;" aria-label="Search" value="<?= isset($_GET['keyword']) ? esc($_GET['keyword']) : '' ?>">
                    <button class="btn btn-warning" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <!-- Tombol Daftar/Masuk -->
                <div class="d-flex ms-lg-auto my-2 my-lg-0">
                    <?php if (session()->get('id_siswa')): ?>
                        <div class="dropdown">
                            <button class="btn btn-warning dropdown-toggle fw-medium px-4" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> <?= esc(session()->get('nama_lengkap')) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="border-radius: 12px; min-width: 200px;">
                                <li>
                                    <a class="dropdown-item p-2 rounded" href="<?= base_url('home_siswa/index') ?>">
                                        <i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item p-2 rounded" href="<?= base_url('home_siswa/profil') ?>">
                                        <i class="fas fa-user me-2 text-info"></i> Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <!-- MENU KURSUS SAYA -->
                                <li>
                                    <a class="dropdown-item p-2 rounded" href="<?= base_url('home_siswa/kursus_saya') ?>">
                                        <i class="fas fa-book me-2 text-success"></i> Kursus Saya
                                    </a>
                                </li>
                                <!-- MENU KERANJANG -->
                                <li>
                                    <a class="dropdown-item p-2 rounded position-relative" href="<?= base_url('home_siswa/cart') ?>">
                                        <i class="fas fa-shopping-cart me-2 text-warning"></i> Keranjang
                                        <?php
                                        $id_siswa = session()->get('id_siswa');
                                        $cartCount = $db->table('keranjang')->where('id_siswa', $id_siswa)->countAllResults();
                                        if ($cartCount > 0):
                                        ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; margin-top: -8px; margin-left: -8px;">
                                                <?= $cartCount ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item p-2 rounded position-relative" href="<?= base_url('home_siswa/status_bayar') ?>">
                                        <i class="fas fa-clock me-2 text-warning"></i> Status Pembayaran
                                        <?php
                                        $id_siswa = session()->get('id_siswa');
                                        $cartCount = 0;
                                        if ($id_siswa) {
                                            $cartCount = $db->table('pendaftaran')
                                                ->join('pembayaran', 'pembayaran.kode_invoice = pendaftaran.kode_invoice', 'inner')
                                                ->where('pendaftaran.id_siswa', $id_siswa)
                                                ->whereIn('pembayaran.status_pembayaran', ['pending', 'failed'])
                                                ->countAllResults();
                                        }
                                        if ($cartCount > 0):
                                        ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; margin-top: -5px; margin-left: -5px; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; padding: 0.25rem 0.35rem;">
                                                <?= $cartCount ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item p-2 rounded" href="<?= base_url('home_siswa/riwayat_beli') ?>">
                                        <i class="fas fa-history me-2 text-secondary"></i> Riwayat Pembelian
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="<?= base_url('auth_login/logout_siswa') ?>" method="post" class="m-0">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="dropdown-item p-2 rounded text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('auth_login/login_siswa') ?>" class="btn btn-warning fw-medium px-4 text-decoration-none" type="button">Daftar/Masuk</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>

        <?php
        $request = service('request');
        $currentRoute = $request->getUri()->getPath();

        $shouldShow = \App\Helpers\RouteHelper::shouldShowSection($currentRoute);

        if ($shouldShow):
        ?>

            <div class="container my-4">
                <h2 class="text-center fw-bold mb-4 text-primary">Alur Pendaftaran Kursus di Insaba</h2>
                <div class="row g-4 align-items-center">
                    <div class="col-md-6">
                        <div class="text-center">
                            <img src="<?= base_url('/gambar_kursus/cs.png') ?>"
                                class="img-fluid rounded-3 shadow"
                                alt="Ilustrasi pendaftaran - Customer Service">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <img src="<?= base_url('/gambar_kursus/gd.png') ?>"
                                class="img-fluid rounded-3 shadow"
                                alt="Ilustrasi pendaftaran - Graphic Design">
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </main>

    <!-- Wave Divider -->
    <div class="position-relative" style="height: 80px; background: #0d6efd;">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: 0; width: 100%; height: 100%;">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#ffffff"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#ffffff"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#ffffff"></path>
        </svg>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <h3 class="text-white">InaSaba</h3>
                    <p class="text-white-50">Lembaga Kursus Komputer terkemuka dengan pengalaman 25 tahun dalam mendidik dan mengedukasi masyarakat.</p>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/" target="_blank" rel="noopener" class="text-white" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" class="text-white" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://twitter.com/" target="_blank" rel="noopener" class="text-white" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.youtube.com/" target="_blank" rel="noopener" class="text-white" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="tel:+62857967408" class="text-white" aria-label="Telepon / WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <h3 class="text-white">Kontak Kami</h3>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i> Jl. Teuku Umar No. 94, Pontianak
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-phone me-2"></i> +62 857-9674-08
                    </p>
                    <p class="text-white-50 mb-2">
                        <i class="fas fa-envelope me-2"></i> info@inasaba.com
                    </p>
                </div>
                <div class="col-md-3 mb-3">
                    <h3 class="text-white">Quick Links</h3>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><a href="<?= base_url('home_website/sejarah') ?>" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i> Tentang Kami</a></li>
                        <li class="mb-2"><a href="<?= base_url('home_website/kls_online') ?>" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i> Program Kursus</a></li>
                        <li class="mb-2"><a href="<?= base_url('home_website/galeri') ?>" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i> Galeri Kegiatan</a></li>
                        <li class="mb-2"><a href="<?= base_url('alumni_show') ?>" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i> Testimoni Alumni</a></li>
                        <li class="mb-2"><a href="<?= base_url('home_website/kontak') ?>" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i> Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center pt-3 border-top border-secondary">
                <p class="text-white-50 mb-0">&copy; <?= date("Y") ?> Lembaga Kursus InaSaba. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Counter Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.counter');
            
            // Only run counter animation if counter elements exist
            if (counters.length > 0) {
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const suffix = counter.getAttribute('data-suffix') || '';
                    const duration = 2000;
                    const step = Math.ceil(target / (duration / 16));
                    let current = 0;
                    const updateCount = () => {
                        current += step;
                        if (current >= target) {
                            counter.textContent = target.toLocaleString('id-ID') + suffix;
                        } else {
                            counter.textContent = current.toLocaleString('id-ID') + suffix;
                            requestAnimationFrame(updateCount);
                        }
                    };
                    const observer = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting) {
                            updateCount();
                            observer.unobserve(counter);
                        }
                    }, {
                        threshold: 0.5
                    });
                    observer.observe(counter);
                });
            }
        });
    </script>

    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?= base_url('/sw.js') ?>')
                    .then(reg => console.log('[PWA] SW registered:', reg.scope))
                    .catch(err => console.log('[PWA] SW registration failed:', err));
            });
        }
    </script>

</body>

</html>