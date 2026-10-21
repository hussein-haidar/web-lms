<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home_website');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);


// ============================================================================
// 👑 SUPERADMIN ROUTES (Direct routes for testing)
// ============================================================================
$routes->group(
    'home_superadmin',
    ['filter' => 'filter_superadmin'],
    function ($routes) {
        // Dashboard
        $routes->get('/', 'Home_superadmin::index');
        $routes->get('index', 'Home_superadmin::index');
        $routes->get('home_superadmin', 'Home_superadmin::index');
        $routes->get('home_superadmin/index', 'Home_superadmin::index');
        
        // Web Management
        $routes->get('web', 'Home_superadmin::web');
        $routes->get('add_web', 'Home_superadmin::add_web');
        $routes->post('save_web', 'Home_superadmin::save_web');
        $routes->get('edit_web/(:num)', 'Home_superadmin::edit_web/$1');
        $routes->post('update_web/(:num)', 'Home_superadmin::update_web/$1');
        $routes->get('deleted_web/(:num)', 'Home_superadmin::deleted_web/$1');
        
        // Backup
        $routes->get('backup_db', 'Home_superadmin::backup_db');
        $routes->post('proses_db', 'Home_superadmin::proses_db');
        $routes->get('download_backup/(:segment)', 'Home_superadmin::download_backup/$1');
        $routes->get('deleted_backup/(:segment)', 'Home_superadmin::deleted_backup/$1');
        
        // Profil
        $routes->get('profil', 'Home_superadmin::profil');
        $routes->get('edit_profil', 'Home_superadmin::edit_profil');
        $routes->post('update_profil', 'Home_superadmin::update_profil');
        
        // Program
        $routes->get('program', 'Home_superadmin::program');
        $routes->get('add_program', 'Home_superadmin::add_program');
        $routes->post('save_program', 'Home_superadmin::save_program');
        $routes->get('edit_program/(:num)', 'Home_superadmin::edit_program/$1');
        $routes->post('update_program/(:num)', 'Home_superadmin::update_program/$1');
        $routes->get('deleted_program/(:num)', 'Home_superadmin::deleted_program/$1');

        // --- KURSUS (Management) ---
        $routes->get('kursus', 'Home_superadmin::kursus_admin');
        $routes->get('add_kursus', 'Home_superadmin::add_kursus');
        $routes->post('save_kursus', 'Home_superadmin::save_kursus');
        $routes->get('edit_kursus/(:num)', 'Home_superadmin::edit_kursus/$1');
        $routes->post('update_kursus/(:num)', 'Home_superadmin::update_kursus/$1');
        $routes->get('deleted_kursus/(:num)', 'Home_superadmin::deleted_kursus/$1');
        $routes->get('restore_kursus/(:num)', 'Home_superadmin::restore_kursus/$1');
        $routes->get('force_delete_kursus/(:num)', 'Home_superadmin::force_delete_kursus/$1');
        $routes->get('kursus_deleted', 'Home_superadmin::kursus_deleted');

        // --- MODUL (Management) ---
        $routes->get('modul/(:num)', 'Home_superadmin::modul/$1');
        $routes->get('add_modul', 'Home_superadmin::add_modul');
        $routes->get('add_modul/(:num)', 'Home_superadmin::add_modul/$1');
        $routes->post('save_modul', 'Home_superadmin::save_modul');
        $routes->get('edit_modul/(:num)', 'Home_superadmin::edit_modul/$1');
        $routes->post('update_modul/(:num)', 'Home_superadmin::update_modul/$1');
        $routes->get('delete_modul/(:num)', 'Home_superadmin::delete_modul/$1');

        // --- MATERI (Management) ---
        $routes->get('materi/(:num)', 'Home_superadmin::materi/$1');
        $routes->get('add_materi', 'Home_superadmin::add_materi');
        $routes->get('add_materi/(:num)', 'Home_superadmin::add_materi/$1');
        $routes->post('save_materi', 'Home_superadmin::save_materi');
        $routes->get('edit_materi/(:num)', 'Home_superadmin::edit_materi/$1');
        $routes->post('update_materi/(:num)', 'Home_superadmin::update_materi/$1');
        $routes->get('delete_materi/(:num)', 'Home_superadmin::delete_materi/$1');

        // --- PAKET KURSUS ---
        $routes->get('paket_kursus', 'Home_superadmin::paket_kursus');
        $routes->get('add_paket', 'Home_superadmin::add_paket');
        $routes->post('save_paket', 'Home_superadmin::save_paket');
        $routes->get('edit_paket/(:num)', 'Home_superadmin::edit_paket/$1');
        $routes->post('update_paket/(:num)', 'Home_superadmin::update_paket/$1');
        $routes->get('delete_paket/(:num)', 'Home_superadmin::delete_paket/$1');
        $routes->get('restore_paket/(:num)', 'Home_superadmin::restore_paket/$1');
        $routes->get('force_delete_paket/(:num)', 'Home_superadmin::force_delete_paket/$1');
        $routes->get('paket_kursus_deleted', 'Home_superadmin::paket_kursus_deleted');

        // --- POSTINGAN ---
        $routes->get('postingan_admin', 'Home_superadmin::postingan_admin');
        $routes->get('postingan_create', 'Home_superadmin::postingan_create');
        $routes->post('postingan_save', 'Home_superadmin::postingan_save');
        $routes->get('postingan_edit/(:num)', 'Home_superadmin::postingan_edit/$1');
        $routes->post('postingan_update/(:num)', 'Home_superadmin::postingan_update/$1');
        $routes->get('postingan_delete/(:num)', 'Home_superadmin::postingan_delete/$1');
        $routes->get('postingan_restore/(:num)', 'Home_superadmin::postingan_restore/$1');
        $routes->get('postingan_permanent_delete/(:num)', 'Home_superadmin::postingan_permanent_delete/$1');
        $routes->get('postingan_deleted', 'Home_superadmin::postingan_deleted');

        // --- KARYAWAN MANAGEMENT ---
        $routes->get('karyawan', 'Home_superadmin::karyawan');
        $routes->get('add_karyawan', 'Home_superadmin::add_karyawan');
        $routes->post('save_karyawan', 'Home_superadmin::save_karyawan');
        $routes->get('edit_karyawan/(:num)', 'Home_superadmin::edit_karyawan/$1');
        $routes->post('update_karyawan/(:num)', 'Home_superadmin::update_karyawan/$1');
        $routes->get('deleted_karyawan/(:num)', 'Home_superadmin::deleted_karyawan/$1');
        $routes->get('restore_karyawan/(:num)', 'Home_superadmin::restore_karyawan/$1');
        $routes->get('force_delete_karyawan/(:num)', 'Home_superadmin::force_delete_karyawan/$1');
        $routes->get('karyawan_deleted', 'Home_superadmin::karyawan_deleted');
       
        // --- SLIDER PROMO ---
        $routes->get('slider_promo', 'Home_superadmin::slider_promo');
        $routes->get('add_slider_promo', 'Home_superadmin::add_slider_promo');
        $routes->post('save_slider_promo', 'Home_superadmin::save_slider_promo');
        $routes->get('edit_slider_promo/(:num)', 'Home_superadmin::edit_slider_promo/$1');
        $routes->post('update_slider_promo/(:num)', 'Home_superadmin::update_slider_promo/$1');
        $routes->get('deleted_slider_promo/(:num)', 'Home_superadmin::deleted_slider_promo/$1');
        $routes->post('update_order_slider_promo', 'Home_superadmin::update_order_slider_promo');
        $routes->post('toggle_status_slider_promo/(:num)', 'Home_superadmin::toggle_status_slider_promo/$1');

        // --- SLIDER WEB ---
        $routes->get('slider_web', 'Home_superadmin::slider_web');
        $routes->get('add_slider_web', 'Home_superadmin::add_slider_web');
        $routes->post('save_slider_web', 'Home_superadmin::save_slider_web');
        $routes->get('edit_slider_web/(:num)', 'Home_superadmin::edit_slider_web/$1');
        $routes->post('update_slider_web/(:num)', 'Home_superadmin::update_slider_web/$1');
        $routes->get('deleted_slider_web/(:num)', 'Home_superadmin::deleted_slider_web/$1');
        $routes->post('update_order_slider_web', 'Home_superadmin::update_order_slider_web');
        $routes->post('toggle_status_slider_web/(:num)', 'Home_superadmin::toggle_status_slider_web/$1');

        // --- BANK MANAGEMENT ---
        $routes->get('bank', 'Home_superadmin::bank');
        $routes->get('add_bank', 'Home_superadmin::add_bank');
        $routes->post('save_bank', 'Home_superadmin::save_bank');
        $routes->get('edit_bank/(:num)', 'Home_superadmin::edit_bank/$1');
        $routes->post('update_bank/(:num)', 'Home_superadmin::update_bank/$1');
        $routes->get('deleted_bank/(:num)', 'Home_superadmin::deleted_bank/$1');
        $routes->get('restore_bank/(:num)', 'Home_superadmin::restore_bank/$1');
        $routes->get('force_delete_bank/(:num)', 'Home_superadmin::force_delete_bank/$1');
        $routes->get('bank_deleted', 'Home_superadmin::bank_deleted');

        // --- UJI KOMPETENSI MANAGEMENT ---
        $routes->get('uji_kompetensi', 'Home_superadmin::uji_kompetensi');
        $routes->get('add_uji_kompetensi', 'Home_superadmin::add_uji_kompetensi');
        $routes->post('save_uji_kompetensi', 'Home_superadmin::save_uji_kompetensi');
        $routes->get('edit_uji_kompetensi/(:num)', 'Home_superadmin::edit_uji_kompetensi/$1');
        $routes->post('update_uji_kompetensi/(:num)', 'Home_superadmin::update_uji_kompetensi/$1');
        $routes->get('deleted_uji_kompetensi/(:num)', 'Home_superadmin::deleted_uji_kompetensi/$1');

        // --- GALERI UJI KOMPETENSI MANAGEMENT ---
        $routes->get('galeri_uji_kompetensi', 'Home_superadmin::galeri_uji_kompetensi');
        $routes->get('add_galeri_uji_kompetensi', 'Home_superadmin::add_galeri_uji_kompetensi');
        $routes->post('save_galeri_uji_kompetensi', 'Home_superadmin::save_galeri_uji_kompetensi');
        $routes->get('deleted_galeri_uji_kompetensi/(:num)', 'Home_superadmin::deleted_galeri_uji_kompetensi/$1');

        // --- STATS MANAGEMENT ---
        $routes->get('stats', 'Home_superadmin::stats');
        $routes->get('stats/add', 'Home_superadmin::stats_add');
        $routes->post('stats/save', 'Home_superadmin::stats_save');
        $routes->get('stats/edit/(:num)', 'Home_superadmin::stats_edit/$1');
        $routes->post('stats/update/(:num)', 'Home_superadmin::stats_update/$1');
        $routes->get('stats/delete/(:num)', 'Home_superadmin::stats_delete/$1');
        $routes->get('stats/toggle/(:num)', 'Home_superadmin::stats_toggle/$1');
        $routes->get('stats/api', 'Home_superadmin::stats_getStats');

        
        // --- ALUMNI MANAGEMENT ---
        $routes->get('alumni', 'Home_superadmin::alumni');
        $routes->group('alumni', ['filter' => 'filter_superadmin'], function ($routes) {
            $routes->get('/', '\App\Controllers\Admin\Alumni::index');
            $routes->get('create', '\App\Controllers\Admin\Alumni::create');
            $routes->post('store', '\App\Controllers\Admin\Alumni::store');
            $routes->get('edit/(:num)', '\App\Controllers\Admin\Alumni::edit/$1');
            $routes->post('update/(:num)', '\App\Controllers\Admin\Alumni::update/$1');
            $routes->get('delete/(:num)', '\App\Controllers\Admin\Alumni::delete/$1');
        });
        
        // --- MITRA KERJA MANAGEMENT ---
        $routes->get('mitra_kerja', 'Home_superadmin::mitra_kerja');
        $routes->get('add_mitra_kerja', 'Home_superadmin::add_mitra_kerja');
        $routes->post('save_mitra_kerja', 'Home_superadmin::save_mitra_kerja');
        $routes->get('edit_mitra_kerja/(:num)', 'Home_superadmin::edit_mitra_kerja/$1');
        $routes->post('update_mitra_kerja/(:num)', 'Home_superadmin::update_mitra_kerja/$1');
        $routes->get('deleted_mitra_kerja/(:num)', 'Home_superadmin::deleted_mitra_kerja/$1');
        $routes->get('restore_mitra_kerja/(:num)', 'Home_superadmin::restore_mitra_kerja/$1');
        $routes->get('force_delete_mitra_kerja/(:num)', 'Home_superadmin::force_delete_mitra_kerja/$1');
        $routes->get('mitra_kerja_deleted', 'Home_superadmin::mitra_kerja_deleted');

        // --- MANAJEMEN CRUD ---
        $routes->get('manajemen', 'Home_superadmin::manajemen');
        $routes->get('create_manajemen', 'Home_superadmin::create_manajemen');
        $routes->post('save_manajemen', 'Home_superadmin::save_manajemen');
        $routes->get('edit_manajemen/(:num)', 'Home_superadmin::edit_manajemen/$1');
        $routes->post('update_manajemen/(:num)', 'Home_superadmin::update_manajemen/$1');
        $routes->get('delete_manajemen/(:num)', 'Home_superadmin::delete_manajemen/$1');

        // --- INSTRUKTUR CRUD ---
        $routes->get('instruktur', 'Home_superadmin::instruktur');
        $routes->get('create_instruktur', 'Home_superadmin::create_instruktur');
        $routes->post('save_instruktur', 'Home_superadmin::save_instruktur');
        $routes->get('edit_instruktur/(:num)', 'Home_superadmin::edit_instruktur/$1');
        $routes->post('update_instruktur/(:num)', 'Home_superadmin::update_instruktur/$1');
        $routes->get('delete_instruktur/(:num)', 'Home_superadmin::delete_instruktur/$1');

        // --- PROFIL LPK CRUD ---
        $routes->get('profil_lpk', 'Home_superadmin::profil_lpk');
        $routes->get('create_profil', 'Home_superadmin::create_profil');
        $routes->post('save_profil', 'Home_superadmin::save_profil');
        $routes->get('edit_profil/(:num)', 'Home_superadmin::edit_profil_lpk/$1');
        $routes->post('update_profil/(:num)', 'Home_superadmin::update_profil_lpk/$1');
        $routes->get('delete_profil/(:num)', 'Home_superadmin::delete_profil/$1');

        // --- VISI & MISI CRUD ---
        $routes->get('visi_misi', 'Home_superadmin::visi_misi');
        $routes->get('create_visi_misi', 'Home_superadmin::create_visi_misi');
        $routes->post('save_visi_misi', 'Home_superadmin::save_visi_misi');
        $routes->get('edit_visi_misi/(:num)', 'Home_superadmin::edit_visi_misi/$1');
        $routes->post('update_visi_misi/(:num)', 'Home_superadmin::update_visi_misi/$1');
        $routes->get('delete_visi_misi/(:num)', 'Home_superadmin::delete_visi_misi/$1');

        // --- BANK SOAL MANAGEMENT ---
        $routes->get('bank_soal', 'Home_superadmin::bank_soal');
        $routes->get('bank_soal/(:num)', 'Home_superadmin::bank_soal/$1');
        $routes->get('add_bank_soal/(:num)', 'Home_superadmin::add_bank_soal/$1');
        $routes->post('save_bank_soal', 'Home_superadmin::save_bank_soal');
        $routes->get('edit_bank_soal/(:num)', 'Home_superadmin::edit_bank_soal/$1');
        $routes->post('update_bank_soal/(:num)', 'Home_superadmin::update_bank_soal/$1');
        $routes->get('delete_bank_soal/(:num)', 'Home_superadmin::delete_bank_soal/$1');
        $routes->post('import_bank_soal', 'Home_superadmin::import_bank_soal');

        // --- GRADEBOOK ---
        $routes->get('gradebook', 'Home_superadmin::gradebook');
        $routes->get('gradebook/(:num)', 'Home_superadmin::gradebook_detail/$1');

        // --- BACKUP ---
        $routes->get('backup', 'BackupController::index');
        $routes->post('backup/create', 'BackupController::create');
        $routes->get('backup/download/(:segment)', 'BackupController::download/$1');
        $routes->post('backup/delete/(:segment)', 'BackupController::delete/$1');
    }
);

