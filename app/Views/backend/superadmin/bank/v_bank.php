<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box">
            <div class="box-header with-border">
                <i class="fa fa-university"></i> Data <?= $title2 ?>
                <div class="box-tools pull-right">
                    <a href="<?= base_url('home_superadmin/add_bank') ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Tambah Data
                    </a>
                    <a href="<?= base_url('home_superadmin/bank_deleted') ?>" class="btn btn-sm btn-secondary">
                        <i class="fa fa-trash"></i> Data Dihapus
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if (session()->getFlashdata('pesan')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i>
                        <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-ban"></i>
                        <?= session()->getFlashdata('errors') ?>
                    </div>
                <?php endif ?>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Nama Bank</th>
                            <th>No Rekening</th>
                            <th>Atas Nama</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($bank as $b) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $b['nama_bank'] ?></td>
                                <td><?= $b['no_rek'] ?></td>
                                <td><?= $b['a_n'] ?></td>
                                <td>
                                    <a href="<?= base_url('home_superadmin/edit_bank/' . $b['id_bank']) ?>" class="btn btn-warning btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('home_superadmin/deleted_bank/' . $b['id_bank']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>
