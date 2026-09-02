<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Soal Baru - <?= esc($kursus['nama_kursus']) ?></h3>
    </div>
    <form action="<?= base_url('home_superadmin/save_bank_soal') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id_kursus" value="<?= $id_kursus ?>">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe Soal <span class="text-danger">*</span></label>
                        <select name="tipe_soal" id="tipe_soal" class="form-control" required onchange="toggleSoalFields()">
                            <option value="pilihan_ganda">Pilihan Ganda</option>
                            <option value="true_false">True / False</option>
                            <option value="fill_blank">Isian Singkat (Fill in the Blank)</option>
                            <option value="essay">Essay</option>
                            <option value="matching">Matching (Menjodohkan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Modul</label>
                        <select name="id_modul" class="form-control">
                            <option value="">-- Tanpa Modul --</option>
                            <?php foreach ($modul_list as $m): ?>
                                <option value="<?= $m['id_modul'] ?>"><?= esc($m['nama_modul']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Bab 1, UTAS, dll">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" name="bobot" class="form-control" value="1" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Level Kesulitan</label>
                        <select name="level" class="form-control">
                            <option value="mudah">Mudah</option>
                            <option value="sedang" selected>Sedang</option>
                            <option value="sulit">Sulit</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Pertanyaan <span class="text-danger">*</span></label>
                <textarea name="pertanyaan" class="form-control" rows="4" required placeholder="Tulis pertanyaan di sini..."></textarea>
            </div>

            <!-- Pilihan Ganda -->
            <div id="field_pilihan_ganda" class="soal-fields">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilihan A</label>
                            <input type="text" name="pilihan_a" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilihan B</label>
                            <input type="text" name="pilihan_b" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilihan C</label>
                            <input type="text" name="pilihan_c" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilihan D</label>
                            <input type="text" name="pilihan_d" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jawaban Benar (A/B/C/D) <span class="text-danger">*</span></label>
                    <select name="jawaban_benar" class="form-control" id="jawaban_pilihan" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>

            <!-- True/False -->
            <div id="field_true_false" class="soal-fields" style="display:none">
                <div class="form-group">
                    <label>Jawaban Benar <span class="text-danger">*</span></label>
                    <select name="jawaban_benar_tf" class="form-control" required>
                        <option value="A">TRUE</option>
                        <option value="B">FALSE</option>
                    </select>
                </div>
            </div>

            <!-- Fill Blank -->
            <div id="field_fill_blank" class="soal-fields" style="display:none">
                <div class="form-group">
                    <label>Jawaban Benar (Teks) <span class="text-danger">*</span></label>
                    <input type="text" name="jawaban_benar_fill" class="form-control" placeholder="Jawaban yang benar" required>
                </div>
            </div>

            <!-- Essay -->
            <div id="field_essay" class="soal-fields" style="display:none">
                <div class="form-group">
                    <label>Panduan Jawaban (untuk penilaian manual)</label>
                    <textarea name="jawaban_benar_essay" class="form-control" rows="3" placeholder="Kunci jawaban / panduan penilaian"></textarea>
                </div>
            </div>

            <!-- Matching -->
            <div id="field_matching" class="soal-fields" style="display:none">
                <div id="matching_pairs">
                    <div class="row matching-row" style="margin-bottom:10px">
                        <div class="col-md-5"><input type="text" name="pair_left[]" class="form-control" placeholder="Kiri (Pertanyaan)"></div>
                        <div class="col-md-1 text-center"><strong>=</strong></div>
                        <div class="col-md-5"><input type="text" name="pair_right[]" class="form-control" placeholder="Kanan (Jawaban)"></div>
                        <div class="col-md-1"><button type="button" class="btn btn-xs btn-danger" onclick="this.closest('.matching-row').remove()"><i class="fa fa-times"></i></button></div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-default" onclick="addPair()"><i class="fa fa-plus"></i> Tambah Pasangan</button>
            </div>

            <div class="form-group">
                <label>Penjelasan</label>
                <textarea name="penjelasan" class="form-control" rows="3" placeholder="Penjelasan jawaban (opsional)"></textarea>
            </div>
        </div>

        <div class="box-footer">
            <a href="<?= base_url('home_superadmin/bank_soal/' . $id_kursus) ?>" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-success pull-right">Simpan Soal</button>
        </div>
    </form>
</div>

<script>
function toggleSoalFields() {
    const tipe = document.getElementById('tipe_soal').value;
    document.querySelectorAll('.soal-fields').forEach(el => el.style.display = 'none');
    document.getElementById('field_' + tipe).style.display = 'block';

    // Set jawaban_benar field name for different types
    const jawabanInput = document.querySelector('[name="jawaban_benar"]');
    if (tipe === 'pilihan_ganda') {
        jawabanInput.name = 'jawaban_benar';
        jawabanInput.value = '';
    }
}

function addPair() {
    const html = '<div class="row matching-row" style="margin-bottom:10px"><div class="col-md-5"><input type="text" name="pair_left[]" class="form-control" placeholder="Kiri (Pertanyaan)"></div><div class="col-md-1 text-center"><strong>=</strong></div><div class="col-md-5"><input type="text" name="pair_right[]" class="form-control" placeholder="Kanan (Jawaban)"></div><div class="col-md-1"><button type="button" class="btn btn-xs btn-danger" onclick="this.closest(\'.matching-row\').remove()"><i class="fa fa-times"></i></button></div></div>';
    document.getElementById('matching_pairs').insertAdjacentHTML('beforeend', html);
}
</script>

<?= $this->endSection() ?>
