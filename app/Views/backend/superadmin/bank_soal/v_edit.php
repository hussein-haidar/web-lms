<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Soal - <?= esc($kursus['nama_kursus']) ?></h3>
    </div>
    <form action="<?= base_url('home_superadmin/update_bank_soal/' . $soal['id_soal']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe Soal</label>
                        <select name="tipe_soal" id="tipe_soal" class="form-control" onchange="toggleSoalFields()">
                            <?php $tipes = ['pilihan_ganda', 'true_false', 'fill_blank', 'essay', 'matching']; ?>
                            <?php foreach ($tipes as $t): ?>
                                <option value="<?= $t ?>" <?= $soal['tipe_soal'] === $t ? 'selected' : '' ?>><?= str_replace('_', ' ', ucfirst($t)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Modul</label>
                        <select name="id_modul" class="form-control">
                            <option value="">-- Tanpa Modul --</option>
                            <?php foreach ($modul_list as $m): ?>
                                <option value="<?= $m['id_modul'] ?>" <?= ($soal['id_modul'] == $m['id_modul']) ? 'selected' : '' ?>><?= esc($m['nama_modul']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?= esc($soal['kategori'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Bobot</label>
                        <input type="number" name="bobot" class="form-control" value="<?= $soal['bobot'] ?>" min="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" class="form-control">
                            <option value="mudah" <?= $soal['level'] === 'mudah' ? 'selected' : '' ?>>Mudah</option>
                            <option value="sedang" <?= $soal['level'] === 'sedang' ? 'selected' : '' ?>>Sedang</option>
                            <option value="sulit" <?= $soal['level'] === 'sulit' ? 'selected' : '' ?>>Sulit</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Pertanyaan</label>
                <textarea name="pertanyaan" class="form-control" rows="4" required><?= esc($soal['pertanyaan']) ?></textarea>
            </div>

            <?php $pilihan = json_decode($soal['pilihan'], true) ?: []; ?>

            <!-- Pilihan Ganda -->
            <div id="field_pilihan_ganda" class="soal-fields" <?= $soal['tipe_soal'] === 'pilihan_ganda' ? '' : 'style="display:none"' ?>>
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>A</label><input type="text" name="pilihan_a" class="form-control" value="<?= esc($pilihan['A'] ?? '') ?>"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>B</label><input type="text" name="pilihan_b" class="form-control" value="<?= esc($pilihan['B'] ?? '') ?>"></div></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>C</label><input type="text" name="pilihan_c" class="form-control" value="<?= esc($pilihan['C'] ?? '') ?>"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>D</label><input type="text" name="pilihan_d" class="form-control" value="<?= esc($pilihan['D'] ?? '') ?>"></div></div>
                </div>
                <div class="form-group">
                    <label>Jawaban Benar</label>
                    <select name="jawaban_benar" class="form-control">
                        <?php foreach (['A','B','C','D'] as $h): ?>
                            <option value="<?= $h ?>" <?= strtoupper($soal['jawaban_benar']) === $h ? 'selected' : '' ?>><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- True/False -->
            <div id="field_true_false" class="soal-fields" style="display:none">
                <div class="form-group">
                    <label>Jawaban Benar</label>
                    <select name="jawaban_benar" class="form-control">
                        <option value="A" <?= strtoupper($soal['jawaban_benar']) === 'A' ? 'selected' : '' ?>>TRUE</option>
                        <option value="B" <?= strtoupper($soal['jawaban_benar']) === 'B' ? 'selected' : '' ?>>FALSE</option>
                    </select>
                </div>
            </div>

            <!-- Fill Blank -->
            <div id="field_fill_blank" class="soal-fields" style="display:none">
                <div class="form-group">
                    <label>Jawaban Benar (Teks)</label>
                    <input type="text" name="jawaban_benar" class="form-control" value="<?= esc($soal['jawaban_benar']) ?>">
                </div>
            </div>

            <!-- Essay -->
            <div id="field_essay" class="soal-fields" style="display:none">
                <div class="form-group">
                    <label>Panduan Jawaban</label>
                    <textarea name="jawaban_benar" class="form-control" rows="3"><?= esc($soal['jawaban_benar']) ?></textarea>
                </div>
            </div>

            <!-- Matching -->
            <div id="field_matching" class="soal-fields" style="display:none">
                <div id="matching_pairs">
                    <?php
                    $pairs = json_decode($soal['pilihan_pair'], true) ?: [];
                    if (!empty($pairs)):
                        foreach ($pairs as $left => $right):
                    ?>
                    <div class="row matching-row" style="margin-bottom:10px">
                        <div class="col-md-5"><input type="text" name="pair_left[]" class="form-control" value="<?= esc($left) ?>"></div>
                        <div class="col-md-1 text-center"><strong>=</strong></div>
                        <div class="col-md-5"><input type="text" name="pair_right[]" class="form-control" value="<?= esc($right) ?>"></div>
                        <div class="col-md-1"><button type="button" class="btn btn-xs btn-danger" onclick="this.closest('.matching-row').remove()"><i class="fa fa-times"></i></button></div>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                <button type="button" class="btn btn-sm btn-default" onclick="addPair()"><i class="fa fa-plus"></i> Tambah Pasangan</button>
            </div>

            <div class="form-group">
                <label>Penjelasan</label>
                <textarea name="penjelasan" class="form-control" rows="3"><?= esc($soal['penjelasan'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="box-footer">
            <a href="<?= base_url('home_superadmin/bank_soal/' . $soal['id_kursus']) ?>" class="btn btn-default">Batal</a>
            <button type="submit" class="btn btn-primary pull-right">Update Soal</button>
        </div>
    </form>
</div>

<script>
function toggleSoalFields() {
    const tipe = document.getElementById('tipe_soal').value;
    document.querySelectorAll('.soal-fields').forEach(el => el.style.display = 'none');
    const field = document.getElementById('field_' + tipe);
    if (field) field.style.display = 'block';
}

function addPair() {
    const html = '<div class="row matching-row" style="margin-bottom:10px"><div class="col-md-5"><input type="text" name="pair_left[]" class="form-control" placeholder="Kiri"></div><div class="col-md-1 text-center"><strong>=</strong></div><div class="col-md-5"><input type="text" name="pair_right[]" class="form-control" placeholder="Kanan"></div><div class="col-md-1"><button type="button" class="btn btn-xs btn-danger" onclick="this.closest(\'.matching-row\').remove()"><i class="fa fa-times"></i></button></div></div>';
    document.getElementById('matching_pairs').insertAdjacentHTML('beforeend', html);
}

toggleSoalFields();
</script>

<?= $this->endSection() ?>