// --- WEB ---
$routes->get('/', 'Home_website::index');
$routes->get('home_website/index', 'Home_website::index');
$routes->get('home_website/program_cfk', 'Home_website::program_cfk');
$routes->get('home_website/program_setahun', 'Home_website::program_setahun');
$routes->get('home_website/program_singkat', 'Home_website::program_singkat');
$routes->get('home_website/detail_program', 'Home_website::detail_program');
$routes->get('home_website/detail_program/(:any)', 'Home_website::detail_program/$1');
$routes->get('detail_program', 'Home_website::detail_program');
$routes->get('detail_program/(:any)', 'Home_website::detail_program/$1');
// ✅ Route list paket offline
$routes->get('home_website/kls_offline', 'Home_website::kls_offline');
$routes->get('home_website/detail_kelas/(:any)', 'Home_website::detail_kelas/$1');
// ✅ Route detail paket - tambahkan parameter (:num) atau (:any)
$routes->get('home_website/detail_offline/(:any)', 'Home_website::detail_offline/$1');
$routes->get('home_website/detail_program_a', 'Home_website::detail_program_a');
$routes->get('home_website/detail_program_a/(:any)', 'Home_website::detail_program_a/$1');
$routes->get('home_website/detail_program_b', 'Home_website::detail_program_b');
$routes->get('home_website/detail_program_b/(:any)', 'Home_website::detail_program_b/$1');
$routes->get('home_website/uji_kompetensi', 'Home_website::uji_kompetensi');
$routes->get('uji_kompetensi', 'Home_website::uji_kompetensi');
$routes->get('uji_kompetensi/detail/(:num)', 'Home_website::detail_uji_kompetensi/$1');
$routes->get('home_website/alumni', 'Home_website::alumni');
$routes->get('alumni_show', 'Home_website::alumni');
$routes->get('home_website/teach_factory', 'Home_website::teach_factory');
$routes->get('home_website/kontak', 'Home_website::kontak');
$routes->get('home_website/kontak_saran', 'Home_website::kontak');
$routes->post('home_website/simpan_saran', 'Home_website::simpan_saran');
$routes->get('home_website/sejarah', 'Home_website::sejarah');
$routes->get('home_website/galeri', 'Home_website::galeri');
$routes->get('home_website/pencarian', 'Home_website::pencarian');

