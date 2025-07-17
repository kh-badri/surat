<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Bantuan extends Controller // Nama kelas harus 'Bantuan'
{
    public function index()
    {
        $data = [
            'active_menu' => 'bantuan', // Menambahkan 'active_menu' ke array data
        ];

        return view('bantuan/index', $data); // Melewatkan array data ke view
    }
}
