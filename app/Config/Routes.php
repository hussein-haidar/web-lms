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


// Route reset password siswa menggunakan controller Auth_login
$routes->get('auth_login/reset_password_siswa/(:any)', 'Auth_login::reset_password_siswa/$1');
$routes->post('auth_login/reset_password_siswa/(:any)', 'Auth_login::reset_password_siswa/$1');

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
        $routes->get('add_modul/(:num)', 'Home_superadmin::add_modul/$1');
        $routes->post('save_modul', 'Home_superadmin::save_modul');
        $routes->get('edit_modul/(:num)', 'Home_superadmin::edit_modul/$1');
        $routes->post('update_modul/(:num)', 'Home_superadmin::update_modul/$1');
        $routes->get('delete_modul/(:num)', 'Home_superadmin::delete_modul/$1');

        // --- MATERI (Management) ---
        $routes->get('materi/(:num)', 'Home_superadmin::materi/$1');
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
        $routes->get('deleted_paket/(:num)', 'Home_superadmin::deleted_paket/$1');

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
       
        // --- SLIDER ---
        $routes->get('slider', 'Home_superadmin::slider');
        $routes->get('add_slider', 'Home_superadmin::add_slider');
        $routes->post('save_slider', 'Home_superadmin::save_slider');
        $routes->get('edit_slider/(:num)', 'Home_superadmin::edit_slider/$1');
        $routes->post('update_slider/(:num)', 'Home_superadmin::update_slider/$1');
        $routes->get('deleted_slider/(:num)', 'Home_superadmin::deleted_slider/$1');
        $routes->post('update_order_slider', 'Home_superadmin::update_order_slider');
        $routes->post('toggle_status_slider/(:num)', 'Home_superadmin::toggle_status_slider/$1');

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

        // --- LULUSAN MANAGEMENT ---
        $routes->get('lulusan', 'Home_superadmin::lulusan');
        $routes->get('add_lulusan', 'Home_superadmin::add_lulusan');
        $routes->post('save_lulusan', 'Home_superadmin::save_lulusan');
        $routes->get('edit_lulusan/(:num)', 'Home_superadmin::edit_lulusan/$1');
        $routes->post('update_lulusan/(:num)', 'Home_superadmin::update_lulusan/$1');
        $routes->get('deleted_lulusan/(:num)', 'Home_superadmin::deleted_lulusan/$1');
        $routes->get('view_lulusan/(:num)', 'Home_superadmin::view_lulusan/$1');

        // --- ALUMNI MANAGEMENT ---
        $routes->get('alumni', 'Alumni::index');
        $routes->group('alumni', ['filter' => 'filter_superadmin'], function ($routes) {
            $routes->get('create', 'Alumni::create');
            $routes->post('store', 'Alumni::store');
            $routes->get('edit/(:num)', 'Alumni::edit/$1');
            $routes->post('update/(:num)', 'Alumni::update/$1');
            $routes->get('delete/(:num)', 'Alumni::delete/$1');
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
    }
);

// --- WEB ---
$routes->get('/', 'Home_website::index');
$routes->get('home_website/index', 'Home_website::index');
$routes->get('home_website/program_cfk', 'Home_website::program_cfk');
$routes->get('home_website/program_setahun', 'Home_website::program_setahun');
$routes->get('home_website/program_singkat', 'Home_website::program_singkat');
$routes->get('home_website/detail_program', 'Home_website::detail_program');
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
$routes->get('home_website/lulusan', 'Home_website::lulusan');
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
$routes->get('home_website/cart', 'Home_website::cart');
$routes->post('home_website/save_cart', 'home_website::save_cart');
$routes->get('home_website/edit_cart/(:num)', 'home_website::edit_cart/$1');
$routes->get('home_website/checkout_noncart', 'Home_website::checkout_noncart');
$routes->post('home_website/save_checkout_noncart', 'home_website::save_checkout_noncart');
$routes->get('home_website/checkout_cart', 'Home_website::checkout_cart');
$routes->post('home_website/save_checkout', 'home_website::save_checkout');
$routes->get('home_website/status_bayar', 'Home_website::status_bayar');
$routes->get('home_website/riwayat_beli', 'Home_website::riwayat_beli');

// Route untuk Login Superadmin
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

