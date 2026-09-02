<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> - LPK INASABA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('/icon/OIP.png') ?>">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="h4 fw-bold">LPK INASABA</h3>
                        <p class="mb-0">Sistem Pendidikan & Pembelajaran</p>
                        <h5 class="mt-2">Sign In</h5>
                    </div>

                    <div class="card-body">
                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following:</h6>
                                <ul class="mb-0 mt-2">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('pesan_warning')): ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('pesan_warning') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('pesan')): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('pesan') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form action="<?= base_url('auth_login/cek_login_siswa') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="login_siswa" class="form-label">Email or NIS</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="login_siswa"
                                        name="login_siswa" placeholder="Enter email or NIS" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="kata_sandi" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="kata_sandi"
                                        name="kata_sandi" placeholder="Enter your password" required>
                                </div>
                                <div class="text-end mt-1">
                                    <a href="<?= base_url('auth_login/lupa_password_siswa') ?>" class="text-decoration-none small">Forgot password?</a>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <p class="mb-0">Don't have an account?
                                    <a href="<?= base_url('auth_login/register_siswa') ?>" class="text-decoration-none">Sign Up</a>
                                </p>
                            </div>

                            <hr>

                            <div class="text-center mb-2">
                                <small class="text-muted">Or continue with</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="fab fa-google me-2"></i>Google
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="fab fa-facebook-f me-2"></i>Facebook
                                </button>
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