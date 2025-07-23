<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DatasetModel; // Pastikan Anda telah membuat DatasetModel

class DatasetController extends BaseController
{
    protected $datasetModel;

    public function __construct()
    {
        // Inisialisasi Model di constructor
        $this->datasetModel = new DatasetModel();
    }

    public function index()
    {
        // Menggunakan Model untuk mengambil data
        $dataTidur = $this->datasetModel->orderBy('tanggal', 'DESC')->findAll();

        return view('dataset/index', ['data_tidur' => $dataTidur]);
    }

    public function upload()
    {
        $validationRule = [
            'dataset_csv' => [
                'label' => 'File CSV',
                'rules' => 'uploaded[dataset_csv]'
                    . '|ext_in[dataset_csv,csv]'
                    . '|max_size[dataset_csv,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->to('/dataset')
                ->withInput()
                ->with('error', $this->validator->getErrors()['dataset_csv']);
        }

        $file = $this->request->getFile('dataset_csv');
        if (!$file->isValid()) {
            return redirect()->to('/dataset')->with('error', $file->getErrorString() . '(' . $file->getError() . ')');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);
        $pathToFile = WRITEPATH . 'uploads/' . $newName;

        $insertedCount = 0;
        $skippedCount = 0;

        if (($handle = fopen($pathToFile, 'r')) !== false) {
            $isHeader = true;

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                // Pastikan indeks array sesuai dengan struktur CSV Anda
                $tanggal = date('Y-m-d', strtotime($data[0] ?? ''));
                $durasiTidur = (float) ($data[1] ?? 0);
                $kualitasTidur = (float) ($data[2] ?? 0);

                // Cek apakah data dengan tanggal tersebut sudah ada
                $exists = $this->datasetModel->where('tanggal', $tanggal)->countAllResults();

                if ($exists == 0 && !empty($tanggal)) {
                    $this->datasetModel->insert([
                        'tanggal' => $tanggal,
                        'durasi_tidur' => $durasiTidur,
                        'kualitas_tidur' => $kualitasTidur,
                    ]);
                    $insertedCount++;
                } else {
                    $skippedCount++;
                }
            }

            fclose($handle);
            unlink($pathToFile); // Hapus file CSV setelah diproses

            return redirect()->to('/dataset')
                ->with('success', "Upload selesai! Data baru ditambahkan: {$insertedCount}. Duplikat diabaikan: {$skippedCount}.");
        } else {
            return redirect()->to('/dataset')->with('error', 'Gagal membuka file CSV.');
        }
    }

    // Method untuk menampilkan form edit data
    public function edit($id)
    {
        $data = $this->datasetModel->find($id);

        if (empty($data)) {
            // Jika data tidak ditemukan, lempar error 404 atau redirect
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidur dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('dataset/edit', ['data_tidur' => $data]);
    }

    // Method untuk memproses update data
    public function update($id)
    {
        // Validasi input dari form
        $rules = [
            'tanggal' => 'required|valid_date',
            'durasi_tidur' => 'required|numeric',
            'kualitas_tidur' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[10]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form dengan error
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Ambil data dari form
        $dataToUpdate = [
            'tanggal' => $this->request->getPost('tanggal'),
            'durasi_tidur' => (float) $this->request->getPost('durasi_tidur'),
            'kualitas_tidur' => (float) $this->request->getPost('kualitas_tidur'),
        ];

        // Perbarui data menggunakan Model
        if ($this->datasetModel->update($id, $dataToUpdate)) {
            return redirect()->to('/dataset')->with('success', 'Data berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    // Method untuk menghapus data
    public function delete($id)
    {
        // Pastikan request adalah POST untuk keamanan (sesuai dengan form di view)
        if ($this->request->getMethod() === 'post') {
            if ($this->datasetModel->delete($id)) {
                return redirect()->to('/dataset')->with('success', 'Data berhasil dihapus!');
            } else {
                return redirect()->to('/dataset')->with('error', 'Gagal menghapus data.');
            }
        }
        // Jika diakses dengan metode selain POST, bisa di-redirect atau tampilkan error
        return redirect()->to('/dataset')->with('error', 'Metode tidak diizinkan untuk penghapusan.');
    }
}
