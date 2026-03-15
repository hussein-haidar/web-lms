<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box">
            <div class="box-header with-border">
                <i class="fa fa-trash"></i> Data <?= $title2 ?>
                <div class="box-tools pull-right">
                    <a href="<?= base_url('home_superadmin/bank') ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Data Bank
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
                            <th width="200px">Aksi</th>
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
                                    <a href="<?= base_url('home_superadmin/restore_bank/' . $b['id_bank']) ?>" onclick="return confirm('Apakah Anda yakin ingin memulihkan data ini?')" class="btn btn-success btn-xs">
                                        <i class="fa fa-undo"></i> Pulihkan
                                    </a>
                                    <a href="<?= base_url('home_superadmin/force_delete_bank/' . $b['id_bank']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen? Tindakan ini tidak dapat dibatalkan!')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Hapus Permanen
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                
                <?php if (empty($bank)) : ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Tidak ada data bank yang dihapus.
                    </div>
                <?php endif ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- /.content -->

<?= $this->endSection() ?>
