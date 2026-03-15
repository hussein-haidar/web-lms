<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div style="padding: 1.5rem 1rem;">
    <div style="display: flex; flex-wrap: wrap; margin: 0 -0.75rem; max-width: 100%;">
        <!-- Course Info Card -->
        <div style="flex: 0 0 33.333333%; max-width: 33.333333%; padding: 0 0.75rem;">
            <!-- Course Card -->
            <div style="background: white; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 0.75rem; margin-bottom: 1.5rem;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; border-radius: 0.75rem 0.75rem 0 0;">
                    <h5 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                        <i class="fas fa-graduation-cap" style="margin-right: 0.5rem;"></i>
                        <?= esc($pendaftaran['nama_kursus'] ?? 'Unknown Course') ?>
                    </h5>
                </div>
                <div style="padding: 1rem;">
                    <!-- Course Image -->
                    <?php if (!empty($pendaftaran['gambar_detail_a'])): ?>
                        <img src="<?= base_url('kursus/materi/' . $pendaftaran['gambar_detail_a']) ?>"
                            style="width: 100%; border-radius: 0.75rem; margin-bottom: 1rem; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);"
                            alt="<?= $pendaftaran['nama_kursus'] ?>"
                            onerror="this.src='<?= base_url('kursus/materi/as.png') ?>'">
                    <?php else: ?>
                        <div style="text-align: center; padding: 1.5rem 0; margin-bottom: 1rem; background: #f8f9fa; border-radius: 0.75rem;">
                            <i class="fas fa-book-open" style="font-size: 4rem; color: #6c757d;"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Course Info -->
                    <div style="margin-bottom: 1rem;">
                        <span style="background: #17a2b8; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem; font-weight: 500;">
                            <i class="fas fa-tag" style="margin-right: 0.25rem;"></i>
                            <?= esc($pendaftaran['nama_program'] ?? '-') ?>
                        </span>
                    </div>

                    <!-- Payment Info -->
                    <div style="margin-bottom: 1.5rem;">
                        <h6 style="color: #6c757d; margin-bottom: 1rem; font-size: 1rem;">Informasi Pembayaran</h6>
                        <div style="border: none;">
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #dee2e6;">
                                <small style="color: #6c757d;">Invoice</small>
                                <strong><?= esc($pendaftaran['kode_invoice'] ?? '-') ?></strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #dee2e6;">
                                <small style="color: #6c757d;">Status</small>
                                <span style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">Lunas</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #dee2e6;">
                                <small style="color: #6c757d;">Jumlah Bayar</small>
                                <strong style="color: #28a745;">Rp <?= number_format(!empty($pendaftaran['pembayaran_jumlah_bayar']) ? $pendaftaran['pembayaran_jumlah_bayar'] : ($pendaftaran['jumlah_bayar'] ?? 0), 0, ',', '.') ?></strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #dee2e6;">
                                <small style="color: #6c757d;">Metode</small>
                                <span><?= !empty($pendaftaran['metode_pembayaran']) ? ucfirst(str_replace('_', ' ', $pendaftaran['metode_pembayaran'])) : '-' ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0;">
                                <small style="color: #6c757d;">Tanggal Konfirmasi</small>
                                <span><?= !empty($pendaftaran['pembayaran_tanggal_konfirmasi']) ? date('d/m/Y', strtotime($pendaftaran['pembayaran_tanggal_konfirmasi'])) : (!empty($pendaftaran['tanggal_konfirmasi']) ? date('d/m/Y', strtotime($pendaftaran['tanggal_konfirmasi'])) : '-') ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress -->
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <h6 style="margin: 0; font-size: 1rem;">Progress Pembelajaran</h6>
                            <span style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;"><?= $progress_stats['progress_percentage'] ?>%</span>
                        </div>
                        <div style="height: 8px; background: #e9ecef; border-radius: 4px; overflow: hidden;">
                            <div style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); height: 100%; width: <?= $progress_stats['progress_percentage'] ?>%; transition: width 0.3s ease;"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: grid; gap: 0.5rem;">
                        <a href="<?= base_url('home_siswa/belajar/' . $pendaftaran['id_pendaftaran']) ?>"
                            style="background: #28a745; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 0.5rem; font-size: 1.125rem; font-weight: 500; text-align: center; display: block;">
                            <i class="fas fa-play-circle" style="margin-right: 0.5rem;"></i> MULAI BELAJAR
                        </a>
                        <a href="<?= base_url('home_siswa/index') ?>" style="background: transparent; color: #6c757d; padding: 0.75rem 1.5rem; text-decoration: none; border: 1px solid #6c757d; border-radius: 0.5rem; font-weight: 500; text-align: center; display: block;">
                            <i class="fas fa-home" style="margin-right: 0.5rem;"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div style="background: white; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 0.75rem; margin-bottom: 1.5rem;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; border-radius: 0.75rem 0.75rem 0 0;">
                    <h6 style="margin: 0; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-chart-bar" style="margin-right: 0.5rem;"></i>
                        Statistik Pembelajaran
                    </h6>
                </div>
                <div style="padding: 1rem;">
                    <div style="display: flex; text-align: center;">
                        <div style="flex: 0 0 33.333333%; max-width: 33.333333%;">
                            <div style="padding: 1rem 0; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                <div style="color: <?= $progress_stats['completed_materials'] == $progress_stats['total_materials'] && $progress_stats['total_materials'] > 0 ? '#28a745' : '#6c757d' ?>; margin-bottom: 0.25rem;">
                                    <i class="fas <?= $progress_stats['completed_materials'] == $progress_stats['total_materials'] && $progress_stats['total_materials'] > 0 ? 'fa-check-circle' : 'fa-play-circle' ?>" style="font-size: 2rem;"></i>
                                </div>
                                <h4 style="margin: 0; font-size: 1.5rem; font-weight: 600;">
                                    <?= $progress_stats['completed_materials'] ?>/<?= $progress_stats['total_materials'] ?>
                                </h4>
                                <div>
                                    <small style="color: #6c757d;">Materi</small>
                                    <?php if ($progress_stats['completed_materials'] == $progress_stats['total_materials'] && $progress_stats['total_materials'] > 0): ?>
                                        <span style="background: #28a745; color: white; padding: 0.125rem 0.375rem; border-radius: 0.25rem; font-size: 0.75rem; margin-left: 0.25rem;">✓</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div style="flex: 0 0 33.333333%; max-width: 33.333333%;">
                            <div style="padding: 1rem 0; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                <div style="color: <?= $progress_stats['completed_tasks'] == $progress_stats['total_tasks'] && $progress_stats['total_tasks'] > 0 ? '#28a745' : '#007bff' ?>; margin-bottom: 0.25rem;">
                                    <i class="fas <?= $progress_stats['completed_tasks'] == $progress_stats['total_tasks'] && $progress_stats['total_tasks'] > 0 ? 'fa-check-circle' : 'fa-tasks' ?>" style="font-size: 2rem;"></i>
                                </div>
                                <h4 style="margin: 0; font-size: 1.5rem; font-weight: 600;">
                                    <?= $progress_stats['completed_tasks'] ?>/<?= $progress_stats['total_tasks'] ?>
                                </h4>
                                <div>
                                    <small style="color: #6c757d;">Tugas</small>
                                    <?php if ($progress_stats['completed_tasks'] == $progress_stats['total_tasks'] && $progress_stats['total_tasks'] > 0): ?>
                                        <span style="background: #28a745; color: white; padding: 0.125rem 0.375rem; border-radius: 0.25rem; font-size: 0.75rem; margin-left: 0.25rem;">✓</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div style="flex: 0 0 33.333333%; max-width: 33.333333%;">
                            <div style="padding: 1rem 0; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                <div style="color: <?= $progress_stats['completed_quizzes'] == $progress_stats['total_quizzes'] && $progress_stats['total_quizzes'] > 0 ? '#28a745' : '#ffc107' ?>; margin-bottom: 0.25rem;">
                                    <i class="fas <?= $progress_stats['completed_quizzes'] == $progress_stats['total_quizzes'] && $progress_stats['total_quizzes'] > 0 ? 'fa-check-circle' : 'fa-question-circle' ?>" style="font-size: 2rem;"></i>
                                </div>
                                <h4 style="margin: 0; font-size: 1.5rem; font-weight: 600;">
                                    <?= $progress_stats['completed_quizzes'] ?>/<?= $progress_stats['total_quizzes'] ?>
                                </h4>
                                <div>
                                    <small style="color: #6c757d;">Quiz</small>
                                    <?php if ($progress_stats['completed_quizzes'] == $progress_stats['total_quizzes'] && $progress_stats['total_quizzes'] > 0): ?>
                                        <span style="background: #28a745; color: white; padding: 0.125rem 0.375rem; border-radius: 0.25rem; font-size: 0.75rem; margin-left: 0.25rem;">✓</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div style="flex: 0 0 66.666667%; max-width: 66.666667%; padding: 0 0.75rem;">
            <div style="background: white; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 0.75rem;">
                <div style="background: white; border-bottom: 1px solid #dee2e6; padding: 1rem; border-radius: 0.75rem 0.75rem 0 0;">
                    <ul style="display: flex; list-style: none; padding: 0; margin: 0; border-bottom: 1px solid #dee2e6;">
                        <li style="margin-right: 0.5rem;">
                            <a href="#overview" data-bs-toggle="tab" role="tab" 
                               style="background: #f8f9fa; border: none; color: #007bff; padding: 0.5rem 1rem; text-decoration: none; font-weight: 500; border-bottom: 3px solid #007bff; display: block;">
                                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Overview
                            </a>
                        </li>
                        <li style="margin-right: 0.5rem;">
                            <a href="#modules" data-bs-toggle="tab" role="tab"
                               style="background: transparent; border: none; color: #6c757d; padding: 0.5rem 1rem; text-decoration: none; font-weight: 500; border-bottom: 3px solid transparent; display: block; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#f8f9fa'; this.style.color='#007bff'; this.style.borderBottom='3px solid #007bff';"
                               onmouseout="this.style.background='transparent'; this.style.color='#6c757d'; this.style.borderBottom='3px solid transparent';">
                                <i class="fas fa-book" style="margin-right: 0.5rem;"></i>Materi
                            </a>
                        </li>
                        <li style="margin-right: 0.5rem;">
                            <a href="#tasks" data-bs-toggle="tab" role="tab"
                               style="background: transparent; border: none; color: #6c757d; padding: 0.5rem 1rem; text-decoration: none; font-weight: 500; border-bottom: 3px solid transparent; display: block; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#f8f9fa'; this.style.color='#007bff'; this.style.borderBottom='3px solid #007bff';"
                               onmouseout="this.style.background='transparent'; this.style.color='#6c757d'; this.style.borderBottom='3px solid transparent';">
                                <i class="fas fa-tasks" style="margin-right: 0.5rem;"></i>Tugas
                            </a>
                        </li>
                        <li>
                            <a href="#quizzes" data-bs-toggle="tab" role="tab"
                               style="background: transparent; border: none; color: #6c757d; padding: 0.5rem 1rem; text-decoration: none; font-weight: 500; border-bottom: 3px solid transparent; display: block; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#f8f9fa'; this.style.color='#007bff'; this.style.borderBottom='3px solid #007bff';"
                               onmouseout="this.style.background='transparent'; this.style.color='#6c757d'; this.style.borderBottom='3px solid transparent';">
                                <i class="fas fa-question-circle" style="margin-right: 0.5rem;"></i>Quiz
                            </a>
                        </li>
                    </ul>
                </div>
                <div style="padding: 1rem;">
                    <!-- Overview Tab -->
                    <div id="overview" role="tabpanel" style="display: block;">
                        <h5 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600;">
                            <i class="fas fa-graduation-cap" style="margin-right: 0.5rem;"></i>
                            Tentang Kelas
                        </h5>

                        <p style="color: #6c757d; line-height: 1.6;">
                            <?= (!empty($pendaftaran['deskripsi_singkat']) && is_string($pendaftaran['deskripsi_singkat'])) ? nl2br(esc($pendaftaran['deskripsi_singkat'])) : 'Tidak ada deskripsi tersedia.' ?>
                        </p>

                        
                        <div style="margin-top: 1.5rem;">
                            <h6 style="margin-bottom: 1rem; font-size: 1.125rem; font-weight: 600;">
                                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                                Informasi Pembayaran
                            </h6>
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                            <td style="padding: 0.75rem; font-weight: 600;"><strong>Kode Invoice:</strong></td>
                                            <td style="padding: 0.75rem;"><?= esc($pendaftaran['kode_invoice']) ?></td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                            <td style="padding: 0.75rem; font-weight: 600;"><strong>Status:</strong></td>
                                            <td style="padding: 0.75rem;"><span style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">Aktif - Pembayaran Lunas</span></td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #dee2e6;">
                                            <td style="padding: 0.75rem; font-weight: 600;"><strong>Tanggal Pendaftaran:</strong></td>
                                            <td style="padding: 0.75rem;"><?= date('d/m/Y H:i', strtotime($pendaftaran['tanggal_pendaftaran'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0.75rem; font-weight: 600;"><strong>Tanggal Konfirmasi:</strong></td>
                                            <td style="padding: 0.75rem;"><?= !empty($pendaftaran['pembayaran_tanggal_konfirmasi']) ? date('d/m/Y H:i', strtotime($pendaftaran['pembayaran_tanggal_konfirmasi'])) : (!empty($pendaftaran['tanggal_konfirmasi']) ? date('d/m/Y H:i', strtotime($pendaftaran['tanggal_konfirmasi'])) : '-') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modules Tab -->
                    <div id="modules" role="tabpanel" style="display: none;">
                        <h5 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600;">
                            <i class="fas fa-book" style="margin-right: 0.5rem;"></i>
                            Materi Pembelajaran
                        </h5>

                        <?php if (!empty($modules)): ?>
                            <?php foreach ($modules as $module): ?>
                                <div style="background: white; border: 1px solid #dee2e6; border-radius: 0.625rem; margin-bottom: 1rem;">
                                    <div style="background: #f8f9fa; padding: 0.75rem; border-bottom: 1px solid #dee2e6; border-radius: 0.625rem 0.625rem 0 0;">
                                        <h6 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                            <i class="fas fa-folder-open" style="margin-right: 0.5rem;"></i>
                                            <?= esc($module['nama_modul']) ?>
                                            <span style="background: #6c757d; color: white; padding: 0.125rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; float: right;"><?= count($module['materi']) ?> materi</span>
                                        </h6>
                                    </div>
                                    <div style="padding: 1rem;">
                                        <?php if (!empty($module['materi'])): ?>
                                            <?php foreach ($module['materi'] as $material): ?>
                                                <div style="display: flex; align-items: center; margin-bottom: 1rem; padding: 0.5rem; border-radius: 0.375rem; transition: background-color 0.3s ease;"
                                                   onmouseover="this.style.backgroundColor='#f8f9fa';"
                                                   onmouseout="this.style.backgroundColor='transparent';">
                                                    <div style="margin-right: 0.75rem;">
                                                        <?php if ($material['tipe_materi'] == 'quiz'): ?>
                                                            <?php if ($material['is_completed'] == 1): ?>
                                                                <div style="color: #28a745;">
                                                                    <i class="fas fa-question-circle" style="font-size: 2rem;"></i>
                                                                </div>
                                                            <?php else: ?>
                                                                <div style="color: #ffc107;">
                                                                    <i class="fas fa-question-circle" style="font-size: 2rem;"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if ($material['is_completed'] == 1): ?>
                                                                <div style="color: #28a745;">
                                                                    <i class="fas fa-check-circle" style="font-size: 2rem;"></i>
                                                                </div>
                                                            <?php else: ?>
                                                                <div style="color: #6c757d;">
                                                                    <i class="fas fa-play-circle" style="font-size: 2rem;"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <h6 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;"><?= esc($material['judul_materi']) ?></h6>
                                                        <small style="color: #6c757d;">
                                                            <?php if ($material['tipe_materi'] == 'quiz'): ?>
                                                                <i class="fas fa-question-circle" style="margin-right: 0.25rem;"></i>
                                                                Quiz
                                                                <?php if ($material['is_completed'] == 1): ?>
                                                                    | <i class="fas fa-check" style="margin-right: 0.25rem;"></i>
                                                                    Lulus
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                                                <?= $material['durasi'] ?> menit
                                                                <?php if ($material['is_completed'] == 1 && !empty($material['updated_at'])): ?>
                                                                    | <i class="fas fa-check" style="margin-right: 0.25rem;"></i>
                                                                    Selesai: <?= date('d/m/Y H:i', strtotime($material['updated_at'])) ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <span style="background: <?= $material['tipe_materi'] == 'quiz' ? '#ffc107' : ($material['tipe_materi'] == 'youtube' ? '#dc3545' : ($material['tipe_materi'] == 'zoom' ? '#17a2b8' : '#6c757d')) ?>; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                                            <?= $material['tipe_materi'] == 'quiz' ? 'Quiz' : ucfirst($material['tipe_materi']) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div style="text-align: center; padding: 1.5rem 0;">
                                                <i class="fas fa-folder-open" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                                                <p style="color: #6c757d; margin: 0;">Belum ada materi dalam modul ini.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="text-align: center; padding: 1.5rem 0;">
                                <i class="fas fa-book" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                                <p style="color: #6c757d; margin: 0;">Belum ada modul pembelajaran tersedia.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Tasks Tab -->
                    <div id="tasks" role="tabpanel" style="display: none;">
                        <h5 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600;">
                            <i class="fas fa-tasks" style="margin-right: 0.5rem;"></i>
                            Tugas
                        </h5>

                        <?php if (!empty($tasks)): ?>
                            <?php foreach ($tasks as $task): ?>
                                <div style="background: white; border: 1px solid #dee2e6; border-radius: 0.625rem; margin-bottom: 1rem;">
                                    <div style="background: #f8f9fa; padding: 0.75rem; border-bottom: 1px solid #dee2e6; border-radius: 0.625rem 0.625rem 0 0;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <h6 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                                <i class="fas fa-clipboard" style="margin-right: 0.5rem;"></i>
                                                <?= esc($task['judul_tugas']) ?>
                                            </h6>
                                            <small style="color: #6c757d;">
                                                <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                                Deadline: <?= !empty($task['deadline']) ? date('d/m/Y H:i', strtotime($task['deadline'])) : 'N/A' ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div style="padding: 1rem;">
                                        <p style="color: #6c757d; margin-bottom: 1rem;"><?= esc($task['deskripsi']) ?></p>

                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <small style="color: #6c757d;">
                                                <i class="fas fa-calendar" style="margin-right: 0.25rem;"></i>
                                                Dibuat: <?= !empty($task['created_at']) ? date('d/m/Y H:i', strtotime($task['created_at'])) : 'N/A' ?>
                                            </small>
                                            <div>
                                                <?php if ($task['status_penilaian'] === 'dinilai'): ?>
                                                    <span style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; margin-right: 0.5rem; font-size: 0.75rem;">
                                                        <i class="fas fa-check" style="margin-right: 0.25rem;"></i>
                                                        Sudah Dinilai
                                                    </span>
                                                    <?php if ($task['nilai'] !== null): ?>
                                                        <span style="background: #17a2b8; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">Nilai: <?= $task['nilai'] ?></span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span style="background: #ffc107; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                                        <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                                        Belum Dinilai
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="text-align: center; padding: 2rem 0; background: #fff3cd; border: 2px dashed #ffc107; border-radius: 0.625rem; margin-bottom: 1rem;">
                                <i class="fas fa-tasks" style="font-size: 3rem; color: #ffc107; margin-bottom: 1rem;"></i>
                                <h6 style="color: #856404; margin: 0 0 0.5rem 0; font-weight: 600;">Belum ada tugas tersedia</h6>
                                <p style="color: #856404; margin: 0; font-size: 0.875rem;">Tugas untuk kursus ini akan ditampilkan di sini ketika tersedia.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Quizzes Tab -->
                    <div id="quizzes" role="tabpanel" style="display: none;">
                        <h5 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600;">
                            <i class="fas fa-question-circle" style="margin-right: 0.5rem;"></i>
                            Quiz
                        </h5>

                        <?php if (!empty($quizzes)): ?>
                            <?php foreach ($quizzes as $quiz): ?>
                                <div style="background: white; border: 1px solid #dee2e6; border-radius: 0.625rem; margin-bottom: 1rem;">
                                    <div style="background: #f8f9fa; padding: 0.75rem; border-bottom: 1px solid #dee2e6; border-radius: 0.625rem 0.625rem 0 0;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <h6 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                                <i class="fas fa-question-circle" style="margin-right: 0.5rem;"></i>
                                                <?= esc($quiz['judul_quiz']) ?>
                                            </h6>
                                            <small style="color: #6c757d;">
                                                <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                                Durasi: <?= $quiz['durasi_menit'] ?> menit
                                            </small>
                                        </div>
                                    </div>
                                    <div style="padding: 1rem;">
                                        <p style="color: #6c757d; margin-bottom: 1rem;"><?= esc($quiz['deskripsi']) ?></p>

                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <span style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; margin-right: 0.5rem; font-size: 0.75rem;">
                                                    <i class="fas fa-list-ol" style="margin-right: 0.25rem;"></i>
                                                    <?= !empty($quiz['soal_json']) ? count(json_decode($quiz['soal_json'], true)) : 0 ?> Soal
                                                </span>
                                                <span style="background: #17a2b8; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                                    <i class="fas fa-percentage" style="margin-right: 0.25rem;"></i>
                                                    Passing Grade: <?= $quiz['passing_grade'] ?>%
                                                </span>
                                            </div>
                                            <div>
                                                <?php if ($quiz['is_lulus'] == 1): ?>
                                                    <span style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; margin-right: 0.5rem; font-size: 0.75rem;">
                                                        <i class="fas fa-check" style="margin-right: 0.25rem;"></i>
                                                        Lulus
                                                    </span>
                                                    <span style="background: #17a2b8; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">Nilai: <?= $quiz['total_nilai'] ?></span>
                                                <?php else: ?>
                                                    <span style="background: #ffc107; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                                        <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                                        Belum Dikerjakan
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="text-align: center; padding: 2rem 0; background: #f8d7da; border: 2px dashed #f5c6cb; border-radius: 0.625rem; margin-bottom: 1rem;">
                                <i class="fas fa-question-circle" style="font-size: 3rem; color: #dc3545; margin-bottom: 1rem;"></i>
                                <h6 style="color: #721c24; margin: 0 0 0.5rem 0; font-weight: 600;">Belum ada quiz tersedia</h6>
                                <p style="color: #721c24; margin: 0; font-size: 0.875rem;">Quiz untuk kursus ini akan ditampilkan di sini ketika tersedia.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Responsive Layout Handler
function handleResponsiveLayout() {
    const container = document.querySelector('[style*="display: flex"]');
    const sidebar = container ? container.querySelector('[style*="flex: 0 0 33.333333%"]') : null;
    const mainContent = container ? container.querySelector('[style*="flex: 0 0 66.666667%"]') : null;
    
    if (!container || !sidebar || !mainContent) return;
    
    const screenWidth = window.innerWidth;
    
    if (screenWidth <= 1024) {
        // Tablet and Mobile: Stack layout
        container.style.flexDirection = 'column';
        sidebar.style.flex = '0 0 auto';
        sidebar.style.maxWidth = '100%';
        sidebar.style.marginBottom = '1.5rem';
        mainContent.style.flex = '1';
        mainContent.style.maxWidth = '100%';
    } else {
        // Desktop: Side by side layout
        container.style.flexDirection = 'row';
        sidebar.style.flex = '0 0 33.333333%';
        sidebar.style.maxWidth = '33.333333%';
        sidebar.style.marginBottom = '0';
        mainContent.style.flex = '0 0 66.666667%';
        mainContent.style.maxWidth = '66.666667%';
    }
}

// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
    const panes = document.querySelectorAll('[role="tabpanel"]');
    
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            // Use href instead of data-bs-target
            const targetId = this.getAttribute('href');
            
            // Hide all panes
            panes.forEach(pane => {
                pane.style.display = 'none';
            });
            
            // Remove active state from all tabs
            tabs.forEach(t => {
                t.style.background = 'transparent';
                t.style.color = '#6c757d';
                t.style.borderBottom = '3px solid transparent';
            });
            
            // Show target pane
            const targetPane = document.querySelector(targetId);
            if (targetPane) {
                targetPane.style.display = 'block';
            }
            
            // Set active state for clicked tab
            this.style.background = '#f8f9fa';
            this.style.color = '#007bff';
            this.style.borderBottom = '3px solid #007bff';
        });
    });
});

