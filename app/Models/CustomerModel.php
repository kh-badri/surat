<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_customer',
        'nama_customer',
        'alamat',
        'no_hp',
        'email'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        // --- PERUBAHAN DI SINI: id_customer tidak lagi unique ---
        'id_customer'   => 'required|max_length[50]', // Hapus 'is_unique[customer.id_customer]'
        'nama_customer' => 'required|max_length[100]',
        'no_hp'         => 'required|max_length[20]',
        'email'         => 'permit_empty|valid_email|is_unique[customer.email]', // Email tetap unique
    ];
    protected $validationMessages   = [
        'id_customer' => [
            'required' => 'ID Customer harus diisi.',
            // 'is_unique' => 'ID Customer ini sudah terdaftar.', // Hapus pesan ini
            'max_length' => 'ID Customer terlalu panjang.'
        ],
        'nama_customer' => [
            'required' => 'Nama Customer harus diisi.',
            'max_length' => 'Nama Customer terlalu panjang.'
        ],
        'no_hp' => [
            'required' => 'Nomor HP harus diisi.',
            'max_length' => 'Nomor HP terlalu panjang.'
        ],
        'email' => [
            'valid_email' => 'Format Email tidak valid.',
            'is_unique' => 'Email ini sudah terdaftar.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
