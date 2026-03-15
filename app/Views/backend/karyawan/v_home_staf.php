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
             <div class="small-box bg-yellow">
                 <div class="inner">
                     <h3><?= $total_karyawan ?></h3>
                     <p>Total Karyawan</p>
                 </div>
                 <div class="icon"><i class="ion ion-person-add"></i></div>
                 <a href="<?= base_url('home_karyawan') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-red">
                 <div class="inner">
                     <h3><?= $total_kursus ?></h3>
                     <p>Total Kursus</p>
                 </div>
                 <div class="icon"><i class="ion ion-university"></i></div>
                 <a href="<?= base_url('home_karyawan/kursus_pengajar') ?>" class="small-box-footer">
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

     <!-- Additional Statistics -->
     <div class="row">
         <div class="col-md-6">
             <div class="box box-primary">
                 <div class="box-header">
                     <h3 class="box-title">Statistik Pendaftaran</h3>
                 </div>
                 <div class="box-body">
                     <div class="progress-group">
                         <span class="progress-text">Pendaftaran Aktif</span>
                         <span class="float-right"><b><?= $pendaftaran_aktif ?></b> / <?= $total_pendaftaran ?></span>
                         <div class="progress sm">
                             <div class="progress-bar progress-bar-green" style="width: <?= $total_pendaftaran > 0 ? ($pendaftaran_aktif / $total_pendaftaran * 100) : 0 ?>%"></div>
                         </div>
                     </div>
                     <div class="progress-group">
                         <span class="progress-text">Menunggu Verifikasi</span>
                         <span class="float-right"><b><?= $pendaftaran_pending ?></b> / <?= $total_pendaftaran ?></span>
                         <div class="progress sm">
                             <div class="progress-bar progress-bar-yellow" style="width: <?= $total_pendaftaran > 0 ? ($pendaftaran_pending / $total_pendaftaran * 100) : 0 ?>%"></div>
                         </div>
                     </div>
                     <div class="progress-group">
                         <span class="progress-text">Pembayaran Berhasil</span>
                         <span class="float-right"><b><?= $pembayaran_success ?></b> / <?= $total_pendaftaran ?></span>
                         <div class="progress sm">
                             <div class="progress-bar progress-bar-blue" style="width: <?= $total_pendaftaran > 0 ? ($pembayaran_success / $total_pendaftaran * 100) : 0 ?>%"></div>
                         </div>
                     </div>
                 </div>
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
 </section>

 <?= $this->endSection() ?>