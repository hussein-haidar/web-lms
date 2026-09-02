<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\M_superadmin;
use App\Models\M_karyawan;
use App\Models\M_siswa;
use App\Models\M_pendaftaran;

class Auth_login extends BaseController
{
    protected $M_superadmin;
    protected $M_karyawan;
    protected $M_siswa;
    protected $M_pendaftaran;

    // Rate limiting config
    protected int $maxAttempts = 5;
    protected int $lockoutTime = 900; // 15 minutes in seconds

    public function __construct()
    {
        $this->M_superadmin = new M_superadmin();
        $this->M_karyawan  = new M_karyawan();
        $this->M_siswa = new M_siswa();
        $this->M_pendaftaran = new M_pendaftaran();
    }

    // ============================================
    // RATE LIMITING METHODS
    // ============================================

    private function getRateLimitKey(string $identifier, string $type): string
    {
        return 'rate_limit_' . $type . '_' . md5($identifier);
    }

    private function checkRateLimit(string $identifier, string $type): ?string
    {
        $key = $this->getRateLimitKey($identifier, $type);
        $data = session()->get($key);

        if (!$data) {
            return null; // No lockout
        }

        $attempts = $data['attempts'] ?? 0;
        $lockedAt = $data['locked_at'] ?? 0;

        // Check if lockout period has expired
        if ($lockedAt > 0 && (time() - $lockedAt) > $this->lockoutTime) {
            session()->remove($key);
            return null;
        }

        if ($attempts >= $this->maxAttempts) {
            $remaining = $this->lockoutTime - (time() - $lockedAt);
            $minutes = ceil($remaining / 60);
            return "Terlalu banyak percobaan gagal. Coba lagi dalam {$minutes} menit.";
        }

        return null;
    }

    private function recordFailedAttempt(string $identifier, string $type): void
    {
        $key = $this->getRateLimitKey($identifier, $type);
        $data = session()->get($key) ?? ['attempts' => 0, 'locked_at' => 0];

        $data['attempts']++;

        if ($data['attempts'] >= $this->maxAttempts && $data['locked_at'] === 0) {
            $data['locked_at'] = time();
        }

        session()->set($key, $data);
    }

    private function clearFailedAttempts(string $identifier, string $type): void
    {
        $key = $this->getRateLimitKey($identifier, $type);
        session()->remove($key);
    }

    public function login_superadmin()
    {
        $data = [
            'title' => 'LOGIN LPK INASABA',
            'title2' => 'LOGIN LPK INASABA',
        ];
        return view('backend/superadmin/v_login', $data);
    }

