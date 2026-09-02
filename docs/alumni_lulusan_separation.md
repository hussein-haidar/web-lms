# Dokumentasi Pemisahan Tabel Alumni dan Lulusan

## 🎯 Tujuan
Memisahkan tabel `alumni` dan `lulusan` untuk menghindari konflik data dan struktur yang berbeda.

## 📊 Struktur Tabel

### 1. Tabel `alumni` (Baru)
- **Tujuan:** Data alumni untuk keperluan portofolio dan showcase
- **Controller:** `Home_website.php` method `lulusan()`
- **Model:** `M_alumni.php`
- **View:** `frontend/web/v_lulusan.php`

**Kolom Utama:**
```sql
- id (Primary Key, Auto-increment)
- nama (Nama alumni/portofolio)
- deskripsi (Deskripsi bisnis/portofolio)
- kategori (Kategori: Percetakan & Desain, dll)
- lokasi (Lokasi bisnis)
- foto_profil (Foto profil opsional)
- gambar (Path gambar utama - auto generate)
- folder_galeri (Folder galeri - auto generate)
- gambar_pattern (Pattern penamaan file - auto generate)
- facebook_url, tiktok_url, whatsapp_url (Social media)
- galeri (JSON data galeri foto)
- warna_tema (Warna tema UI)
- status (aktif/nonaktif)
```

### 2. Tabel `lulusan` (Existing)
- **Tujuan:** Data akademik lulusan resmi LPK
- **Model:** `M_lulusan.php`
- **Tidak ada controller yang aktif saat ini**

**Kolom Utama:**
```sql
- id_lulusan (Primary Key)
- nama_lulusan (Nama lengkap lulusan)
- nisn, nik (Data identitas)
- tempat_lahir, tanggal_lahir (Data pribadi)
- alamat, no_hp, email (Kontak)
- nama_kursus, tahun_lulus (Data akademik)
- predikat, nilai_akhir (Hasil belajar)
- foto_lulusan (Foto resmi)
- status_pekerjaan, nama_perusahaan, jabatan (Karir)
```

## 🔄 Proses Migrasi

### Step 1: Jalankan Migration
```sql
-- Jalankan file: 002_create_alumni_table.sql
```

### Step 2: Verifikasi Data
```sql
-- Cek data alumni
SELECT * FROM alumni;

-- Cek data lulusan
SELECT * FROM lulusan;
```

### Step 3: Test Functionality
- Akses halaman: `/home_website/lulusan`
- Pastikan data alumni tampil dengan gambar yang benar
- Pastikan path gambar auto-generate berjalan

## 🚀 Fitur Auto-Generate Path

### Pattern Mapping:
- **FLATO** → `pwk/flato/d(1-6).jpg`
- **Nusa Karya** → `pwk/nusa_karya/n(1-6).jpg`
- **DOOP** → `pwk/doop/k(1-6).jpg`
- **Custom** → Auto-generate dari nama alumni

### Fallback System:
1. Gunakan `gambar_pattern` jika ada
2. Gunakan `folder_galeri` + generate pattern
3. Generate dari nama alumni

## 📝 Catatan Penting

1. **Tidak ada data loss** - Data lulusan asli tetap utuh di tabel `lulusan`
2. **Backward compatible** - View tetap bisa handle data lama
3. **Independent systems** - Alumni dan lulusan bisa dikembangkan terpisah
4. **Auto-increment enabled** - Tabel alumni pakai ID auto-increment

## 🔧 Maintenance

### Menambah Alumni Baru:
```php
$alumniModel = new \App\Models\M_alumni();
$data = [
    'nama' => 'Nama Alumni Baru',
    'deskripsi' => 'Deskripsi portofolio',
    'kategori' => 'Percetakan & Desain',
    // ... field lainnya
];
$alumniModel->addAlumniWithPaths($data); // Auto-generate paths
```

### Update Data Alumni:
```php
$alumniModel->updateAlumni($id, $data);
```

### Hapus Alumni:
```php
$alumniModel->deleteAlumni($id); // Auto-hapus files
```

## ✅ Status Selesai

- [x] Migration tabel alumni terpisah
- [x] Update model M_alumni
- [x] Controller sudah menggunakan model yang benar
- [x] View sudah kompatibel
- [x] Auto-generate path berjalan
- [x] Tidak ada konflik data

Sistem sekarang sudah terpisah dan tidak ada lagi konflik antara data alumni (portofolio) dan data lulusan (akademik).
