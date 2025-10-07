<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluarModel extends Model
{
    // Properti Model disesuaikan dengan struktur Anda
    protected $table            = 'surat_keluar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // PERBAIKAN: Kolom yang diizinkan disesuaikan dengan logika aplikasi saat ini
    protected $allowedFields    = [
        'login_id',
        'jenis_surat',
        'tipe_surat',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'lampiran'
    ];

    // Mengaktifkan timestamp (created_at, updated_at)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    /**
     * Menghasilkan nomor surat baru secara otomatis.
     * Nomor ini berlanjut dari surat terakhir yang dibuat pada tahun yang sama,
     * tanpa memandang tipe suratnya.
     * Format: 002.1/NOMOR_URUT/PTI/FT-UNA/TAHUN
     *
     * @param string $tipeSurat (Parameter tidak digunakan dalam logika baru, tapi dipertahankan agar tidak error di controller)
     * @return string Nomor surat yang sudah digenerate.
     */
    public function generateNomorSurat($tipeSurat = '')
    {
        // 1. Definisikan kode awalan yang statis untuk semua surat
        $kodeTipe = '002.1';
        $tahunSekarang = date('Y');
        $kodeAkhiran = "/PTI/FT-UNA/{$tahunSekarang}";

        // 2. Cari nomor surat terakhir di database, TANPA memandang tipe surat, hanya berdasarkan tahun
        $lastSurat = $this->like('nomor_surat', $kodeAkhiran, 'before') // cari yang tahunnya sama
            ->orderBy('id', 'DESC')
            ->first();

        $nomorUrutBaru = 1; // Nomor urut akan dimulai dari 1 jika belum ada surat di tahun ini

        if ($lastSurat) {
            // 3. Jika surat sudah ada, ambil nomor urutnya dan tambahkan 1
            $nomorTerakhir = $lastSurat['nomor_surat'];
            $parts = explode('/', $nomorTerakhir);

            // Cek jika formatnya sesuai (KODE/NOMOR/...)
            if (isset($parts[1]) && is_numeric($parts[1])) {
                $nomorUrutTerakhir = (int) $parts[1];
                $nomorUrutBaru = $nomorUrutTerakhir + 1;
            }
        }

        // 4. Gabungkan semua bagian menjadi format nomor surat yang lengkap
        $nomorSuratBaru = "{$kodeTipe}/{$nomorUrutBaru}{$kodeAkhiran}";

        return $nomorSuratBaru;
    }
}
