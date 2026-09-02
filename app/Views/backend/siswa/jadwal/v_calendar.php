<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i> Kalender Akademik</h3>
                    <div class="box-tools pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm" id="prevMonth">
                                <i class="fa fa-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" id="todayBtn">Hari Ini</button>
                            <button type="button" class="btn btn-default btn-sm" id="nextMonth">
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Legend -->
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i> Keterangan</h3>
                </div>
                <div class="box-body">
                    <ul class="list-unstyled" style="font-size:13px;">
                        <li style="margin-bottom:8px;">
                            <span style="display:inline-block;width:14px;height:14px;background:#3c8dbc;border-radius:3px;margin-right:6px;vertical-align:middle;"></span>
                            Kursus / Kelas
                        </li>
                        <li style="margin-bottom:8px;">
                            <span style="display:inline-block;width:14px;height:14px;background:#f39c12;border-radius:3px;margin-right:6px;vertical-align:middle;"></span>
                            Deadline Tugas
                        </li>
                        <li style="margin-bottom:8px;">
                            <span style="display:inline-block;width:14px;height:14px;background:#e74c3c;border-radius:3px;margin-right:6px;vertical-align:middle;"></span>
                            Ujian / Quiz
                        </li>
                        <li style="margin-bottom:8px;">
                            <span style="display:inline-block;width:14px;height:14px;background:#27ae60;border-radius:3px;margin-right:6px;vertical-align:middle;"></span>
                            Libur / Hari Besar
                        </li>
                        <li style="margin-bottom:8px;">
                            <span style="display:inline-block;width:14px;height:14px;background:#8e44ad;border-radius:3px;margin-right:6px;vertical-align:middle;"></span>
                            Event Lainnya
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-clock-o"></i> Jadwal Mendatang</h3>
                </div>
                <div class="box-body">
                    <?php if (empty($jadwal)): ?>
                        <p class="text-muted">Tidak ada jadwal aktif bulan ini.</p>
                    <?php else: ?>
                        <?php foreach (array_slice($jadwal, 0, 5) as $j): ?>
                            <div style="margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid #f4f4f4;">
                                <strong style="font-size:13px;">
                                    <span style="display:inline-block;width:10px;height:10px;background:<?= $j['warna'] ?? '#3c8dbc' ?>;border-radius:50%;margin-right:4px;"></span>
                                    <?= esc($j['judul']) ?>
                                </strong>
                                <br>
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> <?= date('d M Y', strtotime($j['tanggal_mulai'])) ?>
                                    <?= $j['tanggal_selesai'] && $j['tanggal_selesai'] != $j['tanggal_mulai'] ? ' - ' . date('d M Y', strtotime($j['tanggal_selesai'])) : '' ?>
                                </small>
                                <?php if (!empty($j['nama_kursus'])): ?>
                                    <br><small class="text-muted"><i class="fa fa-book"></i> <?= esc($j['nama_kursus']) ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FullCalendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css">
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: ''
        },
        height: 500,
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: '<?= base_url('api/siswa/jadwal/events') ?>',
                dataType: 'json',
                data: {
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                },
                success: function(response) {
                    callback(response);
                }
            });
        },
        eventClick: function(calEvent, jsEvent, view) {
            $.ajax({
                url: '<?= base_url('api/siswa/jadwal/detail/') ?>' + calEvent.id,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        var d = response.data;
                        var modal = '<div class="modal fade" id="jadwalModal" tabindex="-1" role="dialog">' +
                            '<div class="modal-dialog" role="document">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header" style="background:' + (d.warna || '#3c8dbc') + ';color:#fff;">' +
                            '<button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>' +
                            '<h4 class="modal-title">' + (d.judul || '') + '</h4></div>' +
                            '<div class="modal-body">' +
                            '<p><strong>Tipe:</strong> ' + (d.tipe || '-') + '</p>' +
                            '<p><strong>Tanggal:</strong> ' + (d.tanggal_mulai || '-') + (d.tanggal_selesai && d.tanggal_selesai !== d.tanggal_mulai ? ' - ' + d.tanggal_selesai : '') + '</p>' +
                            '<p><strong>Kursus:</strong> ' + (d.nama_kursus || '-') + '</p>' +
                            (d.deskripsi ? '<p><strong>Deskripsi:</strong> ' + d.deskripsi + '</p>' : '') +
                            '</div>' +
                            '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button></div>' +
                            '</div></div></div>';
                        $('body').append(modal);
                        $('#jadwalModal').modal('show');
                        $('#jadwalModal').on('hidden.bs.modal', function() { $(this).remove(); });
                    }
                }
            });
        },
        eventRender: function(event, element) {
            element.css('cursor', 'pointer');
        }
    });

    // Navigation buttons
    $('#prevMonth').click(function() { $('#calendar').fullCalendar('prev'); });
    $('#nextMonth').click(function() { $('#calendar').fullCalendar('next'); });
    $('#todayBtn').click(function() { $('#calendar').fullCalendar('today'); });
});
</script>

<?= $this->endSection() ?>
