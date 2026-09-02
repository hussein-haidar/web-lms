<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <i class="fa fa-calendar-plus-o"></i> <?= $jadwal ? 'Edit Jadwal' : 'Tambah Jadwal' ?>
            <div class="box-tools pull-right">
                <a href="<?= base_url('staf/jadwal') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul style="margin-bottom:0;">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post"
                  action="<?= $jadwal ? base_url('staf/jadwal/update/' . $jadwal['id_jadwal']) : base_url('staf/jadwal/store') ?>">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Judul Jadwal <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" required maxlength="255"
                           value="<?= old('judul', $jadwal['judul'] ?? '') ?>"
                           placeholder="Contoh: Ujian Tengah Semester - Web Programming">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control" required
                                   value="<?= old('tanggal_mulai', $jadwal['tanggal_mulai'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control" required
                                   value="<?= old('tanggal_selesai', $jadwal['tanggal_selesai'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <?php
                                $tipes = ['kursus' => 'Kursus', 'deadline' => 'Deadline', 'ujian' => 'Ujian', 'libur' => 'Libur', 'lainnya' => 'Lainnya'];
                                $tipeSelected = old('tipe', $jadwal['tipe'] ?? 'kursus');
                                foreach ($tipes as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= $tipeSelected === $val ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Warna</label>
                            <input type="color" name="warna" class="form-control" style="height:38px;padding:4px;"
                                   value="<?= old('warna', $jadwal['warna'] ?? '#3c8dbc') ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <?php $statusSelected = old('status', $jadwal['status'] ?? 'aktif'); ?>
                                <option value="aktif" <?= $statusSelected === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= $statusSelected === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kursus Terkait <small class="text-muted">(kosongkan untuk jadwal umum)</small></label>
                            <select name="id_kursus" class="form-control">
                                <option value="">-- Umum / Tanpa Kursus --</option>
                                <?php $kursusTerpilih = old('id_kursus', $jadwal['id_kursus'] ?? ''); ?>
                                <?php foreach ($kursus as $k): ?>
                                    <option value="<?= $k['id_kursus'] ?>" <?= $kursusTerpilih == $k['id_kursus'] ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kursus']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pengajar <small class="text-muted">(opsional)</small></label>
                            <select name="id_karyawan" class="form-control">
                                <option value="">-- Pilih Pengajar --</option>
                                <?php $karTerpilih = old('id_karyawan', $jadwal['id_karyawan'] ?? ''); ?>
                                <?php foreach ($karyawan as $kar): ?>
                                    <option value="<?= $kar['id_karyawan'] ?>" <?= $karTerpilih == $kar['id_karyawan'] ? 'selected' : '' ?>>
                                        <?= esc($kar['nama_lengkap']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-control"
                              placeholder="Keterangan tambahan mengenai jadwal ini..."><?= old('deskripsi', $jadwal['deskripsi'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="<?= base_url('staf/jadwal') ?>" class="btn btn-default">Batal</a>
            </form>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
