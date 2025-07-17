<?php

namespace App\Models;

use CodeIgniter\Model;

class PrediksiModel extends Model
{
    protected $table            = 'prediksi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'tahun',
        'kecamatan',
        'jumlah',
        'probabilitas',
        'cdf',
        'batas',
        'angka_acak',
        'hasil_prediksi',
        'total_keseluruhan'
    ];
}
