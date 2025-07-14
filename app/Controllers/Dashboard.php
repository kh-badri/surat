<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function index()
    {
        // Tidak perlu ada checkLogin() di sini sama sekali.
        return view('dashboard/index', [
            'title'       => 'Dashboard',
            'active_menu' => 'dashboard'
        ]);
    }
}
