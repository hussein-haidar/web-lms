<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => \App\Filters\CustomCsrfFilter::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        // Custom filters untuk role-based access
        'filter_superadmin' => \App\Filters\Filter_superadmin::class,
        'filter_staf'       => \App\Filters\Filter_staf::class,
        'filter_pengajar'   => \App\Filters\Filter_pengajar::class,
        'filter_teknisi'    => \App\Filters\Filter_teknisi::class,
        'filter_siswa'      => \App\Filters\Filter_siswa::class,
        'filter_karyawan'   => \App\Filters\Filter_karyawan::class,
        'filter_website'    => \App\Filters\Filter_website::class,
    ];

    public array $required = [
        'before' => [
            'forcehttps',
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [],
        'after' => [],
    ];

    public array $methods = [
        'post' => ['csrf'],
        'put'  => ['csrf'],
        'delete' => ['csrf'],
    ];

    public array $filters = [];
}
