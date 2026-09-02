<?= $this->extend('frontend/template_web/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Quiz Header -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden">
                <div class="bg-gradient bg-primary text-white p-4 text-center">
                    <h2 class="mb-2 fw-bold"><?= esc($quiz['judul_quiz']) ?></h2>
                    <p class="mb-2 opacity-90"><?= esc($quiz['deskripsi']) ?></p>
                    <span class="badge bg-white text-primary px-3 py-2">
                        Attempt #<?= $attempt ?> dari <?= $quiz['max_attempt'] ?>
                    </span>
                </div>
            </div>

            <!-- Quiz Info Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-primary mb-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h5 class="card-title mb-2">Durasi</h5>
                            <p class="card-text text-muted"><?= $quiz['durasi_menit'] ?? 30 ?> Menit</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-primary mb-3">
                                <i class="fas fa-list-ol fa-2x"></i>
                            </div>
                            <h5 class="card-title mb-2">Jumlah Soal</h5>
                            <p class="card-text text-muted"><?= count($quiz['soal']) ?> Soal</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="text-primary mb-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <h5 class="card-title mb-2">Nilai Minimum</h5>
                            <p class="card-text text-muted">70%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Progress: <span id="progressText" class="text-primary">0%</span></span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                             id="progressBar" 
                             role="progressbar" 
                             style="width: 0%">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timer -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-clock fa-lg text-warning me-2"></i>
                        <span id="timer" class="fs-5 fw-semibold">--:--</span>
                        <span class="ms-2 text-muted">tersisa</span>
                    </div>
                </div>
            </div>

            <!-- Quiz Form -->
            <form id="quizForm" method="post" action="<?= base_url('home_siswa/quiz/submit') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="id_quiz" value="<?= $quiz['id_quiz'] ?>">
                <input type="hidden" name="id_pendaftaran" value="<?= $pendaftaran['id_pendaftaran'] ?>">
                <input type="hidden" name="waktu_mulai" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" id="totalQuestions" value="<?= count($quiz['soal']) ?>">

                <!-- Questions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <?php if (isset($quiz['soal']) && is_array($quiz['soal']) && !empty($quiz['soal'])): ?>
                            <?php $questionIndex = 0; ?>
                            <?php foreach ($quiz['soal'] as $qIndex => $question): ?>
                                <?php $questionIndex++; ?>
                                <?php
                                // Generate question ID if not exists
                                $questionId = $question['id'] ?? ($qIndex + 1);
                                
                                // Tentukan tipe soal berdasarkan struktur data
                                if (isset($question['pilihan']) && is_array($question['pilihan'])) {
                                    $questionType = 'pilihan_ganda';
                                } else {
                                    $questionType = 'essay'; // Default jika tidak ada pilihan
                                }
                                ?>
                                <div class="p-4 border-bottom question-card" data-question="<?= $questionIndex ?>">
                                    <div class="mb-3">
                                        <span class="badge bg-primary text-white px-3 py-2">
                                            Soal <?= $questionIndex ?> dari <?= count($quiz['soal']) ?>
                                        </span>
                                    </div>
                                    
                                    <div class="question-text mb-4">
                                        <?php 
                                        $pertanyaan = $question['pertanyaan'];
                                        // Handle if pertanyaan is an array (convert to string)
                                        if (is_array($pertanyaan)) {
                                            $pertanyaan = implode(' ', $pertanyaan);
                                        }
                                        // Ensure pertanyaan is always a string
                                        $pertanyaan = (string) $pertanyaan;
                                        ?>
                                        <?= nl2br(esc($pertanyaan)) ?>
                                        <?php if (isset($question['bobot']) && !empty($question['bobot']) && is_numeric($question['bobot'])): ?>
                                            <span class="badge bg-warning text-dark ms-2"><?= $question['bobot'] ?> poin</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php 
                                    $questionType = $question['tipe'] ?? 'pilihan_ganda'; // Default ke pilihan_ganda
                                    if ($questionType === 'pilihan_ganda'): ?>
                                        <div class="row g-3">
                                            <?php if (isset($question['pilihan']) && is_array($question['pilihan'])): ?>
                                                <?php foreach ($question['pilihan'] as $index => $option): ?>
                                                    <div class="col-md-6">
                                                        <label class="d-flex align-items-center p-3 border bg-light rounded cursor-pointer option-item h-100">
                                                            <input type="radio" 
                                                                   class="form-check-input me-3" 
                                                                   name="jawaban[<?= $questionId ?>]" 
                                                                   value="<?= $index ?>" 
                                                                   id="option_<?= $questionId ?>_<?= $index ?>"
                                                                   required>
                                                            <div class="flex-grow-1">
                                                                <span class="fw-semibold d-block"><?= esc($option) ?></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>

                                    <?php elseif ($questionType === 'benar_salah'): ?>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="d-flex align-items-center p-3 border bg-light rounded cursor-pointer option-item h-100">
                                                    <input type="radio" 
                                                           class="form-check-input me-3" 
                                                           name="jawaban[<?= $questionId ?>]" 
                                                           value="benar" 
                                                           id="option_<?= $questionId ?>_benar"
                                                           required>
                                                    <div class="flex-grow-1">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span>Benar</span>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="d-flex align-items-center p-3 border bg-light rounded cursor-pointer option-item h-100">
                                                    <input type="radio" 
                                                           class="form-check-input me-3" 
                                                           name="jawaban[<?= $questionId ?>]" 
                                                           value="salah" 
                                                           id="option_<?= $questionId ?>_salah"
                                                           required>
                                                    <div class="flex-grow-1">
                                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                                        <span>Salah</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                    <?php elseif ($questionType === 'essay'): ?>
                                        <div class="form-group">
                                            <textarea class="form-control" 
                                                      name="jawaban[<?= $questionId ?>]" 
                                                      rows="5" 
                                                      placeholder="Tulis jawaban Anda di sini..."
                                                      required></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Quiz Tidak Tersedia -->
                            <div class="text-center p-5">
                                <div class="mb-4">
                                    <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                                </div>
                                <h4 class="text-dark mb-3">Quiz Tidak Tersedia</h4>
                                <p class="text-muted mb-4">
                                    Quiz untuk materi ini sedang tidak tersedia atau belum dikonfigurasi dengan benar.<br>
                                    Silakan hubungi administrator atau kembali ke halaman kursus.
                                </p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="<?= base_url('home_siswa/detail_kelas_saya/' . $pendaftaran['id_pendaftaran']) ?>" 
                                       class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Kelas
                                    </a>
                                    <a href="<?= base_url('home_siswa/kursus_saya') ?>" 
                                       class="btn btn-secondary">
                                        <i class="fas fa-list me-2"></i>Daftar Kursus
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body text-center">
                        <div class="alert alert-info d-inline-block">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Pastikan semua jawaban sudah terisi sebelum submit.</strong><br>
                            <small>Quiz akan otomatis disubmit jika waktu habis.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i> Submit Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%) !important;
}

