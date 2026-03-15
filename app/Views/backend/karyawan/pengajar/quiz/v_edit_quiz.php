<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= esc($title) ?></h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('home_karyawan/quiz_management') ?>" class="btn btn-sm btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong><br>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        • <?= esc($error) ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-ban"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('home_karyawan/update_quiz/' . $quiz['id_quiz']) ?>" method="post" id="quizForm">
                <?= csrf_field() ?>

                <!-- Informasi Dasar Quiz -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_kursus" class="control-label required">Kursus</label>
                            <select class="form-control" id="id_kursus" name="id_kursus" required>
                                <option value="">-- Pilih Kursus --</option>
                                <?php if (!empty($kursus_list)): ?>
                                    <?php foreach ($kursus_list as $kursus): ?>
                                        <option value="<?= $kursus['id_kursus'] ?>" <?= old('id_kursus', $quiz['id_kursus']) == $kursus['id_kursus'] ? 'selected' : '' ?>>
                                            <?= esc($kursus['nama_kursus']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul_quiz" class="control-label required">Judul Quiz</label>
                            <input type="text" class="form-control" id="judul_quiz" name="judul_quiz"
                                   value="<?= old('judul_quiz', $quiz['judul_quiz']) ?>" placeholder="Contoh: Quiz Introduction HTML" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deskripsi" class="control-label">Deskripsi Quiz</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                      placeholder="Deskripsi singkat tentang quiz ini..."><?= old('deskripsi', $quiz['deskripsi']) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Pengaturan Quiz -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="durasi_menit" class="control-label required">Durasi (menit)</label>
                            <input type="number" class="form-control" id="durasi_menit" name="durasi_menit"
                                   value="<?= old('durasi_menit', $quiz['durasi_menit']) ?>" min="5" max="180" required>
                            <small class="text-muted">5 - 180 menit</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="passing_grade" class="control-label required">Passing Grade (%)</label>
                            <input type="number" class="form-control" id="passing_grade" name="passing_grade"
                                   value="<?= old('passing_grade', $quiz['passing_grade']) ?>" min="0" max="100" required>
                            <small class="text-muted">0 - 100%</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="max_attempt" class="control-label required">Max Attempt</label>
                            <input type="number" class="form-control" id="max_attempt" name="max_attempt"
                                   value="<?= old('max_attempt', $quiz['max_attempt']) ?>" min="1" max="10" required>
                            <small class="text-muted">1 - 10 kali</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status" class="control-label required">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="draft" <?= old('status', $quiz['status']) == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="aktif" <?= old('status', $quiz['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status', $quiz['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Quiz (Opsional) -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_mulai" class="control-label">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                   value="<?= old('tanggal_mulai', $quiz['tanggal_mulai']) ?>">
                            <small class="text-muted">Kosongkan jika tersedia langsung</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_selesai" class="control-label">Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                   value="<?= old('tanggal_selesai', $quiz['tanggal_selesai']) ?>">
                            <small class="text-muted">Kosongkan jika tidak ada batas waktu</small>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Question Builder -->
                <div class="form-group">
                    <label class="control-label required">Soal Quiz</label>
                    <div id="questionBuilder">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            <strong>Petunjuk:</strong> Edit soal quiz yang sudah ada atau tambahkan soal baru.
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary" onclick="addQuestion('pilihan_ganda')">
                                    <i class="fa fa-plus"></i> Pilihan Ganda
                                </button>
                                <button type="button" class="btn btn-success" onclick="addQuestion('benar_salah')">
                                    <i class="fa fa-plus"></i> Benar/Salah
                                </button>
                                <button type="button" class="btn btn-warning" onclick="addQuestion('essay')">
                                    <i class="fa fa-plus"></i> Essay
                                </button>
                            </div>
                            <div class="col-md-4 text-right">
                                <small class="text-muted">Total Soal: <span id="totalQuestions">0</span></small>
                            </div>
                        </div>

                        <div id="questionsContainer" class="space-y-4">
                            <!-- Load existing questions -->
                            <?php
                            $existingQuestions = json_decode($quiz['soal_json'], true) ?: [];
                            $questionCount = 0;
                            foreach ($existingQuestions as $index => $question):
                                $questionCount++;
                            ?>
                            <div class="card card-outline card-primary" id="question_<?= $questionCount ?>">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <span class="question-number"><?= $questionCount ?>. Soal <?= ucfirst($question['tipe']) ?></span>
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm" onclick="removeQuestion('question_<?= $questionCount ?>')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="question_type_<?= $questionCount ?>" value="<?= $question['tipe'] ?>">
                                    
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <textarea class="form-control" name="question_text_<?= $questionCount ?>" rows="2" 
                                                  placeholder="Tulis pertanyaan di sini..." required><?= esc($question['pertanyaan']) ?></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Bobot Nilai</label>
                                        <input type="number" class="form-control" name="question_bobot_<?= $questionCount ?>" 
                                               value="<?= $question['bobot'] ?>" min="1" max="100" required>
                                        <small class="text-muted">1 - 100 poin</small>
                                    </div>
                                    
                                    <?php if ($question['tipe'] === 'pilihan_ganda'): ?>
                                        <div class="form-group">
                                            <label>Opsi Jawaban</label>
                                            <?php foreach (['a', 'b', 'c', 'd'] as $letter): ?>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><?= strtoupper($letter) ?></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="option_<?= $letter ?>_<?= $questionCount ?>" 
                                                           placeholder="Opsi <?= strtoupper($letter) ?>" 
                                                           value="<?= isset($question['opsi'][$letter]) ? $question['opsi'][$letter] : '' ?>"
                                                           <?= isset($question['opsi'][$letter]) && !empty($question['opsi'][$letter]) ? 'required' : '' ?>>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <input type="radio" name="correct_<?= $questionCount ?>" value="<?= $letter ?>" 
                                                                   <?= $question['jawaban_benar'] === $letter ? 'checked' : '' ?>
                                                                   <?= isset($question['opsi'][$letter]) && !empty($question['opsi'][$letter]) ? 'required' : '' ?>> Benar
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php elseif ($question['tipe'] === 'benar_salah'): ?>
                                        <div class="form-group">
                                            <label>Jawaban Benar</label>
                                            <div>
                                                <label class="radio-inline">
                                                    <input type="radio" name="correct_<?= $questionCount ?>" value="benar" required
                                                           <?= $question['jawaban_benar'] === 'benar' ? 'checked' : '' ?>> Benar
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="correct_<?= $questionCount ?>" value="salah" required
                                                           <?= $question['jawaban_benar'] === 'salah' ? 'checked' : '' ?>> Salah
                                                </label>
                                            </div>
                                        </div>
                                    <?php elseif ($question['tipe'] === 'essay'): ?>
                                        <div class="form-group">
                                            <label>Kunci Jawaban (untuk pengecekan)</label>
                                            <textarea class="form-control" name="essay_answer_<?= $questionCount ?>" rows="3" 
                                                      placeholder="Kunci jawaban untuk membantu penilaian..."><?= esc($question['jawaban_benar']) ?></textarea>
                                            <small class="text-muted">Opsional, untuk membantu penilaian essay</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Hidden field untuk soal JSON -->
                    <input type="hidden" id="soal_json" name="soal_json" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update Quiz
                    </button>
                    <a href="<?= base_url('home_karyawan/quiz_management') ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
let questionCount = <?= $questionCount ?>;

function addQuestion(type) {
    questionCount++;
    const questionId = `question_${questionCount}`;
    
    const questionHtml = `
        <div class="card card-outline card-primary" id="${questionId}">
            <div class="card-header">
                <h3 class="card-title">
                    <span class="question-number">${questionCount}. Soal ${type.charAt(0).toUpperCase() + type.slice(1)}</span>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" onclick="removeQuestion('${questionId}')">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="question_type_${questionCount}" value="${type}">
                
                <div class="form-group">
                    <label>Pertanyaan</label>
                    <textarea class="form-control" name="question_text_${questionCount}" rows="2" 
                              placeholder="Tulis pertanyaan di sini..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Bobot Nilai</label>
                    <input type="number" class="form-control" name="question_bobot_${questionCount}" 
                           value="10" min="1" max="100" required>
                    <small class="text-muted">1 - 100 poin</small>
                </div>
                
                ${getQuestionOptionsHtml(type, questionCount)}
            </div>
        </div>
    `;
    
    document.getElementById('questionsContainer').insertAdjacentHTML('beforeend', questionHtml);
    updateQuestionCount();
}

function getQuestionOptionsHtml(type, questionId) {
    if (type === 'pilihan_ganda') {
        return `
            <div class="form-group">
                <label>Opsi Jawaban</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">A</span>
                    </div>
                    <input type="text" class="form-control" name="option_a_${questionId}" placeholder="Opsi A" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="radio" name="correct_${questionId}" value="a" required> Benar
                        </div>
                    </div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">B</span>
                    </div>
                    <input type="text" class="form-control" name="option_b_${questionId}" placeholder="Opsi B" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="radio" name="correct_${questionId}" value="b" required> Benar
                        </div>
                    </div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">C</span>
                    </div>
                    <input type="text" class="form-control" name="option_c_${questionId}" placeholder="Opsi C">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="radio" name="correct_${questionId}" value="c"> Benar
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">D</span>
                    </div>
                    <input type="text" class="form-control" name="option_d_${questionId}" placeholder="Opsi D">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="radio" name="correct_${questionId}" value="d"> Benar
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else if (type === 'benar_salah') {
        return `
            <div class="form-group">
                <label>Jawaban Benar</label>
                <div>
                    <label class="radio-inline">
                        <input type="radio" name="correct_${questionId}" value="benar" required> Benar
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="correct_${questionId}" value="salah" required> Salah
                    </label>
                </div>
            </div>
        `;
    } else if (type === 'essay') {
        return `
            <div class="form-group">
                <label>Kunci Jawaban (untuk pengecekan)</label>
                <textarea class="form-control" name="essay_answer_${questionId}" rows="3" 
                          placeholder="Kunci jawaban untuk membantu penilaian..."></textarea>
                <small class="text-muted">Opsional, untuk membantu penilaian essay</small>
            </div>
        `;
    }
}

function removeQuestion(questionId) {
    const element = document.getElementById(questionId);
    element.remove();
    updateQuestionCount();
}

function updateQuestionCount() {
    const questions = document.querySelectorAll('#questionsContainer .card');
    document.getElementById('totalQuestions').textContent = questions.length;
    
    // Update question numbers
    questions.forEach((question, index) => {
        const numberElement = question.querySelector('.question-number');
        if (numberElement) {
            numberElement.textContent = `${index + 1}. Soal`;
        }
    });
}

// Form submission
document.getElementById('quizForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const questions = [];
    const questionCards = document.querySelectorAll('#questionsContainer .card');
    
    questionCards.forEach((card, index) => {
        const questionId = index + 1;
        const type = card.querySelector(`input[name="question_type_${questionId}"]`).value;
        const text = card.querySelector(`textarea[name="question_text_${questionId}"]`).value;
        const bobot = parseInt(card.querySelector(`input[name="question_bobot_${questionId}"]`).value);
        
        let jawabanBenar = '';
        let opsi = {};
        
        if (type === 'pilihan_ganda') {
            ['a', 'b', 'c', 'd'].forEach(letter => {
                const optionInput = card.querySelector(`input[name="option_${letter}_${questionId}"]`);
                if (optionInput && optionInput.value) {
                    opsi[letter] = optionInput.value;
                }
            });
            jawabanBenar = card.querySelector(`input[name="correct_${questionId}"]:checked`)?.value || '';
        } else if (type === 'benar_salah') {
            opsi = {
                'benar': 'Benar',
                'salah': 'Salah'
            };
            jawabanBenar = card.querySelector(`input[name="correct_${questionId}"]:checked`)?.value || '';
        } else if (type === 'essay') {
            const essayAnswer = card.querySelector(`textarea[name="essay_answer_${questionId}"]`);
            jawabanBenar = essayAnswer ? essayAnswer.value : '';
        }
        
        questions.push({
            id: questionId,
            pertanyaan: text,
            tipe: type,
            opsi: opsi,
            jawaban_benar: jawabanBenar,
            bobot: bobot
        });
    });
    
    // Validate questions
    if (questions.length === 0) {
        alert('Quiz harus memiliki setidaknya 1 soal!');
        return false;
    }
    
    // Set JSON value
    document.getElementById('soal_json').value = JSON.stringify(questions);
    
    // Submit form
    this.submit();
});

// Initialize question count on page load
updateQuestionCount();
</script>

<?= $this->endSection() ?>
