<?= $this->extend('template_user/main') ?>
<?= $this->section('content') ?>

<div class="quiz-container">
    <!-- Quiz Header -->
    <div class="quiz-header">
        <h1><?= esc($quiz['judul_quiz']) ?></h1>
        <p class="mb-0"><?= esc($quiz['deskripsi']) ?></p>
        <small>Attempt #<?= $attempt ?> dari <?= $quiz['max_attempt'] ?></small>
    </div>

    <!-- Timer -->
    <div class="quiz-timer">
        <i class="fa fa-clock"></i> 
        <span id="timer">--:--</span> tersisa
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar-container">
        <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
    </div>

    <!-- Quiz Form -->
    <form id="quizForm" method="post" action=m "<?= base_url('home_siswa/quiz/submit') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id_quiz" value="<?= $quiz['id_quiz'] ?>">
        <input type="hidden" name="id_pendaftaran" value="<?= $pendaftaran['id_pendaftaran'] ?>">
        <input type="hidden" name="waktu_mulai" value="<?= date('Y-m-d H:i:s') ?>">
        <input type="hidden" id="totalQuestions" value="<?= count($quiz['soal']) ?>">

        <!-- Questions -->
        <div id="questionsContainer">
            <?php if (isset($quiz['soal']) && is_array($quiz['soal']) && !empty($quiz['soal'])): ?>
                <?php $questionIndex = 0; ?>
                <?php foreach ($quiz['soal'] as $question): ?>
                    <?php $questionIndex++; ?>
                    <div class="question-card" data-question="<?= $questionIndex ?>">
                        <div class="question-number">
                            Soal <?= $questionIndex ?> dari <?= count($quiz['soal']) ?>
                        </div>
                        
                        <div class="question-text">
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
                                <span class="badge badge-info ml-2"><?= $question['bobot'] ?> poin</span>
                            <?php endif; ?>
                        </div>

                        <?php if ($question['tipe'] === 'pilihan_ganda'): ?>
                            <div class="options-container">
                                <?php if (isset($question['opsi']) && is_array($question['opsi'])): ?>
                                    <?php foreach ($question['opsi'] as $key => $option): ?>
                                        <div class="option-item" onclick="selectOption(this)">
                                            <input type="radio" 
                                                   name="jawaban[<?= $question['id'] ?>]" 
                                                   value="<?= $key ?>" 
                                                   id="option_<?= $question['id'] ?>_<?= $key ?>"
                                                   required>
                                            <label for="option_<?= $question['id'] ?>_<?= $key ?>" style="cursor: pointer;">
                                                <strong><?= strtoupper($key) ?>.</strong> <?= esc($option) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                        <?php elseif ($question['tipe'] === 'benar_salah'): ?>
                            <div class="options-container">
                                <div class="option-item" onclick="selectOption(this)">
                                    <input type="radio" 
                                           name="jawaban[<?= $question['id'] ?>]" 
                                           value="benar" 
                                           id="option_<?= $question['id'] ?>_benar"
                                           required>
                                    <label for="option_<?= $question['id'] ?>_benar" style="cursor: pointer;">
                                        <i class="fa fa-check text-success"></i> Benar
                                    </label>
                                </div>
                                <div class="option-item" onclick="selectOption(this)">
                                    <input type="radio" 
                                           name="jawaban[<?= $question['id'] ?>]" 
                                           value="salah" 
                                           id="option_<?= $question['id'] ?>_salah"
                                           required>
                                    <label for="option_<?= $question['id'] ?>_salah" style="cursor: pointer;">
                                        <i class="fa fa-times text-danger"></i> Salah
                                    </label>
                                </div>
                            </div>

                        <?php elseif ($question['tipe'] === 'essay'): ?>
                            <div class="essay-container">
                                <textarea class="essay-answer" 
                                          name="jawaban[<?= $question['id'] ?>]" 
                                          placeholder="Tulis jawaban Anda di sini..."
                                          required></textarea>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Quiz Tidak Tersedia -->
                <div class="quiz-empty-state">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fa fa-exclamation-triangle fa-4x text-warning"></i>
                        </div>
                        <h3 class="text-warning mb-3">Quiz Tidak Tersedia</h3>
                        <p class="text-muted mb-4">
                            Quiz untuk materi ini sedang tidak tersedia atau belum dikonfigurasi dengan benar.<br>
                            Silakan hubungi administrator atau kembali ke halaman kursus.
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="<?= base_url('home_siswa/detail_kelas_saya/' . $pendaftaran['id_pendaftaran']) ?>" class="btn btn-outline-primary">
                                <i class="fa fa-arrow-left me-2"></i>Kembali ke Kelas
                            </a>
                            <a href="<?= base_url('home_siswa/kursus') ?>" class="btn btn-primary">
                                <i class="fa fa-list me-2"></i>Daftar Kursus
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Submit Section -->
        <div class="quiz-footer">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                <strong>Pastikan semua jawaban sudah terisi sebelum submit.</strong><br>
                <small>Quiz akan otomatis disubmit jika waktu habis.</small>
            </div>
            
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fa fa-paper-plane"></i> Submit Quiz
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Quiz Configuration
const quizDuration = <?= $quiz['durasi_menit'] ?? 30 ?> * 60; // Convert to seconds
const totalQuestions = <?= isset($quiz['soal']) && is_array($quiz['soal']) ? count($quiz['soal']) : 0 ?>;
const waktuMulai = new Date('<?= date('Y-m-d H:i:s') ?>').getTime(); // Waktu mulai aktual
let timeRemaining = quizDuration;
let timerInterval;
let quizSubmitted = false;

// Start Timer
function startTimer() {
    updateTimerDisplay();
    
    timerInterval = setInterval(() => {
        // Hitung waktu tersisa berdasarkan waktu aktual
        const waktuSekarang = new Date().getTime();
        const waktuBerlalu = Math.floor((waktuSekarang - waktuMulai) / 1000);
        timeRemaining = Math.max(0, quizDuration - waktuBerlalu);
        
        updateTimerDisplay();
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            submitQuiz(true); // Auto submit when time is up
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
    const timerElement = document.querySelector('.quiz-timer');
    if (timeRemaining <= 300) {
        timerElement.style.background = '#dc3545';
        timerElement.style.color = 'white';
    } else if (timeRemaining <= 600) {
        timerElement.style.background = '#ffc107';
        timerElement.style.color = '#333';
    }
}

// Update Progress
function updateProgress() {
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked, textarea').length;
    const progress = (answeredQuestions / totalQuestions) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
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
    
    // Check the radio button
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
        <?php foreach ($quiz['soal'] as $question): ?>
            const question<?= $question['id'] ?> = document.querySelector('input[name="jawaban[<?= $question['id'] ?>]"]:checked, textarea[name="jawaban[<?= $question['id'] ?>]"]');
            if (!question<?= $question['id'] ?> || (question<?= $question['id'] ?>.type === 'textarea' && !question<?= $question['id'] ?>.value.trim())) {
                unansweredQuestions.push(<?= $question['id'] ?>);
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
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...';
    
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
document.addEventListener('DOMContentLoaded', function() {
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
