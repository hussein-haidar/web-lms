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
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="h4 fw-bold">LPK INASABA</h3>
                        <p class="mb-0">Sistem Pendidikan & Pembelajaran</p>
                        <h5 class="mt-2">Reset Password</h5>
                    </div>

                    <div class="card-body">
                        <!-- User Info -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Account:</strong> <?= $user['email']; ?>
                        </div>

                        <!-- Flash Messages -->
                        <?php if(session()->get('pesan_success')): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i><?= session()->get('pesan_success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->get('error_password')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i><?= session()->get('error_password'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Form -->
                        <form method="post" action="<?= base_url('auth_login/reset_password_siswa/' . $user['id_siswa']); ?>">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="new_password" 
                                           name="new_password" placeholder="Enter new password" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="confirm_password" 
                                           name="confirm_password" placeholder="Confirm new password" required>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Reset Password
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
    
    <!-- Password Validation -->
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>

</html>
