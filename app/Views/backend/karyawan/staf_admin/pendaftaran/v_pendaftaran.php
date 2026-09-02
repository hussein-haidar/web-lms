<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-users"></i> Data <?= $title2 ?></h3>

            <div class="box-tools pull-right">
                <div class="btn-group" style="margin-right:10px;">
                    <a href="<?= base_url('home_karyawan/export/peserta?format=csv') ?>" class="btn btn-default btn-sm" title="Export CSV">
                        <i class="fa fa-file-text-o"></i> CSV
                    </a>
                    <a href="<?= base_url('home_karyawan/export/peserta?format=excel') ?>" class="btn btn-default btn-sm" title="Export Excel">
                        <i class="fa fa-file-excel-o"></i> Excel
                    </a>
                </div>
                <form method="get" action="<?= base_url('home_karyawan/pendaftaran') ?>" class="form-inline" style="display:inline;">
                    <select name="status" class="form-control input-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="menunggu" <?= ($filter_status ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="diverifikasi" <?= ($filter_status ?? '') == 'diverifikasi' ? 'selected' : '' ?>>Diverifikasi</option>
                        <option value="lunas" <?= ($filter_status ?? '') == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="ditolak" <?= ($filter_status ?? '') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                    <a href="<?= base_url('home_karyawan/pendaftaran') ?>" class="btn btn-default btn-sm">
                        <i class="fa fa-refresh"></i> Reset
                    </a>
                </form>
            </div>
        </div>

        <div class="box-body">
            <?php if (session()->getFlashdata('pesan')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="8%">Foto</th>
                                <th>Nama Lengkap</th>
                                <th width="12%">No Telepon</th>
                                <th width="15%">Paket Kursus</th>
                                                             <th width="12%">Total Bayar</th>
                                <th width="10%">Status</th>
                                <th width="12%">Tanggal Daftar</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($daftar) && is_array($daftar)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($daftar as $item): ?>
                                    <?php if (!is_array($item)) continue; ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <img src="<?= !empty($item['foto_profil']) ? base_url('fotosiswa/' . $item['foto_profil']) : base_url('template/dist/img/user2-160x160.jpg') ?>"
                                                class="img-circle" width="40" height="40" alt="Foto">
                                        </td>
                                        <td>
                                            <strong><?= esc($item['nama_lengkap'] ?? '') ?></strong><br>
                                            <small class="text-muted"><?= esc($item['email'] ?? '') ?></small>
                                        </td>
                                        <td>
                                            <span class="text-primary"><?= esc($item['telepon_pendaftaran'] ?? ($item['telepon_siswa'] ?? '-')) ?></span>
                                        </td>
                                        <td>
                                            <?= esc($item['nama_paket'] ?? '-') ?><br>
                                            <small><?= esc($item['program_pelatihan'] ?? '') ?></small>
                                        </td>
                                                                            <td>
                                            <strong>Rp <?= number_format($item['total_bayar'] ?? 0, 0, ',', '.') ?></strong>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = [
                                                'menunggu' => 'warning',
                                                'diverifikasi' => 'info',
                                                'lunas' => 'success',
                                                'ditolak' => 'danger'
                                            ];
                                            $statusLabel = [
                                                'menunggu' => '⏳ Menunggu',
                                                'diverifikasi' => '✅ Diverifikasi',
                                                'lunas' => '💰 Lunas',
                                                'ditolak' => '❌ Ditolak'
                                            ];
                                            $s = $item['status'] ?? 'menunggu';
                                            ?>
                                            <span class="label label-<?= $statusClass[$s] ?? 'default' ?>">
                                                <?= $statusLabel[$s] ?? ucfirst($s) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($item['tanggal_pendaftaran'] ?? now())) ?></td>
                                        <td>
                                            <!-- Tombol Lihat Bukti Bayar -->
                                            <?php if (!empty($item['foto_bukti_bayar'])): ?>
                                                <button class="btn btn-xs btn-primary btn-bukti"
                                                    data-toggle="modal"
                                                    data-target="#modalBukti"
                                                    data-foto="<?= base_url('buktibayar/' . $item['foto_bukti_bayar']) ?>"
                                                    data-nama="<?= esc($item['nama_lengkap']) ?>"
                                                    title="Lihat Bukti Bayar">
                                                    <i class="fa fa-image"></i> Bukti
                                                </button>
                                            <?php else: ?>
                                                <span class="label label-default" title="Belum upload bukti">No Bukti</span>
                                            <?php endif; ?>

                                            <!-- Dropdown Update Status -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-cog"></i> Status
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <li><a href="#" class="update-status" data-id="<?= $item['id_pendaftaran'] ?>" data-status="menunggu">⏳ Menunggu</a></li>
                                                    <li><a href="#" class="update-status" data-id="<?= $item['id_pendaftaran'] ?>" data-status="diverifikasi">✅ Diverifikasi</a></li>
                                                    <li><a href="#" class="update-status" data-id="<?= $item['id_pendaftaran'] ?>" data-status="lunas">💰 Lunas</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" class="update-status-reject" data-id="<?= $item['id_pendaftaran'] ?>">❌ Ditolak</a></li>
                                                </ul>
                                            </div>

                                            <!-- Tombol Edit -->
                                            <a href="<?= base_url('home_karyawan/edit_daftar/' . ($item['id_pendaftaran'] ?? '')) ?>"
                                                class="btn btn-xs btn-warning" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada data pendaftaran siswa.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ✅ Modal Lihat Bukti Bayar -->
