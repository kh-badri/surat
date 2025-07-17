<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\WilayahModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $wilayahModel;
    protected array $validationRules;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->wilayahModel = new WilayahModel();

        // Aturan validasi terpusat untuk create dan update
        $this->validationRules = [
            'tahun' => [
                'rules' => 'required|integer',
                'errors' => ['required' => 'Tahun wajib diisi.', 'integer' => 'Format tahun tidak valid.']
            ],
            'kecamatan_id' => [
                'rules' => 'required|is_natural_no_zero',
                'errors' => ['required' => 'Nama kecamatan wajib dipilih.']
            ],
            'jumlah' => [
                'rules' => 'required|numeric',
                'errors' => ['required' => 'Jumlah siswa wajib diisi.', 'numeric' => 'Jumlah harus berupa angka.']
            ]
        ];
    }

    public function index()
    {
        $selectedTahun = $this->request->getGet('tahun');
        $siswa_list = $this->siswaModel->getSiswaWithWilayah($selectedTahun); // Mengambil data siswa yang sudah di-join dan difilter

        $tahun_list = $this->siswaModel->getDistinctTahun();

        // --- Bagian baru untuk menghitung total jumlah ---
        $total_jumlah = 0;
        foreach ($siswa_list as $siswa) {
            $total_jumlah += (int)$siswa['jumlah']; // Pastikan 'jumlah' adalah integer
        }
        // ---------------------------------------------------

        $data = [
            'title'          => 'Data Siswa',
            'siswa_list'     => $siswa_list,
            'tahun_list'     => $tahun_list, // getDistinctTahun() sudah mengembalikan array kolom 'tahun'
            'selected_tahun' => $selectedTahun,
            'total_jumlah'   => $total_jumlah, // Menambahkan total_jumlah ke data yang dikirim ke view
            'active_menu'    => 'siswa'
        ];
        return view('siswa/index', $data);
    }

    public function new()
    {
        $data = [
            'title'        => 'Tambah Data Siswa',
            'wilayah_list' => $this->wilayahModel->findAll(),
            'validation'   => \Config\Services::validation(),
            'active_menu'  => 'siswa'
        ];
        return view('siswa/new', $data);
    }

    public function create()
    {
        if (!$this->validate($this->validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $tahun = $this->request->getPost('tahun');
        $this->siswaModel->save([
            'tahun'        => $tahun,
            'kecamatan_id' => $this->request->getPost('kecamatan_id'),
            'jumlah'       => $this->request->getPost('jumlah')
        ]);

        // LANGSUNG PANGGIL FUNGSI KALKULASI SETELAH MENYIMPAN
        $this->_calculateByYear($tahun);

        session()->setFlashdata('success', 'Data siswa berhasil ditambahkan dan dihitung.');
        return redirect()->to('/siswa?tahun=' . $tahun);
    }

    public function edit($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            throw PageNotFoundException::forPageNotFound('Data siswa dengan ID ' . $id . ' tidak ditemukan.');
        }
        $data = [
            'title'        => 'Edit Data Siswa',
            'siswa'        => $siswa,
            'wilayah_list' => $this->wilayahModel->findAll(),
            'validation'   => \Config\Services::validation(),
            'active_menu'  => 'siswa'
        ];
        return view('siswa/edit', $data);
    }

    public function update($id)
    {
        if (!$this->siswaModel->find($id)) {
            throw PageNotFoundException::forPageNotFound('Data tidak ditemukan.');
        }

        if (!$this->validate($this->validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $tahun = $this->request->getPost('tahun');
        $this->siswaModel->update($id, [
            'tahun'        => $tahun,
            'kecamatan_id' => $this->request->getPost('kecamatan_id'),
            'jumlah'       => $this->request->getPost('jumlah')
        ]);

        // LANGSUNG PANGGIL FUNGSI KALKULASI SETELAH UPDATE
        $this->_calculateByYear($tahun);

        session()->setFlashdata('success', 'Data siswa berhasil diperbarui dan dihitung ulang.');
        return redirect()->to('/siswa?tahun=' . $tahun);
    }

    public function delete($id)
    {
        // Ambil data siswa sebelum dihapus untuk mendapatkan tahunnya
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            throw PageNotFoundException::forPageNotFound('Data tidak ditemukan.');
        }

        $tahun = $siswa['tahun'];
        $this->siswaModel->delete($id);

        // HITUNG ULANG SETELAH DATA DIHAPUS
        $this->_calculateByYear($tahun);

        session()->setFlashdata('success', 'Data siswa berhasil dihapus dan perhitungan telah diperbarui.');
        return redirect()->to('/siswa?tahun=' . $tahun);
    }

    /**
     * Menghitung probabilitas, CDF, dan batas RI untuk data siswa berdasarkan tahun
     * @param int $tahun Tahun yang akan dihitung
     */
    private function _calculateByYear($tahun)
    {
        $dataSiswa = $this->siswaModel->where('tahun', $tahun)->orderBy('kecamatan_id')->findAll();

        if (empty($dataSiswa)) {
            return; // Keluar jika tidak ada data
        }

        $totalPermintaan = array_sum(array_column($dataSiswa, 'jumlah'));

        // Validasi total permintaan harus lebih dari 0
        if ($totalPermintaan <= 0) {
            return;
        }

        $updateData = [];
        $cumulativeProb = 0;
        $batasBawah = 0;
        $totalData = count($dataSiswa);

        foreach ($dataSiswa as $index => $siswa) {
            // Validasi data siswa
            if (!isset($siswa['jumlah']) || $siswa['jumlah'] < 0) {
                continue;
            }

            $probabilitas = $siswa['jumlah'] / $totalPermintaan;
            $cumulativeProb += $probabilitas;

            // Untuk data terakhir, pastikan CDF = 1.000 (menghindari floating point error)
            if ($index === $totalData - 1) {
                $cumulativeProb = 1.000;
            }

            $batasAtas = $cumulativeProb;
            $batasRi = number_format($batasBawah, 3, '.', '') . ' - ' . number_format($batasAtas, 3, '.', '');

            $updateData[] = [
                'id_siswa'     => $siswa['id_siswa'],
                'probabilitas' => round($probabilitas, 3),
                'cdf'          => round($cumulativeProb, 3),
                'batas'        => $batasRi,
            ];

            $batasBawah = $batasAtas;
        }

        if (!empty($updateData)) {
            try {
                $this->siswaModel->updateBatch($updateData, 'id_siswa');
            } catch (Exception $e) {
                // Log error atau handle sesuai kebutuhan
                log_message('error', 'Gagal update batch probability: ' . $e->getMessage());
            }
        }
    }
}