//store
$routes->get('home_website/kls_online', 'Home_website::kls_online');
//routes->get('home_website/detail_online/(:num)', 'Home_website::detail_online/$1');
$routes->get('home_website/detail_online/(:any)', 'Home_website::detail_online/$1');
// Catatan: alur store lama (cart/checkout/status_bayar/riwayat_beli di Home_website)
// telah dimigrasi penuh ke Home_siswa & Siswa\CartSiswa (lihat group home_siswa & siswa).

// Route untuk Login Superadmin
$routes->get('auth_login/superadmin', 'Auth_login::login_superadmin'); // Redirect route for compatibility
$routes->get('auth_login/login_superadmin', 'Auth_login::login_superadmin');
$routes->post('auth_login/cek_login_superadmin', 'Auth_login::cek_login_superadmin');
$routes->get('auth_login/lupa_password_superadmin', 'Auth_login::lupa_password_superadmin');
$routes->post('auth_login/proses_lupa_password_superadmin', 'Auth_login::proses_lupa_password_superadmin');
$routes->get('auth_login/reset_password_superadmin/(:num)', 'Auth_login::reset_password_superadmin/$1');
$routes->post('auth_login/logout_superadmin', 'Auth_login::logout_superadmin');

$routes->get('auth_login/login_karyawan', 'Auth_login::login_karyawan');
$routes->post('auth_login/cek_login_karyawan', 'Auth_login::cek_login_karyawan');
$routes->get('auth_login/lupa_password_karyawan', 'Auth_login::lupa_password_karyawan');
$routes->post('auth_login/proses_lupa_password_karyawan', 'Auth_login::proses_lupa_password_karyawan');
$routes->get('auth_login/reset_password_karyawan/(:num)', 'Auth_login::reset_password_karyawan/$1');
$routes->post('auth_login/logout_karyawan', 'Auth_login::logout_karyawan');

// --- PENDAFTARAN ---
$routes->get('auth_login/register_siswa', 'Auth_login::register_siswa');
$routes->post('auth_login/proses_register', 'Auth_login::proses_register');

$routes->get('auth_login/login_siswa', 'Auth_login::login_siswa');
$routes->post('auth_login/cek_login_siswa', 'Auth_login::cek_login_siswa');
$routes->get('auth_login/lupa_password_siswa', 'Auth_login::lupa_password_siswa');
$routes->post('auth_login/proses_lupa_password_siswa', 'Auth_login::proses_lupa_password_siswa');
$routes->get('auth_login/reset_password_siswa/(:any)', 'Auth_login::reset_password_siswa/$1');
$routes->post('auth_login/reset_password_siswa/(:any)', 'Auth_login::reset_password_siswa/$1');
$routes->post('auth_login/logout_siswa', 'Auth_login::logout_siswa');

// ============================================================================
// 👥 HOME KARYAWAN (SHARED)
// ============================================================================
$routes->group('home_karyawan', ['filter' => 'filter_karyawan'], function ($routes) {
    $routes->get('profil', 'Home_karyawan::profil');
    $routes->get('edit_profil/', 'Home_karyawan::edit_profil/');
    $routes->post('update_profil/', 'Home_karyawan::update_profil/');
    $routes->get('detail_kursus/(:num)', 'Home_karyawan::detail_kursus/$1');
    $routes->get('get_text_content/(:num)', 'Home_karyawan::get_text_content/$1');
});

// ============================================================================
// 🏢 STAF ADMIN ROUTES
// ============================================================================
$routes->group('home_karyawan', ['filter' => 'filter_staf'], function ($routes) {
    $routes->get('home_staf', 'Home_karyawan::home_staf');
    $routes->get('/', 'Home_karyawan::home_staf');

    // --- SISWA MANAGEMENT ---
    $routes->get('siswa_admin', 'Home_karyawan::siswa_admin');
    $routes->get('add_siswa', 'Home_karyawan::add_siswa');
    $routes->post('save_siswa', 'Home_karyawan::save_siswa');
    $routes->get('edit_siswa/(:num)', 'Home_karyawan::edit_siswa/$1');
    $routes->post('update_siswa/(:num)', 'Home_karyawan::update_siswa/$1');
    $routes->get('deleted_siswa/(:num)', 'Home_karyawan::deleted_siswa/$1');
    $routes->get('restore_siswa/(:num)', 'Home_karyawan::restore_siswa/$1');
    $routes->get('force_delete_siswa/(:num)', 'Home_karyawan::force_delete_siswa/$1');

    // --- PENDAFTARAN ---
    $routes->get('pendaftaran', 'Home_karyawan::pendaftaran');
    $routes->get('edit_daftar/(:num)', 'Home_karyawan::edit_daftar/$1');
    $routes->post('update_daftar/(:num)', 'Home_karyawan::update_daftar/$1');
    $routes->get('update_status_pendaftaran/(:num)', 'Home_karyawan::update_status_pendaftaran/$1');
    $routes->post('simpan_daftar', 'Home_karyawan::simpan_daftar');
    $routes->get('hapus_daftar/(:num)', 'Home_karyawan::hapus_daftar/$1');
    $routes->get('pembayaran', 'Home_karyawan::pembayaran');
    $routes->post('konfirmasi/(:num)', 'Home_karyawan::konfirmasi/$1');
    $routes->get('pembayaran/detail/(:num)', 'Home_karyawan::detail/$1');

    // --- NOTIFICATIONS ---
    $routes->get('check_notification_count', 'Home_karyawan::check_notification_count');
    $routes->get('check_payment_updates', 'Home_karyawan::check_payment_updates');
});

