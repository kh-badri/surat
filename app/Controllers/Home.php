<?php

namespace App\Controllers;

class Home extends BaseController
{
    // 
    public function index()
    {

        $data = [
            'title'           => 'Home',
            'active_menu' => 'home', // Untuk menu aktif di sidebar

        ];

        return view('home/index', $data);
    }
}