    public function cek_login_superadmin()
    {
        $input = $this->request->getPost('login_superadmin') ?? '';
        
        // Check rate limit
        $rateLimitMsg = $this->checkRateLimit($input, 'superadmin');
        if ($rateLimitMsg) {
            session()->setFlashdata('pesan_warning', $rateLimitMsg);
            return redirect()->to(base_url('auth_login/login_superadmin'));
        }

        if ($this->validate([
            'login_superadmin' => [
                'label' => 'Username atau Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'kata_sandi' => [
                'label' => 'Kata Sandi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
        ])) {
            $password = $this->request->getPost('kata_sandi');

            // Cari user berdasarkan NIP atau email
            $user = $this->M_superadmin->findByEmailOrUsername($input);
            
                       if ($user) {
                // Verifikasi password
                if ($user['kata_sandi'] === $password) {
                    $this->clearFailedAttempts($input, 'superadmin');
                    $userData = [
                        'id_superadmin' => $user['id_superadmin'],
                        'id_pemilik' => $user['id_pemilik'],
                        'username' => $user['username'],
                        'email' => $user['email'], // tambahkan jika ada
                        'nama_lengkap' => $user['nama_lengkap'],
                        'no_telepon' => $user['no_telepon'],
                        'alamat' => $user['alamat'],
                        'foto_profil' => $user['foto_profil'],
                        'level' => $user['level'],
                        'last_login' => $user['last_login'],
                    ];

                    session()->set('log', true);
                    session()->set($userData);

                    // Update last login
                    $this->M_superadmin->updateLastLogin($user['id_superadmin']);

                    session()->setFlashdata('pesan', 'Selamat Datang, ' . $user['nama_lengkap'] . '!');

                    // Redirect berdasarkan level
                    switch ($user['level']) {
                        case 'superadmin':
                            return redirect()->to(base_url('home_superadmin/index'));
                        default:
                            return redirect()->to(base_url('auth_login/login_superadmin'));
                    }
                } else {
                    $this->recordFailedAttempt($input, 'superadmin');
                    session()->setFlashdata('pesan_warning', 'Login Gagal, Password Salah!');
                    return redirect()->to(base_url('auth_login/login_superadmin'));
                }
            } else {
                $this->recordFailedAttempt($input, 'superadmin');
                session()->setFlashdata('pesan_warning', 'Login Gagal, Username atau Email Tidak Ditemukan!');
                return redirect()->to(base_url('auth_login/login_superadmin'));
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth_login/login_superadmin'));
        }
    }

    // Menampilkan halaman untuk form lupa password
    public function lupa_password_superadmin()
    {
        $data = [
            'title' => 'Lupa Password',
            'title2' => 'Lupa Password',
        ];
        return view('auth_login/v_lupa_password', $data);
    }

    // Proses untuk mengecek email dan lanjut ke halaman reset password
    public function proses_lupa_password_superadmin()
    {
        // Validasi dan cek jika form dipost
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');

            // Validasi jika email tidak kosong
            if (empty($email)) {
                return redirect()->back()->with('error_email', 'email tidak boleh kosong.');
            }

            // Cek apakah email ada di database
            $user = $this->M_superadmin->where('email', $email)->first();

            // Jika email ditemukan, lanjut ke halaman reset password
            if ($user) {
                return redirect()->to(base_url('auth_login/reset_password_superadmin/' . $user['id_superadmin']));
            } else {
                // Jika email tidak ditemukan, tampilkan pesan error
                return redirect()->back()->with('error_email', 'email tidak ditemukan.');
            }
        }

        // Menampilkan halaman lupa password jika tidak ada request post
        return view('auth_login/v_lupa_password');
    }

    // Menampilkan halaman untuk reset password
    public function reset_password_superadmin($id_superadmin = null)
    {
        // Jika id_superadmin tidak ada, redirect kembali ke halaman lupa password
        if ($id_superadmin === null) {
            return redirect()->to(base_url('auth_login/lupa_password_superadmin'));
        }

        // Ambil data user berdasarkan id_superadmin
        $user = $this->M_superadmin->find($id_superadmin);

        // Jika user tidak ditemukan, redirect kembali ke halaman lupa password
        if (!$user) {
            return redirect()->to(base_url('auth_login/lupa_password_superadmin'));
        }

        // Validasi jika form reset password dipost
        if ($this->request->getMethod() === 'post') {
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validasi jika password dan konfirmasi password tidak cocok
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error_password', 'Password tidak cocok.');
            }

            // Update password baru tanpa enkripsi
            $this->M_superadmin->update($id_superadmin, [
                'kata_sandi' => $newPassword  // Menyimpan password baru tanpa enkripsi
            ]);

            // Beri pesan sukses setelah berhasil update password
            session()->setFlashdata('pesan_success', 'Password berhasil diperbarui.');
            return redirect()->to(base_url('auth_login/login_superadmin'));
        }

        // Menampilkan halaman reset password dengan data user
        $data = [
            'title' => 'Reset Password - ' . $user['email'],
            'title2' => 'LPK INASABA',
            'user' => $user
        ];
        return view('auth_login/v_reset_password', $data);
    }

    public function logout_superadmin()
    {
        // Mengambil semua data sesi yang ada
        $session_data = session()->get();

        // Menghapus semua data sesi menggunakan remove()
        foreach ($session_data as $key => $value) {
            session()->remove($key);
        }

        // Set flashdata pesan_success setelah menghapus sesi
        session()->setFlashdata('pesan_success', 'Logout Berhasil !');

        // Redirect ke halaman login
        return redirect()->to(base_url('auth_login/login_superadmin'));
    }

    public function login_karyawan()
    {
        $data = [
            'title' => 'LOGIN LPK INASABA',
            'title2' => 'LOGIN LPK INASABA',
        ];
        return view('backend/karyawan/v_login', $data);
    }

