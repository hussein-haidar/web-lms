<?= $this->extend('backend/template_user/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-trash me-2"></i>
                            <?= esc($title2) ?>
                        </h5>
                        <a href="<?= base_url('home_superadmin/mitra_kerja') ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Info -->
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Mitra kerja dalam daftar ini telah dihapus secara sementara (soft delete). 
                        Anda dapat memulihkannya atau menghapus permanen.
                    </div>

                    <?php if (session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?= session()->getFlashdata('pesan') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($mitra)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-trash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tempat Sampah Kosong</h5>
                            <p class="text-muted">Belum ada mitra kerja yang dihapus.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Logo</th>
                                        <th width="20%">Nama Mitra</th>
                                        <th width="20%">Website</th>
                                        <th width="15%">Status</th>
                                        <th width="10%">Urutan</th>
                                        <th width="15%">Tanggal Dihapus</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($mitra as $item): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php if (!empty($item['logo_mitra'])): ?>
                                                    <img src="<?= base_url('logo_mitra/' . $item['logo_mitra']) ?>" 
                                                         alt="<?= esc($item['nama_mitra']) ?>" 
                                                         class="img-thumbnail" 
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px; border-radius: 4px;">
                                                        <i class="fas fa-building text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= esc($item['nama_mitra']) ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-globe me-1"></i>
                                                    <a href="<?= esc($item['url_website']) ?>" target="_blank">
                                                        <?= esc($item['url_website']) ?>
                                                    </a>
                                                </small>
                                            </td>
                                            <td><?= esc($item['deskripsi']) ?></td>
                                            <td>
                                                <span class="badge bg-secondary rounded-pill">
                                                    <i class="fas fa-trash me-1"></i>
                                                    Dihapus
                                                </span>
                                            </td>
                                            <td><?= $item['urutan'] ?></td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d M Y, H:i', strtotime($item['deleted_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <!-- Restore -->
                                                    <a href="<?= base_url('home_superadmin/restore_mitra_kerja/' . $item['id_mitra']) ?>" 
                                                       class="btn btn-success btn-sm"
                                                       title="Pulihkan Mitra Kerja"
                                                       onclick="return confirm('Apakah Anda yakin ingin memulihkan mitra kerja ini?')">
                                                        <i class="fas fa-undo"></i>
                                                    </a>
                                                    
                                                    <!-- Permanent Delete -->
                                                    <a href="<?= base_url('home_superadmin/force_delete_mitra_kerja/' . $item['id_mitra']) ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       title="Hapus Permanen"
                                                       onclick="return confirm('PERINGATAN! Ini akan menghapus mitra kerja secara permanen dan tidak dapat dikembalikan. Lanjutkan?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <!-- Summary -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="alert alert-warning mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Total <?= count($mitra) ?> mitra kerja</strong> dalam tempat sampah
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        Mitra kerja yang dihapus permanen tidak dapat dikembalikan
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