<div class="modal fade" id="modalBukti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Bukti Bayar - <span id="buktiNama"></span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img id="buktiImage" src="" class="img-responsive img-thumbnail" alt="Bukti Bayar" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <a id="buktiDownload" href="" class="btn btn-success btn-sm" download>
                    <i class="fa fa-download"></i> Download
                </a>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alasan Penolakan -->
<div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Alasan Penolakan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formReject">
                    <div class="form-group">
                        <label for="alasanPenolakan">Alasan Penolakan</label>
                        <textarea class="form-control" id="alasanPenolakan" name="alasan" rows="4"
                            placeholder="Tuliskan alasan penolakan..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmReject">
                    <i class="fa fa-times"></i> Tolak
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== HANDLE MODAL BUKTI BAYAR =====
        document.querySelectorAll('.btn-bukti').forEach(btn => {
            btn.addEventListener('click', function() {
                const foto = this.dataset.foto;
                const nama = this.dataset.nama;

                document.getElementById('buktiNama').textContent = nama;
                document.getElementById('buktiImage').src = foto;
                document.getElementById('buktiDownload').href = foto;
            });
        });

        // ===== HANDLE UPDATE STATUS =====
        document.querySelectorAll('.update-status').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;
                const status = this.dataset.status;

                const statusText = {
                    'menunggu': 'Menunggu Verifikasi',
                    'diverifikasi': 'Diverifikasi',
                    'lunas': 'Lunas',
                    'ditolak': 'Ditolak'
                };

                Swal.fire({
                    title: 'Update Status?',
                    html: `Ubah status pendaftaran menjadi <strong>${statusText[status]}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        // Redirect ke endpoint update status
                        window.location.href = '<?= base_url('home_karyawan/update_status_pendaftaran/') ?>' + id + '?status=' + status;
                    }
                });
            });
        });

        // ===== HANDLE MODAL PENOLAKAN =====
        document.querySelectorAll('.update-status-reject').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.dataset.id;

                // Tampilkan modal penolakan
                $('#modalReject').modal('show');

                // Handle submit form penolakan
                document.getElementById('confirmReject').onclick = function() {
                    const alasan = document.getElementById('alasanPenolakan').value;

                    if (!alasan.trim()) {
                        Swal.fire('Error', 'Alasan penolakan harus diisi!', 'error');
                        return;
                    }

                    // Submit form dengan POST
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '<?= base_url('home_karyawan/update_status_pendaftaran/') ?>' + id + '?status=ditolak';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= csrf_token() ?>';
                    csrfInput.value = '<?= csrf_hash() ?>';
                    form.appendChild(csrfInput);

                    const alasanInput = document.createElement('input');
                    alasanInput.type = 'hidden';
                    alasanInput.name = 'alasan';
                    alasanInput.value = alasan;
                    form.appendChild(alasanInput);

                    document.body.appendChild(form);
                    form.submit();
                };
            });
        });
    });
</script>

<?= $this->endSection() ?>