<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTE YANG WAJIB LOGIN (Dijaga oleh 'auth') ---
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('home', 'Home::index');

    // Rute untuk halaman Akun
    $routes->get('akun', 'Akun::index');
    $routes->post('akun/update_profil', 'Akun::updateProfil');
    $routes->post('akun/update_sandi', 'Akun::updateSandi');

    // --- RUTE CRUD UNTUK DATASET ---
    // Menampilkan halaman utama (upload & tabel data)
    $routes->get('dataset', 'DatasetController::index');
    // Memproses file yang di-upload
    $routes->post('dataset/upload', 'DatasetController::upload');

    // Rute untuk menampilkan form edit data (GET request)
    $routes->get('dataset/edit/(:num)', 'DatasetController::edit/$1');
    // Memproses pembaruan data dari form edit (POST request)
    $routes->post('dataset/update/(:num)', 'DatasetController::update/$1');
    // Memproses penghapusan data (POST request, sesuai dengan form di view)
    $routes->post('dataset/delete/(:num)', 'DatasetController::delete/$1');

    // Catatan: Jika Anda berencana untuk memiliki form input data manual terpisah (bukan upload CSV),
    // Anda akan memerlukan rute GET untuk menampilkan form dan rute POST untuk memprosesnya.
    // Contoh:
    // $routes->get('dataset/new', 'DatasetController::new'); // Untuk menampilkan form tambah data manual
    // $routes->post('dataset/create', 'DatasetController::create'); // Untuk memproses data baru dari form manual
    // ---------------------------------
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
