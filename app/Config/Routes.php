<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==================================================
// RUTE UNTUK TAMU (Hanya bisa diakses jika BELUM login)
// ==================================================
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->get('register', 'Auth::register');
});

// ==================================================
// RUTE AKSI PUBLIK (Proses login, register, logout)
// ==================================================
$routes->post('login', 'Auth::login');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');

// ==================================================
// RUTE UMUM (Hanya bisa diakses jika SUDAH login)
// ==================================================
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('akun', 'Akun::index');
    $routes->post('akun/update_profil', 'Akun::updateProfil');
    $routes->post('akun/update_sandi', 'Akun::updateSandi');
});

// ==================================================
// RUTE KHUSUS PRODI (Wajib login & role 'prodi')
// ==================================================
$routes->group('prodi', ['filter' => 'role:prodi', 'namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'ProdiSuratController::index');
    $routes->get('new', 'ProdiSuratController::new');
    $routes->get('create', 'ProdiSuratController::create');
    $routes->post('/', 'ProdiSuratController::save');
    $routes->get('export-pdf/(:num)', 'ProdiSuratController::exportPdf/$1');
    $routes->get('edit/(:num)', 'ProdiSuratController::edit/$1');
    $routes->post('update/(:num)', 'ProdiSuratController::update/$1');
    $routes->post('delete/(:num)', 'ProdiSuratController::delete/$1');
    $routes->get('(:num)', 'ProdiSuratController::show/$1');
});

// ==================================================
// RUTE KHUSUS FAKULTAS (Wajib login & role 'fakultas')
// ==================================================
$routes->group('fakultas', ['filter' => 'role:fakultas', 'namespace' => 'App\Controllers'], function ($routes) {
    // (Anda bisa isikan rute untuk fakultas di sini jika diperlukan)
    // Contoh:
    // $routes->get('/', 'FakultasSuratController::index');
});
