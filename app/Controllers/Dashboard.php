<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper('url'); // Pastikan helper url dimuat untuk fungsi base_url()
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'active_menu' => 'dashboard', // Variabel untuk menu aktif
        ];

        // --- PERBAIKAN DI SINI ---
        // Sekarang variabel $data dikirimkan ke view
        return view('dashboard/index', $data);
    }
}
