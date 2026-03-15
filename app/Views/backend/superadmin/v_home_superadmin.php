<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <!-- Alert sukses -->
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <!-- Alert warning -->
    <?php if (session()->getFlashdata('message') && !session()->getFlashdata('pesan')): ?>
        <div class="alert alert-warning"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <!-- Statistik Dashboard -->
    <div class="row">
        <!-- Total Siswa -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= number_format($total_siswa, 0, ',', '.') ?></h3>
                    <p>Total Siswa</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
            </div>
        </div>

        <!-- Total Pengajar -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= number_format($total_pengajar, 0, ',', '.') ?></h3>
                    <p>Total Pengajar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-graduation-cap"></i>
                </div>
            </div>
        </div>

        <!-- Total Staf Admin -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= number_format($total_staf_admin, 0, ',', '.') ?></h3>
                    <p>Total Staf Admin</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
            </div>
        </div>

        <!-- Total Kursus -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= number_format($total_kursus, 0, ',', '.') ?></h3>
                    <p>Total Kursus</p>
                </div>
                <div class="icon">
                    <i class="ion ion-book"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Row Kedua -->
    <div class="row" style="margin-top: 20px;">
        <!-- Total Pembayaran -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3><?= number_format($total_pembayaran, 0, ',', '.') ?></h3>
                    <p>Total Pembayaran</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
            </div>
        </div>

        <!-- Pembayaran Pending -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3><?= number_format($pembayaran_pending, 0, ',', '.') ?></h3>
                    <p>Menunggu Konfirmasi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clock"></i>
                </div>
            </div>
        </div>

        <!-- Pembayaran Success -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?= number_format($pembayaran_success, 0, ',', '.') ?></h3>
                    <p>Pembayaran Sukses</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark-circled"></i>
                </div>
            </div>
        </div>

        <!-- Persentase Pembayaran -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-navy">
                <div class="inner">
                    <h3><?= $persentase_pembayaran ?>%</h3>
                    <p>Tingkat Konfirmasi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Bulan Ini -->
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Statistik <?= $bulan_ini ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-user-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pendaftaran Baru</span>
                                    <span class="info-box-number"><?= number_format($pendaftaran_bulan_ini, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pembayaran Bulan Ini</span>
                                    <span class="info-box-number"><?= number_format($pembayaran_bulan_ini, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Karyawan -->
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Statistik Karyawan</h3>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        <li class="item">
                            <div class="product-info">
                                <a href="<?= base_url('home_karyawan') ?>" class="product-title">Total Karyawan</a>
                                <span class="product-description">
                                    <span class="badge badge-primary"><?= $total_karyawan ?></span> karyawan
                                </span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-info">
                                <a href="<?= base_url('home_karyawan') ?>" class="product-title">Pengajar</a>
                                <span class="product-description">
                                    <span class="badge badge-success"><?= $total_pengajar ?></span> pengajar
                                </span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-info">
                                <a href="<?= base_url('home_karyawan') ?>" class="product-title">Teknisi</a>
                                <span class="product-description">
                                    <span class="badge badge-warning"><?= $total_teknisi ?></span> teknisi
                                </span>
                            </div>
                        </li>
                        <li class="item">
                            <div class="product-info">
                                <a href="<?= base_url('home_karyawan/pembayaran') ?>" class="product-title">Pembayaran Pending</a>
                                <span class="product-description">
                                    <span class="badge badge-danger"><?= $pembayaran_pending ?></span> menunggu konfirmasi
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Aksi Cepat</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?= base_url('home_karyawan/pembayaran') ?>" class="btn btn-primary btn-block">
                                <i class="fa fa-money"></i> Verifikasi Pembayaran
                                <?php if ($pembayaran_pending > 0): ?>
                                    <span class="badge badge-warning"><?= $pembayaran_pending ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="<?= base_url('home_karyawan/siswa_admin') ?>" class="btn btn-info btn-block">
                                <i class="fa fa-users"></i> Kelola Siswa
                            </a>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-sm-6">
                            <a href="<?= base_url('home_karyawan/kursus_pengajar') ?>" class="btn btn-warning btn-block">
                                <i class="fa fa-graduation-cap"></i> Kelola Kursus
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="<?= base_url('home_karyawan') ?>" class="btn btn-success btn-block">
                                <i class="fa fa-user-plus"></i> Kelola Karyawan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>