<?= $this->extend('frontend/template_web/main') ?>

<?= $this->section('content') ?>

<!-- === HEADER SECTION === -->
<section class="py-4" style="background: linear-gradient(135deg, #0056b3 0%, #00b4d8 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white fw-bold mb-2" style="font-size: 2.2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                    Alumni Program Kecakapan Kewirausahaan
                </h2>
                <p class="text-white-50 mb-0">Berikut adalah portofolio alumni yang telah sukses mengembangkan usahanya</p>
            </div>
        </div>
    </div>
</section>

<!-- === PORTFOLIO SECTION === -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <?php if (!empty($alumni) && is_array($alumni)): ?>
            <?php foreach ($alumni as $index => $item): ?>
                <!-- Portfolio Item <?= $index + 1 ?>: <?= esc($item['nama']) ?> -->
                <div class="row mb-5 g-4 align-items-start">
                    <!-- Left Column - Info -->
                    <div class="col-lg-4 col-md-5">
                        <div class="card border-0 shadow-lg h-100" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <?php if (!empty($item['foto_profil'])): ?>
                                        <img src="<?= base_url('uploads/alumni/profil/' . $item['foto_profil']) ?>" 
                                             alt="<?= esc($item['nama']) ?>" 
                                             class="rounded-circle mb-3" 
                                             width="150" 
                                             height="150"
                                             style="object-fit: cover; border: 4px solid <?= esc($item['warna_tema']) ?>; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                                    <?php elseif (!empty($item['gambar_path'])): ?>
                                        <img src="<?= base_url($item['gambar_path']) ?>" 
                                             alt="<?= esc($item['nama']) ?>" 
                                             class="rounded-circle mb-3" 
                                             width="150" 
                                             height="150"
                                             style="object-fit: cover; border: 4px solid <?= esc($item['warna_tema']) ?>; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                                    <?php else: ?>
                                        <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" 
                                             width="150" 
                                             height="150"
                                             style="background: <?= esc($item['warna_tema']) ?>; color: white; font-size: 3rem; font-weight: bold;">
                                            <?= strtoupper(substr((string)$item['nama'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="fw-bold mb-2" style="color: <?= esc($item['warna_tema']) ?>;"><?= esc($item['nama']) ?></h4>
                                <span class="badge bg-success mb-3"><?= esc($item['kategori']) ?></span>
                                <p class="text-muted small mb-4">
                                    <?= nl2br(esc((string)$item['deskripsi'])) ?>
                                </p>
                                
                                <?php if (!empty($item['lokasi'])): ?>
                                    <div class="mb-4">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <span class="text-muted small"><?= esc($item['lokasi']) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Social Media Buttons -->
                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                    <?php if (!empty($item['facebook_url'])): ?>
                                        <a href="<?= esc($item['facebook_url']) ?>" class="btn flex-fill" 
                                           style="background: #1877F2; color: white; border: none; min-width: 100px; font-size: 0.85rem;" 
                                           target="_blank">
                                            <i class="fab fa-facebook-f me-1"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['tiktok_url'])): ?>
                                        <a href="<?= esc($item['tiktok_url']) ?>" class="btn flex-fill" 
                                           style="background: #000000; color: white; border: none; min-width: 100px; font-size: 0.85rem;" 
                                           target="_blank">
                                            <i class="fab fa-tiktok me-1"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['whatsapp_url'])): ?>
                                        <a href="<?= esc($item['whatsapp_url']) ?>" class="btn flex-fill" 
                                           style="background: #25D366; color: white; border: none; min-width: 100px; font-size: 0.85rem;" 
                                           target="_blank">
                                            <i class="fab fa-whatsapp me-1"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Gallery -->
                    <div class="col-lg-8 col-md-7">
                        <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 text-primary">
                                    <i class="fas fa-images me-2"></i>Galeri
                                </h5>
                                <?php
                                // Get gallery photos for this alumni
                                $galeri = [];
                                
                                // Try to get gallery data from the galeri field if it exists
                                if (!empty($item['galeri'])) {
                                    $galeriData = json_decode($item['galeri'], true);
                                    if (is_array($galeriData)) {
                                        $galeri = $galeriData;
                                    }
                                }
                                
                                // If no galeri data but we have gallery_paths, use that instead
                                if (empty($galeri) && !empty($item['gallery_paths'])) {
                                    $galeri = [];
                                    foreach ($item['gallery_paths'] as $index => $path) {
                                        $galeri[] = [
                                            'foto' => $path,
                                            'keterangan' => 'Gambar ' . ($index + 1)
                                        ];
                                    }
                                }
                                ?>

                                <?php if (!empty($galeri)): ?>
                                    <div class="row g-3">
                                        <?php foreach ($galeri as $photoIndex => $photo): ?>
                                            <?php if ($photoIndex === 0): ?>
                                                <!-- First large image -->
                                                <div class="col-md-6">
                                                    <div style="min-height: 250px; display: flex; align-items: center; justify-content: center; background: #e9ecef; border-radius: 8px; overflow: hidden;">
                                                        <?php if (!empty($item['gallery_paths']) && isset($item['gallery_paths'][$photoIndex])): ?>
                                                            <img src="<?= base_url($item['gallery_paths'][$photoIndex]) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 400px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php else: ?>
                                                            <img src="<?= base_url('uploads/alumni/galeri/' . $photo['foto']) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 400px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php elseif ($photoIndex === 1 || $photoIndex === 2): ?>
                                                <!-- Second and third images in smaller grid -->
                                                <?php if ($photoIndex === 1): ?>
                                                    <div class="col-md-6">
                                                        <div class="row g-3">
                                                <?php endif; ?>
                                                <div class="col-12">
                                                    <div style="min-height: 115px; display: flex; align-items: center; justify-content: center; background: #e9ecef; border-radius: 8px; overflow: hidden;">
                                                        <?php if (!empty($item['gallery_paths']) && isset($item['gallery_paths'][$photoIndex])): ?>
                                                            <img src="<?= base_url($item['gallery_paths'][$photoIndex]) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 200px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php else: ?>
                                                            <img src="<?= base_url('uploads/alumni/galeri/' . $photo['foto']) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 200px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <?php if ($photoIndex === 2): ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php elseif ($photoIndex === 3): ?>
                                                <!-- Fourth image full width -->
                                                <div class="col-12">
                                                    <div style="min-height: 250px; display: flex; align-items: center; justify-content: center; background: #e9ecef; border-radius: 8px; overflow: hidden;">
                                                        <?php if (!empty($item['gallery_paths']) && isset($item['gallery_paths'][$photoIndex])): ?>
                                                            <img src="<?= base_url($item['gallery_paths'][$photoIndex]) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 400px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php else: ?>
                                                            <img src="<?= base_url('uploads/alumni/galeri/' . $photo['foto']) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 400px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <!-- Additional images in grid -->
                                                <div class="col-md-4 col-6">
                                                    <div style="min-height: 180px; display: flex; align-items: center; justify-content: center; background: #e9ecef; border-radius: 8px; overflow: hidden;">
                                                        <?php if (!empty($item['gallery_paths']) && isset($item['gallery_paths'][$photoIndex])): ?>
                                                            <img src="<?= base_url($item['gallery_paths'][$photoIndex]) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 300px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php else: ?>
                                                            <img src="<?= base_url('uploads/alumni/galeri/' . $photo['foto']) ?>" 
                                                                 alt="<?= esc($photo['keterangan'] ?? 'Gambar ' . ($photoIndex + 1)) ?>"
                                                                 style="width: 100%; height: auto; max-height: 300px; object-fit: contain; display: block; transition: transform 0.3s ease;"
                                                                 onmouseover="this.style.transform='scale(1.05)'"
                                                                 onmouseout="this.style.transform='scale(1)'"
                                                                 loading="lazy">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center text-muted py-5">
                                        <i class="fas fa-images fa-3x mb-3"></i>
                                        <p>Belum ada galeri foto untuk alumni ini.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada data alumni</h4>
                <p class="text-muted">Data alumni akan segera ditampilkan setelah tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
