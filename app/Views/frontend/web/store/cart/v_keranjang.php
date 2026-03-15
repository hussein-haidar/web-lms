<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Keranjang Belanja</h4>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll(true)">
                            <i class="fas fa-check-square me-1"></i>Pilih Semua
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectAll(false)">
                            <i class="far fa-square me-1"></i>Batal Pilih
                        </button>
                        <span class="badge bg-primary rounded-pill"><?= count($keranjang) ?> items</span>
                    </div>
                </div>

                <?php if (empty($keranjang)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h5>Keranjang Anda Kosong</h5>
                        <p class="text-muted">Jelajahi kursus kami dan temukan kursus yang tepat untuk Anda.</p>
                        <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-primary">Lihat Kursus</a>
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('home_siswa/checkout_cart') ?>" method="post" id="checkoutForm">
                        <?= csrf_field() ?>
                        <?php foreach ($keranjang as $item): ?>
                            <div class="mb-4 pb-4 border-bottom">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-1">
                                        <div class="form-check">
                                            <input class="form-check-input course-checkbox" 
                                                   type="checkbox" 
                                                   name="selected_courses[]" 
                                                   value="<?= $item['id_keranjang'] ?>"
                                                   id="course_<?= $item['id_keranjang'] ?>"
                                                   checked>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="<?= base_url('kursus/materi/' . ($item['gambar_detail_a'] ?? 'as.png')) ?>" 
                                             class="img-fluid rounded" 
                                             alt="<?= $item['nama_kursus'] ?>"
                                             onerror="this.src='<?= base_url('kursus/materi/as.png') ?>'">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-1"><?= $item['nama_kursus'] ?></h6>
                                        <p class="text-muted small mb-2">
                                            Paket: <strong><?= $item['nama_paket'] ?></strong> (<?= $item['nama_program'] ?? 'Kelas Online' ?>)
                                        </p>
                                        <div class="text-muted small">
                                            <span><i class="fas fa-check-circle text-success me-1"></i>Akses Selamanya</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="fw-bold fs-5 mb-2">Rp<?= number_format($item['harga_kursus'], 0, ',', '.') ?></div>
                                        <a href="<?= base_url('home_siswa/delete_cart/' . $item['id_keranjang']) ?>" class="text-danger text-decoration-none small" onclick="return confirmDelete(event, '<?= $item['id_keranjang'] ?>', '<?= $item['nama_kursus'] ?>')">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="text-end mt-4">
                            <a href="<?= base_url('home_website/kls_online') ?>" class="btn btn-outline-primary me-2">
                                <i class="fas fa-arrow-left me-1"></i>Lanjut Belanja
                            </a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white rounded-3 shadow-sm p-4 sticky-top z-0" style="top: 100px;">
                <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total (<?= count($keranjang) ?> kursus)</span>
                        <span class="fw-bold fs-4 text-primary">Rp<?= number_format($total_harga, 0, ',', '.') ?></span>
                    </div>
                </div>

                <?php if (!empty($keranjang)): ?>
                    <button type="submit" form="checkoutForm" class="btn btn-success w-100 py-3 mb-3 fw-bold fs-5">
                        <i class="fas fa-shopping-cart me-2"></i>Lanjut ke Checkout (<span id="selectedCount"><?= count($keranjang) ?></span>)
                    </button>
                <?php else: ?>
                    <button class="btn btn-secondary w-100 py-3 mb-3 fw-bold fs-5" disabled>
                        <i class="fas fa-shopping-cart me-2"></i>Lanjut ke Checkout (0)
                    </button>
                <?php endif; ?>

                <div class="alert alert-info small mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Pilih kursus yang ingin Anda checkout atau gunakan "Pilih Semua" untuk memilih semua kursus.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function selectAll(select) {
    const checkboxes = document.querySelectorAll('.course-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = select;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkedBoxes = document.querySelectorAll('.course-checkbox:checked');
    const count = checkedBoxes.length;
    const selectedCountElement = document.getElementById('selectedCount');
    if (selectedCountElement) {
        selectedCountElement.textContent = count;
    }
    
    // Update button state - find the submit button in the form
    const submitBtn = document.querySelector('#checkoutForm button[type="submit"]');
    if (submitBtn) {
        if (count > 0) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-success');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.remove('btn-success');
            submitBtn.classList.add('btn-secondary');
        }
    }
}

function confirmDelete(event, id, namaKursus) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Hapus Kursus?',
        html: `Apakah Anda yakin ingin menghapus kursus <strong>${namaKursus}</strong> dari keranjang?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // Redirect ke delete URL
            window.location.href = `<?= base_url('home_siswa/delete_cart/') ?>${id}`;
        }
    });
}

// Add event listeners to checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.course-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    updateSelectedCount(); // Initialize count
});
</script>

<?= $this->endSection() ?>
