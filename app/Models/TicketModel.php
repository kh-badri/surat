<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id'; // Primary key untuk tabel tickets itu sendiri
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code_ticket',
        'customer_id',
        'nama_customer_ticket',
        'alamat_customer_ticket',
        'no_hp_customer_ticket',
        'keluhan',
        'deskripsi',
        'status',
        'prioritas',
        'tanggal_buat',
        'petugas_id',
        'nama_petugas_ticket',
        'no_hp_petugas_ticket',
        'role_petugas_ticket',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'code_ticket'           => 'required|is_unique[tickets.code_ticket]|max_length[50]',
        'customer_id'           => 'required|integer|is_not_unique[customer.id]', // Memastikan customer_id ada di tabel customer
        'nama_customer_ticket'  => 'required|max_length[100]',
        'no_hp_customer_ticket' => 'required|max_length[20]',
        'keluhan'               => 'required|max_length[255]',
        'status'                => 'required|in_list[open,progress,closed]',
        'prioritas'             => 'required|in_list[low,medium,high,urgent]',
        'petugas_id'            => 'required|integer|is_not_unique[petugas.id_petugas]', // Memastikan petugas_id ada di tabel petugas
        'nama_petugas_ticket'   => 'required|max_length[100]',
        'no_hp_petugas_ticket'  => 'required|max_length[20]',
        'role_petugas_ticket'   => 'required|max_length[50]', // Role petugas adalah VARCHAR(50)
    ];

    protected $validationMessages = [
        'code_ticket' => [
            'required'  => 'Kode tiket harus ada.',
            'is_unique' => 'Kode tiket ini sudah digunakan.'
        ],
        'customer_id' => [
            'required'      => 'Customer harus dipilih.',
            'integer'       => 'ID Customer tidak valid.',
            'is_not_unique' => 'Customer tidak ditemukan.'
        ],
        'nama_customer_ticket' => ['required' => 'Nama customer harus diisi.'],
        'no_hp_customer_ticket' => ['required' => 'No. HP customer harus diisi.'],
        'keluhan' => ['required' => 'Keluhan harus diisi.'],
        'status' => ['required' => 'Status harus dipilih.', 'in_list' => 'Status tidak valid.'],
        'prioritas' => ['required' => 'Prioritas harus dipilih.', 'in_list' => 'Prioritas tidak valid.'],
        'petugas_id' => [
            'required'      => 'Petugas harus dipilih.',
            'integer'       => 'ID Petugas tidak valid.',
            'is_not_unique' => 'Petugas tidak ditemukan.'
        ],
        'nama_petugas_ticket' => ['required' => 'Nama petugas harus diisi.'],
        'no_hp_petugas_ticket' => ['required' => 'No. HP petugas harus diisi.'],
        'role_petugas_ticket' => ['required' => 'Role petugas harus diisi.'],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