// ============================================================================
// 🎓 PENGAJAR ROUTES
// ============================================================================
$routes->group('home_karyawan', ['filter' => 'filter_pengajar'], function ($routes) {
    $routes->get('home_pengajar', 'Home_karyawan::home_pengajar');
    $routes->get('pengajar', 'Home_karyawan::pengajar');
    $routes->get('kursus_saya', 'Home_karyawan::kursus_pengajar'); // Ubah dari v_kursus
    $routes->get('kursus_pengajar', 'Home_karyawan::kursus_pengajar');
    $routes->get('detail_kursus/(:num)', 'Home_karyawan::detail_kursus/$1');
    $routes->get('siswa_pengajar', 'Home_karyawan::siswa_pengajar');
    $routes->get('tugas', 'Home_karyawan::tugas');
    $routes->get('add_tugas', 'Home_karyawan::add_tugas');
    $routes->post('save_tugas', 'Home_karyawan::save_tugas');
    $routes->get('edit_tugas/(:num)', 'Home_karyawan::edit_tugas/$1');
    $routes->post('update_tugas/(:num)', 'Home_karyawan::update_tugas/$1');
    $routes->get('deleted_tugas/(:num)', 'Home_karyawan::deleted_tugas/$1');
    $routes->get('v_kumpul_tugas', 'Home_karyawan::v_kumpul_tugas');
    $routes->post('update_kumpul/(:num)', 'Home_karyawan::update_kumpul/$1');
    $routes->get('quiz/(:num)', 'Home_karyawan::quiz/$1');
    $routes->get('kerjakan/(:num)', 'Home_karyawan::kerjakan/$1');
    $routes->post('submit', 'Home_karyawan::submit');
    $routes->get('hasil/(:num)', 'Home_karyawan::hasil/$1');
    $routes->get('retry/(:num)', 'Home_karyawan::retry/$1');
    $routes->post('update_progress', 'Home_karyawan::update_progress');
    $routes->get('quiz_management', 'Home_karyawan::quiz_management');
    $routes->get('add_quiz', 'Home_karyawan::add_quiz');
    $routes->post('save_quiz', 'Home_karyawan::save_quiz');
    $routes->get('edit_quiz/(:num)', 'Home_karyawan::edit_quiz/$1');
    $routes->post('update_quiz/(:num)', 'Home_karyawan::update_quiz/$1');
    $routes->get('delete_quiz/(:num)', 'Home_karyawan::delete_quiz/$1');
    $routes->get('quiz_stats/(:num)', 'Home_karyawan::quiz_stats/$1');
    $routes->get('sertifikat', 'Home_karyawan::sertifikat');
    $routes->get('generate/(:num)', 'Home_karyawan::generate/$1');
    $routes->get('diskusi/(:num)', 'Home_karyawan::diskusi/$1');
    $routes->post('save_diskusi', 'Home_karyawan::save_diskusi');
    $routes->get('diskusi/show/(:segment)', 'Home_karyawan::show/$1');
    $routes->post('diskusi/komentar/(:num)', 'Home_karyawan::add_komentar/$1');
    $routes->post('diskusi/like/(:num)/(:segment)', 'Home_karyawan::like_komentar/$1/$2');
    $routes->post('diskusi/solution/(:num)/(:segment)', 'Home_karyawan::set_solution/$1/$2');
    $routes->get('diskusi/pin/(:num)', 'Home_karyawan::toggle_pin/$1');
    $routes->get('diskusi/lock/(:num)', 'Home_karyawan::toggle_lock/$1');
    $routes->get('diskusi/search', 'Home_karyawan::search');
    $routes->get('mentor_unanswered', 'Home_karyawan::mentor_unanswered');
});

// ============================================================================
// 🛠️ TEKNISI ROUTES
// ============================================================================
$routes->group('home_karyawan', ['filter' => 'filter_teknisi'], function ($routes) {
    $routes->get('home_teknisi', 'Home_karyawan::home_teknisi');
    $routes->get('inventory', 'Home_karyawan::inventory');
    $routes->get('add_inventory', 'Home_karyawan::add_inventory');
    $routes->post('save_inventory', 'Home_karyawan::save_inventory');
    $routes->get('edit_inventory/(:num)', 'Home_karyawan::edit_inventory/$1');
    $routes->post('update_inventory/(:num)', 'Home_karyawan::update_inventory/$1');
    $routes->get('delete_inventory/(:num)', 'Home_karyawan::delete_inventory/$1');
    $routes->get('search_inventory', 'Home_karyawan::search_inventory');
});

// 🔓 Public Karyawan Routes (with staf filter)
$routes->get('home_karyawan/riwayat_bayar', 'Home_karyawan::riwayat_bayar', ['filter' => 'filter_staf']);
$routes->get('home_karyawan/verify', 'Home_karyawan::verify', ['filter' => 'filter_staf']);
$routes->get('home_karyawan/verify/(:num)', 'Home_karyawan::verify/$1', ['filter' => 'filter_staf']);
$routes->get('home_karyawan/download/(:num)', 'Home_karyawan::download/$1', ['filter' => 'filter_staf']);

// Standalone home_staf route (with filter)
$routes->get('home_staf', 'Home_karyawan::home_staf', ['filter' => 'filter_staf']);

// ============================================================================
// 👥 HOME SISWA - DASHBOARD & PROFIL
// ============================================================================
$routes->group('home_siswa', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'Home_siswa::index');
    $routes->get('index', 'Home_siswa::index');
    $routes->get('profil', 'Home_siswa::profil');
    $routes->get('edit_profil', 'Home_siswa::edit_profil');
    $routes->post('update_profil', 'Home_siswa::update_profil');
    $routes->get('ganti-password', 'Home_siswa::ganti_password');
    $routes->post('update-password', 'Home_siswa::update_password');
    $routes->post('update_progres', 'Home_siswa::update_progres'); // Add this line
    $routes->get('cart', 'Home_siswa::cart');
    $routes->post('save_cart', 'Home_siswa::save_cart');
    $routes->get('delete_cart/(:num)', 'Home_siswa::delete_cart/$1');
    $routes->match(['GET', 'POST'], 'checkout_noncart', 'Home_siswa::checkout_noncart');
    $routes->get('checkout_direct/(:num)', 'Home_siswa::checkout_direct/$1');
    $routes->post('save_checkout_noncart', 'Home_siswa::save_checkout_noncart');
    $routes->get('upload_bukti/(:num)', 'Home_siswa::upload_bukti/$1');
    $routes->post('proses_upload', 'Home_siswa::proses_upload');
    $routes->match(['GET', 'POST'], 'checkout_cart', 'Home_siswa::checkout_cart');
    $routes->post('save_checkout', 'Home_siswa::save_checkout');
    $routes->get('status_bayar', 'Home_siswa::status_bayar');
    $routes->get('check_payment_status', 'Home_siswa::check_payment_status');
    $routes->get('reset_payment_tracking', 'Home_siswa::reset_payment_tracking');
    $routes->get('riwayat_beli', 'Home_siswa::riwayat_beli');
    $routes->get('kursus_saya', 'Home_siswa::kursus_saya'); // Ubah dari v_kursus
    $routes->get('kursus/detail/(:num)', 'Home_siswa::detail_kursus/$1');
    $routes->get('v_tugas', 'Home_siswa::v_tugas');
    $routes->get('detail_kelas_saya/(:num)', 'Home_siswa::detail_kelas_saya/$1');
    $routes->get('belajar/(:num)', 'Home_siswa::belajar/$1');
    $routes->get('belajar/(:num)/(:num)', 'Home_siswa::belajar/$1/$2');
    $routes->get('kumpul_tugas', 'Home_siswa::kumpul_tugas');
    $routes->get('add_kumpul', 'Home_siswa::add_kumpul');
    $routes->post('save_kumpul', 'Home_siswa::save_kumpul');
    $routes->get('edit_kumpul/(:num)', 'Home_siswa::edit_kumpul/$1');
    $routes->post('update_kumpul/(:num)', 'Home_siswa::update_kumpul/$1');
    $routes->get('deleted_kumpul_tugas/(:num)', 'Home_siswa::deleted_kumpul_tugas/$1');
    $routes->get('hasil/(:num)', 'Home_siswa::hasil/$1');
});