    public function cek_login_karyawan()
    {
        $input = $this->request->getPost('login_karyawan') ?? '';

        // Check rate limit
        $rateLimitMsg = $this->checkRateLimit($input, 'karyawan');
        if ($rateLimitMsg) {
            session()->setFlashdata('pesan_warning', $rateLimitMsg);
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }

        // Validasi input
        if ($this->validate([
            'login_karyawan' => [
                'label' => 'NIP atau Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'kata_sandi' => [
                'label' => 'Kata Sandi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
        ])) {
            $password = $this->request->getPost('kata_sandi');

            $user = $this->M_karyawan->findByNipOrEmail($input);

            if ($user) {
                if ($password === $user['kata_sandi']) {
                    $this->clearFailedAttempts($input, 'karyawan');
                    $userData = [
                        'log' => true,
                        'id_karyawan' => $user['id_karyawan'],
                        'id_pemilik' => $user['id_pemilik'],
                        'nip' => $user['nip'],
                        'email' => $user['email'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'no_telepon' => $user['no_telepon'],
                        'alamat' => $user['alamat'],
                        'foto_profil' => $user['foto_profil'] ?? 'default.png',
                        'level' => $user['level'],
                        'last_login' => $user['last_login'] ?? null,
                    ];

                    session()->set('log', true);
                    session()->set($userData);

                    // Update last login
                    $this->M_karyawan->updateLastLogin($user['id_karyawan']);

                    session()->setFlashdata('pesan', 'Selamat Datang, ' . $user['nama_lengkap'] . '!');

                    // Redirect berdasarkan level
                    switch ($user['level']) {
                        case 'staf_admin':
                            return redirect()->to(base_url('home_karyawan/home_staf'));
                        case 'pengajar':
                            return redirect()->to(base_url('home_karyawan/home_pengajar'));
                        case 'teknisi':
                            return redirect()->to(base_url('home_karyawan/home_teknisi'));
                        default:
                            return redirect()->to(base_url('auth_login/login_karyawan')); // Atau home_website
                    }
                } else {
                    $this->recordFailedAttempt($input, 'karyawan');
                    session()->setFlashdata('pesan_warning', 'Login Gagal, Password Salah!');
                    return redirect()->to(base_url('auth_login/login_karyawan'));
                }
            } else {
                $this->recordFailedAttempt($input, 'karyawan');
                session()->setFlashdata('pesan_warning', 'Login Gagal, NIP atau Email Tidak Ditemukan!');
                return redirect()->to(base_url('auth_login/login_karyawan'));
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }
    }

    // Menampilkan halaman untuk form lupa password
    public function lupa_password_karyawan()
    {
        $data = [
            'title' => 'Lupa Password',
            'title2' => 'Lupa Password',
        ];
        return view('auth_login/v_lupa_password', $data);
    }

    // Proses untuk mengecek email dan lanjut ke halaman reset password
    public function proses_lupa_password_karyawan()
    {
        // Validasi dan cek jika form dipost
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');

            // Validasi jika email tidak kosong
            if (empty($email)) {
                return redirect()->back()->with('error_email', 'email tidak boleh kosong.');
            }

            // Cek apakah email ada di database
            $user = $this->M_karyawan->where('email', $email)->first();

            // Jika email ditemukan, lanjut ke halaman reset password
            if ($user) {
                return redirect()->to(base_url('auth_login/reset_password_karyawan/' . $user['id_karyawan']));
            } else {
                // Jika email tidak ditemukan, tampilkan pesan error
                return redirect()->back()->with('error_email', 'email tidak ditemukan.');
            }
        }

        // Menampilkan halaman lupa password jika tidak ada request post
        return view('auth_login/v_lupa_password');
    }

    // Menampilkan halaman untuk reset password
    public function reset_password_karyawan($id_karyawan = null)
    {
        // Jika id_karyawan tidak ada, redirect kembali ke halaman lupa password
        if ($id_karyawan === null) {
            return redirect()->to(base_url('auth_login/lupa_password_karyawan'));
        }

        // Ambil data user berdasarkan id_karyawan
        $user = $this->M_karyawan->find($id_karyawan);

        // Jika user tidak ditemukan, redirect kembali ke halaman lupa password
        if (!$user) {
            return redirect()->to(base_url('auth_login/lupa_password_karyawan'));
        }

        // Validasi jika form reset password dipost
        if ($this->request->getMethod() === 'post') {
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validasi jika password dan konfirmasi password tidak cocok
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error_password', 'Password tidak cocok.');
            }

            // Update password baru tanpa enkripsi
            $this->M_karyawan->update($id_karyawan, [
                'kata_sandi' => $newPassword  // Menyimpan password baru tanpa enkripsi
            ]);

            // Beri pesan sukses setelah berhasil update password
            session()->setFlashdata('pesan_success', 'Password berhasil diperbarui.');
            return redirect()->to(base_url('auth_login/login_karyawan'));
        }

        // Menampilkan halaman reset password dengan data user
        $data = [
            'title' => 'Reset Password - ' . $user['email'],
            'title2' => 'LPK INASABA',
            'user' => $user
        ];
        return view('auth_login/v_reset_password', $data);
    }

    public function logout_karyawan()
    {
        // Mengambil semua data sesi yang ada
        $session_data = session()->get();

        // Menghapus semua data sesi menggunakan remove()
        foreach ($session_data as $key => $value) {
            session()->remove($key);
        }

        // Set flashdata pesan_success setelah menghapus sesi
        session()->setFlashdata('pesan_success', 'Logout Berhasil !');

        // Redirect ke halaman login
        return redirect()->to(base_url('auth_login/login_karyawan'));
    }

    public function login_siswa()
    {
        $data = [
            'title' => 'LOGIN LPK INASABA',
            'title2' => 'LOGIN LPK INASABA',

        ];
        return view('frontend/web/v_login', $data);
    }

    // ============================================
    // PROSES LOGIN SISWA
    // ============================================

    public function cek_login_siswa()
    {
        $input = $this->request->getPost('login_siswa') ?? '';

        // Check rate limit
        $rateLimitMsg = $this->checkRateLimit($input, 'siswa');
        if ($rateLimitMsg) {
            session()->setFlashdata('pesan_warning', $rateLimitMsg);
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        if ($this->validate([
            'login_siswa' => [
                'label' => 'NIS atau Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
            'kata_sandi' => [
                'label' => 'Kata Sandi',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
            ],
        ])) {
            $password = $this->request->getPost('kata_sandi');

            // Cari user berdasarkan NIS atau email
            $user = $this->M_siswa->findByNisOrEmail($input);

            if ($user) {
                // ✅ VERIFIKASI PASSWORD LANGSUNG (TANPA password_verify)
                if ($password === $user['kata_sandi']) {
                    $this->clearFailedAttempts($input, 'siswa');
                    $userData = [
                        'id_siswa' => $user['id_siswa'],
                        'id_pemilik' => $user['id_pemilik'],
                        'nis' => $user['nis'],
                        'email' => $user['email'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'no_telepon' => $user['no_telepon'],
                        'jenis_kelamin' => $user['jenis_kelamin'],
                        'alamat' => $user['alamat'],
                        'foto_profil' => $user['foto_profil'],
                        'level' => $user['level'],
                        'last_login' => $user['last_login'],
                    ];

                    session()->set('log', true);
                    session()->set($userData);

                    // Update last login
                    $this->M_siswa->updateLastLogin($user['id_siswa']);

                    session()->setFlashdata('pesan', 'Selamat Datang, ' . $user['nama_lengkap'] . '!');

                    // Redirect ke dashboard siswa
                    return redirect()->to(base_url('home_siswa/index'));
                } else {
                    $this->recordFailedAttempt($input, 'siswa');
                    session()->setFlashdata('pesan_warning', 'Login Gagal, Password Salah!');
                    return redirect()->to(base_url('auth_login/login_siswa'));
                }
            } else {
                $this->recordFailedAttempt($input, 'siswa');
                session()->setFlashdata('pesan_warning', 'Login Gagal, NIS atau Email Tidak Ditemukan!');
                return redirect()->to(base_url('auth_login/login_siswa'));
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth_login/login_siswa'));
        }
    }

    public function register_siswa()
    {
        $data = [
            'title' => 'LOGIN LPK INASABA',
            'title2' => 'LOGIN LPK INASABA',
                  ];
        return view('frontend/web/v_register', $data);
    }

    // ============================================
    // PROSES PENDAFTARAN (Simpan ke tabel daftar)
    // ============================================

    public function proses_register()
    {
        // Validasi form
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[siswa.email]',
            'kata_sandi' => 'required|min_length[6]',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required|in_list[Laki - laki,Perempuan]',
            'agama' => 'required|in_list[Islam,Kristen,Katolik,Hindu]',
            'alamat' => 'required',
            'no_telepon' => 'required|min_length[10]|max_length[15]|regex_match[/^[0-9]+$/]'
        ]);

        // Upload pas foto (opsional)
        $file = $this->request->getFile('foto_profil');
        $foto_profil = null;
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi file
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            $maxSize = 2048 * 1024; // 2MB
            
            if (!in_array(strtolower($file->getExtension()), $allowedTypes)) {
                session()->setFlashdata('error', 'Format file tidak valid. Gunakan JPG, JPEG, atau PNG.');
                return redirect()->back()->withInput();
            }
            
            if ($file->getSize() > $maxSize) {
                session()->setFlashdata('error', 'Ukuran file terlalu besar. Maksimal 2MB.');
                return redirect()->back()->withInput();
            }
            
            // Generate nama file unik
            $newName = 'foto_profil_' . date('YmdHis') . '_' . rand(1000, 9999) . '.' . $file->getExtension();
            
            // Pindahkan file ke folder public/fotosiswa/ (bukan writable)
            $uploadPath = FCPATH . 'fotosiswa/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($file->move($uploadPath, $newName)) {
                $foto_profil = $newName;
            }
        }

        // Generate NIS sederhana (bisa disesuaikan)
        $nis = 'NIS' . date('YmdHis');
      
        // Simpan data ke tabel siswa (Buat Akun)
        $dataSiswa = [
            'nis' => $nis,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'kata_sandi' => $this->request->getPost('kata_sandi'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama' => $this->request->getPost('agama'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'level' => 'siswa',
            'status_aktif' => 'aktif',
            'tanggal_daftar' => date('Y-m-d H:i:s'),
            // Upload pas foto
            'foto_profil' => $foto_profil,
        ];

        $id_siswa_baru = $this->M_siswa->insert($dataSiswa);
        
        if (!$id_siswa_baru) {
            return redirect()->back()->with('error', 'Gagal membuat akun siswa.');
        }

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->to(base_url('auth_login/login_siswa'))
            ->with('pesan', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }

    // ============================================
    // HALAMAN LUPA PASSWORD
    // ============================================

    public function lupa_password_siswa()
    {
        $data = [
            'title' => 'Lupa Password',
            'title2' => 'Lupa Password',
        ];
        return view('auth_login/v_lupa_password', $data);
    }

    // ============================================
    // PROSES LUPA PASSWORD (Cek Email)
    // ============================================

    public function proses_lupa_password_siswa()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getPost('email');

            // Validasi input
            $rules = [
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email wajib diisi!',
                        'valid_email' => 'Format email tidak valid!'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return redirect()->to(base_url('auth_login/lupa_password_siswa'))->with('error_email', $this->validator->getError('email'));
            }

            // Cek apakah email ada di database siswa
            $user = $this->M_siswa->where('email', $email)->first();

            if ($user) {
                // Generate token untuk reset password (opsional, untuk keamanan lebih baik)
                $reset_token = bin2hex(random_bytes(32));
                
                // Simpan token ke database (tambahkan field reset_token dan reset_token_expiry di tabel siswa)
                // Untuk sekarang, langsung redirect ke halaman reset
                session()->setFlashdata('pesan_info', 'Email ditemukan. Silakan reset password Anda.');
                return redirect()->to(base_url('auth_login/reset_password_siswa/' . $user['id_siswa']));
            } else {
                // Untuk keamanan, berikan pesan yang sama meskipun email tidak ditemukan
                return redirect()->to(base_url('auth_login/lupa_password_siswa'))->with('error_email', 'Email tidak terdaftar dalam sistem kami.');
            }
        }

        $data = [
            'title' => 'Lupa Password',
            'title2' => 'Lupa Password',
        ];
        return view('auth_login/v_lupa_password', $data);
    }

    // ============================================
    // HALAMAN RESET PASSWORD
    // ============================================

    public function reset_password_siswa($id_siswa = null)
    {
        log_message('debug', 'RESET PASSWORD METHOD STARTED');
        log_message('debug', 'RESET PASSWORD PARAM: ' . $id_siswa);
        log_message('debug', 'REQUEST METHOD: ' . $this->request->getMethod());
        log_message('debug', 'ALL POST DATA: ' . json_encode($this->request->getPost()));
        
        // Coba dapatkan ID dari URL jika tidak ada parameter
        if ($id_siswa === null) {
            $uri = service('uri')->getSegments();
            log_message('debug', 'URI SEGMENTS: ' . json_encode($uri));
            
            // Cari ID dalam URI
            foreach ($uri as $segment) {
                if (is_numeric($segment)) {
                    $id_siswa = $segment;
                    log_message('debug', 'FOUND ID FROM URI: ' . $id_siswa);
                    break;
                }
            }
        }
        
        if ($id_siswa === null) {
            session()->setFlashdata('error_email', 'Link reset password tidak valid.');
            return redirect()->to(base_url('auth_login/lupa_password_siswa'));
        }

        $user = $this->M_siswa->find($id_siswa);

        if (!$user) {
            session()->setFlashdata('error_email', 'Pengguna tidak ditemukan.');
            return redirect()->to(base_url('auth_login/lupa_password_siswa'));
        }

        // Cek method dengan multiple approaches
        $method = $this->request->getMethod();
        $isPost = $this->request->is('post');
        $serverMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        
        log_message('debug', 'METHOD CHECK - getMethod(): ' . $method);
        log_message('debug', 'METHOD CHECK - is(post): ' . ($isPost ? 'true' : 'false'));
        log_message('debug', 'METHOD CHECK - SERVER: ' . $serverMethod);
        
        if ($isPost || $method === 'POST' || $serverMethod === 'POST') {
            log_message('debug', 'POST REQUEST DETECTED');
            log_message('debug', 'ALL POST DATA: ' . json_encode($this->request->getPost()));
            
            // Validasi input
            $rules = [
                'new_password' => [
                    'label' => 'Password Baru',
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Password baru wajib diisi!',
                        'min_length' => 'Password minimal 6 karakter!'
                    ]
                ],
                'confirm_password' => [
                    'label' => 'Konfirmasi Password',
                    'rules' => 'required|matches[new_password]',
                    'errors' => [
                        'required' => 'Konfirmasi password wajib diisi!',
                        'matches' => 'Konfirmasi password tidak cocok!'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                log_message('debug', 'VALIDATION FAILED: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()->with('error_password', $this->validator->getError('confirm_password'));
            }

            log_message('debug', 'VALIDATION PASSED');

            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Double check password match
            if ($newPassword !== $confirmPassword) {
                log_message('debug', 'PASSWORD MISMATCH');
                return redirect()->back()->with('error_password', 'Password tidak cocok.');
            }

            log_message('debug', 'UPDATING PASSWORD FOR USER ID: ' . $id_siswa);

            // Update password
            $updateData = [
                'kata_sandi' => $newPassword,  // Sesuai dengan sistem yang ada (tanpa hash)
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->M_siswa->update($id_siswa, $updateData);

            log_message('debug', 'PASSWORD UPDATED SUCCESSFULLY');

            session()->setFlashdata('pesan_success', 'Password berhasil diperbarui. Silakan login dengan password baru Anda.');
            return redirect()->to(base_url('auth_login/login_siswa'));
        }

        $data = [
            'title' => 'Reset Password - ' . $user['email'],
            'title2' => 'LPK INASABA',
            'user' => $user
        ];
        return view('auth_login/v_reset_password', $data);
    }

    // ============================================
    // LOGOUT SISWA
    // ============================================

    public function logout_siswa()
    {
        // Hapus semua session
        session()->destroy();

        // Set flashdata pesan sukses
        session()->setFlashdata('pesan_success', 'Logout Berhasil!');

        // Redirect ke halaman login
        return redirect()->to(base_url('home_website/index'));
    }
}
