<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    // **PERBAIKAN DI SINI**
    // Nama tabel disesuaikan dengan nama tabel di database Anda
    protected $table            = 'login';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'email', 'foto'];

    /**
     * Mengambil data user berdasarkan username.
     * @param string $username
     * @return array|null
     */
    public function getUserByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Menyimpan data pengguna baru ke database.
     * @param array $data
     * @return bool
     */
    public function registerUser(array $data)
    {
        return $this->insert($data);
    }
}