.cursor-pointer {
    cursor: pointer;
}

.option-item {
    transition: all 0.3s ease;
    border: 2px solid #dee2e6 !important;
    min-height: 60px;
}

.option-item:hover {
    background-color: #f8f9fa !important;
    border-color: #0d6efd !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
}

.option-item input[type="radio"]:checked + .flex-grow-1 {
    color: #0d6efd;
}

.option-item input[type="radio"]:checked ~ .flex-grow-1 {
    color: #0d6efd;
    font-weight: 600;
}

.option-item input[type="radio"]:checked {
    border-color: #0d6efd;
    background-color: #0d6efd;
}

.question-card:last-child {
    border-bottom: none !important;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .option-item {
        min-height: auto;
        padding: 15px !important;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Quiz Configuration
    const quizDuration = <?= $quiz['durasi_menit'] ?? 30 ?> * 60; // Convert to seconds
    const totalQuestions = <?= isset($quiz['soal']) && is_array($quiz['soal']) ? count($quiz['soal']) : 0 ?>;
    const idQuiz = <?= (int) $quiz['id_quiz'] ?>;
    const idPendaftaran = <?= (int) ($pendaftaran['id_pendaftaran'] ?? 0) ?>;
    const csrfToken = '<?= csrf_hash() ?>';
    const csrfName = '<?= csrf_token() ?>';
    const timerApiUrl = '<?= base_url('api/siswa/quiz/timer/' . (int) $quiz['id_quiz']) ?>';
    let timeRemaining = quizDuration;
    let timerInterval;
    let quizSubmitted = false;
    let serverSynced = false;

    // Sinkronkan sisa waktu dari server agar refresh/re-login tidak mereset timer
    async function syncTimerFromServer() {
        try {
            const res = await fetch(timerApiUrl + '?id_pendaftaran=' + idPendaftaran, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const json = await res.json();
            if ((json.status === 'success' || json.status === 'fresh') && typeof json.remaining_seconds !== 'undefined') {
                timeRemaining = Math.max(0, parseInt(json.remaining_seconds, 10) || 0);
                if (json.status === 'fresh') {
                    saveTimerToServer(timeRemaining); // simpan nilai awal ke server
                }
            }
        } catch (e) {
            console.warn('Gagal sinkronisasi timer dengan server:', e);
        }
    }

    // Persist sisa waktu ke server tiap 30 detik & saat timeout
    async function saveTimerToServer(remaining = null) {
        try {
            const body = new FormData();
            body.append('id_pendaftaran', idPendaftaran);
            body.append('remaining_seconds', remaining !== null ? remaining : Math.max(0, timeRemaining));
            body.append(csrfName, csrfToken);

            const res = await fetch(timerApiUrl, {
                method: 'POST',
                body: body,
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' }
            });
            return await res.json();
        } catch (e) {
            console.warn('Gagal menyimpan timer ke server:', e);
            return null;
        }
    }

    // Start Timer
    async function startTimer() {
        updateTimerDisplay();
        updateProgress();

        let tickCount = 0;
        timerInterval = setInterval(() => {
            if (!serverSynced) return;

            timeRemaining = Math.max(0, timeRemaining - 1);
            tickCount++;

            updateTimerDisplay();
            updateProgress();

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                // Simpan status habis lalu submit otomatis
                saveTimerToServer(0).finally(() => submitQuiz(true));
                return;
            }

            // Persist tiap 30 detik agar tetap berjalan saat halaman di-refresh
            if (tickCount % 30 === 0) {
                saveTimerToServer();
            }

            // Warning when 5 minutes left
            if (timeRemaining === 300) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: '5 menit tersisa! Segera selesaikan quiz.',
                    icon: 'warning',
                    timer: 5000,
                    timerProgressBar: true
                });
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        document.getElementById('timer').textContent = display;
        
        // Change color when time is running out
        const timerElement = document.querySelector('.card-body:has(#timer)');
        if (timeRemaining <= 300) {
            timerElement.parentElement.classList.add('bg-danger', 'text-white');
            timerElement.parentElement.classList.remove('bg-light');
        } else if (timeRemaining <= 600) {
            timerElement.parentElement.classList.add('bg-warning');
            timerElement.parentElement.classList.remove('bg-light');
        }
    }

    function updateProgress() {
        const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked, textarea').length;
        const progress = totalQuestions > 0 ? Math.round((answeredQuestions / totalQuestions) * 100) : 0;
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('progressText').textContent = progress + '%';
    }

    // Option Selection
    function selectOption(element) {
        // Remove selected class from siblings
        const container = element.parentElement;
        container.querySelectorAll('.option-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        // Add selected class to clicked element
        element.classList.add('selected');
        
        // Check radio button
        const radio = element.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
        
        updateProgress();
    }

    // Submit Quiz
    function submitQuiz(autoSubmit = false) {
        if (quizSubmitted) return;
        
        const form = document.getElementById('quizForm');
        const unansweredQuestions = [];
        
        // Check for unanswered questions
        <?php if (isset($quiz['soal']) && is_array($quiz['soal']) && !empty($quiz['soal'])): ?>
            <?php foreach ($quiz['soal'] as $qIndex => $question): ?>
                <?php 
                // Generate question ID if not exists
                $questionId = $question['id'] ?? ($qIndex + 1);
                ?>
                const question<?= $questionId ?> = document.querySelector('input[name="jawaban[<?= $questionId ?>]"]:checked, textarea[name="jawaban[<?= $questionId ?>]"]');
                if (!question<?= $questionId ?> || (question<?= $questionId ?>.type === 'textarea' && !question<?= $questionId ?>.value.trim())) {
                    unansweredQuestions.push(<?= $questionId ?>);
                }
            <?php endforeach; ?>
        <?php endif; ?>
        
        if (!autoSubmit && unansweredQuestions.length > 0) {
            Swal.fire({
                title: 'Belum Lengkap!',
                text: `Ada ${unansweredQuestions.length} soal yang belum dijawab. Yakin ingin submit?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Submit',
                cancelButtonText: 'Lengkapi Dulu'
            }).then((result) => {
                if (result.isConfirmed) {
                    performSubmit();
                }
            });
        } else {
            performSubmit();
        }
    }

    function performSubmit() {
        quizSubmitted = true;
        clearInterval(timerInterval);
        
        // Disable submit button
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
        
        // Submit form
        document.getElementById('quizForm').submit();
    }

    // Prevent page leave during quiz
    window.addEventListener('beforeunload', function(e) {
        if (!quizSubmitted) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', async function() {
        await syncTimerFromServer();
        serverSynced = true;
        startTimer();
        updateProgress();
        
        // Add event listeners to all radio buttons and textareas
        document.querySelectorAll('input[type="radio"], textarea').forEach(element => {
            element.addEventListener('change', updateProgress);
            element.addEventListener('input', updateProgress);
        });
        
        // Form submission
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitQuiz();
        });
    });
</script>

<?= $this->endSection() ?>
