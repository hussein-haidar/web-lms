<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - LPK INASABA</title>

    <!-- Bootstrap CSS Only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('/icon/OIP.png') ?>">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="h4 fw-bold">LPK INASABA</h3>
                        <p class="mb-0">Sistem Pendidikan & Pembelajaran</p>
                        <h5 class="mt-2">Formulir Pendaftaran</h5>
                    </div>

                    <!-- Notifikasi Error -->
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following:</h6>
                            <ul class="mb-0 mt-2">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i><?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <div class="card-body">
                        <form action="<?= base_url('auth_login/proses_register') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.nama_lengkap') ? 'is-invalid' : '' ?>"
                                    id="nama_lengkap" name="nama_lengkap"
                                    value="<?= old('nama_lengkap') ?>"
                                    placeholder="Masukkan nama lengkap Anda" required>
                                <?php if (session('errors.nama_lengkap')): ?>
                                    <div class="invalid-feedback"><?= session('errors.nama_lengkap') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                                    id="email" name="email"
                                    value="<?= old('email') ?>"
                                    placeholder="Masukkan email Anda" required>
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control <?= session('errors.kata_sandi') ? 'is-invalid' : '' ?>"
                                    id="kata_sandi" name="kata_sandi"
                                    placeholder="Masukkan kata sandi (min. 6 karakter)" required>
                                <?php if (session('errors.kata_sandi')): ?>
                                    <div class="invalid-feedback"><?= session('errors.kata_sandi') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control <?= session('errors.no_telepon') ? 'is-invalid' : '' ?>"
                                    id="no_telepon" name="no_telepon"
                                    value="<?= old('no_telepon') ?>"
                                    placeholder="Masukkan nomor telepon aktif" required>
                                <?php if (session('errors.no_telepon')): ?>
                                    <div class="invalid-feedback"><?= session('errors.no_telepon') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control <?= session('errors.tempat_lahir') ? 'is-invalid' : '' ?>"
                                    id="tempat_lahir" name="tempat_lahir"
                                    value="<?= old('tempat_lahir') ?>"
                                    placeholder="Contoh: Pekalongan" required>
                                <?php if (session('errors.tempat_lahir')): ?>
                                    <div class="invalid-feedback"><?= session('errors.tempat_lahir') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control <?= session('errors.tanggal_lahir') ? 'is-invalid' : '' ?>"
                                    id="tanggal_lahir" name="tanggal_lahir"
                                    value="<?= old('tanggal_lahir') ?>" required>
                                <?php if (session('errors.tanggal_lahir')): ?>
                                    <div class="invalid-feedback"><?= session('errors.tanggal_lahir') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>"
                                    id="alamat" name="alamat"
                                    value="<?= old('alamat') ?>"
                                    placeholder="Contoh: Pekalongan" required>
                                <?php if (session('errors.alamat')): ?>
                                    <div class="invalid-feedback"><?= session('errors.alamat') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select <?= session('errors.jenis_kelamin') ? 'is-invalid' : '' ?>"
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" <?= old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                <?php if (session('errors.jenis_kelamin')): ?>
                                    <div class="invalid-feedback"><?= session('errors.jenis_kelamin') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-select <?= session('errors.agama') ? 'is-invalid' : '' ?>"
                                    id="agama" name="agama" required>
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" <?= old('agama') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                                    <option value="Kristen" <?= old('agama') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                    <option value="Katolik" <?= old('agama') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                    <option value="Hindu" <?= old('agama') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                </select>
                                <?php if (session('errors.agama')): ?>
                                    <div class="invalid-feedback"><?= session('errors.agama') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="foto_profil" class="form-label">Pas Foto (Ukuran 3x4) <small class="text-muted">(Opsional)</small></label>
                                <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                                <small class="text-muted">Format: JPG/PNG, Maks: 2MB, Ukuran: 3x4 cm</small>
                                <?php if (session('errors.foto_profil')): ?>
                                    <div class="invalid-feedback"><?= session('errors.foto_profil') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                                </button>
                                <a href="<?= base_url('auth_login/login_siswa'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>