<?php

namespace App\Models;

use CodeIgniter\Model;

class DatasetModel extends Model
{
    protected $table = 'data_tidur'; // Nama tabel database Anda
    protected $primaryKey = 'id'; // Primary key tabel Anda

    protected $useAutoIncrement = true;
    protected $returnType     = 'object'; // Atau 'array'
    protected $useSoftDeletes = false; // Jika Anda tidak menggunakan soft delete

    protected $allowedFields = ['tanggal', 'durasi_tidur', 'kualitas_tidur']; // Kolom yang boleh diisi

    // Tambahkan rules validasi jika ingin model yang memvalidasi
    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}
