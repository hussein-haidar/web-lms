<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div style="padding: 1.5rem 1rem;">
    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: flex-start; max-width: 100%; margin: 0 auto;">
        <!-- Sidebar: Course Navigation -->
        <div style="flex: 0 0 320px; min-width: 320px; max-width: 320px;">
            <div style="background: white; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 0.75rem; position: sticky; top: 20px;">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; border-radius: 0.75rem 0.75rem 0 0;">
                    <h6 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;"><?= esc($pendaftaran['nama_kursus']) ?></h6>
                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                        <small style="margin-right: 0.5rem;">Progress:</small>
                        <span style="background: white; color: #667eea; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;"><?= round($pendaftaran['progress']) ?>%</span>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); height: 8px; border-radius: 4px; overflow: hidden;">
                        <div style="background: white; height: 100%; width: <?= $pendaftaran['progress'] ?>%; transition: width 0.3s ease;"></div>
                    </div>
                </div>
                <div style="padding: 0; max-height: 75vh; overflow-y: auto;">
                    <?php if (empty($modul)): ?>
                        <div style="text-align: center; padding: 1.5rem;">
                            <i class="fas fa-folder-open" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                            <p style="color: #6c757d; margin: 0;">Belum ada modul pembelajaran tersedia.</p>
                            <a href="<?= base_url('home_siswa/detail_kelas_saya/' . $pendaftaran['id_pendaftaran']) ?>" style="display: inline-block; background: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 0.5rem; margin-top: 1rem;">
                                <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i> Kembali ke Detail Kelas
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($modul as $i => $m): ?>
                            <div style="border-bottom: 1px solid #dee2e6;">
                                <button style="width: 100%; text-align: left; padding: 0.75rem; border: none; background: <?= $materi_aktif && $materi_aktif['id_modul'] == $m['id_modul'] ? '#f8f9fa' : 'transparent' ?>; cursor: pointer;"
                                    onclick="toggleModule('module<?= $m['id_modul'] ?>', this)">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-weight: 600;">
                                            <i class="fas fa-folder-open" style="margin-right: 0.5rem;"></i>
                                            <?= esc($m['nama_modul']) ?>
                                        </span>
                                        <i class="fas fa-chevron-down chevron-icon" style="transition: transform 0.3s ease;"></i>
                                    </div>
                                </button>
                                <div id="module<?= $m['id_modul'] ?>" class="collapse" style="display: none;">
                                    <?php if (empty($m['materi'])): ?>
                                        <div style="text-align: center; padding: 0.75rem;">
                                            <i class="fas fa-book" style="font-size: 2rem; color: #6c757d; margin-bottom: 0.5rem;"></i>
                                            <p style="color: #6c757d; margin: 0;">Belum ada materi dalam modul ini.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($m['materi'] as $mat): ?>
                                            <?php if ($mat['tipe_materi'] == 'quiz'): ?>
                                                <!-- Quiz Item - Special handling for quiz materi -->
                                                <a href="<?= base_url('home_siswa/quiz/kerjakan/' . $mat['id_quiz']) ?>"
                                                    style="display: block; padding: 0.75rem; text-decoration: none; color: #495057; background: <?= $materi_aktif && $materi_aktif['id_materi'] == $mat['id_materi'] ? '#007bff' : 'transparent' ?>; <?= $materi_aktif && $materi_aktif['id_materi'] == $mat['id_materi'] ? 'color: white;' : '' ?> border-bottom: 1px solid #dee2e6; transition: background-color 0.3s ease;">
                                                    <div style="display: flex; align-items: center;">
                                                        <div style="margin-right: 0.75rem;">
                                                            <?php 
                                                            $is_completed = false;
                                                            
                                                            // Check regular progress for materi
                                                            if (isset($progres[$mat['id_materi']]) && $progres[$mat['id_materi']]['is_completed'] == 1) {
                                                                $is_completed = true;
                                                            }
                                                            
                                                            // For quiz items, check if already marked as completed in materi data
                                                            if ($mat['tipe_materi'] == 'quiz' && isset($mat['is_completed']) && $mat['is_completed'] == 1) {
                                                                $is_completed = true;
                                                            }
                                                            ?>
                                                            
                                                            <?php if ($is_completed): ?>
                                                                <div style="color: #28a745;">
                                                                    <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                                                                </div>
                                                            <?php else: ?>
                                                                <div style="color: #6c757d;">
                                                                    <i class="far fa-circle" style="font-size: 1.25rem;"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div style="flex: 1;">
                                                            <div style="display: flex; align-items: center; margin-bottom: 0.25rem;">
                                                                <i class="fas fa-question-circle" style="color: #ffc107; margin-right: 0.5rem;"></i>
                                                                <span><?= esc($mat['judul_materi']) ?></span>
                                                            </div>
                                                            <?php if (isset($mat['durasi']) && $mat['durasi'] > 0): ?>
                                                                <small style="color: #6c757d; margin-left: 1.75rem;">
                                                                    <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>
                                                                    <?= $mat['durasi'] ?> menit
                                                                </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php else: ?>
                                                <!-- Regular Materi Item -->
                                                <!-- Non-quiz materi - use belajar route -->
                                                <a href="<?= base_url('home_siswa/belajar/' . $pendaftaran['id_pendaftaran'] . '/' . $mat['id_materi']) ?>"
                                                        style="display: block; padding: 0.75rem; text-decoration: none; color: #495057; background: <?= $materi_aktif && $materi_aktif['id_materi'] == $mat['id_materi'] ? '#007bff' : 'transparent' ?>; <?= $materi_aktif && $materi_aktif['id_materi'] == $mat['id_materi'] ? 'color: white;' : '' ?> border-bottom: 1px solid #dee2e6; transition: background-color 0.3s ease;">
                                                        <div style="display: flex; align-items: center;">
                                                            <div style="margin-right: 0.75rem;">
                                                                <?php 
                                                                $is_completed = false;
                                                                
                                                                // Check regular progress for materi
                                                                if (isset($progres[$mat['id_materi']]) && $progres[$mat['id_materi']]['is_completed'] == 1) {
                                                                    $is_completed = true;
                                                                }
                                                                ?>
                                                                <i class="fas <?= $is_completed ? 'fa-check-circle' : 'fa-circle' ?>" style="color: <?= $is_completed ? '#28a745' : '#6c757d' ?>; margin-right: 0.5rem;"></i>
                                                                <span style="font-weight: 500;"><?= esc($mat['judul_materi']) ?></span>
                                                            </div>
                                                            <i class="fas fa-chevron-right" style="color: #6c757d;"></i>
                                                        </div>
                                                    </a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div style="flex: 1; min-width: 0;">
            <?php if ($materi_aktif): ?>
                <div style="background: white; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 0.75rem;">
                    <div style="background: white; border-bottom: 1px solid #dee2e6; padding: 1rem; border-radius: 0.75rem 0.75rem 0 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span style="background: <?= $materi_aktif['tipe_materi'] == 'youtube' ? '#dc3545' : ($materi_aktif['tipe_materi'] == 'zoom' ? '#17a2b8' : ($materi_aktif['tipe_materi'] == 'quiz' ? '#ffc107' : '#6c757d')) ?>; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                    <i class="<?= $materi_aktif['tipe_materi'] == 'youtube' ? 'fab fa-youtube' : ($materi_aktif['tipe_materi'] == 'zoom' ? 'fas fa-video' : ($materi_aktif['tipe_materi'] == 'quiz' ? 'fas fa-question-circle' : 'fas fa-file-alt')) ?>" style="margin-right: 0.25rem;"></i>
                                    <?= ucfirst($materi_aktif['tipe_materi']) ?>
                                </span>
                                <h5 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.25rem; font-weight: 600;"><?= esc($materi_aktif['judul_materi']) ?></h5>
                                <small style="color: #6c757d;"><?= esc($materi_aktif['deskripsi_materi']) ?></small>
                            </div>
                            <div>
                                <a href="<?= base_url('home_siswa/detail_kelas_saya/' . $pendaftaran['id_pendaftaran']) ?>" style="background: transparent; color: #6c757d; padding: 0.5rem 1rem; text-decoration: none; border: 1px solid #6c757d; border-radius: 0.5rem;">
                                    <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 1.5rem;">
                        <!-- Video Content -->
                        <?php if ($materi_aktif['tipe_materi'] == 'youtube' || $materi_aktif['tipe_materi'] == 'video'): ?>
                            <?php 
                            // Detect video source (YouTube or Google Drive)
                            $video_url = trim($materi_aktif['url_youtube'] ?? '');
                            $video_id = '';
                            $video_source = ''; // 'youtube' or 'gdrive'
                            $embed_url = '';
                            
                            // Detect Google Drive
                            if (preg_match('/drive\.google\.com/', $video_url)) {
                                $video_source = 'gdrive';
                                // Extract file ID from various Google Drive URL formats
                                if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                } elseif (preg_match('/^([a-zA-Z0-9_-]{25,})$/', $video_url)) {
                                    $video_id = $video_url;
                                }
                                if ($video_id) {
                                    $embed_url = "https://drive.google.com/file/d/{$video_id}/preview";
                                }
                            }
                            // Detect YouTube
                            else {
                                $video_source = 'youtube';
                                if (preg_match('/youtube\.com\/watch\?v=([^&\?#]+)/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                } elseif (preg_match('/youtu\.be\/([^&\?#]+)/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                } elseif (preg_match('/youtube\.com\/embed\/([^&\?#]+)/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                } elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', $video_url)) {
                                    $video_id = $video_url;
                                }
                                if ($video_id) {
                                    $video_id = explode('&', $video_id)[0];
                                    $video_id = explode('#', $video_id)[0];
                                    $embed_url = "https://www.youtube.com/embed/{$video_id}?rel=0&showinfo=0&controls=1&modestbranding=1";
                                }
                            }
                            ?>
                            
                            <?php if (!empty($embed_url)): ?>
                                <!-- Video YouTube Valid -->
                                <div class="video-container">
                                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 0.5rem; background: #000;">
                                        <iframe 
                                            src="<?= $embed_url ?>" 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                    
                                    <!-- Alternative Player (Fallback) -->
                                    <div id="fallback-player" style="display: none; margin-top: 1rem;">
                                        <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.5rem; padding: 1rem; text-align: center;">
                                            <p style="margin-bottom: 1rem;">Video tidak dapat dimuat? Coba tautan alternatif:</p>
                                            <a href="https://www.youtube.com/watch?v=<?= $video_id ?>" target="_blank" 
                                               style="background: #dc3545; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 0.5rem; display: inline-block;">
                                                <i class="fab fa-youtube" style="margin-right: 0.5rem;"></i> Tonton di YouTube
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Video Info -->
                                    <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 0.5rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                            <span style="font-weight: 500;">
                                                <i class="fab fa-youtube" style="color: #dc3545; margin-right: 0.5rem;"></i>
                                                Video Pembelajaran
                                            </span>
                                            <small style="color: #6c757d;">Video ID: <?= $video_id ?></small>
                                        </div>
                                        
                                        <!-- Video Progress Tracking -->
                                        <div id="videoProgress" style="margin-top: 1rem; padding: 1rem; background: white; border: 1px solid #dee2e6; border-radius: 0.5rem;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                                <span style="font-weight: 500;">Progress Video</span>
                                                <span id="videoTime">00:00 / 00:00</span>
                                            </div>
                                            <div style="background: #e9ecef; border-radius: 0.25rem; height: 8px; margin-bottom: 1rem;">
                                                <div id="progressBar" style="background: #007bff; height: 100%; width: 0%; border-radius: 0.25rem; transition: width 0.3s;"></div>
                                            </div>
                                            <div style="text-align: center;">
                                                <button id="markVideoComplete" onclick="markVideoAsCompleted()" style="background: #28a745; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; cursor: pointer; font-size: 1rem;">
                                                    <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> Tandai Selesai Menonton
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Script untuk fallback dan tracking -->
                                <script>
                                // Cek apakah iframe dapat dimuat
                                setTimeout(() => {
                                    const iframe = document.querySelector('iframe[src*="youtube.com/embed"]');
                                    if (iframe) {
                                        // Tambahkan event listener untuk error handling
                                        iframe.onerror = function() {
                                            console.log('Iframe error, showing fallback');
                                            document.getElementById('fallback-player').style.display = 'block';
                                        };
                                        
                                        // Cek apakah iframe diblokir atau gagal dimuat
                                        try {
                                            // Test akses ke iframe
                                            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                                        } catch (e) {
                                            console.log('Iframe blocked, showing fallback');
                                            document.getElementById('fallback-player').style.display = 'block';
                                        }
                                    }
                                }, 2000);
                                
                                // Fallback tracking tanpa YouTube API
                                let videoDuration = 300; // Default 5 menit
                                let currentTime = 0;
                                let videoWatched = false;
                                
                                // Simulasi progress tracking
                                function startProgressTracking() {
                                    const interval = setInterval(() => {
                                        currentTime += 1;
                                        const progress = Math.min((currentTime / videoDuration) * 100, 100);
                                        
                                        // Update progress bar
                                        const progressBar = document.getElementById('progressBar');
                                        if (progressBar) {
                                            progressBar.style.width = progress + '%';
                                        }
                                        
                                        // Update time display
                                        const currentMinutes = Math.floor(currentTime / 60);
                                        const currentSeconds = currentTime % 60;
                                        const durationMinutes = Math.floor(videoDuration / 60);
                                        const durationSeconds = videoDuration % 60;
                                        
                                        const videoTime = document.getElementById('videoTime');
                                        if (videoTime) {
                                            videoTime.textContent = 
                                                `${currentMinutes.toString().padStart(2, '0')}:${currentSeconds.toString().padStart(2, '0')} / ${durationMinutes.toString().padStart(2, '0')}:${durationSeconds.toString().padStart(2, '0')}`;
                                        }
                                        
                                        // Auto-mark as complete jika 80% atau lebih
                                        if (progress >= 80 && !videoWatched) {
                                            videoWatched = true;
                                            clearInterval(interval);
                                            // Auto-mark setelah delay
                                            setTimeout(() => markVideoAsCompleted(), 1000);
                                        }
                                        
                                        // Stop jika sudah 100%
                                        if (progress >= 100) {
                                            clearInterval(interval);
                                        }
                                    }, 1000);
                                }
                                
                                // Mulai tracking saat halaman dimuat
                                document.addEventListener('DOMContentLoaded', function() {
                                    startProgressTracking();
                                });
                                
                                function markVideoAsCompleted() {
                                    if (videoWatched) return;
                                    
                                    if (confirm('Apakah Anda yakin sudah menyelesaikan video ini?')) {
                                        const formData = new URLSearchParams({
                                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                                            id_pendaftaran: <?= $pendaftaran['id_pendaftaran'] ?>,
                                            id_materi: <?= $materi_aktif['id_materi'] ?? 0 ?>,
                                            last_position: Math.floor(currentTime),
                                            is_completed: 1
                                        });
                                        
                                        fetch('<?= base_url('home_siswa/update_progres') ?>', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                                'X-Requested-With': 'XMLHttpRequest'
                                            },
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                alert('Video telah ditandai sebagai selesai.');
                                                window.location.reload();
                                            } else {
                                                alert('Gagal menandai video sebagai selesai: ' + (data.message || 'Unknown error'));
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Network error:', error);
                                            alert('Terjadi kesalahan jaringan: ' + error.message);
                                        });
                                    }
                                }
                                </script>
                                
                            <?php else: ?>
                                <!-- Tidak ada video YouTube valid, tampilkan pesan error -->
                                <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 0.625rem; padding: 1.5rem; text-align: center; margin-bottom: 1.5rem;">
                                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f39c12; margin-bottom: 1rem;"></i>
                                    <h6 style="color: #856404; margin-bottom: 0.5rem;">Video YouTube Tidak Tersedia</h6>
                                    <p style="color: #856404; margin: 0; font-size: 0.875rem;">
                                        URL YouTube yang tersimpan tidak valid. Pastikan URL berformat:<br>
                                        • https://www.youtube.com/watch?v=VIDEO_ID<br>
                                        • https://youtu.be/VIDEO_ID<br>
                                        • https://www.youtube.com/embed/VIDEO_ID
                                    </p>
                                    <?php if (!empty($youtube_url)): ?>
                                        <div style="margin-top: 1rem; padding: 0.5rem; background: #f8f9fa; border-radius: 0.25rem;">
                                            <small style="color: #6c757d; word-break: break-all;">URL saat ini: <?= esc($youtube_url) ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        <!-- Zoom Content -->
                        <?php elseif ($materi_aktif['tipe_materi'] == 'zoom'): ?>
                            <div style="text-align: center; padding: 1.5rem 0;">
                                <i class="fas fa-video" style="font-size: 4rem; color: #17a2b8; margin-bottom: 1.5rem;"></i>
                                <h4 style="margin-bottom: 1rem;">Live Session (Zoom)</h4>
                                <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.625rem; padding: 0.75rem; display: inline-block; margin-bottom: 1.5rem;">
                                    <i class="fas fa-calendar-alt" style="margin-right: 0.5rem;"></i>
                                    <strong>Jadwal:</strong> <?= isset($materi_aktif['zoom_waktu']) ? date('d M Y, H:i', strtotime($materi_aktif['zoom_waktu'])) : 'Belum dijadwalkan' ?>
                                </div>

                                <div style="display: flex; justify-content: center;">
                                    <div style="flex: 0 0 66.666667%; max-width: 66.666667%;">
                                        <div style="background: white; border: 1px solid #007bff; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border-radius: 0.625rem;">
                                            <div style="padding: 1.5rem;">
                                                <h6 style="margin-bottom: 1rem;">
                                                    <i class="fas fa-video" style="margin-right: 0.5rem;"></i>
                                                    Informasi Meeting
                                                </h6>
                                                <div style="margin-bottom: 1rem;">
                                                    <p style="margin-bottom: 0.5rem;">
                                                        <strong><i class="fas fa-id-badge" style="margin-right: 0.5rem;"></i>Meeting ID:</strong> 
                                                        <code style="background: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 0.25rem;"><?= isset($materi_aktif['zoom_meeting_id']) ? $materi_aktif['zoom_meeting_id'] : 'Tersedia saat meeting dimulai' ?></code>
                                                    </p>
                                                    <p style="margin: 0;">
                                                        <strong><i class="fas fa-lock" style="margin-right: 0.5rem;"></i>Password:</strong> 
                                                        <code style="background: #e9ecef; padding: 0.25rem 0.5rem; border-radius: 0.25rem;"><?= isset($materi_aktif['zoom_password']) ? $materi_aktif['zoom_password'] : 'Tersedia saat meeting dimulai' ?></code>
                                                    </p>
                                                </div>
                                                <div style="display: grid; gap: 0.5rem;">
                                                    <a href="<?= isset($materi_aktif['zoom_url']) ? $materi_aktif['zoom_url'] : '#' ?>" target="_blank" style="background: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 0.5rem; text-align: center;">
                                                        <i class="fas fa-external-link-alt" style="margin-right: 0.5rem;"></i> Gabung Zoom
                                                    </a>
                                                    <button onclick="markAsCompleted()" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; cursor: pointer;">
                                                        <i class="fas fa-check" style="margin-right: 0.5rem;"></i> Tandai Sudah Ikut
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- Quiz Content -->
                        <?php elseif ($materi_aktif['tipe_materi'] == 'quiz' && $quiz): ?>
                            <?php if ($quiz_hasil): ?>
                                <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 0.625rem; padding: 1.5rem; text-align: center; margin-bottom: 1.5rem;">
                                    <i class="fas fa-award" style="font-size: 3rem; color: <?= $quiz_hasil['is_lulus'] ? '#28a745' : '#ffc107' ?>; margin-bottom: 1rem;"></i>
                                    <h5>Hasil Kuis Anda</h5>
                                    <h2 style="margin: 0 0 0.5rem 0;"><?= round($quiz_hasil['total_nilai']) ?></h2>
                                    <p style="margin: 0;">Status: <strong><?= $quiz_hasil['is_lulus'] ? 'LULUS' : 'BELUM LULUS' ?></strong></p>
                                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #6c757d;">
                                        Attempt ke-<?= $quiz_hasil['attempt_ke'] ?> dari <?= $quiz['max_attempt'] ?? 3 ?> maksimal
                                    </p>
                                    
                                    <?php if (!$quiz_hasil['is_lulus']): ?>
                                        <div style="margin-top: 1rem;">
                                            <a href="<?= base_url('home_siswa/quiz/kerjakan/' . $quiz['id_quiz']) ?>" style="background: #ffc107; color: #212529; padding: 0.5rem 1rem; text-decoration: none; border-radius: 0.5rem; display: inline-block;">
                                                <i class="fas fa-redo" style="margin-right: 0.5rem;"></i> Coba Lagi
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div style="margin-top: 1rem;">
                                            <a href="<?= base_url('home_siswa/hasil/' . $quiz['id_quiz']) ?>" style="background: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 0.5rem; display: inline-block;">
                                                <i class="fas fa-chart-line" style="margin-right: 0.5rem;"></i> Lihat Detail
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!$quiz_hasil || !$quiz_hasil['is_lulus']): ?>
                                <form action="<?= base_url('home_siswa/quiz/submit') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_pendaftaran" value="<?= $pendaftaran['id_pendaftaran'] ?>">
                                    <input type="hidden" name="id_quiz" value="<?= $quiz['id_quiz'] ?? '' ?>">
                                    <input type="hidden" name="id_materi" value="<?= $materi_aktif['id_materi'] ?? '' ?>">

                                    <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.625rem; margin-bottom: 1.5rem;">
                                        <div style="padding: 1rem;">
                                            <div style="display: flex; align-items: center;">
                                                <div style="color: #ffc107; margin-right: 1rem;">
                                                    <i class="fas fa-question-circle" style="font-size: 2rem;"></i>
                                                </div>
                                                <div>
                                                    <h5 style="margin: 0 0 0.25rem 0;"><?= esc($quiz['judul_quiz'] ?? 'Quiz') ?></h5>
                                                    <small style="color: #6c757d;">
                                                        <i class="fas fa-list-ol" style="margin-right: 0.25rem;"></i>
                                                        <?= $quiz['jumlah_soal'] ?? 0 ?> soal
                                                        <i class="fas fa-clock" style="margin-left: 0.5rem; margin-right: 0.25rem;"></i>
                                                        Durasi: <?= $quiz['durasi'] ?? 30 ?> menit
                                                        <i class="fas fa-percentage" style="margin-left: 0.5rem; margin-right: 0.25rem;"></i>
                                                        Passing Grade: <?= $quiz['passing_grade'] ?? 70 ?>%
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (isset($quiz['soal']) && is_array($quiz['soal']) && !empty($quiz['soal'])): ?>
                                        <?php foreach ($quiz['soal'] as $idx => $s): ?>
                                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 0.625rem; margin-bottom: 1rem;">
                                            <div style="background: #f8f9fa; padding: 0.75rem; border-bottom: 1px solid #dee2e6; border-radius: 0.625rem 0.625rem 0 0;">
                                                <h6 style="margin: 0;">
                                                    <span style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; margin-right: 0.5rem; font-size: 0.75rem;"><?= ($idx + 1) ?></span>
                                                    Soal
                                                </h6>
                                            </div>
                                            <div style="padding: 1rem;">
                                                <?php 
                                                // Handle different question formats
                                                $pertanyaan = '';
                                                $pilihan = [];
                                                
                                                if (isset($s['pertanyaan'])) {
                                                    $pertanyaan = $s['pertanyaan'];
                                                } elseif (isset($s['question'])) {
                                                    $pertanyaan = $s['question'];
                                                }
                                                
                                                if (isset($s['pilihan'])) {
                                                    $pilihan = $s['pilihan'];
                                                } elseif (isset($s['options'])) {
                                                    $pilihan = $s['options'];
                                                } elseif (isset($s['jawaban'])) {
                                                    // Handle old format where jawaban contains options
                                                    if (is_array($s['jawaban'])) {
                                                        $pilihan = $s['jawaban'];
                                                    }
                                                }
                                                
                                                // Ensure pertanyaan is string
                                                if (is_array($pertanyaan)) {
                                                    $pertanyaan = implode(' ', $pertanyaan);
                                                }
                                                $pertanyaan = (string) $pertanyaan;
                                                ?>
                                                
                                                <p style="margin-bottom: 1rem; font-weight: 500;"><?= nl2br(esc($pertanyaan)) ?></p>
                                                
                                                <?php if (!empty($pilihan) && is_array($pilihan)): ?>
                                                    <?php foreach ($pilihan as $key => $opsi): ?>
                                                        <div style="margin-bottom: 0.5rem;">
                                                            <input type="radio" name="jawaban[<?= $idx ?>]" value="<?= $key ?>" required style="margin-right: 0.5rem;">
                                                            <label style="display: flex; align-items: center; cursor: pointer;">
                                                                <span style="background: #6c757d; color: white; padding: 0.125rem 0.375rem; border-radius: 0.25rem; margin-right: 0.5rem; font-size: 0.75rem; font-weight: 500;">
                                                                    <?php 
                                                                    if (is_numeric($key)) {
                                                                        echo chr(65 + $key);
                                                                    } else {
                                                                        echo strtoupper($key);
                                                                    }
                                                                    ?>
                                                                </span>
                                                                <?= esc($opsi) ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 0.25rem; padding: 0.75rem;">
                                                        <small style="color: #856404;">
                                                            <i class="fas fa-exclamation-triangle"></i> Pilihan jawaban tidak tersedia
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 0.625rem; padding: 2rem; text-align: center;">
                                            <i class="fas fa-question-circle" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                                            <h5 style="color: #6c757d;">Quiz Belum Tersedia</h5>
                                            <p style="color: #6c757d;">Soal untuk quiz ini belum dikonfigurasi.</p>
                                        </div>
                                    <?php endif; ?>

                                    <div style="text-align: center;">
                                        <button type="submit" style="background: #007bff; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; cursor: pointer; font-size: 1.125rem;">
                                            <i class="fas fa-paper-plane" style="margin-right: 0.5rem;"></i> Kirim Jawaban
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>

                        <!-- Text Content -->
                        <?php elseif ($materi_aktif['tipe_materi'] == 'text'): ?>
                            <div style="background: white; border: 1px solid #dee2e6; border-radius: 0.625rem;">
                                <div style="padding: 1rem;">
                                    <!-- Reading Progress -->
                                    <div id="readingProgress" style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 0.5rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                            <span style="font-weight: 500;">Progress Membaca</span>
                                            <span id="readingTime">00:00</span>
                                        </div>
                                        <div style="background: #e9ecef; border-radius: 0.25rem; height: 8px; margin-bottom: 0.5rem;">
                                            <div id="readingProgressBar" style="background: #007bff; height: 100%; width: 0%; border-radius: 0.25rem; transition: width 0.3s;"></div>
                                        </div>
                                        <small style="color: #6c757d;">Waktu membaca: <span id="readingDuration">0</span> menit</small>
                                    </div>
                                    
                                    <div style="line-height: 1.8; font-size: 16px; max-height: 500px; overflow-y: auto; padding-right: 1rem;" id="textContent">
                                        <?= $materi_aktif['konten_text'] ?>
                                    </div>
                                    
                                    <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #dee2e6;">
                                        <button onclick="markTextAsCompleted()" style="background: #28a745; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; cursor: pointer; font-size: 1.125rem;">
                                            <i class="fas fa-check-double" style="margin-right: 0.5rem;"></i> Selesai Membaca
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                            // Reading tracking
                            let readingStartTime = Date.now();
                            let readingProgress = 0;
                            let textCompleted = false;
                            
                            // Track reading progress
                            document.addEventListener('DOMContentLoaded', function() {
                                const textContent = document.getElementById('textContent');
                                const readingProgressBar = document.getElementById('readingProgressBar');
                                const readingTime = document.getElementById('readingTime');
                                const readingDuration = document.getElementById('readingDuration');
                                
                                // Update reading time every second
                                setInterval(() => {
                                    const elapsed = Math.floor((Date.now() - readingStartTime) / 1000);
                                    const minutes = Math.floor(elapsed / 60);
                                    const seconds = elapsed % 60;
                                    
                                    readingTime.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                    readingDuration.textContent = minutes;
                                    
                                    // Update progress based on scroll
                                    if (textContent) {
                                        const scrollPercentage = (textContent.scrollTop / (textContent.scrollHeight - textContent.clientHeight)) * 100;
                                        readingProgress = Math.min(scrollPercentage, 100);
                                        readingProgressBar.style.width = readingProgress + '%';
                                        
                                        // Auto-mark as complete if scrolled to 80% or read for 5 minutes
                                        if ((readingProgress >= 80 || minutes >= 5) && !textCompleted) {
                                            textCompleted = true;
                                            markTextAsCompleted();
                                        }
                                    }
                                }, 1000);
                                
                                // Track scroll
                                if (textContent) {
                                    textContent.addEventListener('scroll', () => {
                                        const scrollPercentage = (textContent.scrollTop / (textContent.scrollHeight - textContent.clientHeight)) * 100;
                                        readingProgress = Math.min(scrollPercentage, 100);
                                        readingProgressBar.style.width = readingProgress + '%';
                                    });
                                }
                            });
                            
                            function markTextAsCompleted() {
                                console.log('Marking text as completed...');
                                if (confirm('Apakah Anda yakin sudah menyelesaikan materi ini?')) {
                                    fetch('<?= base_url('home_siswa/update_progres') ?>', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                            'X-Requested-With': 'XMLHttpRequest'
                                        },
                                    body: new URLSearchParams({
                                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                                        id_pendaftaran: <?= $pendaftaran['id_pendaftaran'] ?>,
                                        id_materi: <?= $materi_aktif['id_materi'] ?? 0 ?>,
                                        last_position: Math.floor(readingProgress),
                                        is_completed: 1
                                    })
                                    })
                                    .then(response => {
                                        console.log('Response status:', response.status);
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Response data:', data);
                                        if (data.status === 'success') {
                                            alert('Materi telah ditandai sebagai selesai.');
                                            console.log('Reloading page with cache bust...');
                                            // Force reload with cache busting
                                            const timestamp = new Date().getTime();
                                            window.location.href = window.location.pathname + '?t=' + timestamp + '#' + window.location.hash;
                                            window.location.reload(true);
                                        } else {
                                            alert('Gagal menandai materi sebagai selesai.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan, silakan coba lagi.');
                                    });
                                }
                            }
                            </script>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <div style="background: white; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); border-radius: 0.75rem;">
                    <div style="padding: 3rem; text-align: center;">
                        <i class="fas fa-book-open" style="font-size: 4rem; color: #6c757d; margin-bottom: 1.5rem;"></i>
                        <h4 style="margin-bottom: 1rem;">Selamat Datang di Ruang Belajar</h4>
                        <p style="color: #6c757d; margin-bottom: 2rem;">Silakan pilih modul di samping untuk memulai perjalanan belajar Anda.</p>
                        <div style="margin-top: 1.5rem;">
                            <a href="<?= base_url('home_siswa/detail_kelas_saya/' . $pendaftaran['id_pendaftaran']) ?>" style="background: #007bff; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 0.5rem;">
                                <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i> Kembali ke Detail Kelas
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function markAsCompleted() {
    if (confirm('Apakah Anda yakin ingin menandai materi ini sebagai selesai?')) {
        fetch('<?= base_url('home_siswa/update_progres') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                id_pendaftaran: <?= $pendaftaran['id_pendaftaran'] ?>,
                id_materi: <?= $materi_aktif['id_materi'] ?? 0 ?>,
                last_position: 0,
                is_completed: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            alert('Materi telah ditandai sebagai selesai.');
            location.reload();
        })
        .catch(error => {
            alert('Terjadi kesalahan, silakan coba lagi.');
        });
    }
}