$routes->group('home_siswa/kursus', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'Home_siswa::kursus_saya'); // Ubah dari v_kursus
    $routes->get('tersedia', 'Home_siswa::kursus_tersedia');
    $routes->get('detail/(:num)', 'Home_siswa::detail_kursus/$1');
    $routes->get('saya', 'Home_siswa::kursus_saya');
    $routes->get('saya/(:num)', 'Home_siswa::akses_kursus/$1');
    $routes->get('saya/(:num)/modul/(:num)', 'Home_siswa::akses_modul/$1/$2');
    $routes->get('materi/(:num)', 'Home_siswa::view_materi/$1');
});

$routes->group('home_siswa/pendaftaran', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('baru/(:num)', 'Home_siswa::form_daftar/$1');
    $routes->post('simpan', 'Home_siswa::simpan_pendaftaran');
    $routes->get('riwayat', 'Home_siswa::riwayat_pendaftaran');
    $routes->get('riwayat/(:num)', 'Home_siswa::detail_pendaftaran/$1');
});

$routes->group('home_siswa/progress', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'Home_siswa::progress_dashboard');
    $routes->post('update/(:num)', 'Home_siswa::update_progress/$1');
    $routes->get('nilai', 'Home_siswa::v_nilai');
    $routes->get('nilai/(:num)', 'Home_siswa::detail_nilai/$1');
});

$routes->group('home_siswa/quiz', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('(:num)', 'Home_siswa::quiz/$1');
    $routes->get('kerjakan/(:num)', 'Home_siswa::kerjakan/$1');
    $routes->get('start/(:num)', 'Home_siswa::start/$1');
    $routes->post('submit', 'Home_siswa::submit');
    $routes->get('hasil/(:num)', 'Home_siswa::hasil/$1');
    $routes->post('retry/(:num)', 'Home_siswa::retry/$1');
});

// Route alternatif untuk quiz kerjakan (backup)
$routes->get('home_siswa/kerjakan/(:num)', 'Home_siswa::kerjakan/$1');

$routes->group('home_siswa/tugas', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('(:num)', 'Home_siswa::v_tugas/$1');
    $routes->get('detail/(:num)', 'Home_siswa::detail_tugas/$1');
    $routes->get('kumpul/(:num)', 'Home_siswa::form_kumpul/$1');
    $routes->post('kumpul/simpan', 'Home_siswa::save_kumpul');
    $routes->get('kumpul/edit/(:num)', 'Home_siswa::edit_kumpul/$1');
    $routes->post('kumpul/update/(:num)', 'Home_siswa::update_kumpul/$1');
    $routes->get('kumpul/hapus/(:num)', 'Home_siswa::deleted_kumpul/$1');
    $routes->get('nilai/(:num)', 'Home_siswa::lihat_penilaian/$1');
});

$routes->group('home_siswa/diskusi', ['namespace' => 'App\Controllers\Siswa', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('(:num)', 'DiskusiSiswa::index/$1');
    $routes->get('buat/(:num)', 'DiskusiSiswa::create/$1');
    $routes->post('simpan', 'DiskusiSiswa::store');
    $routes->get('view/(:segment)', 'DiskusiSiswa::show/$1');
    $routes->post('komentar/(:num)', 'DiskusiSiswa::add_komentar/$1');
    $routes->post('like/(:num)/(:segment)', 'DiskusiSiswa::like_komentar/$1/$2');
    $routes->get('search', 'DiskusiSiswa::search');
});

$routes->group('home_siswa/review', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('buat/(:num)', 'Home_siswa::form_review/$1');
    $routes->post('simpan', 'Home_siswa::simpan_review');
    $routes->get('saya', 'Home_siswa::review_saya');
});

$routes->group('home_siswa/notifikasi', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'Home_siswa::notifikasi');
    $routes->get('mark-read/(:num)', 'Home_siswa::mark_read/$1');
    $routes->post('mark-all-read', 'Home_siswa::mark_all_read');
    $routes->get('ajax', 'Home_siswa::ajax_get_notifications');
    $routes->get('count', 'Home_siswa::ajax_notif_count');
    $routes->post('load-more', 'Home_siswa::ajax_load_notifikasi');
});

// ✅ Auto-generate certificates (Superadmin)
$routes->get('admin/auto-generate-certificates', 'Home_superadmin::auto_generate_certificates', ['filter' => 'filter_superadmin']);

// ✅ Dashboard Analytics (Pengajar)
$routes->get('home_karyawan/analytics', 'Home_karyawan::dashboard_analytics', ['filter' => 'filter_pengajar']);

// ✅ Deadline Tugas (Pengajar)
$routes->get('home_karyawan/deadline-tugas', 'Home_karyawan::get_tugas_deadline', ['filter' => 'filter_pengajar']);

// ✅ Learning Path (Siswa)
$routes->group('home_siswa/learning-path', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'Home_siswa::learning_path');
    $routes->get('modul/(:num)', 'Home_siswa::learning_path_modul/$1');
    $routes->get('next', 'Home_siswa::learning_path_next');
});

$routes->group('api/siswa', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->post('progress/materi/(:num)', 'Home_siswa::ajax_update_materi_progress/$1');
    $routes->get('pembayaran/status/(:num)', '\App\Controllers\Siswa\PembayaranController::ajax_status/$1');
    $routes->get('pembayaran/status-check', '\App\Controllers\Siswa\PembayaranController::ajax_status_check');
    $routes->post('pembayaran/snap', '\App\Controllers\Siswa\PembayaranController::create_snap');
    $routes->post('quiz/timer/(:num)', '\App\Controllers\Siswa\QuizController::ajax_timer/$1');
    $routes->get('quiz/timer/(:num)', '\App\Controllers\Siswa\QuizController::ajax_get_timer/$1');
    $routes->post('quiz/timer/reset/(:num)', '\App\Controllers\Siswa\QuizController::ajax_reset_timer/$1');
    $routes->get('jadwal/events', '\App\Controllers\Siswa\JadwalController::ajax_events');
    $routes->get('jadwal/detail/(:num)', '\App\Controllers\Siswa\JadwalController::detail/$1');
});

$routes->group('api/siswa', ['namespace' => 'App\Controllers\Siswa', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('diskusi/komentar/(:num)', 'DiskusiSiswa::ajax_load_komentar/$1');
    $routes->get('chat/unread', 'ChatSiswa::ajax_unread_count');
    $routes->get('chat/messages/(:num)', 'ChatSiswa::ajax_messages/$1');
    $routes->post('chat/send', 'ChatSiswa::send');
    $routes->post('chat/delete/(:num)', 'ChatSiswa::delete_message/$1');
    $routes->post('chat/edit/(:num)', 'ChatSiswa::edit_message/$1');
    $routes->get('chat/search', 'ChatSiswa::search_messages');
    $routes->post('chat/pin/(:num)', 'ChatSiswa::pin_message/$1');
    $routes->post('chat/react/(:num)', 'ChatSiswa::react_message/$1');
    $routes->post('chat/typing', 'ChatSiswa::typing_indicator');
    $routes->get('chat/typing/(:num)', 'ChatSiswa::check_typing/$1');
    $routes->get('chat/export/(:num)', 'ChatSiswa::export_chat/$1');
    $routes->post('chat/online', 'ChatSiswa::update_last_activity');
    $routes->get('chat/online/(:num)', 'ChatSiswa::check_online_status/$1');
});

