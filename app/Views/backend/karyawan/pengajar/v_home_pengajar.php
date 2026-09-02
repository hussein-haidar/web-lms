<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('message') && !session()->getFlashdata('pesan')): ?>
        <div class="alert alert-warning"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <!-- Stats Cards -->
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
                    <h3><?= $tugas_pending ?></h3>
                    <p>Tugas Perlu Dinilai</p>
                </div>
                <div class="icon"><i class="ion ion-clipboard"></i></div>
                <a href="<?= base_url('home_karyawan/v_kumpul_tugas') ?>" class="small-box-footer">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $total_quiz ?></h3>
                    <p>Total Quiz</p>
                </div>
                <div class="icon"><i class="ion ion-help-circled"></i></div>
                <a href="<?= base_url('home_karyawan/quiz_management') ?>" class="small-box-footer">
                    Selengkapnya <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Rata-rata Nilai Quiz per Materi</h3>
                </div>
                <div class="box-body">
                    <canvas id="gradeChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i> Statistik Kelulusan</h3>
                </div>
                <div class="box-body">
                    <canvas id="performanceChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress & Activity Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Statistik Siswa & Kursus</h3>
                </div>
                <div class="box-body">
                    <div class="progress-group">
                        <span class="progress-text">Siswa Aktif</span>
                        <span class="float-right"><b><?= $siswa_aktif ?></b> / <?= $total_siswa ?></span>
                        <div class="progress sm">
                            <div class="progress-bar progress-bar-green" style="width: <?= $total_siswa > 0 ? round($siswa_aktif / $total_siswa * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Kursus Aktif</span>
                        <span class="float-right"><b><?= $kursus_aktif ?></b> / <?= $total_kursus ?></span>
                        <div class="progress sm">
                            <div class="progress-bar progress-bar-yellow" style="width: <?= $total_kursus > 0 ? round($kursus_aktif / $total_kursus * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Tugas Dinilai</span>
                        <span class="float-right"><b><?= $tugas_dinilai ?></b> / <?= $total_tugas ?></span>
                        <div class="progress sm">
                            <div class="progress-bar progress-bar-aqua" style="width: <?= $total_tugas > 0 ? round($tugas_dinilai / $total_tugas * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="progress-group">
                        <span class="progress-text">Quiz Dikerjakan</span>
                        <span class="float-right"><b><?= $quiz_taken ?></b></span>
                        <div class="progress sm">
                            <div class="progress-bar progress-bar-red" style="width: <?= min(100, $quiz_taken * 10) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Pengumpulan Tugas Terbaru (Belum Dinilai)</h3>
                </div>
                <div class="box-body">
                    <?php if (!empty($recent_submissions)): ?>
                        <ul class="product-list product-list-in-box">
                            <?php foreach ($recent_submissions as $sub): ?>
                                <li class="item">
                                    <div class="product-info">
                                        <a href="<?= base_url('home_karyawan/v_kumpul_tugas') ?>" class="product-title">
                                            <?= esc($sub['nama_siswa']) ?>
                                        </a>
                                        <span class="product-description">
                                            <?= esc($sub['judul_tugas'] ?? '-') ?>
                                            <span class="label label-warning pull-right">Menunggu</span>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center text-muted py-3">
                            <i class="fa fa-check-circle fa-2x"></i>
                            <p>Semua tugas sudah dinilai!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Grade Chart
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    const gradeData = <?= json_encode($avg_grades) ?>;
    new Chart(gradeCtx, {
        type: 'bar',
        data: {
            labels: gradeData.map(d => d.nama.length > 15 ? d.nama.substring(0, 15) + '...' : d.nama),
            datasets: [{
                label: 'Rata-rata Nilai (%)',
                data: gradeData.map(d => Math.round(d.avg_nilai * 10) / 10),
                backgroundColor: gradeData.map(d => d.avg_nilai >= 70 ? '#28a745' : '#dc3545'),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, max: 100 } },
            plugins: { legend: { display: false } }
        }
    });

    // Performance Pie Chart
    const perfCtx = document.getElementById('performanceChart').getContext('2d');
    const perfData = <?= json_encode($performance) ?>;
    new Chart(perfCtx, {
        type: 'doughnut',
        data: {
            labels: ['Lulus', 'Tidak Lulus'],
            datasets: [{
                data: [perfData.lulus, perfData.tidak_lulus],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>

<?= $this->endSection() ?>
