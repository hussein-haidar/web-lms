<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-edit"></i> <?= $title2 ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_superadmin/bank') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
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

            <form action="<?= base_url('home_superadmin/update_bank/' . $bank['id_bank']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank" 
                                   value="<?= old('nama_bank', $bank['nama_bank']) ?>" required>
                            <?php if (isset($validation) && $validation->hasError('nama_bank')) : ?>
                                <span class="text-danger"><?= $validation->getError('nama_bank') ?></span>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_rek">No Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="no_rek" name="no_rek" 
                                   value="<?= old('no_rek', $bank['no_rek']) ?>" required>
                            <?php if (isset($validation) && $validation->hasError('no_rek')) : ?>
                                <span class="text-danger"><?= $validation->getError('no_rek') ?></span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="a_n">Atas Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="a_n" name="a_n" 
                                   value="<?= old('a_n', $bank['a_n']) ?>" required>
                            <?php if (isset($validation) && $validation->hasError('a_n')) : ?>
                                <span class="text-danger"><?= $validation->getError('a_n') ?></span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>
                    <a href="<?= base_url('home_superadmin/bank') ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