// 🔓 Public Karyawan Routes (No Filter)
$routes->get('home_karyawan/riwayat_bayar', 'Home_karyawan::riwayat_bayar');
$routes->get('home_karyawan/verify', 'Home_karyawan::verify');
$routes->get('home_karyawan/verify/(:num)', 'Home_karyawan::verify/$1');
$routes->get('home_karyawan/download/(:num)', 'Home_karyawan::download/$1');

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
    $routes->post('submit', 'Home_siswa::submit');
    $routes->get('hasil/(:num)', 'Home_siswa::hasil/$1');
    $routes->post('retry/(:num)', 'Home_siswa::retry/$1');
});

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

$routes->group('home_siswa/diskusi', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->get('(:num)', 'DiskusiController::index/$1');
    $routes->get('buat/(:num)', 'DiskusiController::create/$1');
    $routes->post('simpan', 'DiskusiController::store');
    $routes->get('view/(:segment)', 'DiskusiController::show/$1');
    $routes->post('komentar/(:num)', 'DiskusiController::add_komentar/$1');
    $routes->post('like/(:num)/(:segment)', 'DiskusiController::like_komentar/$1/$2');
    $routes->get('search', 'DiskusiController::search');
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
});

$routes->group('api/siswa', ['namespace' => 'App\Controllers', 'filter' => 'filter_siswa'], function ($routes) {
    $routes->post('progress/materi/(:num)', 'Home_siswa::ajax_update_materi_progress/$1');
    $routes->get('pembayaran/status/(:num)', 'PembayaranController::ajax_status/$1');
    $routes->post('quiz/timer/(:num)', 'QuizController::ajax_timer/$1');
    $routes->get('diskusi/komentar/(:num)', 'DiskusiController::ajax_load_komentar/$1');
});

// ============================================================================
// 📝 POSTINGAN ROUTES (Public & Admin)
// ============================================================================

// Public Postingan Routes
$routes->get('postingan', 'Home_website::postingan_index');
$routes->get('postingan/detail/(:segment)', 'Home_website::postingan_detail/$1');
$routes->get('postingan/search', 'Home_website::postingan_search');

// Admin Postingan Routes
$routes->group('home_superadmin', ['filter' => 'filter_superadmin'], function ($routes) {
    $routes->get('postingan_admin', 'Home_superadmin::postingan_admin');
    $routes->get('postingan_create', 'Home_superadmin::postingan_create');
    $routes->post('postingan_save', 'Home_superadmin::postingan_save');
    $routes->get('postingan_edit/(:num)', 'Home_superadmin::postingan_edit/$1');
    $routes->post('postingan_update/(:num)', 'Home_superadmin::postingan_update/$1');
    $routes->get('postingan_delete/(:num)', 'Home_superadmin::postingan_delete/$1');
    $routes->get('postingan_restore/(:num)', 'Home_superadmin::postingan_restore/$1');
    $routes->get('postingan_permanent_delete/(:num)', 'Home_superadmin::postingan_permanent_delete/$1');
});

// ============================================================================
// 🎓 PUBLIC: VERIFIKASI SERTIFIKAT (Tanpa Login)
// ============================================================================
$routes->get('sertifikat/verify', 'Sertifikat::verify_form');
$routes->get('sertifikat/verify/(:any)', 'Sertifikat::verify/$1');
$routes->get('sertifikat/view/(:num)', 'Sertifikat::view/$1');
$routes->get('verify-sertifikat', 'Home_karyawan::verify');
$routes->get('verify-sertifikat/(:segment)', 'Home_karyawan::verify/$1');

// ============================================================================
// 🎓 SERTIFIKAT ROUTES (Siswa & Admin)
// ============================================================================
$routes->group('sertifikat', ['filter' => 'filter_siswa'], function ($routes) {
    $routes->get('/', 'Sertifikat::index');
    $routes->get('claim/(:num)', 'Sertifikat::claim/$1');
    $routes->get('download/(:num)', 'Sertifikat::download/$1');
});

// ============================================================================
// 🎓 ALUMNI ROUTES
// ============================================================================

// Public Alumni Routes
$routes->get('alumni', 'Alumni::index');

// Admin Alumni Routes (add these to your admin route group)
$routes->group('alumni', ['filter' => 'filter_superadmin'], function ($routes) {
    $routes->get('create', 'Alumni::create');
    $routes->post('store', 'Alumni::store');
    $routes->get('edit/(:num)', 'Alumni::edit/$1');
    $routes->post('update/(:num)', 'Alumni::update/$1');
    $routes->get('delete/(:num)', 'Alumni::delete/$1');
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
