<?php

namespace App\Controllers;

// Gunakan kedua model yang diperlukan
use App\Models\SiswaModel;
use App\Models\PrediksiModel;

class Prediksi extends BaseController
{
    protected $siswaModel;
    protected $prediksiModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->prediksiModel = new PrediksiModel();
    }

    /**
     * Metode index() yang dimodifikasi untuk memuat dan menyimpan data prediksi.
     */
    public function index()
    {
        $total_prediksi = null;
        $selected_year = $this->request->getVar('tahun');
        $data_siswa = $this->siswaModel->getSiswaWithWilayah($selected_year);
        $available_years = $this->siswaModel->getDistinctTahun();

        if (!empty($data_siswa)) {
            usort($data_siswa, function ($a, $b) {
                return $a['cdf'] <=> $b['cdf'];
            });

            // =====================================================================
            // >> BAGIAN BARU: Memuat Hasil Prediksi yang Sudah Tersimpan <<
            // =====================================================================
            // Cek apakah ada data prediksi tersimpan untuk tahun yang dipilih
            $saved_predictions = $this->prediksiModel->where('tahun', $selected_year)->findAll();

            if (!empty($saved_predictions)) {
                // Buat "peta" untuk memudahkan pencarian data berdasarkan kecamatan
                $predictions_map = [];
                foreach ($saved_predictions as $pred) {
                    $predictions_map[$pred['kecamatan']] = $pred;
                }

                // Loop melalui data siswa dan suntikkan data prediksi yang tersimpan
                foreach ($data_siswa as $key => $row) {
                    if (isset($predictions_map[$row['kecamatan']])) {
                        $data_siswa[$key]['angka_acak'] = $predictions_map[$row['kecamatan']]['angka_acak'];
                        $data_siswa[$key]['hasil_prediksi'] = $predictions_map[$row['kecamatan']]['hasil_prediksi'];
                    }
                }

                // Ambil juga total prediksi yang sudah tersimpan
                $total_prediksi = $saved_predictions[0]['total_keseluruhan'];
            }
            // =====================================================================
            // >> AKHIR BAGIAN BARU <<
            // =====================================================================
        }

        // Jika metode adalah POST (menjalankan prediksi baru),
        // data yang sudah dimuat di atas akan ditimpa oleh hasil perhitungan baru.
        if (strtolower($this->request->getMethod()) === 'post') {
            $post_data = $this->request->getPost();
            $a = (int)($post_data['a'] ?? 19);
            $c = (int)($post_data['c'] ?? 237);
            $m = (int)($post_data['m'] ?? 128);
            $x0 = (int)($post_data['x0'] ?? 12357);

            if (!empty($data_siswa)) {
                $data_siswa = $this->hitungMonteCarlo($data_siswa, $a, $c, $m, $x0);
                $total_prediksi = array_sum(array_column($data_siswa, 'hasil_prediksi'));

                // Set flag untuk menandakan bahwa ini adalah hasil simulasi baru
                session()->setFlashdata('info', 'Simulasi prediksi berhasil dijalankan. Data belum tersimpan, klik tombol "Simpan Hasil Prediksi" untuk menyimpan.');
            }
        }

        $data = [
            'active_menu'     => 'prediksi',
            'title'           => 'Halaman Prediksi Data Siswa Dengan Metode Monte Carlo',
            'data_tabel'      => $data_siswa,
            'available_years' => $available_years,
            'selected_year'   => $selected_year,
            'total_prediksi'  => $total_prediksi,
            'is_simulation'   => strtolower($this->request->getMethod()) === 'post' && !empty($data_siswa),
        ];

        return view('prediksi/index', $data);
    }

    /**
     * Metode simpan() - bisa dipertahankan untuk keperluan khusus
     */
    public function simpan()
    {
        $dataPrediksiJson = $this->request->getPost('data_prediksi');
        $totalPrediksi = $this->request->getPost('total_prediksi');
        $dataFromView = json_decode($dataPrediksiJson, true);

        if (empty($dataFromView)) {
            return redirect()->to('prediksi')->with('error', 'Tidak ada data hasil prediksi untuk disimpan.');
        }

        $tahun_prediksi = $dataFromView[0]['tahun'];
        $this->prediksiModel->where('tahun', $tahun_prediksi)->delete();

        $dataToInsert = [];
        foreach ($dataFromView as $row) {
            $dataToInsert[] = [
                'tahun'             => $row['tahun'],
                'kecamatan'         => $row['kecamatan'],
                'jumlah'            => $row['jumlah'],
                'probabilitas'      => $row['probabilitas'],
                'cdf'               => $row['cdf'],
                'batas'             => $row['batas'],
                'angka_acak'        => $row['angka_acak'] ?? null,
                'hasil_prediksi'    => $row['hasil_prediksi'] ?? null,
                'total_keseluruhan' => $totalPrediksi,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
        }

        $this->prediksiModel->insertBatch($dataToInsert);
        return redirect()->to('prediksi')->with('success', "Data prediksi untuk tahun {$tahun_prediksi} berhasil diperbarui.");
    }

    // --- FUNGSI HELPER (TIDAK ADA PERUBAHAN) ---

    private function hitungMonteCarlo($data_siswa, $a, $c, $m, $x0)
    {
        $jumlah_data = count($data_siswa);
        $x_sekarang = $x0;

        for ($i = 0; $i < $jumlah_data; $i++) {
            $x_sekarang = ($a * $x_sekarang + $c) % $m;
            $angka_acak = $x_sekarang / $m;
            $data_siswa[$i]['angka_acak'] = $angka_acak;
            $data_siswa[$i]['hasil_prediksi'] = $this->tentukanHasilPrediksi($angka_acak, $data_siswa);
        }

        return $data_siswa;
    }

    private function tentukanHasilPrediksi($angka_acak, $data_siswa)
    {
        foreach ($data_siswa as $row) {
            if ($angka_acak <= $row['cdf']) {
                return $row['jumlah'];
            }
        }
        return end($data_siswa)['jumlah'];
    }
}
