<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> - LPK INASABA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="h4 fw-bold">LPK INASABA</h3>
                        <p class="mb-0">Sistem Pendidikan & Pembelajaran</p>
                        <h5 class="mt-2"><?= $title2; ?></h5>
                    </div>

                    <div class="card-body">
                        <!-- Flash Messages -->
                        <?php if(session()->get('pesan_success')): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?= session()->get('pesan_success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->get('pesan_info')): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i><?= session()->get('pesan_info'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->get('error_email')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?= session()->get('error_email'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form method="post" action="<?= base_url('auth_login/proses_lupa_password_siswa'); ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" 
                                           name="email" placeholder="Enter your email" required>
                                </div>
                                <div class="form-text">We'll send you a link to reset your password.</div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="<?= base_url('auth_login/login_siswa'); ?>" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Login
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
