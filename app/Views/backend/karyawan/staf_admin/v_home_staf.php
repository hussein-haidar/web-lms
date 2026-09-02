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

     <!-- Statistik Staf Admin -->
     <div class="row">
         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-green">
                 <div class="inner">
                     <h3><?= $total_siswa ?></h3>
                     <p>Total Siswa</p>
                 </div>
                 <div class="icon"><i class="ion ion-person-stalker"></i></div>
                 <a href="<?= base_url('home_karyawan/siswa_admin') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3><?= $pendaftaran_aktif ?></h3>
                    <p>Pendaftaran Aktif</p>
                </div>
                <div class="icon"><i class="ion ion-checkmark-circled"></i></div>
                <a href="<?= base_url('home_karyawan/pendaftaran') ?>" class="small-box-footer">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3><?= $pembayaran_success ?></h3>
                    <p>Pembayaran Selesai</p>
                </div>
                <div class="icon"><i class="ion ion-cash"></i></div>
                <a href="<?= base_url('home_karyawan/pembayaran') ?>" class="small-box-footer">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-aqua">
                 <div class="inner">
                     <h3><?= $pembayaran_pending ?></h3>
                     <p>Pembayaran Pending</p>
                 </div>
                 <div class="icon"><i class="ion ion-clock"></i></div>
                 <a href="<?= base_url('home_karyawan/pembayaran') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>
     </div>

     <!-- Quick Actions -->
     <div class="row">
         <div class="col-md-12">
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
                 </div>
             </div>
         </div>
     </div>

     <!-- Konten Informatif -->
     <div class="row">
         <div class="col-md-12">
             <div class="box box-primary">
                 <div class="box-header">
                     <h3 class="box-title">Informasi Penting</h3>
                 </div>
                 <div class="box-body">
                     <!-- Baris 1: 2 kolom -->
                     <div class="row">
                         <div class="col-md-6">
                             <div class="info-box">
                                 <span class="info-box-icon bg-info"><i class="fa fa-calendar"></i></span>
                                 <div class="info-box-content">
                                     <span class="info-box-text">Pendaftaran Hari Ini</span>
                                     <span class="info-box-number"><?= $total_pendaftaran ?></span>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="info-box">
                                 <span class="info-box-icon bg-success"><i class="fa fa-user-plus"></i></span>
                                 <div class="info-box-content">
                                     <span class="info-box-text">Siswa Baru</span>
                                     <span class="info-box-number"><?= $pendaftaran_pending ?></span>
                                 </div>
                             </div>
                         </div>
                     </div>
                     
                     <!-- Baris 2: 2 kolom -->
                     <div class="row">
                         <div class="col-md-6">
                             <div class="info-box">
                                 <span class="info-box-icon bg-warning"><i class="fa fa-money"></i></span>
                                 <div class="info-box-content">
                                     <span class="info-box-text">Pendapatan Hari Ini</span>
                                     <span class="info-box-number">Rp <?= number_format($pembayaran_success * 500000, 0, ',', '.') ?></span>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="info-box">
                                 <span class="info-box-icon bg-danger"><i class="fa fa-clock-o"></i></span>
                                 <div class="info-box-content">
                                     <span class="info-box-text">Butuh Verifikasi</span>
                                     <span class="info-box-number"><?= $pembayaran_pending ?></span>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>

 <?= $this->endSection() ?>