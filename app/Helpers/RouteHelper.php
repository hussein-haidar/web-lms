<?php

namespace App\Helpers;

class RouteHelper
{
    /**
     * Otomatis generate daftar route yang akan dikecualikan dari menampilkan section tertentu
     * Berdasarkan pola controller dan method yang sudah ditentukan
     */
    public static function getAutoExcludeRoutes(): array
    {
        return [
            // ✅ HOME_WEBSITE - HANYA kls_online yang TIDAK perlu menampilkan section
            'home_website/kls_online',        // Daftar kelas online (TIDAK TAMPIL)
            // Method home_website LAINNYA AKAN MENAMPILKAN section
            
            // ✅ HOME_SISWA - SEMUA method dikecualikan (area siswa)
            'home_siswa/*',                  // SEMUA method di controller home_siswa
            
            // ✅ AUTH - Semua method dikecualikan
            'auth_login/*',                  // Login/register area
            
            // ✅ FUTURE PROOFING - Controller yang belum ada
            'admin/*',                      // Admin area
            'backend/*',                     // Backend area
            'api/*',                        // API endpoints
            'ajax/*',                       // AJAX requests
            'dynamic/*',                    // Dynamic content
        ];
    }
    
    /**
     * Cek apakah route saat ini harus dikecualikan
     * Menggunakan pattern matching untuk fleksibilitas
     */
    public static function shouldExcludeRoute(string $currentRoute): bool
    {
        $excludePatterns = self::getAutoExcludeRoutes();
        
        foreach ($excludePatterns as $pattern) {
            // Jika pattern mengandung wildcard, gunakan regex matching
            if (strpos($pattern, '*') !== false) {
                $regexPattern = str_replace('*', '.*', preg_quote($pattern, '/'));
                if (preg_match('/^' . $regexPattern . '/i', $currentRoute)) {
                    return true;
                }
            }
            // Jika pattern exact match
            elseif (strpos($currentRoute, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Alternative method: Generate exclude list berdasarkan controller yang aktif
     * Lebih dinamis dan tidak perlu hardcoding
     */
    public static function getExcludeByController(): array
    {
        // Controller yang semua method-nya harus dikecualikan
        $excludeAllMethods = [
            'home_siswa',
            'auth_login',
            'admin',
            'api'
        ];
        
        // Method spesifik yang dikecualikan dari controller tertentu
        $excludeSpecificMethods = [
            'home_website' => [
                'kls_online' // HANYA kls_online yang dikecualikan dari home_website
            ]
        ];
        
        return [
            'exclude_all' => $excludeAllMethods,
            'exclude_specific' => $excludeSpecificMethods
        ];
    }
    
    /**
     * Cek berdasarkan controller dan method yang aktif
     * Method ini membutuhkan akses ke router/CI4 instance
     */
    public static function shouldExcludeByController(string $currentRoute): bool
    {
        $config = self::getExcludeByController();
        
        // Parse current route untuk mendapatkan controller dan method
        $routeParts = explode('/', trim($currentRoute, '/'));
        $controller = $routeParts[0] ?? '';
        $method = $routeParts[1] ?? 'index';
        
        // Debug: Log parsing
        log_message('debug', 'RouteHelper - Controller: ' . $controller . ', Method: ' . $method);
        
        // Cek apakah controller termasuk yang harus dikecualikan semua method-nya
        if (in_array($controller, $config['exclude_all'])) {
            log_message('debug', 'RouteHelper - Controller in exclude_all: YES');
            return true;
        }
        
        // Cek apakah method spesifik harus dikecualikan
        if (isset($config['exclude_specific'][$controller]) && 
            in_array($method, $config['exclude_specific'][$controller])) {
            log_message('debug', 'RouteHelper - Method in exclude_specific: YES');
            return true;
        }
        
        log_message('debug', 'RouteHelper - Not excluded');
        return false;
    }
    
    /**
     * Method yang paling praktis: Kombinasi pattern dan controller
     */
    public static function shouldShowSection(string $currentRoute): bool
    {
        // Debug: Log current route
        log_message('debug', 'RouteHelper - Current Route: ' . $currentRoute);
        
        // Clean route path - remove base path
        $cleanRoute = str_replace('/web_lms/public/', '', $currentRoute);
        $cleanRoute = ltrim($cleanRoute, '/');
        
        log_message('debug', 'RouteHelper - Clean Route: ' . $cleanRoute);
        
        // Cek dengan pattern matching langsung untuk lebih pasti
        $excludePatterns = [
            'home_siswa',           // Semua route home_siswa
            'home_website/kls_online',  // Khusus kls_online
            'home_website/detail_online',  // Khusus detail_online
            'auth_login',           // Semua auth routes
        ];
        
        foreach ($excludePatterns as $pattern) {
            if (strpos($cleanRoute, $pattern) === 0) {
                log_message('debug', 'RouteHelper - Matched exclude pattern: ' . $pattern);
                return false; // Tampilkan = false
            }
        }
        
        log_message('debug', 'RouteHelper - Not excluded, showing section');
        return true; // Tampilkan = true
    }
}
