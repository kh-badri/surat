<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table      = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields    = true;

    // Semua kolom yang diizinkan untuk diisi dari luar (form)
    protected $allowedFields = [
        'nama_petugas',
        'alamat_petugas',
        'no_hp',
        'email',
        'role'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Aturan validasi untuk setiap kolom
    protected $validationRules = [
        'nama_petugas'   => 'required|min_length[3]|max_length[100]',
        'alamat_petugas' => 'required', // Menambahkan validasi untuk alamat
        'no_hp'          => 'required|numeric|min_length[10]|max_length[15]|is_unique[petugas.no_hp,id_petugas,{id_petugas}]',
        'email'          => 'permit_empty|valid_email|is_unique[petugas.email,id_petugas,{id_petugas}]',
        'role'           => 'required|in_list[teknisi,admin,supervisor,noc]',
    ];

    // Pesan validasi khusus
    protected $validationMessages = [
        'nama_petugas' => [
            'required'   => 'Nama Petugas harus diisi.',
            'min_length' => 'Nama Petugas minimal 3 karakter.',
            'max_length' => 'Nama Petugas terlalu panjang (maksimal 100 karakter).'
        ],
        'alamat_petugas' => [
            'required' => 'Alamat Petugas harus diisi.'
        ],
        'no_hp' => [
            'required'    => 'Nomor HP harus diisi.',
            'numeric'     => 'Nomor HP harus berupa angka.',
            'min_length'  => 'Nomor HP terlalu pendek (minimal 10 digit).',
            'max_length'  => 'Nomor HP terlalu panjang (maksimal 15 digit).',
            'is_unique'   => 'Nomor HP ini sudah terdaftar.'
        ],
        'email' => [
            'valid_email' => 'Format Email tidak valid.',
            'is_unique'   => 'Email ini sudah terdaftar.'
        ],
        'role' => [
            'required' => 'Role petugas harus dipilih.',
            'in_list'  => 'Role yang dipilih tidak valid.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
