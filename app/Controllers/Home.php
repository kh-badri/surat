<?php

namespace App\Controllers;

class Home extends BaseController
{
    // 
    public function index()
    {

        $data = [
            'title'           => 'Home',
            'active_menu'     => 'home',

        ];

        return view('home/index', $data);
    }
}
