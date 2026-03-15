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

     <!-- Statistik -->
     <div class="row">
         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-green">
                 <div class="inner">
                     <h3>46</h3>
                     <p>Data Peserta Seminar</p>
                 </div>
                 <div class="icon"><i class="ion ion-stats-bars"></i></div>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-yellow">
                 <div class="inner">
                     <h3>90</h3>
                     <p>Data Jadwal Semnas</p>
                 </div>
                 <div class="icon"><i class="ion ion-person-add"></i></div>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-red">
                 <div class="inner">
                     <h3>90</h3>
                     <p>Data Kegiatan Semnas</p>
                 </div>
                 <div class="icon"><i class="ion ion-stats-bars"></i></div>
             </div>
         </div>

         <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-aqua">
                 <div class="inner">
                     <h3>90</h3>
                     <p>Data User Sistem</p>
                 </div>
                 <div class="icon"><i class="ion ion-stats-bars"></i></div>
             </div>
         </div>
     </div>
 </section>

 <?= $this->endSection() ?>