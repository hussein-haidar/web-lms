<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<style>
    .info-item {
        padding: 10px;
        margin-bottom: 10px;
        border-left: 3px solid #3c8dbc;
        background-color: #f9f9f9;
        border-radius: 3px;
    }
</style>

<!-- Main content -->
<section class="content">

    <!-- Header Section -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-eye"></i> Detail Kursus</h3>
                    <div class="box-tools pull-right">
                        <a href="<?= base_url('home_karyawan/v_kursus') ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <?php if (!empty($kursus)): ?>
                        <!-- Course Header -->
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-md-4">
                                <?php if (!empty($kursus['gambar_detail_a'])): ?>
                                    <img src="<?= base_url('kursus/materi/' . $kursus['gambar_detail_a']) ?>"
                                        class="img-responsive"
                                        style="width: 100%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);"
                                        alt="<?= esc($kursus['nama_kursus']) ?>">
                                <?php else: ?>
                                    <div style="width: 100%; height: 250px; background: #f5f5f5; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                                        <i class="fa fa-image fa-4x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h2 style="color: #333; margin-top: 0;"><?= esc($kursus['nama_kursus']) ?></h2>
                                <p class="text-muted"><i class="fa fa-folder"></i> <?= esc($kursus['nama_program'] ?? 'Umum') ?></p>

                                <div class="row" style="margin: 20px 0;">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <strong><i class="fa fa-user text-blue"></i> Pengajar:</strong><br>
                                            <span class="text-blue"><?= esc($kursus['nama_pengajar'] ?? '-') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <strong><i class="fa fa-calendar text-green"></i> Dibuat:</strong><br>
                                            <?= esc(date('d M Y', strtotime($kursus['tanggal_dibuat'] ?? ''))) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin: 20px 0;">
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <strong><i class="fa fa-circle text-<?= ($kursus['status'] == 'aktif') ? 'success' : 'danger' ?>"></i> Status:</strong><br>
                                            <span class="label label-<?= ($kursus['status'] == 'aktif') ? 'success' : 'danger' ?>">
                                                <?= ucfirst($kursus['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <strong><i class="fa fa-tag text-purple"></i> Kelas:</strong><br>
                                            <span class="text-muted"><?= esc($kursus['nama_program'] ?? 'Kelas Online') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-item">
                                            <strong><i class="fa fa-clock-o text-orange"></i> Durasi:</strong><br>
                                            <?php
                                            $totalPertemuan = $kursus['total_pertemuan'] ?? 0;
                                            $durasiPerPertemuan = $kursus['durasi_per_pertemuan_jam'] ?? 0;
                                            if ($totalPertemuan && $durasiPerPertemuan) {
                                                echo esc($totalPertemuan . ' Pertemuan × ' . $durasiPerPertemuan . ' Jam');
                                            } elseif ($totalPertemuan) {
                                                echo esc($totalPertemuan . ' Pertemuan');
                                            } elseif ($durasiPerPertemuan) {
                                                echo esc($durasiPerPertemuan . ' Jam per pertemuan');
                                            } else {
                                                echo 'Tidak ada data durasi';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($kursus['deskripsi'])): ?>
                                    <div style="margin-top: 20px;">
                                        <strong><i class="fa fa-info-circle"></i> Deskripsi:</strong><br>
                                        <p><?= esc(is_array($kursus['deskripsi'] ?? '') ? implode('', $kursus['deskripsi']) : ($kursus['deskripsi'] ?? '')) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Course Modules -->
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if (!empty($moduls)): ?>
                                    <div class="panel-group" id="accordion">
                                        <?php foreach ($moduls as $index => $modul): ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $index ?>">
                                                            <i class="fa fa-book"></i> <?= esc(is_array($modul['nama_modul']) ? implode('', $modul['nama_modul']) : $modul['nama_modul']) ?>
                                                            <span class="pull-right badge badge-primary"><?= is_array($modul['jumlah_materi']) ? 0 : $modul['jumlah_materi'] ?> Materi</span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse<?= $index ?>" class="panel-collapse collapse <?= ($index == 0) ? 'in' : '' ?>">
                                                    <div class="panel-body">
                                                        <?php if (!empty($modul['deskripsi'])): ?>
                                                            <p class="text-muted"><?= esc(is_array($modul['deskripsi']) ? implode('', $modul['deskripsi']) : $modul['deskripsi']) ?></p>
                                                        <?php else: ?>
                                                                                                                   <?php endif; ?>

                                                        <?php if (!empty($modul['materis'])): ?>
                                                            <div class="list-group">
                                                                <?php foreach ($modul['materis'] as $materi): ?>
                                                                    <div class="list-group-item">
                                                                        <div class="row">
                                                                            <div class="col-xs-1 text-center">
                                                                                <?php
                                                                                $icon = 'fa-file';
                                                                                $tipeMateri = is_array($materi['tipe_materi'] ?? '') ? implode('', $materi['tipe_materi'] ?? '') : ($materi['tipe_materi'] ?? '');
                                                                                if ($tipeMateri === 'youtube') $icon = 'fa-youtube-play';
                                                                                elseif ($tipeMateri === 'zoom') $icon = 'fa-video-camera';
                                                                                elseif ($tipeMateri === 'text') $icon = 'fa-file-text-o';
                                                                                elseif ($tipeMateri === 'quiz') $icon = 'fa-question-circle';
                                                                                ?>
                                                                                <i class="fa <?= $icon ?>"></i>
                                                                            </div>
                                                                            <div class="col-xs-8">
                                                                                <strong><?= esc(is_array($materi['judul_materi']) ? implode('', $materi['judul_materi']) : $materi['judul_materi']) ?></strong><br>
                                                                                <small class="text-muted">
                                                                                    <?= !empty($materi['deskripsi_materi']) ? esc(is_array($materi['deskripsi_materi']) ? implode('', $materi['deskripsi_materi']) : $materi['deskripsi_materi']) : 'Tidak ada deskripsi' ?>
                                                                                </small>
                                                                            </div>
                                                                            <div class="col-xs-3 text-right">
                                                                                <?php
                                                                                $tipeMateri = is_array($materi['tipe_materi'] ?? '') ? implode('', $materi['tipe_materi'] ?? '') : ($materi['tipe_materi'] ?? '');
                                                                                $kontenTeks = is_array($materi['konten_text'] ?? '') ? implode('', $materi['konten_text'] ?? '') : ($materi['konten_text'] ?? '');

                                                                                if ($tipeMateri === 'zoom' && !empty($kontenTeks)): ?>
                                                                                    <a href="<?= esc($kontenTeks) ?>"
                                                                                        target="_blank"
                                                                                        class="btn btn-xs btn-info">
                                                                                        <i class="fa fa-video-camera"></i> Join
                                                                                    </a>
                                                                                <?php elseif ($tipeMateri === 'text'): ?>
                                                                                    <button class="btn btn-xs btn-success"
                                                                                        data-id-modul="<?= esc($modul['id_modul']) ?>"
                                                                                        data-id-materi="<?= esc($materi['id_materi']) ?>"
                                                                                        data-konten="<?= esc(htmlspecialchars($kontenTeks, ENT_QUOTES, 'UTF-8')) ?>"
                                                                                        onclick="showTextContent(this)">
                                                                                        <i class="fa fa-eye"></i> Lihat
                                                                                    </button>
                                                                                <?php elseif ($tipeMateri === 'quiz'): ?>
                                                                                    <button class="btn btn-xs btn-warning"
                                                                                        onclick="startQuiz('<?= esc($materi['id_materi']) ?>')">
                                                                                        <i class="fa fa-question-circle"></i> Quiz
                                                                                    </button>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <p class="text-muted">Belum ada materi untuk modul ini.</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i> Belum ada modul untuk kursus ini.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> Kursus tidak ditemukan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function showTextContent(button) {
        console.log('showTextContent called');

        // Get data from button attributes
        const idModul = button.getAttribute('data-id-modul');
        const idMateri = button.getAttribute('data-id-materi');
        let kontenTeks = button.getAttribute('data-konten');

        console.log('ID Modul:', idModul);
        console.log('ID Materi:', idMateri);
        console.log('Konten Teks (raw):', kontenTeks);

        // Decode HTML entities
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = kontenTeks;
        kontenTeks = tempDiv.textContent || tempDiv.innerText || 'Tidak ada konten tersedia';

        console.log('Konten Teks (decoded):', kontenTeks);

        // Create modal to show text content
        const modalHtml = `
        <div class="modal fade" id="textModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-green" style="color: white;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                        <h4 class="modal-title">
                            <i class="fa fa-file-text"></i> Konten Materi
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="well" style="max-height: 400px; overflow-y: auto; white-space: pre-wrap;">
                            ${kontenTeks}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    `;

        console.log('Modal HTML created');

        // Remove existing modal if any
        const existingModal = document.getElementById('textModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body and show it
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        console.log('Modal added to DOM');

        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.error('jQuery not loaded');
            alert('Error: jQuery tidak tersedia');
            return;
        }

        // Try to show modal
        try {
            $('#textModal').modal('show');
            console.log('Modal show() called');
        } catch (error) {
            console.error('Error showing modal:', error);
            alert('Error menampilkan modal: ' + error.message);
        }
    }

    function startQuiz(idMateri) {
        console.log('startQuiz called with ID:', idMateri);
        // Redirect to quiz page or show quiz modal
        window.location.href = `${base_url}home_karyawan/quiz/${idMateri}`;
    }
</script>

<?= $this->endSection() ?>