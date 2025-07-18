<?php

namespace App\Controllers;

use App\Models\SelisihModel;
use App\Models\PrediksiModel; // Asumsi Anda sudah punya ini
use App\Models\GuruModel; // Asumsi Anda sudah punya ini

class Selisih extends BaseController
{
    protected $selisihModel;
    protected $prediksiModel;
    protected $guruModel;

    public function __construct()
    {
        $this->selisihModel = new SelisihModel();
        $this->prediksiModel = new PrediksiModel(); // Inisialisasi PrediksiModel
        $this->guruModel = new GuruModel(); // Inisialisasi GuruModel
    }

    public function index()
    {
        $selisihData = $this->selisihModel->getSelisihWithKecamatan(); // Ambil semua data selisih

        // === PERUBAHAN DIMULAI DI SINI ===
        $countKekurangan = 0;
        $countKelebihan = 0;

        foreach ($selisihData as $s) {
            if (isset($s['keterangan'])) {
                if ($s['keterangan'] === 'kekurangan') {
                    $countKekurangan++; // Tambah 1 jika keterangan 'kekurangan'
                } elseif ($s['keterangan'] === 'kelebihan') {
                    $countKelebihan++; // Tambah 1 jika keterangan 'kelebihan'
                }
            }
        }
        // === PERUBAHAN SELESAI DI SINI ===

        $data = [
            'active_menu' => 'selisih',
            'title' => 'Data Selisih',
            'selisih' => $selisihData, // Kirim data selisih yang sudah ada
            'countKekurangan' => $countKekurangan, // Tambahkan jumlah kekurangan
            'countKelebihan' => $countKelebihan,   // Tambahkan jumlah kelebihan
        ];
        return view('selisih/index', $data);
    }

    public function new()
    {
        $data = [
            'active_menu' => 'selisih',
            'title' => 'Tambah Data Selisih',
            'validation' => \Config\Services::validation(),
            'kecamatans' => $this->selisihModel->getKecamatanForDropdown(),
            'jumlah_gurus' => $this->selisihModel->getJumlahGuruForDropdown(),
            'years' => $this->getAvailableYears(), // Fungsi untuk mendapatkan tahun
        ];
        return view('selisih/new', $data);
    }

