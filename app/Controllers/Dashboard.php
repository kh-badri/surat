<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\SelisihModel;
use App\Models\WilayahModel; // Use WilayahModel instead of KecamatanModel

class Dashboard extends BaseController
{
    protected $guruModel;
    protected $siswaModel;
    protected $selisihModel;
    protected $wilayahModel; // Declare WilayahModel

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->siswaModel = new SiswaModel();
        $this->selisihModel = new SelisihModel();
        $this->wilayahModel = new WilayahModel(); // Initialize WilayahModel
    }

    public function index()
    {
        // --- Existing data fetching (Guru & Siswa) ---
        $allGuru = $this->guruModel->findAll();
        $totalGuru = 0;
        foreach ($allGuru as $guru) {
            $totalGuru += (int)$guru['jumlah'];
        }

        $allSiswa = $this->siswaModel->findAll();
        $totalSiswa = 0;
        foreach ($allSiswa as $siswa) {
            $totalSiswa += (int)$siswa['jumlah'];
        }

        // --- Existing data fetching (Selisih) ---
        $selisihData = $this->selisihModel->findAll();

        $countKekurangan = 0;
        $countKelebihan = 0;

        foreach ($selisihData as $s) {
            if (isset($s['keterangan'])) {
                if ($s['keterangan'] === 'kekurangan') {
                    $countKekurangan++;
                } elseif ($s['keterangan'] === 'kelebihan') {
                    $countKelebihan++;
                }
            }
        }
        // --- End of existing data fetching ---

        // --- NEW: Fetching data for chart (Guru per Kecamatan) ---
        // Assuming 'kecamatan_id' in 'guru' table corresponds to 'id' in 'wilayah' table
        $guruPerKecamatan = $this->guruModel->select('kecamatan_id, SUM(jumlah) as total_guru')
            ->groupBy('kecamatan_id')
            ->findAll();

        // --- NEW: Fetching data for chart (Siswa per Kecamatan) ---
        // Assuming 'kecamatan_id' in 'siswa' table corresponds to 'id' in 'wilayah' table
        $siswaPerKecamatan = $this->siswaModel->select('kecamatan_id, SUM(jumlah) as total_siswa')
            ->groupBy('kecamatan_id')
            ->findAll();

        // --- NEW: Combine data and get kecamatan names from WilayahModel ---
        $chartData = [];
        $kecamatanNames = [];

        // Get all kecamatan names from 'wilayah' table
        // Assuming 'id' is the primary key and 'kecamatan' is the name column in 'wilayah' table
        $allWilayah = $this->wilayahModel->findAll();
        foreach ($allWilayah as $wilayah) {
            $kecamatanNames[$wilayah['id']] = $wilayah['kecamatan']; // Use $wilayah['id'] and $wilayah['kecamatan']
        }

        // Initialize chart data structure with all kecamatan names
        foreach ($kecamatanNames as $id => $name) {
            $chartData[$id] = [
                'name' => $name,
                'total_guru' => 0,
                'total_siswa' => 0,
            ];
        }

        // Populate total_guru
        foreach ($guruPerKecamatan as $item) {
            if (isset($chartData[$item['kecamatan_id']])) {
                $chartData[$item['kecamatan_id']]['total_guru'] = (int)$item['total_guru'];
            }
        }

        // Populate total_siswa
        foreach ($siswaPerKecamatan as $item) {
            if (isset($chartData[$item['kecamatan_id']])) {
                $chartData[$item['kecamatan_id']]['total_siswa'] = (int)$item['total_siswa'];
            }
        }

        $data = [
            'title'           => 'Dashboard',
            'active_menu'     => 'dashboard',
            'total_guru'      => $totalGuru,
            'total_siswa'     => $totalSiswa,
            'countKekurangan' => $countKekurangan,
            'countKelebihan'  => $countKelebihan,
            'chartData'       => array_values($chartData), // Pass combined chart data
        ];

        return view('dashboard/index', $data);
    }
}
