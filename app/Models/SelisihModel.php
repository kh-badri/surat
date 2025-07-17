<?php

namespace App\Models;

use CodeIgniter\Model;

class SelisihModel extends Model
{
    protected $table = 'selisih';
    protected $primaryKey = 'id_selisih';
    protected $allowedFields = [
        'tahun',
        'kecamatan_id',
        'hasil_prediksi_id',
        'jumlah_guru_id',
        'kebutuhan',
        'nilai_selisih',
        'keterangan'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data kecamatan dari tabel prediksi untuk dropdown.
     * Menggunakan MIN(id_prediksi) untuk mengatasi sql_mode=only_full_group_by.
     * @param int $tahun Opsional: untuk memfilter berdasarkan tahun.
     * @return array
     */
    public function getKecamatanForDropdown($tahun = null)
    {
        $builder = $this->db->table('prediksi');
        // Menggunakan MIN(id_prediksi) untuk mendapatkan satu id_prediksi per kecamatan unik
        $builder->select('MIN(id_prediksi) as id_prediksi, kecamatan');
        if ($tahun) {
            $builder->where('tahun', $tahun);
        }
        $builder->groupBy('kecamatan'); // Grouping by kecamatan
        // Order by kecamatan for better display in dropdown
        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil hasil prediksi berdasarkan id_prediksi (yang disimpan sebagai kecamatan_id di tabel selisih) dan tahun.
     * @param int $id_prediksi
     * @param int $tahun
     * @return array|null
     */
    public function getHasilPrediksi($id_prediksi, $tahun)
    {
        return $this->db->table('prediksi')
            ->select('hasil_prediksi')
            ->where('id_prediksi', $id_prediksi)
            ->where('tahun', $tahun)
            ->get()
            ->getRowArray();
    }

    /**
     * Mengambil jumlah guru dari tabel guru.
     * @param int $tahun Opsional: untuk memfilter berdasarkan tahun.
     * @param int $kecamatan_id Opsional: untuk memfilter berdasarkan kecamatan.
     * @return array
     */
    public function getJumlahGuruForDropdown($tahun = null, $kecamatan_id = null)
    {
        $builder = $this->db->table('guru');
        $builder->select('id_guru, jumlah');
        if ($tahun) {
            $builder->where('tahun', $tahun);
        }
        if ($kecamatan_id) {
            // Ini perlu disesuaikan jika tabel guru memiliki kolom kecamatan_id
            // Atau Anda bisa melakukan query JOIN di model jika relasi kompleks.
            // Jika ada relasi: $builder->where('kecamatan_id', $kecamatan_id);
        }
        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil data guru berdasarkan ID.
     * @param int $id_guru
     * @return array|null
     */
    public function getGuruById($id_guru)
    {
        return $this->db->table('guru')
            ->select('jumlah')
            ->where('id_guru', $id_guru)
            ->get()
            ->getRowArray();
    }

    /**
     * Mengambil semua data selisih beserta nama kecamatan.
     * Digunakan untuk menampilkan di halaman indeks.
     * @return array
     */
    public function getSelisihWithKecamatan()
    {
        return $this->db->table($this->table)
            ->select('selisih.*, prediksi.kecamatan') // Pilih semua kolom selisih dan nama kecamatan dari prediksi
            ->join('prediksi', 'prediksi.id_prediksi = selisih.kecamatan_id', 'left')
            ->get()
            ->getResultArray();
    }
}
