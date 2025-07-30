<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table            = 'petugas';
    protected $primaryKey       = 'id_petugas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
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

    // --- KRUSIAL: TAMBAHKAN KEMBALI BAGIAN INI ---
    protected $validationRules = [
        'nama_petugas'  => 'required|max_length[100]',
        'no_hp'         => 'required|max_length[20]',
        'email'         => 'permit_empty|valid_email|is_unique[petugas.email]',
        'role'          => 'required|in_list[teknisi,admin,supervisor,noc]',
    ];
    // --- AKHIR BAGIAN YANG DITAMBAHKAN KEMBALI ---

    protected $validationMessages = [
        'nama_petugas' => [
            'required'  => 'Nama Petugas harus diisi.',
            'max_length' => 'Nama Petugas terlalu panjang.'
        ],
        'no_hp' => [
            'required'  => 'Nomor HP harus diisi.',
            'max_length' => 'Nomor HP terlalu panjang.'
        ],
        'email' => [
            'valid_email' => 'Format Email tidak valid.',
            'is_unique' => 'Email ini sudah terdaftar.'
        ],
        'role' => [
            'required'  => 'Role petugas harus dipilih.',
            'in_list'   => 'Role yang dipilih tidak valid. Pilihan yang tersedia: Teknisi, Admin, Supervisor, Noc.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true; // Ini juga penting, pastikan tidak hilang
}
