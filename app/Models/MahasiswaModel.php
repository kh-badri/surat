<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // INI BAGIAN PALING PENTING
    // Pastikan semua kolom dari tabel 'mahasiswa' yang ingin Anda isi ada di sini.
    protected $allowedFields    = [
        'surat_keluar_id',
        'npm',
        'nama_mahasiswa',
        'perusahaan',
        'alamat_perusahaan',
        'judul',
        'dosen_pembimbing',
        'waktu_pelaksanaan',
        'dosen_pembanding',
        'dosen_penguji'
    ];

    // Mengaktifkan Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
