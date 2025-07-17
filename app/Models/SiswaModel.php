<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['kecamatan_id', 'tahun', 'jumlah', 'probabilitas', 'cdf', 'batas'];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil semua data siswa dengan nama kecamatan dari tabel wilayah.
     */
    public function getSiswaWithWilayah($tahun = null)
    {
        $builder = $this->db->table('siswa');
        // Sesuaikan 'id_siswa' jika nama kolom primary key Anda berbeda
        $builder->select('siswa.id_siswa, siswa.tahun, siswa.jumlah, siswa.probabilitas, siswa.cdf, siswa.batas, wilayah.kecamatan');
        $builder->join('wilayah', 'wilayah.id = siswa.kecamatan_id');

        // Jika parameter tahun ada nilainya, tambahkan filter WHERE
        if ($tahun) {
            $builder->where('siswa.tahun', $tahun);
        }

        // $builder->orderBy('siswa.tahun', 'DESC');
        // $builder->orderBy('wilayah.kecamatan', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil semua tahun unik dari tabel siswa untuk dropdown filter.
     */
    public function getDistinctTahun()
    {
        // Mengembalikan array berisi tahun-tahun unik, misal: [2025, 2024, 2023]
        return $this->distinct()->orderBy('tahun', 'DESC')->findColumn('tahun');
    }
}