// Midtrans webhook (no session filter)
$routes->post('home_siswa/pembayaran/midtrans_notification', '\App\Controllers\Siswa\PembayaranController::midtrans_notification');

// ============================================================================
// 💬 CHAT ROUTES (Siswa)
// ============================================================================
$routes->group('home_siswa/chat', ['namespace' => 'App\Controllers\Siswa', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'ChatSiswa::index');
    $routes->get('(:num)', 'ChatSiswa::conversation/$1');
    $routes->get('(:num)/(:segment)', 'ChatSiswa::conversation/$1/$2');
    $routes->post('send', 'ChatSiswa::send');
    $routes->post('delete/(:num)', 'ChatSiswa::delete_message/$1');
    $routes->post('edit/(:num)', 'ChatSiswa::edit_message/$1');
    $routes->get('search', 'ChatSiswa::search_messages');
    $routes->post('pin/(:num)', 'ChatSiswa::pin_message/$1');
    $routes->post('react/(:num)', 'ChatSiswa::react_message/$1');
    $routes->post('typing', 'ChatSiswa::typing_indicator');
    $routes->get('typing/(:num)', 'ChatSiswa::check_typing/$1');
    $routes->get('export/(:num)', 'ChatSiswa::export_chat/$1');
    $routes->post('online', 'ChatSiswa::update_last_activity');
    $routes->get('online/(:num)', 'ChatSiswa::check_online_status/$1');
    $routes->get('sse/(:num)', 'ChatSiswa::sse_chat/$1');
    $routes->get('groups', 'ChatSiswa::groups');
    $routes->post('groups/create', 'ChatSiswa::create_group');
    $routes->get('groups/(:num)', 'ChatSiswa::group_conversation/$1');
    $routes->post('groups/send', 'ChatSiswa::send_group_message');
    $routes->get('groups/sse/(:num)', 'ChatSiswa::sse_group/$1');
    $routes->get('groups/ajax/(:num)', 'ChatSiswa::ajax_group_messages/$1');
});

// ============================================================================
// 📅 JADWAL / KALENDER (Siswa)
// ============================================================================
$routes->group('home_siswa/jadwal', ['namespace' => 'App\Controllers\Siswa', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'JadwalController::index');
    $routes->get('detail/(:num)', 'JadwalController::detail/$1');
});

// ============================================================================
// 📊 EXPORT ROUTES (Staf Admin)
// ============================================================================
$routes->group('home_karyawan/export', ['namespace' => 'App\Controllers\Staf', 'filter' => 'filter_staf'], function ($routes) {
    $routes->get('pembayaran', 'ExportStaf::pembayaran');
    $routes->get('nilai', 'ExportStaf::nilai');
    $routes->get('peserta', 'ExportStaf::peserta');
});

// ============================================================================
// 📝 POSTINGAN ROUTES (Public)
// ============================================================================

// Public Postingan Routes
$routes->get('postingan', 'Home_website::postingan_index');
$routes->get('postingan/detail/(:segment)', 'Home_website::postingan_detail/$1');
$routes->get('postingan/search', 'Home_website::postingan_search');

// ============================================================================
// 🎓 PUBLIC: VERIFIKASI SERTIFIKAT (Tanpa Login)
// ============================================================================
$routes->get('sertifikat/verify', 'Sertifikat::verify_form');
$routes->post('sertifikat/verify', 'Sertifikat::verify');
$routes->get('sertifikat/verify/(:any)', 'Sertifikat::verify/$1');
$routes->get('sertifikat/view/(:num)', 'Sertifikat::view/$1');
$routes->get('verify-sertifikat', 'Home_karyawan::verify');
$routes->get('verify-sertifikat/(:segment)', 'Home_karyawan::verify/$1');

// ============================================================================
// 🎓 SERTIFIKAT ROUTES (Siswa & Admin)
// ============================================================================
$routes->group('sertifikat', ['namespace' => 'App\Controllers\Siswa', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'SertifikatSiswa::index');
    $routes->get('claim/(:num)', 'SertifikatSiswa::claim/$1');
    $routes->get('download/(:num)', 'SertifikatSiswa::download/$1');
    $routes->get('print/(:num)', 'SertifikatSiswa::print/$1');
    $routes->get('view/(:num)', '\App\Controllers\Sertifikat::view/$1');
    $routes->get('verify/(:any)', '\App\Controllers\Sertifikat::verify/$1');
});

// Sertifikat Admin Routes
$routes->group('sertifikat/admin', ['namespace' => 'App\Controllers\Staf', 'filter' => 'filter_staf'], function ($routes) {
    $routes->get('/', 'SertifikatStaf::index');
    $routes->get('create/(:num)', 'SertifikatStaf::create/$1');
    $routes->post('bulk-create', 'SertifikatStaf::bulk_create');
    $routes->get('delete/(:num)', 'SertifikatStaf::delete/$1');
});

// ============================================================================
// 🎓 ALUMNI ROUTES
// ============================================================================

// Public Alumni Routes
$routes->get('alumni', 'Home_website::alumni');

// Admin Alumni Routes
$routes->group('alumni', ['namespace' => 'App\Controllers\Admin', 'filter' => 'filter_superadmin'], function ($routes) {
    $routes->get('create', 'Alumni::create');
    $routes->post('store', 'Alumni::store');
    $routes->get('edit/(:num)', 'Alumni::edit/$1');
    $routes->post('update/(:num)', 'Alumni::update/$1');
    $routes->get('delete/(:num)', 'Alumni::delete/$1');
});

