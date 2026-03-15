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

       <!-- Statistik Pengajar -->
     <div class="row">
         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-green">
                 <div class="inner">
                     <h3><?= $total_siswa ?></h3>
                     <p>Total Siswa</p>
                 </div>
                 <div class="icon"><i class="ion ion-person-stalker"></i></div>
                 <a href="<?= base_url('home_karyawan/siswa_pengajar') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-yellow">
                 <div class="inner">
                     <h3><?= $kursus_aktif ?></h3>
                     <p>Kursus Aktif</p>
                 </div>
                 <div class="icon"><i class="ion ion-university"></i></div>
                 <a href="<?= base_url('home_karyawan/kursus_pengajar') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-red">
                 <div class="inner">
                     <h3><?= $total_tugas ?></h3>
                     <p>Total Tugas</p>
                 </div>
                 <div class="icon"><i class="ion ion-clipboard"></i></div>
                 <a href="<?= base_url('home_karyawan/tugas') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-aqua">
                 <div class="inner">
                     <h3><?= $tugas_dinilai ?></h3>
                     <p>Tugas Dinilai</p>
                 </div>
                 <div class="icon"><i class="ion ion-checkmark-circled"></i></div>
                 <a href="<?= base_url('home_karyawan/v_kumpul_tugas') ?>" class="small-box-footer">
                     Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                 </a>
             </div>
         </div>
     </div>

     <!-- Additional Info -->
     <div class="row">
         <div class="col-md-6">
             <div class="box box-primary">
                 <div class="box-header">
                     <h3 class="box-title">Statistik Siswa</h3>
                 </div>
                 <div class="box-body">
                     <div class="progress-group">
                         <span class="progress-text">Siswa Aktif</span>
                         <span class="float-right"><b><?= $siswa_aktif ?></b> / <?= $total_siswa ?></span>
                         <div class="progress sm">
                             <div class="progress-bar progress-bar-green" style="width: <?= $total_siswa > 0 ? ($siswa_aktif / $total_siswa * 100) : 0 ?>%"></div>
                         </div>
                     </div>
                     <div class="progress-group">
                         <span class="progress-text">Kursus Aktif</span>
                         <span class="float-right"><b><?= $kursus_aktif ?></b> / <?= $total_kursus ?></span>
                         <div class="progress sm">
                             <div class="progress-bar progress-bar-yellow" style="width: <?= $total_kursus > 0 ? ($kursus_aktif / $total_kursus * 100) : 0 ?>%"></div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-md-6">
             <div class="box box-info">
                 <div class="box-header">
                     <h3 class="box-title">Aktivitas Terkini</h3>
                 </div>
                 <div class="box-body">
                     <ul class="products-list product-list-in-box">
                         <li class="item">
                             <div class="product-info">
                                 <a href="<?= base_url('home_karyawan/v_kumpul_tugas') ?>" class="product-title">Tugas Menunggu Penilaian</a>
                                 <span class="product-description">
                                     <span class="badge badge-warning"><?= $total_tugas - $tugas_dinilai ?></span> tugas
                                 </span>
                             </div>
                         </li>
                         <li class="item">
                             <div class="product-info">
                                 <a href="<?= base_url('home_karyawan/siswa_pengajar') ?>" class="product-title">Total Siswa</a>
                                 <span class="product-description">
                                     <span class="badge badge-primary"><?= $total_siswa ?></span> siswa
                                 </span>
                             </div>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </section>

 <?= $this->endSection() ?>