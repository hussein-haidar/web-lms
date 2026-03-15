<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title2 ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/bower_components/Ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/dist/css/skins/_all-skins.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('/icon/i.png') ?>">

    <!-- HTML5 Shim and Respond.js IE8 support -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php
        // Definisikan level di awal
        $level = session()->get('level');
        ?>

        <!-- ========== HEADER ========== -->
        <header class="main-header">
            <a href="#" class="logo">
                <span class="logo-mini"><b>INA</b></span>
                <span class="logo-lg"><b>LPK</b>INASABA</span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- Notifications - HANYA UNTUK STAF ADMIN -->
                        <?php if ($level == 'staf_admin'): ?>
                            <?php
                            $jumlahBayar = 0;
                            $daftarNotifikasi = [];

                            // Ambil SEMUA pembayaran pending untuk staf admin
                            $pembayaranModel = new \App\Models\M_pembayaran();
                            $daftarNotifikasi = $pembayaranModel->get_notifikasi_pembayaran(null); // null = semua pending
                            $jumlahBayar = count($daftarNotifikasi);
                            ?>
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning" id="notification-badge"><?= $jumlahBayar ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Anda memiliki <span id="notification-count"><?= $jumlahBayar ?></span> Notifikasi pembayaran</li>
                                    <li>
                                        <!-- inner menu -->
                                        <ul class="menu">
                                            <?php if (!empty($daftarNotifikasi)) : ?>
                                                <?php foreach ($daftarNotifikasi as $notif) : ?>
                                                    <li>
                                                        <a href="<?= base_url('home_karyawan/pembayaran') ?>">
                                                            <i class="fa fa-money text-yellow"></i>
                                                            <?= esc($notif['nama_lengkap']) ?> - Kode: <?= esc($notif['kode_transaksi']) ?>
                                                            <br>Rp <?= number_format($notif['jumlah_bayar'], 0, ',', '.') ?>
                                                            <br><small class="text-muted">(<?= date('d/m/Y H:i', strtotime($notif['tanggal_transaksi'])) ?>)</small>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <li><a href="#"><i class="fa fa-info-circle text-muted"></i> Tidak ada notifikasi pembayaran</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="<?= base_url('home_karyawan/pembayaran') ?>">Lihat semua</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <!-- ========== MENU USER ========== -->
                        <?php
                        // SUPERADMIN MENU
                        if ($level == 'superadmin'): ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('fotoprofil/' . session()->get('foto_profil')) ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= session()->get('nama_lengkap') ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?= base_url('fotoprofil/' . session()->get('foto_profil')) ?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?= session()->get('nama_lengkap') ?>
                                            <small>
                                                Level: <?= ucfirst(session()->get('level')) ?><br>
                                                Last Login: <?= session()->get('last_login') ?>
                                            </small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= base_url('home_superadmin/profil') ?>" class="btn btn-default btn-flat">
                                                <i class="fa fa-fw fa-user"></i>&nbsp;Profil
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <form id="logout-form" action="<?= base_url('auth_login/logout_superadmin') ?>" method="POST" style="display: inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-default btn-flat" id="logout-btn">
                                                    <i class="fa fa-fw fa-key"></i>&nbsp;Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        <?php elseif ($level == 'siswa'): ?>
                            <!-- SISWA MENU -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('fotosiswa/' . session()->get('foto_profil')) ?>"
                                        class="user-image" alt="User Image"
                                        onerror="this.src='<?= base_url('fotosiswa/default.png') ?>'">
                                    <span class="hidden-xs"><?= session()->get('nama_lengkap') ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?= base_url('fotosiswa/' . session()->get('foto_profil')) ?>"
                                            class="img-circle" alt="User Image"
                                            onerror="this.src='<?= base_url('fotosiswa/default.png') ?>'">
                                        <p>
                                            <?= session()->get('nama_lengkap') ?>
                                            <small>
                                                Level: <?= ucfirst(session()->get('level')) ?><br>
                                                Last Login: <?= session()->get('last_login') ?>
                                            </small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= base_url('home_siswa/profil') ?>" class="btn btn-default btn-flat">
                                                <i class="fa fa-fw fa-user"></i>&nbsp;Profil
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <form id="logout-form" action="<?= base_url('auth_login/logout_siswa') ?>" method="POST" style="display: inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-default btn-flat" id="logout-btn">
                                                    <i class="fa fa-fw fa-key"></i>&nbsp;Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        <?php else: ?>

                            <!-- MENU UMUM: karyawan, staf_admin, pengajar, teknisi -->
                            <?php
                            $nama_level = match ($level) {
                                'staf_admin' => 'Staf Admin',
                                'pengajar' => 'Pengajar',
                                'teknisi' => 'Teknisi',
                                'karyawan' => 'Karyawan',
                                default => 'User'
                            };
                            ?>

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('fotoprofil/' . session()->get('foto_profil', 'default.png')) ?>"
                                        class="user-image" alt="User Image"
                                        onerror="this.src='<?= base_url('fotoprofil/default.png') ?>'">
                                    <span class="hidden-xs"><?= esc(session()->get('nama_lengkap')) ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?= base_url('fotoprofil/' . session()->get('foto_profil', 'default.png')) ?>"
                                            class="img-circle" alt="User Image"
                                            onerror="this.src='<?= base_url('fotoprofil/default.png') ?>'">
                                        <p>
                                            <?= esc(session()->get('nama_lengkap')) ?>
                                            <small>
                                                Level: <?= esc($nama_level) ?>
                                                <?php if (session()->get('last_login')): ?>
                                                    <br>Last Login: <?= date('d/m/Y H:i', strtotime(session()->get('last_login'))) ?>
                                                <?php endif; ?>
                                            </small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= base_url('home_karyawan/profil') ?>" class="btn btn-default btn-flat">
                                                <i class="fa fa-fw fa-user"></i>&nbsp;Profil
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <form id="logout-form" action="<?= base_url('auth_login/logout') ?>" method="POST" style="display: inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-default btn-flat" id="logout-btn">
                                                    <i class="fa fa-fw fa-sign-out"></i>&nbsp;Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <!-- ========== END MENU USER ========== -->

                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- ========== MODAL LOGOUT ========== -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-aqua-active">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="logoutModalLabel">
                            <i class="fa fa-sign-out"></i> Konfirmasi Logout
                        </h4>
                    </div>
                    <div class="modal-body text-center">
                        <div class="pad">
                            <i class="fa fa-5x fa-exclamation-triangle text-yellow"></i>
                            <h4 class="margin-top">Yakin ingin keluar?</h4>
                            <p class="text-muted"><strong><?= session()->get('nama_lengkap') ?></strong></p>
                            <p class="text-sm text-muted">Pastikan semua pekerjaan telah disimpan sebelum logout.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Batal
                        </button>
                        <form id="logout-form-modal" method="POST" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger btn-flat">
                                <i class="fa fa-sign-out"></i> Logout
                            </button>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== SIDEBAR ========== -->
        <aside class="main-sidebar">
            <section class="sidebar">
                <!-- User Panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?php if ($level == 'siswa'): ?>
                            <img src="<?= base_url('fotosiswa/' . session()->get('foto_profil')) ?>" class="img-circle" alt="User Image" onerror="this.src='<?= base_url('fotosiswa/default.png') ?>'">
                        <?php else: ?>
                            <img src="<?= base_url('fotoprofil/' . session()->get('foto_profil')) ?>" class="img-circle" alt="User Image" onerror="this.src='<?= base_url('fotoprofil/default.png') ?>'">
                        <?php endif; ?>
                    </div>
                    <div class="pull-left info">
                        <p><?= session()->get('nama_lengkap') ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- ✅ PERBAIKAN: Definisikan $current_page DI SINI sebelum digunakan -->
                <?php
                // Ambil URI string saat ini (contoh: 'home_karyawan/kursus')
                $current_page = uri_string();
                ?>

                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>

                    <?php if ($level == 'superadmin'): ?>
                        <!-- SUPERADMIN MENU -->
                        <li class="<?= in_array($current_page, ['home_superadmin/index', 'home_superadmin']) ? 'active' : '' ?>">
                            <a href="<?= base_url('home_superadmin/index') ?>" class="preserve-filter">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="header">SETTING NAVIGATION</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Setting Web</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_superadmin/web') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/web') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Setting Web
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/slider') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/slider') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Slider Promo
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/slider_web') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/slider_web') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Slider Web
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/backup_db') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/backup_db') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Backup DB
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/postingan_admin') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/postingan_admin') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Manajemen Postingan
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">DATA LAYANAN</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>DATA LAYANAN</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_superadmin/bank') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/bank') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Data Bank
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/uji_kompetensi') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/uji_kompetensi') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Uji Kompetensi
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">DATA PARTNERSHIP</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>DATA PARTNERSHIP</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_superadmin/lulusan') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/lulusan') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Data Lulusan
                                    </a>
                                </li>
                                                               <li class="<?= ($current_page == 'home_superadmin/mitra_kerja') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/mitra_kerja') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Mitra Kerja
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">MASTER DATA NAVIGATION</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>DATA MASTER</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_superadmin/program') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/program') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Program
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/kursus') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/kursus') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Kursus
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_superadmin/paket_kursus') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/paket_kursus') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Paket Kursus
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">DATA SDM</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>DATA KARYAWAN</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_superadmin/karyawan') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/karyawan') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Karyawan
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php elseif ($level == 'staf_admin'): ?>
                        <!-- STAF ADMIN MENU -->
                        <li class="<?= ($current_page == 'home_staf') ? 'active' : '' ?>">
                            <a href="<?= base_url('home_staf') ?>" class="preserve-filter">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="header">MASTER DATA</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>DATA KURSUS</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_karyawan/pendaftaran') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/pendaftaran') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Pendaftaran
                                    </a>
                                <li class="<?= ($current_page == 'home_karyawan/siswa_admin') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/siswa_admin') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Siswa Kursus
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">KEUANGAN</li>
                        <li class="<?= ($current_page == 'home_karyawan/pembayaran') ? 'active' : '' ?>">
                            <a href="<?= base_url('home_karyawan/pembayaran') ?>" class="preserve-filter">
                                <i class="fa fa-money"></i> <span>Verifikasi Pembayaran</span>
                            </a>
                        </li>

                    <?php elseif ($level == 'pengajar'): ?>
                        <!-- PENGAJAR MENU -->
                        <li class="<?= ($current_page == 'home_pengajar') ? 'active' : '' ?>">
                            <a href="<?= base_url('home_pengajar') ?>" class="preserve-filter">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="header">MASTER DATA</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>DATA KURSUS</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_karyawan/kursus_pengajar') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/kursus_pengajar') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Kursus
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_karyawan/siswa_pengajar') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/siswa_pengajar') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Siswa Kursus
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">QUIZ</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>QUIZ</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_karyawan/quiz_management') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/quiz_management') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Manajemen Quiz
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="header">TUGAS & NILAI</li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>TUGAS</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_karyawan/tugas') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/tugas') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Daftar Tugas
                                    </a>
                                </li>
                                <li class="<?= ($current_page == 'home_karyawan/v_kumpul_tugas') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_karyawan/v_kumpul_tugas') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Nilai Tugas
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Tambahan Menu Pembayaran & Sertifikat untuk Pengajar -->
                        <li class="header">SERTIFIKAT</li>
                        <li class="<?= ($current_page == 'sertifikat/admin_index') ? 'active' : '' ?>">
                            <a href="<?= base_url('sertifikat/admin_index') ?>" class="preserve-filter">
                                <i class="fa fa-certificate"></i> <span>Generate Sertifikat</span>
                            </a>
                        </li>

                    <?php elseif ($level == 'teknisi'): ?>
                        <!-- TEKNISI MENU -->
                        <li class="<?= ($current_page == 'home_teknisi') ? 'active' : '' ?>">
                            <a href="<?= base_url('home_teknisi') ?>" class="preserve-filter">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>MASTER DATA</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?= ($current_page == 'home_superadmin/inventory') ? 'active' : '' ?>">
                                    <a href="<?= base_url('home_superadmin/inventory') ?>" class="preserve-filter">
                                        <i class="fa fa-circle-o"></i> Inventory
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php endif; ?>
                </ul>
            </section>
        </aside>

        <!-- ========== CONTENT WRAPPER ========== -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <h1><?= $title ?? 'Dashboard' ?></h1>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="#"><?= $title2 ?? 'Home' ?></a></li>
                    <li class="active"><?= $title ?? 'Dashboard' ?></li>
                </ol>
            </section>

            <!-- Main Content -->
            <?= $this->renderSection('content') ?>
        </div>

        <!-- ========== FOOTER ========== -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date("Y") ?> <a href="#">HSK</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
            <div class="tab-content">
                <div class="tab-pane" id="control-sidebar-home-tab"></div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- ========================================== -->
    <!-- 1. LIBRARY UTAMA (URUTAN WAJIB) -->
    <!-- ========================================== -->

    <!-- jQuery (HANYA 1x - Pilih CDN ATAU Local, jangan keduanya) -->
    <!-- Opsi A: CDN (Uncomment jika pakai internet) -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Opsi B: Local (Direkomendasikan untuk AdminLTE) -->
    <script src="<?= base_url('template/bower_components/jquery/dist/jquery.min.js') ?>"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url('template/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

    <!-- DataTables (Local File - Pastikan file ada di folder) -->
    <script src="<?= base_url('template/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>

    <!-- Plugin AdminLTE lainnya -->
    <script src="<?= base_url('template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
    <script src="<?= base_url('template/bower_components/fastclick/lib/fastclick.js') ?>"></script>
    <script src="<?= base_url('template/dist/js/adminlte.min.js') ?>"></script>
    <script src="<?= base_url('template/dist/js/demo.js') ?>"></script>

    <!-- ========================================== -->
    <!-- 2. INISIALISASI GLOBAL (Sidebar, dll) -->
    <!-- ========================================== -->

    <script>
        $(document).ready(function() {
            $('.sidebar-menu').tree();
        });
    </script>

    <!-- Script alert auto hide -->
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>


    <!-- ✅ JAVASCRIPT: Preserve Filter Params (Tanpa Delay) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil params filter dari URL saat ini
            const currentParams = new URLSearchParams(window.location.search);

            // Jika ada params, attach ke semua link dengan class 'preserve-filter'
            if (currentParams.toString()) {
                document.querySelectorAll('a.preserve-filter').forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Jangan interfere dengan link yang sudah ada params atau external
                        if (this.href.includes('?') || this.hostname !== window.location.hostname) {
                            return;
                        }

                        // Clone params agar tidak modifikasi original
                        const newParams = new URLSearchParams(currentParams);

                        // Update href dengan params
                        const url = new URL(this.href);
                        newParams.forEach((value, key) => {
                            url.searchParams.set(key, value);
                        });
                        this.href = url.toString();
                    });
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                "stateSave": true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "pageLength": 10,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });

            // Optional: Tombol edit arahkan langsung ke halaman edit
            $('#example1 tbody').on('click', '.btn-edit', function() {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                window.location.href = "<?= base_url('') ?>" + id;
            });
        });
    </script>

    <!-- Script preview gambar (dengan null check) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function previewImage(inputId, imgId) {
                const input = document.getElementById(inputId);
                const img = document.getElementById(imgId);
                if (!input || !img) return; // Exit if elements not found

                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
            previewImage('gambar_input', 'gambar_preview');
        });
    </script>

    <!-- Script toggle password -->
    <script>
        function myFunction() {
            var x = document.getElementById("ShowPass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

    <!-- ✅ REAL-TIME NOTIFIKASI PEMBAYARAN -->
    <script>
        // Real-time notification update untuk admin
        let notificationCount = <?= $jumlahBayar ?? 0 ?>;
        let lastNotificationCheck = Date.now();
        let notificationInterval;

        function updateNotificationCount() {
            fetch('<?= base_url('home_karyawan/check_notification_count') ?>', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.count !== notificationCount) {
                        const oldCount = notificationCount;
                        notificationCount = data.count;

                        // Update badge number
                        const badge = document.querySelector('.label.label-warning');
                        if (badge) {
                            badge.textContent = notificationCount;

                            // Animasi jika ada notifikasi baru
                            if (data.count > oldCount) {
                                badge.classList.add('animated', 'bounceIn');
                                setTimeout(() => {
                                    badge.classList.remove('animated', 'bounceIn');
                                }, 1000);

                                // Tampilkan toast untuk pembayaran baru
                                showNotificationToast(`${data.new_payments} pembayaran baru!`, 'info');
                            }
                        }

                        // Update header text
                        const headerText = document.querySelector('.dropdown-menu .header');
                        if (headerText) {
                            headerText.textContent = `Anda memiliki ${notificationCount} Notifikasi pembayaran`;
                        }
                    }
                    
                    // Tampilkan alert untuk pembayaran yang dikonfirmasi
                    if (data.confirmed_payments > 0) {
                        showNotificationToast(`${data.confirmed_payments} pembayaran telah dikonfirmasi!`, 'success');
                    }
                    
                    // Tampilkan alert untuk pembayaran yang ditolak
                    if (data.rejected_payments > 0) {
                        showNotificationToast(`${data.rejected_payments} pembayaran ditolak!`, 'warning');
                    }
                })
                .catch(error => {
                    console.log('Error checking notifications:', error);
                });
        }

        function showNotificationToast(message, type = 'info') {
            // Buat toast container jika belum ada
            let toastContainer = document.getElementById('notification-toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'notification-toast-container';
                toastContainer.style.cssText = `
                    position: fixed;
                    top: 70px;
                    right: 20px;
                    z-index: 9999;
                `;
                document.body.appendChild(toastContainer);
            }

            // Tentukan warna berdasarkan tipe
            let bgColor, icon;
            switch(type) {
                case 'success':
                    bgColor = '#5cb85c';
                    icon = 'fa-check-circle';
                    break;
                case 'warning':
                    bgColor = '#f0ad4e';
                    icon = 'fa-exclamation-triangle';
                    break;
                case 'info':
                default:
                    bgColor = '#3c8dbc';
                    icon = 'fa-bell';
                    break;
            }

            // Buat toast element
            const toast = document.createElement('div');
            toast.className = 'alert alert-success alert-dismissible';
            toast.style.cssText = `
                background: ${bgColor};
                color: white;
                border: none;
                padding: 12px 20px;
                margin-bottom: 10px;
                border-radius: 6px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                min-width: 300px;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
            `;
            toast.innerHTML = `
                <div style="display: flex; align-items: center;">
                    <i class="fa ${icon}" style="margin-right: 10px;"></i>
                    ${message}
                </div>
                <button type="button" class="close" style="margin-left: 10px;" onclick="this.parentElement.remove()">×</button>
            `;

            toastContainer.appendChild(toast);

            // Animasi muncul
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(0)';
            }, 100);

            // Auto remove setelah 5 detik
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 5000);
        }

        // Start auto-check hanya untuk staf_admin
        <?php if ($level == 'staf_admin'): ?>

            function startNotificationCheck() {
                // Check setiap 20 detik untuk notifikasi
                notificationInterval = setInterval(updateNotificationCount, 20000);

                // Juga check setiap 1 menit
                setInterval(() => {
                    if (Date.now() - lastNotificationCheck > 60000) {
                        updateNotificationCount();
                        lastNotificationCheck = Date.now();
                    }
                }, 60000);
            }

            // Mulai setelah halaman loaded
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(startNotificationCheck, 2000); // Delay 2 detik
            });

            // Stop ketika user meninggalkan halaman
            window.addEventListener('beforeunload', function() {
                if (notificationInterval) {
                    clearInterval(notificationInterval);
                }
            });
        <?php endif; ?>
    </script>

    <!-- Script Modal Logout -->
    <script>
        $(document).ready(function() {
            // Sinkronisasi notifikasi badge dan count
            function syncNotificationDisplay() {
                var badge = document.getElementById('notification-badge');
                var count = document.getElementById('notification-count');
                
                if (badge && count) {
                    // Pastikan badge dan count menampilkan nilai yang sama
                    var currentCount = parseInt(badge.textContent) || 0;
                    badge.textContent = currentCount;
                    count.textContent = currentCount;
                    
                    // Hide/show badge based on count
                    if (currentCount > 0) {
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            }
            
            // Jalankan sinkronisasi saat halaman loaded
            syncNotificationDisplay();
            
            // Jalankan lagi setelah 500ms untuk memastikan data terload
            setTimeout(syncNotificationDisplay, 500);
            
            var level = '<?= session()->get('level') ?>';
            var logoutUrl = '';
            switch (level) {
                case 'superadmin':
                    logoutUrl = '<?= base_url('auth_login/logout_superadmin') ?>';
                    break;
                case 'staf_admin':
                case 'pengajar':
                case 'teknisi':
                    logoutUrl = '<?= base_url('auth_login/logout_karyawan') ?>';
                    break;
                case 'siswa':
                    logoutUrl = '<?= base_url('auth_login/logout_siswa') ?>';
                    break;
                default:
                    logoutUrl = '<?= base_url('auth_login/logout') ?>';
            }
            $('#logout-form-modal').attr('action', logoutUrl);
            $('#logout-btn').on('click', function(e) {
                e.preventDefault();
                $('#logoutModal').modal('show');
            });
        });
    </script>

    <!-- ========================================== -->
    <!-- 3. SECTION KHUSUS VIEW (PENTING!) -->
    <!-- ========================================== -->

</body>

</html>