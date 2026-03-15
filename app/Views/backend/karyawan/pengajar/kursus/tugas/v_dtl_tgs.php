 <?= $this->extend('backend/template_user/main') ?>
 <?= $this->section('content') ?>

 <!-- Content Header -->
 <section class="content-header">
     <h1><?= $title ?? 'Dashboard Siswa' ?></h1>
     <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> <?= $title2 ?? 'Home' ?></a></li>
         <li class="active"><?= $title ?? 'Dashboard' ?></li>
     </ol>
 </section>

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

     </div>
 </section>

 <?= $this->endSection() ?>