    public function create()
    {
        // Validasi input
        if (!$this->validate([
            'tahun' => [
                'rules' => 'required|numeric',
                'errors' => ['required' => 'Tahun harus diisi.', 'numeric' => 'Tahun harus angka.']
            ],
            'kecamatan_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kecamatan harus dipilih.']
            ],
            'jumlah_guru_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jumlah Guru harus dipilih.']
            ],
        ])) {
            return redirect()->to(site_url('selisih/new'))->withInput();
        }

        $tahun = $this->request->getPost('tahun');
        $kecamatan_id = $this->request->getPost('kecamatan_id'); // Ini adalah id_prediksi dari tabel prediksi
        $id_jumlah_guru = $this->request->getPost('jumlah_guru_id'); // Ini adalah id_guru dari tabel guru

        // Ambil hasil prediksi berdasarkan kecamatan_id dan tahun
        $data_prediksi = $this->selisihModel->getHasilPrediksi($kecamatan_id, $tahun);
        $hasil_prediksi = $data_prediksi ? $data_prediksi['hasil_prediksi'] : 0;

        // Ambil jumlah guru
        $data_guru = $this->selisihModel->getGuruById($id_jumlah_guru);
        $jumlah_guru = $data_guru ? $data_guru['jumlah'] : 0;

        // Hitung kebutuhan dan bulatkan (LOGIKA DIPERBAIKI)
        $kebutuhan = round($hasil_prediksi / 20);

        // Hitung nilai_selisih
        $nilai_selisih = $kebutuhan - $jumlah_guru;

        // Tentukan keterangan (LOGIKA DIPERBAIKI)
        // Jika nilai selisih positif (> 0), berarti Kebutuhan > Jumlah Guru, maka statusnya "kekurangan".
        // Jika negatif atau nol, berarti Kebutuhan <= Jumlah Guru, maka statusnya "kelebihan".
        $keterangan = ($nilai_selisih > 0) ? 'kekurangan' : 'kelebihan';

        $this->selisihModel->save([
            'tahun' => $tahun,
            'kecamatan_id' => $kecamatan_id, // Simpan nilai id_prediksi
            'hasil_prediksi_id' => $hasil_prediksi, // Simpan nilai hasil prediksi
            'jumlah_guru_id' => $jumlah_guru, // Simpan nilai jumlah guru
            'kebutuhan' => $kebutuhan,
            'nilai_selisih' => $nilai_selisih,
            'keterangan' => $keterangan,
        ]);

        session()->setFlashdata('success', 'Data Selisih berhasil ditambahkan!');
        return redirect()->to(site_url('selisih'));
    }

    public function edit($id_selisih)
    {
        $data = [
            'active_menu' => 'selisih',
            'title' => 'Edit Data Selisih',
            'validation' => \Config\Services::validation(),
            'selisih' => $this->selisihModel->find($id_selisih),
            'kecamatans' => $this->selisihModel->getKecamatanForDropdown(),
            'jumlah_gurus' => $this->selisihModel->getJumlahGuruForDropdown(),
            'years' => $this->getAvailableYears(),
        ];
        return view('selisih/edit', $data);
    }

    public function update($id_selisih)
    {
        // Validasi input
        if (!$this->validate([
            'tahun' => [
                'rules' => 'required|numeric',
                'errors' => ['required' => 'Tahun harus diisi.', 'numeric' => 'Tahun harus angka.']
            ],
            'kecamatan_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kecamatan harus dipilih.']
            ],
            'jumlah_guru_id' => [
                'rules' => 'required',
                'errors' => ['required' => 'Jumlah Guru harus dipilih.']
            ],
        ])) {
            return redirect()->to(site_url('selisih/edit/' . $id_selisih))->withInput();
        }

        $tahun = $this->request->getPost('tahun');
        $kecamatan_id = $this->request->getPost('kecamatan_id'); // Ini adalah id_prediksi dari tabel prediksi
        $id_jumlah_guru = $this->request->getPost('jumlah_guru_id');

        // Ambil hasil prediksi berdasarkan kecamatan_id dan tahun
        $data_prediksi = $this->selisihModel->getHasilPrediksi($kecamatan_id, $tahun);
        $hasil_prediksi = $data_prediksi ? $data_prediksi['hasil_prediksi'] : 0;

        // Ambil jumlah guru
        $data_guru = $this->selisihModel->getGuruById($id_jumlah_guru);
        $jumlah_guru = $data_guru ? $data_guru['jumlah'] : 0;

        // Hitung kebutuhan dan bulatkan (LOGIKA DIPERBAIKI)
        $kebutuhan = round($hasil_prediksi / 20);

        // Hitung nilai_selisih
        $nilai_selisih = $kebutuhan - $jumlah_guru;

        // Tentukan keterangan (LOGIKA DIPERBAIKI)
        // Jika nilai selisih positif (> 0), berarti Kebutuhan > Jumlah Guru, maka statusnya "kekurangan".
        // Jika negatif atau nol, berarti Kebutuhan <= Jumlah Guru, maka statusnya "kelebihan".
        $keterangan = ($nilai_selisih > 0) ? 'kekurangan' : 'kelebihan';

        $this->selisihModel->update($id_selisih, [
            'tahun' => $tahun,
            'kecamatan_id' => $kecamatan_id, // Simpan nilai id_prediksi
            'hasil_prediksi_id' => $hasil_prediksi,
            'jumlah_guru_id' => $jumlah_guru,
            'kebutuhan' => $kebutuhan,
            'nilai_selisih' => $nilai_selisih,
            'keterangan' => $keterangan,
        ]);

        session()->setFlashdata('success', 'Data Selisih berhasil diperbarui!');
        return redirect()->to(site_url('selisih'));
    }

    public function delete($id_selisih)
    {
        $this->selisihModel->delete($id_selisih);
        session()->setFlashdata('success', 'Data Selisih berhasil dihapus!');
        return redirect()->to(site_url('selisih'));
    }

    // Fungsi untuk mendapatkan tahun yang tersedia (misal, 5 tahun ke depan dari tahun saat ini)
    private function getAvailableYears()
    {
        $currentYear = date('Y');
        $years = [];
        for ($i = 0; $i < 5; ++$i) { // Perbaikan: ++$i lebih efisien
            $years[] = $currentYear + $i;
        }
        return $years;
    }

    // API untuk mendapatkan hasil prediksi berdasarkan kecamatan dan tahun
    public function get_hasil_prediksi()
    {
        $kecamatan_id = $this->request->getGet('kecamatan_id');
        $tahun = $this->request->getGet('tahun');

        $data_prediksi = $this->selisihModel->getHasilPrediksi($kecamatan_id, $tahun);

        if ($data_prediksi) {
            return $this->response->setJSON(['hasil_prediksi' => $data_prediksi['hasil_prediksi']]);
        } else {
            return $this->response->setJSON(['hasil_prediksi' => 0]);
        }
    }

    // API untuk mendapatkan jumlah guru berdasarkan tahun dan kecamatan (jika ada relasi di tabel guru)
    public function get_jumlah_guru()
    {
        $tahun = $this->request->getGet('tahun');
        $kecamatan_id = $this->request->getGet('kecamatan_id');

        // Ini perlu disesuaikan jika tabel guru tidak memiliki kecamatan_id
        // Atau Anda bisa melakukan query JOIN di model jika relasi kompleks.
        // Pastikan GuruModel memiliki metode `where` dan `first` yang sesuai
        $data_guru = $this->guruModel->where('tahun', $tahun)
            ->where('kecamatan_id', $kecamatan_id) // Asumsi ada kolom kecamatan_id di tabel guru
            ->first();

        if ($data_guru) {
            return $this->response->setJSON(['jumlah' => $data_guru['jumlah']]);
        } else {
            return $this->response->setJSON(['jumlah' => 0]);
        }
    }
}