// ============================================================================
// 👑 ADMIN KELOLA DATA ROUTES
// ============================================================================
$routes->group('admin', ['filter' => 'filter_superadmin'], function ($routes) {
    // Postingan
    $routes->get('postingan', 'Admin\Postingan::index');
    $routes->get('postingan/create', 'Admin\Postingan::create');
    $routes->post('postingan/save', 'Admin\Postingan::save');
    $routes->get('postingan/edit/(:num)', 'Admin\Postingan::edit/$1');
    $routes->post('postingan/update/(:num)', 'Admin\Postingan::update/$1');
    $routes->get('postingan/delete/(:num)', 'Admin\Postingan::delete/$1');
    $routes->get('postingan/restore/(:num)', 'Admin\Postingan::restore/$1');
    $routes->get('postingan/permanent-delete/(:num)', 'Admin\Postingan::permanent_delete/$1');
    $routes->get('postingan/deleted', 'Admin\Postingan::deleted');

    // Profil LPK
    $routes->get('profil-lpk', 'Admin\ProfilLpk::index');
    $routes->get('profil-lpk/create', 'Admin\ProfilLpk::create');
    $routes->post('profil-lpk/save', 'Admin\ProfilLpk::save');
    $routes->get('profil-lpk/edit/(:num)', 'Admin\ProfilLpk::edit/$1');
    $routes->post('profil-lpk/update/(:num)', 'Admin\ProfilLpk::update/$1');
    $routes->get('profil-lpk/delete/(:num)', 'Admin\ProfilLpk::delete/$1');

    // Visi Misi
    $routes->get('visi-misi', 'Admin\VisiMisi::index');
    $routes->get('visi-misi/create', 'Admin\VisiMisi::create');
    $routes->post('visi-misi/save', 'Admin\VisiMisi::save');
    $routes->get('visi-misi/edit/(:num)', 'Admin\VisiMisi::edit/$1');
    $routes->post('visi-misi/update/(:num)', 'Admin\VisiMisi::update/$1');
    $routes->get('visi-misi/delete/(:num)', 'Admin\VisiMisi::delete/$1');

    // Uji Kompetensi
    $routes->get('uji-kompetensi', 'Admin\GaleriUjiKompetensi::index');
    $routes->get('uji-kompetensi/create', 'Admin\GaleriUjiKompetensi::create');
    $routes->post('uji-kompetensi/save', 'Admin\GaleriUjiKompetensi::save');
    $routes->get('uji-kompetensi/edit/(:num)', 'Admin\GaleriUjiKompetensi::edit/$1');
    $routes->post('uji-kompetensi/update/(:num)', 'Admin\GaleriUjiKompetensi::update/$1');
    $routes->get('uji-kompetensi/delete/(:num)', 'Admin\GaleriUjiKompetensi::delete/$1');

    // Mitra Kerja
    $routes->get('mitra-kerja', 'Admin\MitraKerja::index');
    $routes->get('mitra-kerja/create', 'Admin\MitraKerja::create');
    $routes->post('mitra-kerja/save', 'Admin\MitraKerja::save');
    $routes->get('mitra-kerja/edit/(:num)', 'Admin\MitraKerja::edit/$1');
    $routes->post('mitra-kerja/update/(:num)', 'Admin\MitraKerja::update/$1');
    $routes->get('mitra-kerja/delete/(:num)', 'Admin\MitraKerja::delete/$1');

    // Manajemen
    $routes->get('manajemen', 'Admin\Manajemen::index');
    $routes->get('manajemen/create', 'Admin\Manajemen::create');
    $routes->post('manajemen/save', 'Admin\Manajemen::save');
    $routes->get('manajemen/edit/(:num)', 'Admin\Manajemen::edit/$1');
    $routes->post('manajemen/update/(:num)', 'Admin\Manajemen::update/$1');
    $routes->get('manajemen/delete/(:num)', 'Admin\Manajemen::delete/$1');

    // Instruktur
    $routes->get('instruktur', 'Admin\Instruktur::index');
    $routes->get('instruktur/create', 'Admin\Instruktur::create');
    $routes->post('instruktur/save', 'Admin\Instruktur::save');
    $routes->get('instruktur/edit/(:num)', 'Admin\Instruktur::edit/$1');
    $routes->post('instruktur/update/(:num)', 'Admin\Instruktur::update/$1');
    $routes->get('instruktur/delete/(:num)', 'Admin\Instruktur::delete/$1');

    // Web Management
    $routes->get('web', 'Admin\WebManagement::web');
    $routes->get('web/add', 'Admin\WebManagement::add_web');
    $routes->post('web/save', 'Admin\WebManagement::save_web');
    $routes->get('web/edit/(:num)', 'Admin\WebManagement::edit_web/$1');
    $routes->post('web/update/(:num)', 'Admin\WebManagement::update_web/$1');
    $routes->get('web/delete/(:num)', 'Admin\WebManagement::delete_web/$1');

    // Program
    $routes->get('program', 'Admin\WebManagement::program');
    $routes->get('program/add', 'Admin\WebManagement::add_program');
    $routes->post('program/save', 'Admin\WebManagement::save_program');
    $routes->get('program/edit/(:num)', 'Admin\WebManagement::edit_program/$1');
    $routes->post('program/update/(:num)', 'Admin\WebManagement::update_program/$1');
    $routes->get('program/delete/(:num)', 'Admin\WebManagement::delete_program/$1');

    // Slider Promo
    $routes->get('slider-promo', 'Admin\WebManagement::slider_promo');
    $routes->get('slider-promo/add', 'Admin\WebManagement::add_slider_promo');
    $routes->post('slider-promo/save', 'Admin\WebManagement::save_slider_promo');
    $routes->get('slider-promo/edit/(:num)', 'Admin\WebManagement::edit_slider_promo/$1');
    $routes->post('slider-promo/update/(:num)', 'Admin\WebManagement::update_slider_promo/$1');
    $routes->get('slider-promo/delete/(:num)', 'Admin\WebManagement::delete_slider_promo/$1');
    $routes->post('slider-promo/update-order', 'Admin\WebManagement::update_order_slider_promo');
    $routes->post('slider-promo/toggle-status/(:num)', 'Admin\WebManagement::toggle_status_slider_promo/$1');

    // Slider Web
    $routes->get('slider-web', 'Admin\WebManagement::slider_web');
    $routes->get('slider-web/add', 'Admin\WebManagement::add_slider_web');
    $routes->post('slider-web/save', 'Admin\WebManagement::save_slider_web');
    $routes->get('slider-web/edit/(:num)', 'Admin\WebManagement::edit_slider_web/$1');
    $routes->post('slider-web/update/(:num)', 'Admin\WebManagement::update_slider_web/$1');
    $routes->get('slider-web/delete/(:num)', 'Admin\WebManagement::delete_slider_web/$1');

    // Bank Soal
    $routes->get('bank-soal', 'Admin\BankSoal::index');
    $routes->get('bank-soal/(:num)', 'Admin\BankSoal::index/$1');
    $routes->get('bank-soal/add/(:num)', 'Admin\BankSoal::add/$1');
    $routes->post('bank-soal/save', 'Admin\BankSoal::save');
    $routes->get('bank-soal/edit/(:num)', 'Admin\BankSoal::edit/$1');
    $routes->post('bank-soal/update/(:num)', 'Admin\BankSoal::update/$1');
    $routes->get('bank-soal/delete/(:num)', 'Admin\BankSoal::delete/$1');
    $routes->post('bank-soal/import', 'Admin\BankSoal::import');
});

// ============================================================================
// 🏢 STAF KELOLA DATA ROUTES
// ============================================================================
$routes->group('staf', ['filter' => 'filter_staf'], function ($routes) {
    // Siswa Management
    $routes->get('siswa', 'Staf\SiswaStaf::index');
    $routes->get('siswa/add', 'Staf\SiswaStaf::add');
    $routes->post('siswa/save', 'Staf\SiswaStaf::save');
    $routes->get('siswa/edit/(:num)', 'Staf\SiswaStaf::edit/$1');
    $routes->post('siswa/update/(:num)', 'Staf\SiswaStaf::update/$1');
    $routes->get('siswa/delete/(:num)', 'Staf\SiswaStaf::deleted/$1');
    $routes->get('siswa/restore/(:num)', 'Staf\SiswaStaf::restore/$1');
    $routes->get('siswa/force-delete/(:num)', 'Staf\SiswaStaf::force_delete/$1');

    // Pendaftaran
    $routes->get('pendaftaran', 'Staf\PendaftaranStaf::index');
    $routes->get('pendaftaran/edit/(:num)', 'Staf\PendaftaranStaf::edit/$1');
    $routes->post('pendaftaran/update/(:num)', 'Staf\PendaftaranStaf::update/$1');
    $routes->post('pendaftaran/update-status/(:num)', 'Staf\PendaftaranStaf::update_status/$1');
    $routes->post('pendaftaran/save', 'Staf\PendaftaranStaf::save');
    $routes->get('pendaftaran/delete/(:num)', 'Staf\PendaftaranStaf::delete/$1');

    // Pembayaran
    $routes->get('pembayaran', 'Staf\PembayaranStaf::index');
    $routes->get('pembayaran/detail/(:num)', 'Staf\PembayaranStaf::detail/$1');
    $routes->post('pembayaran/konfirmasi/(:num)', 'Staf\PembayaranStaf::konfirmasi/$1');
    $routes->get('pembayaran/notification-count', 'Staf\PembayaranStaf::check_notification_count');
    $routes->get('pembayaran/payment-updates', 'Staf\PembayaranStaf::check_payment_updates');

    // Export
    $routes->get('export/pembayaran', 'Staf\ExportStaf::pembayaran');
    $routes->get('export/nilai', 'Staf\ExportStaf::nilai');
    $routes->get('export/peserta', 'Staf\ExportStaf::peserta');

    // Jadwal / Kalender Akademik (staf admin & pengajar)
    $routes->get('jadwal', 'Staf\JadwalStaf::index');
    $routes->get('jadwal/create', 'Staf\JadwalStaf::create');
    $routes->post('jadwal/store', 'Staf\JadwalStaf::store');
    $routes->get('jadwal/edit/(:num)', 'Staf\JadwalStaf::edit/$1');
    $routes->post('jadwal/update/(:num)', 'Staf\JadwalStaf::update/$1');
    $routes->get('jadwal/delete/(:num)', 'Staf\JadwalStaf::delete/$1');
    $routes->get('jadwal/toggle/(:num)', 'Staf\JadwalStaf::toggle/$1');
});

