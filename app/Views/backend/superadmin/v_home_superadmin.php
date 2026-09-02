<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('message') && !session()->getFlashdata('pesan')): ?>
        <div class="alert alert-warning"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <!-- Statistik Dashboard -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= number_format($total_siswa, 0, ',', '.') ?></h3>
                    <p>Total Siswa</p>
                </div>
                <div class="icon"><i class="ion ion-person"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= number_format($total_pengajar, 0, ',', '.') ?></h3>
                    <p>Total Pengajar</p>
                </div>
                <div class="icon"><i class="ion ion-graduation-cap"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= number_format($total_staf_admin, 0, ',', '.') ?></h3>
                    <p>Total Staf Admin</p>
                </div>
                <div class="icon"><i class="ion ion-person-stalker"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= number_format($total_kursus, 0, ',', '.') ?></h3>
                    <p>Total Kursus</p>
                </div>
                <div class="icon"><i class="ion ion-book"></i></div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= number_format($total_pendaftaran ?? 0, 0, ',', '.') ?></h3>
                    <p>Total Pendaftaran</p>
                </div>
                <div class="icon"><i class="ion ion-compose"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="icon"><i class="ion ion-cash"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= number_format($total_sertifikat ?? 0, 0, ',', '.') ?></h3>
                    <p>Sertifikat Diterbitkan</p>
                </div>
                <div class="icon"><i class="ion ion-ribbon-a"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= number_format($pending_pembayaran ?? 0, 0, ',', '.') ?></h3>
                    <p>Pembayaran Pending</p>
                </div>
                <div class="icon"><i class="ion ion-clock"></i></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart"></i> Pendaftaran 6 Bulan Terakhir</h3>
                </div>
                <div class="box-body">
                    <canvas id="chartPendaftaran" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i> Status Pembayaran</h3>
                </div>
                <div class="box-body">
                    <canvas id="chartPembayaran" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-line-chart"></i> Pendapatan Bulanan</h3>
                </div>
                <div class="box-body">
                    <canvas id="chartPendapatan" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i> Kursus Populer</h3>
                </div>
                <div class="box-body">
                    <canvas id="chartKursus" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i> Pendaftaran Terbaru</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="list-group">
                        <?php if (!empty($recent_pendaftaran)): ?>
                            <?php foreach ($recent_pendaftaran as $rp): ?>
                                <li class="list-group-item">
                                    <strong><?= esc($rp['nama_lengkap'] ?? '') ?></strong>
                                    mendaftar <strong><?= esc($rp['nama_kursus'] ?? '') ?></strong>
                                    <span class="pull-right text-muted"><small><?= date('d/m', strtotime($rp['created_at'] ?? $rp['tanggal_daftar'] ?? '')) ?></small></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">Belum ada pendaftaran terbaru</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-money"></i> Pembayaran Pending</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="list-group">
                        <?php if (!empty($recent_pembayaran)): ?>
                            <?php foreach ($recent_pembayaran as $rbyr): ?>
                                <li class="list-group-item">
                                    <strong><?= esc($rbyr['nama_lengkap'] ?? '') ?></strong>
                                    - Rp <?= number_format($rbyr['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
                                    <span class="label label-warning pull-right"><?= esc($rbyr['status'] ?? 'pending') ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">Tidak ada pembayaran pending</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
$(document).ready(function() {
    // Pendaftaran Chart
    var ctxPendaf = document.getElementById('chartPendaftaran').getContext('2d');
    new Chart(ctxPendaf, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_pendaftaran_labels ?? ['Jan','Feb','Mar','Apr','Mei','Jun']) ?>,
            datasets: [{
                label: 'Pendaftaran',
                data: <?= json_encode($chart_pendaftaran_data ?? [0,0,0,0,0,0]) ?>,
                backgroundColor: 'rgba(60,141,188,0.8)',
                borderColor: '#3c8dbc',
                borderWidth: 1
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // Pembayaran Status Chart
    var ctxBayar = document.getElementById('chartPembayaran').getContext('2d');
    new Chart(ctxBayar, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Pending', 'Ditolak', 'Gagal'],
            datasets: [{
                data: <?= json_encode($chart_pembayaran_data ?? [0,0,0,0]) ?>,
                backgroundColor: ['#00a65a', '#f39c12', '#dd4b39', '#605ca8']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Pendapatan Chart
    var ctxPendap = document.getElementById('chartPendapatan').getContext('2d');
    new Chart(ctxPendap, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_pendapatan_labels ?? ['Jan','Feb','Mar','Apr','Mei','Jun']) ?>,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: <?= json_encode($chart_pendapatan_data ?? [0,0,0,0,0,0]) ?>,
                fill: true,
                backgroundColor: 'rgba(0,166,90,0.2)',
                borderColor: '#00a65a',
                tension: 0.3
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });

    // Kursus Populer Chart
    var ctxKursus = document.getElementById('chartKursus').getContext('2d');
    new Chart(ctxKursus, {
        type: 'pie',
        data: {
            labels: <?= json_encode($chart_kursus_labels ?? ['Kursus 1','Kursus 2']) ?>,
            datasets: [{
                data: <?= json_encode($chart_kursus_data ?? [0,0]) ?>,
                backgroundColor: ['#3c8dbc','#00a65a','#f39c12','#dd4b39','#605ca8','#00c0ef']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>

<?= $this->endSection() ?>