// Collapsible module functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle module toggle buttons
    const toggleButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const targetElement = document.querySelector(targetId);
            const chevron = this.querySelector('.fa-chevron-down');
            
            if (targetElement) {
                // Toggle visibility
                if (targetElement.style.display === 'none' || targetElement.style.display === '') {
                    targetElement.style.display = 'block';
                    if (chevron) {
                        chevron.style.transform = 'rotate(180deg)';
                    }
                    this.style.background = '#f8f9fa';
                } else {
                    targetElement.style.display = 'none';
                    if (chevron) {
                        chevron.style.transform = 'rotate(0deg)';
                    }
                    this.style.background = 'transparent';
                }
            }
        });
    });
    
    // Open the module containing the active material
    const activeMaterialLink = document.querySelector('a[href*="<?= $materi_aktif['id_materi'] ?? '' ?>"]');
    if (activeMaterialLink) {
        const activeModule = activeMaterialLink.closest('[id^="module"]');
        if (activeModule) {
            activeModule.style.display = 'block';
            const moduleId = activeModule.id;
            const toggleButton = document.querySelector(`[data-bs-target="#${moduleId}"]`);
            if (toggleButton) {
                toggleButton.style.background = '#f8f9fa';
                const chevron = toggleButton.querySelector('.fa-chevron-down');
                if (chevron) {
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
        }
    }
});

