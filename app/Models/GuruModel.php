<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'guru';
    protected $primaryKey       = 'id_guru';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['kecamatan_id', 'tahun', 'jumlah'];

    /**
     * Mengambil semua data guru dengan join ke tabel wilayah
     * untuk mendapatkan nama kecamatan.
     */
    public function getGuruWithWilayah()
    {
        $builder = $this->db->table('guru');
        $builder->select('guru.id_guru, guru.tahun, guru.jumlah, wilayah.kecamatan, guru.kecamatan_id');
        $builder->join('wilayah', 'wilayah.id = guru.kecamatan_id');
        $builder->orderBy('guru.tahun', 'DESC');
        $builder->orderBy('guru.kecamatan_id', 'ASC'); // <-- DIUBAH DI SINI

        return $builder->get()->getResultArray();
    }
}
