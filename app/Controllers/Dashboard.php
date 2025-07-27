<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    // 
    public function index()
    {

        $data = [
            'title'           => 'Dashboard',
            'active_menu' => 'dashboard', // Untuk menu aktif di sidebar

        ];

        return view('dashboard/index', $data);
    }
}