// Video Zoom Functionality
document.addEventListener('DOMContentLoaded', function() {
    const videoContainers = document.querySelectorAll('[style*="position: relative"]');
    
    videoContainers.forEach(container => {
        const iframe = container.querySelector('iframe');
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

// Responsive Layout Handler
function handleResponsiveLayout() {
    const container = document.querySelector('[style*="display: flex"]');
    const sidebar = container ? container.querySelector('[style*="flex: 0 0 320px"]') : null;
    const mainContent = container ? container.querySelector('[style*="flex: 1"]') : null;
    
    if (!container || !sidebar || !mainContent) return;
    
    const screenWidth = window.innerWidth;
    
    if (screenWidth <= 1024) {
        // Tablet and Mobile: Stack layout
        container.style.flexDirection = 'column';
        sidebar.style.flex = '0 0 auto';
        sidebar.style.maxWidth = '100%';
        sidebar.style.minWidth = '100%';
        sidebar.style.marginBottom = '1.5rem';
        mainContent.style.flex = '1';
    } else {
        // Desktop: Side by side layout
        container.style.flexDirection = 'row';
        sidebar.style.flex = '0 0 320px';
        sidebar.style.maxWidth = '320px';
        sidebar.style.minWidth = '320px';
        sidebar.style.marginBottom = '0';
        mainContent.style.flex = '1';
    }
}

// Initialize responsive layout
document.addEventListener('DOMContentLoaded', function() {
    handleResponsiveLayout();
    
    // Find first module with materials and open it
    const moduleButtons = document.querySelectorAll('button[onclick*="toggleModule"]');
    let firstModuleWithMaterials = null;
    
    if (moduleButtons) {
        for (let button of moduleButtons) {
            const moduleId = button.getAttribute('onclick').match(/toggleModule\('([^']+)'/)[1];
            const module = document.getElementById(moduleId);
            
            if (module) {
                const materials = module.querySelectorAll('a, div[style*="background"]');
                if (materials && materials.length > 0) {
                    firstModuleWithMaterials = button;
                    break;
                }
            }
        }
    }
    
    if (firstModuleWithMaterials) {
        const moduleId = firstModuleWithMaterials.getAttribute('onclick').match(/toggleModule\('([^']+)'/)[1];
        const activeModule = document.getElementById(moduleId);
        const chevron = firstModuleWithMaterials.querySelector('.chevron-icon');
        
        if (activeModule) {
            activeModule.style.display = 'block';
        }
        if (chevron) {
            chevron.style.transform = 'rotate(180deg)';
        }
    }
    
    // Close all other modules
    document.querySelectorAll('[id^="module"]').forEach(module => {
        const moduleButton = module.previousElementSibling;
        if (moduleButton && moduleButton !== firstModuleWithMaterials) {
            module.style.display = 'none';
        }
    });
    
    // Reset all chevrons to down position (except active)
    document.querySelectorAll('.chevron-icon').forEach(chevron => {
        const button = chevron.closest('button');
        if (button !== firstModuleWithMaterials) {
            chevron.style.transform = 'rotate(0deg)';
        }
    });
});
window.addEventListener('resize', handleResponsiveLayout);

// Toggle module visibility
function toggleModule(moduleId, button) {
    const module = document.getElementById(moduleId);
    const chevron = button.querySelector('.chevron-icon');
    
    if (module.style.display === 'none' || module.style.display === '') {
        module.style.display = 'block';
        chevron.style.transform = 'rotate(180deg)';
    } else {
        module.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
    }
}

</script>

<?= $this->endSection() ?>
