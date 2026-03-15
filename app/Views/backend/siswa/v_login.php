<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LPK INASABA</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('/icon/OIP.png') ?>">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <!-- Header Form -->
            <div class="form-header">
                <h1 class="h3 fw-bold">LPK INASABA</h1>
                <p class="lead">Sistem Pendidikan & Pembelajaran</p>
                <h2 class="h4 fw-bold mt-3">Sign In</h2>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <!-- Tampilkan Error Validation -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Validasi Gagal!</strong>
                        <ul class="mt-2 mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Tampilkan Pesan Warning -->
                <?php if (session()->getFlashdata('pesan_warning')): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= session()->getFlashdata('pesan_warning') ?>
                    </div>
                <?php endif; ?>

                <!-- Tampilkan Pesan Sukses -->
                <?php if (session()->getFlashdata('pesan')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= session()->getFlashdata('pesan') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth_login/cek_login_siswa') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="login_siswa" class="form-label">Email or NIS*</label>
                        <input type="text" class="form-control" id="login_siswa" name="login_siswa" placeholder="Enter your email or NIS" value="<?= old('login_siswa') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="kata_sandi" class="form-label">Password*</label>
                        <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" placeholder="Enter your password" required>
                        <div class="text-end mt-1">
                            <a href="<?= base_url('auth_login/lupa_password_siswa') ?>" class="text-muted small">Forgot your password?</a>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0">Don't have an account? <a href="<?= base_url('auth_login/register_siswa') ?>" class="text-decoration-none">Sign Up</a></p>
                    </div>

                    <div class="social-login mt-4">
                        <button type="button" class="social-btn">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button type="button" class="social-btn">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>