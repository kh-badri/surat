<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\WilayahModel; // Pastikan Anda punya model ini untuk mengambil data kecamatan

class Guru extends BaseController
{
    /**
     * Menampilkan halaman daftar data guru.
     */
    public function index()
    {
        $guruModel = new GuruModel();

        // Mengambil data guru (diasumsikan getGuruWithWilayah() sudah ada dan berfungsi)
        $guru_list = $guruModel->getGuruWithWilayah();

        // --- Menghitung total jumlah guru ---
        $total_jumlah_guru = 0;
        foreach ($guru_list as $guru) {
            $total_jumlah_guru += (int)$guru['jumlah']; // Pastikan 'jumlah' adalah integer
        }
        // ------------------------------------

        $data = [
            'active_menu'       => 'guru',
            'title'             => 'Data Tenaga Pendidik',
            'guru'              => $guru_list,
            'total_jumlah_guru' => $total_jumlah_guru, // Menambahkan total_jumlah_guru ke data
        ];
        return view('guru/index', $data);
    }

    /**
     * Menampilkan form untuk menambah data guru baru.
     */
    public function create()
    {
        $wilayahModel = new WilayahModel(); // Untuk dropdown kecamatan
        $data = [
            'active_menu' => 'guru',
            'title'       => 'Tambah Data Guru',
            'wilayah'     => $wilayahModel->findAll(),
            'validation'  => \Config\Services::validation()
        ];
        return view('guru/create', $data);
    }

    /**
     * Menyimpan data guru baru ke database.
     */
    public function store()
    {
        // Aturan validasi
        $rules = [
            'kecamatan_id' => 'required',
            'tahun'        => 'required|numeric|exact_length[4]',
            'jumlah'       => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $guruModel = new GuruModel();
        $guruModel->save([
            'kecamatan_id' => $this->request->getPost('kecamatan_id'),
            'tahun'        => $this->request->getPost('tahun'),
            'jumlah'       => $this->request->getPost('jumlah'),
        ]);

        session()->setFlashdata('success', 'Data guru berhasil ditambahkan.');
        return redirect()->to('/guru');
    }

    /**
     * Menampilkan form untuk mengedit data guru.
     */
    public function edit($id)
    {
        $guruModel = new GuruModel();
        $wilayahModel = new WilayahModel();

        $data = [
            'active_menu' => 'guru',
            'title'       => 'Edit Data Guru',
            'guru'        => $guruModel->find($id),
            'wilayah'     => $wilayahModel->findAll(),
            'validation'  => \Config\Services::validation()
        ];
        return view('guru/edit', $data);
    }

    /**
     * Memperbarui data guru di database.
     */
    public function update($id)
    {
        // Aturan validasi
        $rules = [
            'kecamatan_id' => 'required',
            'tahun'        => 'required|numeric|exact_length[4]',
            'jumlah'       => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $guruModel = new GuruModel();
        $guruModel->update($id, [
            'kecamatan_id' => $this->request->getPost('kecamatan_id'),
            'tahun'        => $this->request->getPost('tahun'),
            'jumlah'       => $this->request->getPost('jumlah'),
        ]);

        session()->setFlashdata('success', 'Data guru berhasil diperbarui.');
        return redirect()->to('/guru');
    }

    /**
     * Menghapus data guru dari database.
     */
    public function delete($id)
    {
        $guruModel = new GuruModel();
        $guruModel->delete($id);

        session()->setFlashdata('success', 'Data guru berhasil dihapus.');
        return redirect()->to('/guru');
    }
}