// Window resize listener for responsive layout
window.addEventListener('resize', handleResponsiveLayout);

// Video Zoom Functionality for Detail Page
document.addEventListener('DOMContentLoaded', function() {
    const videoContainers = document.querySelectorAll('.video-container');
    
    videoContainers.forEach(container => {
        const iframe = container.querySelector('.video-frame');
        if (!iframe) return;
        
        let scale = 1;
        let isFullscreen = false;
        
        // Create zoom controls
        const controls = document.createElement('div');
        controls.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            display: flex;
            gap: 5px;
            background: rgba(0,0,0,0.7);
            padding: 5px;
            border-radius: 5px;
        `;
        
        // Zoom in button
        const zoomInBtn = document.createElement('button');
        zoomInBtn.innerHTML = '<i class="fas fa-search-plus" style="color: white; font-size: 14px;"></i>';
        zoomInBtn.style.cssText = 'background: none; border: none; cursor: pointer; padding: 5px;';
        zoomInBtn.title = 'Zoom In (+)';
        
        // Zoom out button
        const zoomOutBtn = document.createElement('button');
        zoomOutBtn.innerHTML = '<i class="fas fa-search-minus" style="color: white; font-size: 14px;"></i>';
        zoomOutBtn.style.cssText = 'background: none; border: none; cursor: pointer; padding: 5px;';
        zoomOutBtn.title = 'Zoom Out (-)';
        
        // Reset button
        const resetBtn = document.createElement('button');
        resetBtn.innerHTML = '<i class="fas fa-compress" style="color: white; font-size: 14px;"></i>';
        resetBtn.style.cssText = 'background: none; border: none; cursor: pointer; padding: 5px;';
        resetBtn.title = 'Reset (0)';
        
        // Fullscreen button
        const fullscreenBtn = document.createElement('button');
        fullscreenBtn.innerHTML = '<i class="fas fa-expand" style="color: white; font-size: 14px;"></i>';
        fullscreenBtn.style.cssText = 'background: none; border: none; cursor: pointer; padding: 5px;';
        fullscreenBtn.title = 'Fullscreen (F)';
        
        controls.appendChild(zoomInBtn);
        controls.appendChild(zoomOutBtn);
        controls.appendChild(resetBtn);
        controls.appendChild(fullscreenBtn);
        container.appendChild(controls);
        
        // Update transform
        function updateTransform() {
            iframe.style.transform = `scale(${scale})`;
            iframe.style.transformOrigin = 'center center';
        }
        
        // Zoom functions
        function zoomIn() {
            if (scale < 3) {
                scale += 0.25;
                updateTransform();
            }
        }
        
        function zoomOut() {
            if (scale > 0.5) {
                scale -= 0.25;
                updateTransform();
            }
        }
        
        function resetZoom() {
            scale = 1;
            updateTransform();
        }
        
        function toggleFullscreen() {
            if (!isFullscreen) {
                if (container.requestFullscreen) {
                    container.requestFullscreen();
                } else if (container.webkitRequestFullscreen) {
                    container.webkitRequestFullscreen();
                } else if (container.msRequestFullscreen) {
                    container.msRequestFullscreen();
                }
                isFullscreen = true;
                fullscreenBtn.innerHTML = '<i class="fas fa-compress" style="color: white; font-size: 14px;"></i>';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                isFullscreen = false;
                fullscreenBtn.innerHTML = '<i class="fas fa-expand" style="color: white; font-size: 14px;"></i>';
            }
        }
        
        // Event listeners
        zoomInBtn.addEventListener('click', zoomIn);
        zoomOutBtn.addEventListener('click', zoomOut);
        resetBtn.addEventListener('click', resetZoom);
        fullscreenBtn.addEventListener('click', toggleFullscreen);
        
        // Mouse wheel zoom
        container.addEventListener('wheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
                if (e.deltaY < 0) {
                    zoomIn();
                } else {
                    zoomOut();
                }
            }
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.target.tagName.toLowerCase() !== 'input' && e.target.tagName.toLowerCase() !== 'textarea') {
                switch(e.key) {
                    case '+':
                    case '=':
                        zoomIn();
                        break;
                    case '-':
                    case '_':
                        zoomOut();
                        break;
                    case '0':
                        resetZoom();
                        break;
                    case 'f':
                    case 'F':
                        toggleFullscreen();
                        break;
                }
            }
        });
        
        // Touch gestures for mobile
        let touchStartDistance = 0;
        
        container.addEventListener('touchstart', function(e) {
            if (e.touches.length === 2) {
                touchStartDistance = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
            }
        });
        
        container.addEventListener('touchmove', function(e) {
            if (e.touches.length === 2) {
                e.preventDefault();
                const currentDistance = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                
                const scaleDiff = currentDistance / touchStartDistance;
                if (scaleDiff > 1.1 && scale < 3) {
                    scale += 0.1;
                    updateTransform();
                    touchStartDistance = currentDistance;
                } else if (scaleDiff < 0.9 && scale > 0.5) {
                    scale -= 0.1;
                    updateTransform();
                    touchStartDistance = currentDistance;
                }
            }
        });
        
        // Double click to reset
        container.addEventListener('dblclick', function(e) {
            if (e.target === iframe || iframe.contains(e.target)) {
                resetZoom();
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
