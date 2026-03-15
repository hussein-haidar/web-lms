<?= $this->extend('backend/template_user/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-trash-alt me-2"></i>
                            Postingan Dihapus (Soft Delete)
                        </h5>
                        <a href="<?= base_url('home_superadmin/postingan_admin') ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Manajemen Postingan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Info -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info:</strong> Postingan dalam daftar ini telah dihapus secara sementara (soft delete). 
                        Anda dapat memulihkannya atau menghapus permanen.
                    </div>

                    <!-- Tabel Postingan Dihapus -->
                    <?php if (empty($postingan)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-trash-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Postingan Dihapus</h5>
                            <p class="text-muted">Belum ada postingan yang dihapus secara sementara.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Gambar</th>
                                        <th width="25%">Judul Postingan</th>
                                        <th width="15%">Kategori</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Tanggal Dihapus</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($postingan as $post): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php if ($post['gambar_postingan']): ?>
                                                    <img src="<?= base_url('uploads/postingan/' . $post['gambar_postingan']) ?>" 
                                                         class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;" 
                                                         alt="<?= esc($post['judul_postingan']) ?>">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 80px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?= esc($post['judul_postingan']) ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i><?= esc($post['penulis']) ?>
                                                        <span class="ms-2">
                                                            <i class="fas fa-eye me-1"></i><?= number_format($post['views'] ?? 0) ?> views
                                                        </span>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($post['kategori']): ?>
                                                    <span class="badge bg-secondary">
                                                        <?= esc($post['kategori']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-trash me-1"></i>Dihapus
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('d M Y, H:i', strtotime($post['deleted_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <!-- Restore -->
                                                    <a href="<?= base_url('home_superadmin/postingan_restore/' . $post['id_postingan']) ?>" 
                                                       class="btn btn-success" 
                                                       title="Pulihkan Postingan"
                                                       onclick="return confirm('Apakah Anda yakin ingin memulihkan postingan ini?')">
                                                        <i class="fas fa-undo"></i>
                                                    </a>
                                                    
                                                    <!-- Permanent Delete -->
                                                    <a href="<?= base_url('home_superadmin/postingan_permanent_delete/' . $post['id_postingan']) ?>" 
                                                       class="btn btn-danger" 
                                                       title="Hapus Permanen"
                                                       onclick="return confirm('PERINGATAN! Ini akan menghapus postingan secara permanen dan tidak dapat dikembalikan. Lanjutkan?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Total <?= count($postingan) ?> postingan</strong> dalam tempat sampah
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    Postingan yang dihapus permanen tidak dapat dikembalikan
                                </small>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