$routes->group('pengajar', ['filter' => 'filter_pengajar'], function ($routes) {
    // Tugas
    $routes->get('tugas', 'Staf\TugasStaf::index');
    $routes->get('tugas/add', 'Staf\TugasStaf::add');
    $routes->post('tugas/save', 'Staf\TugasStaf::save');
    $routes->get('tugas/edit/(:num)', 'Staf\TugasStaf::edit/$1');
    $routes->post('tugas/update/(:num)', 'Staf\TugasStaf::update/$1');
    $routes->get('tugas/delete/(:num)', 'Staf\TugasStaf::delete/$1');
    $routes->get('tugas/kumpul', 'Staf\TugasStaf::kumpul_tugas');
    $routes->post('tugas/grade/(:num)', 'Staf\TugasStaf::grade_kumpul/$1');

    // Quiz
    $routes->get('quiz', 'Staf\QuizStaf::index');
    $routes->get('quiz/add', 'Staf\QuizStaf::add');
    $routes->post('quiz/save', 'Staf\QuizStaf::save');
    $routes->get('quiz/edit/(:num)', 'Staf\QuizStaf::edit/$1');
    $routes->post('quiz/update/(:num)', 'Staf\QuizStaf::update/$1');
    $routes->get('quiz/delete/(:num)', 'Staf\QuizStaf::delete/$1');
    $routes->get('quiz/stats/(:num)', 'Staf\QuizStaf::stats/$1');
});

// ============================================================================
// 👨‍🎓 SISWA KELOLA DATA ROUTES
// ============================================================================
$routes->group('siswa', ['filter' => 'filter_siswa'], function ($routes) {
    // Dashboard
    $routes->get('/', 'Siswa\DashboardSiswa::index');
    $routes->get('dashboard', 'Siswa\DashboardSiswa::index');

    // Profil
    $routes->get('profil', 'Siswa\ProfilSiswa::index');
    $routes->get('profil/edit', 'Siswa\ProfilSiswa::edit');
    $routes->post('profil/update', 'Siswa\ProfilSiswa::update');
    $routes->get('profil/ganti-password', 'Siswa\ProfilSiswa::ganti_password');
    $routes->post('profil/update-password', 'Siswa\ProfilSiswa::update_password');

    // Kursus
    $routes->get('kursus', 'Siswa\KursusSiswa::index');
    $routes->get('kursus/tersedia', 'Siswa\KursusSiswa::tersedia');
    $routes->get('kursus/detail/(:num)', 'Siswa\KursusSiswa::detail/$1');
    $routes->get('kursus/akses/(:num)', 'Siswa\KursusSiswa::akses/$1');
    $routes->get('kursus/akses/(:num)/modul/(:num)', 'Siswa\KursusSiswa::akses_modul/$1/$2');
    $routes->get('kursus/materi/(:num)', 'Siswa\KursusSiswa::view_materi/$1');

    // Quiz
    $routes->get('quiz/(:num)', 'Siswa\QuizSiswa::index/$1');
    $routes->get('quiz/kerjakan/(:num)', 'Siswa\QuizSiswa::kerjakan/$1');
    $routes->get('quiz/start/(:num)', 'Siswa\QuizSiswa::start/$1');
    $routes->post('quiz/submit', 'Siswa\QuizSiswa::submit');
    $routes->get('quiz/hasil/(:num)', 'Siswa\QuizSiswa::hasil/$1');
    $routes->post('quiz/retry/(:num)', 'Siswa\QuizSiswa::retry/$1');

    // Tugas
    $routes->get('tugas', 'Siswa\TugasSiswa::index');
    $routes->get('tugas/detail/(:num)', 'Siswa\TugasSiswa::detail/$1');
    $routes->get('tugas/kumpul/(:num)', 'Siswa\TugasSiswa::form_kumpul/$1');
    $routes->post('tugas/kumpul/simpan', 'Siswa\TugasSiswa::save_kumpul');
    $routes->get('tugas/kumpul/edit/(:num)', 'Siswa\TugasSiswa::edit_kumpul/$1');
    $routes->post('tugas/kumpul/update/(:num)', 'Siswa\TugasSiswa::update_kumpul/$1');
    $routes->get('tugas/kumpul/hapus/(:num)', 'Siswa\TugasSiswa::delete_kumpul/$1');
    $routes->get('tugas/nilai/(:num)', 'Siswa\TugasSiswa::lihat_penilaian/$1');

    // Progress
    $routes->get('progress', 'Siswa\ProgressSiswa::index');
    $routes->get('progress/nilai', 'Siswa\ProgressSiswa::nilai');
    $routes->get('progress/nilai/(:num)', 'Siswa\ProgressSiswa::detail_nilai/$1');
    $routes->post('progress/update/(:num)', 'Siswa\ProgressSiswa::update/$1');

    // Pendaftaran
    $routes->get('pendaftaran/daftar/(:num)', 'Siswa\PendaftaranSiswa::form_daftar/$1');
    $routes->post('pendaftaran/simpan', 'Siswa\PendaftaranSiswa::simpan');
    $routes->get('pendaftaran/riwayat', 'Siswa\PendaftaranSiswa::riwayat');
    $routes->get('pendaftaran/detail/(:num)', 'Siswa\PendaftaranSiswa::detail/$1');

    // Cart & Checkout
    $routes->get('cart', 'Siswa\CartSiswa::index');
    $routes->post('cart/save', 'Siswa\CartSiswa::save_cart');
    $routes->get('cart/delete/(:num)', 'Siswa\CartSiswa::delete_cart/$1');
    $routes->get('checkout-direct/(:num)', 'Siswa\CartSiswa::checkout_direct/$1');
    $routes->post('checkout-noncart', 'Siswa\CartSiswa::checkout_noncart');
    $routes->post('checkout/save-noncart', 'Siswa\CartSiswa::save_checkout_noncart');

    // Chat
    $routes->get('chat', '\App\Controllers\Siswa\ChatSiswa::index');
    $routes->get('chat/(:num)', '\App\Controllers\Siswa\ChatSiswa::conversation/$1');
    $routes->get('chat/(:num)/(:segment)', '\App\Controllers\Siswa\ChatSiswa::conversation/$1/$2');
    $routes->post('chat/send', '\App\Controllers\Siswa\ChatSiswa::send');

    // Diskusi
    $routes->get('diskusi/(:num)', '\App\Controllers\Siswa\DiskusiSiswa::index/$1');
    $routes->get('diskusi/buat/(:num)', '\App\Controllers\Siswa\DiskusiSiswa::create/$1');
    $routes->post('diskusi/simpan', '\App\Controllers\Siswa\DiskusiSiswa::store');
    $routes->get('diskusi/view/(:segment)', '\App\Controllers\Siswa\DiskusiSiswa::show/$1');
    $routes->post('diskusi/komentar/(:num)', '\App\Controllers\Siswa\DiskusiSiswa::add_komentar/$1');
    $routes->post('diskusi/like/(:num)/(:segment)', '\App\Controllers\Siswa\DiskusiSiswa::like_komentar/$1/$2');
    $routes->get('diskusi/search', '\App\Controllers\Siswa\DiskusiSiswa::search');

    // Sertifikat
    $routes->get('sertifikat', '\App\Controllers\Siswa\SertifikatSiswa::index');
    $routes->get('sertifikat/claim/(:num)', '\App\Controllers\Siswa\SertifikatSiswa::claim/$1');
    $routes->get('sertifikat/download/(:num)', '\App\Controllers\Siswa\SertifikatSiswa::download/$1');
    $routes->get('sertifikat/print/(:num)', '\App\Controllers\Siswa\SertifikatSiswa::print/$1');
});

// ============================================================================
// 👑 SUPERADMIN ROUTES
// ============================================================================

// Include custom routes
if (file_exists(ROOTPATH . 'sertifikat_routes.php')) {
    require ROOTPATH . 'sertifikat_routes.php';
}

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
