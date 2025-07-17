<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTE YANG WAJIB LOGIN (Dijaga oleh 'auth') ---
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('akun', 'Akun::index');
    $routes->post('akun/update_profil', 'Akun::updateProfil');
    $routes->post('akun/update_sandi', 'Akun::updateSandi');

    // Resource untuk Wilayah dan Siswa (tetap seperti semula)
    $routes->resource('wilayah');
    $routes->resource('siswa');
    $routes->resource('bantuan');

    // =======================================================
    // >> RUTE UNTUK SELISIH (CRUD) - DIJAGA OLEH GROUP INI <<
    // Hapus $routes->resource('selisih'); yang duplikat
    // =======================================================
    $routes->group('selisih', function ($routes) {
        $routes->get('/', 'Selisih::index');
        $routes->get('new', 'Selisih::new');
        $routes->post('create', 'Selisih::create');
        $routes->get('edit/(:num)', 'Selisih::edit/$1');
        $routes->put('update/(:num)', 'Selisih::update/$1');
        $routes->delete('(:num)', 'Selisih::delete/$1'); // Pastikan ini DELETE method di form
        $routes->get('get_hasil_prediksi', 'Selisih::get_hasil_prediksi'); // API untuk AJAX
        $routes->get('get_jumlah_guru', 'Selisih::get_jumlah_guru'); // API untuk AJAX (opsional, tergantung kebutuhan)
    });

    // Rute untuk Guru (tetap seperti semula, pastikan konsisten dengan controller Guru)
    $routes->get('guru/create', 'Guru::create');
    $routes->post('guru/store', 'Guru::store');
    $routes->get('guru/edit/(:num)', 'Guru::edit/$1');
    $routes->post('guru/update/(:num)', 'Guru::update/$1');
    $routes->get('guru/delete/(:num)', 'Guru::delete/$1'); // Ini juga sebaiknya POST/DELETE method
    $routes->resource('guru', ['only' => ['index']]); // Jika hanya ingin index dari resource

    // Rute untuk Prediksi (tetap seperti semula)
    $routes->match(['get', 'post'], 'prediksi', 'Prediksi::index');
    $routes->post('prediksi/simpan', 'Prediksi::simpan');

    // =======================================================
    // >> HAPUS RUTE SELISIH YANG DUPLIKAT DI BAWAH INI <<
    // Karena sudah didefinisikan di dalam group 'selisih' di atas
    // =======================================================
    // $routes->get('selisih', 'Selisih::index'); // Hapus
    // $routes->post('selisih/store', 'Selisih::store'); // Hapus, gunakan 'create' di atas
    // $routes->get('selisih/delete/(:num)', 'Selisih::delete/$1'); // Hapus, gunakan DELETE method di atas
});


// --- RUTE UNTUK TAMU (Dijaga oleh 'guest') ---
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->get('register', 'Auth::register');
});


// --- RUTE AKSI PUBLIK (Proses Login, Register, Logout) ---
$routes->post('login', 'Auth::login');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');
