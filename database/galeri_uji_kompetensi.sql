-- ============================================================
-- Tabel: galeri_uji_kompetensi
-- Dibuat untuk melengkapi modul Galeri Uji Kompetensi (superadmin)
-- Sebelumnya fitur ini meminjam tabel uji_kompetensi dengan
-- kolom yang tidak cocok sehingga penyimpanan gagal.
-- Jalankan: mysql -u root lmsweb < database/galeri_uji_kompetensi.sql
-- ============================================================

CREATE TABLE IF NOT EXISTS `galeri_uji_kompetensi` (
  `id_galeri` INT(11) NOT NULL AUTO_INCREMENT,
  `id_uji_kompetensi` INT(11) DEFAULT NULL COMMENT 'Relasi opsional ke uji_kompetensi',
  `judul` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NULL,
  `gambar` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_galeri`),
  KEY `fk_galeri_uji` (`id_uji_kompetensi`),
  CONSTRAINT `fk_galeri_uji` FOREIGN KEY (`id_uji_kompetensi`)
    REFERENCES `uji_kompetensi` (`id_uji_kompetensi`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
