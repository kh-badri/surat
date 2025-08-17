<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
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

    // Validation Rules (Default)
    // Aturan yang berlaku untuk semua skenario
    protected $validationRules = [
        'code_ticket'       => 'required|is_unique[tickets.code_ticket]|max_length[50]',
        'keluhan'           => 'required|max_length[255]',
        'status'            => 'required|in_list[open,progress,closed,selesai]',
        'prioritas'         => 'required|in_list[low,medium,high,urgent]',
        'petugas_id'        => 'required|integer|is_not_unique[petugas.id_petugas]',
    ];

    // Validation Messages (Default)
    protected $validationMessages = [
        'code_ticket' => [
            'required'  => 'Kode tiket harus ada.',
            'is_unique' => 'Kode tiket ini sudah digunakan.'
        ],
        'keluhan' => ['required' => 'Keluhan harus diisi.'],
        'status' => ['required' => 'Status harus dipilih.', 'in_list' => 'Status tidak valid.'],
        'prioritas' => ['required' => 'Prioritas harus dipilih.', 'in_list' => 'Prioritas tidak valid.'],
        'petugas_id' => [
            'required'      => 'Petugas harus dipilih.',
            'integer'       => 'ID Petugas tidak valid.',
            'is_not_unique' => 'Petugas tidak ditemukan.'
        ],
    ];

    // Validation Groups for different scenarios
    // Grup validasi untuk skenario "Pilih Pelanggan"
    protected $validationGroups = [
        'createFromCustomer' => [
            'customer_id' => 'required|integer|is_not_unique[customer.id]',
            'nama_customer_ticket' => 'permit_empty|max_length[100]',
            'no_hp_customer_ticket' => 'permit_empty|max_length[20]',
        ],
        // Grup validasi untuk skenario "Custom Input Pelanggan"
        'createFromCustom' => [
            'customer_id' => 'permit_empty', // Izinkan customer_id kosong
            'nama_customer_ticket' => 'required|max_length[100]',
            'alamat_customer_ticket' => 'permit_empty|max_length[255]',
            'no_hp_customer_ticket' => 'required|max_length[20]',
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
