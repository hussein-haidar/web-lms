<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <?= esc($title ?? 'Data Alumni') ?>
        <small><?= esc($title2 ?? '') ?></small>
    </h1>
</section>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-users"></i> Data Alumni</h3>
        </div>
        <div class="box-body">
            <?php if (!empty($alumni)): ?>
                <table class="table table-bordered">
                    <tr>
                        <th style="width:200px">Tahun Lulus</th>
                        <td><?= esc($alumni['tahun_lulus'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Status Kerja</th>
                        <td><?= esc($alumni['status_kerja'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Perusahaan</th>
                        <td><?= esc($alumni['perusahaan'] ?? '-') ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <div class="callout callout-info">
                    <p><i class="fa fa-info-circle"></i> Data alumni belum tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
