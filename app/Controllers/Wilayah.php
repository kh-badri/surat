<?php

namespace App\Controllers;

use App\Models\WilayahModel;

class Wilayah extends BaseController
{
    protected $wilayahModel;

    // Tambahkan construct agar model otomatis dimuat
    public function __construct()
    {
        $this->wilayahModel = new WilayahModel();
    }

    // Fungsi ini sudah ada sebelumnya
    public function index()
    {
        $data = [
            'title'   => 'Data Wilayah',
            'active_menu' => 'wilayah', // Untuk menu aktif di sidebar
            'wilayah' => $this->wilayahModel->findAll()
        ];
        return view('wilayah/index', $data);
    }

    // --- TAMBAHKAN FUNGSI DI BAWAH INI ---

    /**
     * Menampilkan form untuk menambah data wilayah baru.
     */
    public function new()
    {
        $data = [
            'title' => 'Tambah Wilayah Baru'
        ];
        return view('wilayah/new', $data);
    }

    /**
     * Menyimpan data wilayah baru ke database.
     */
    public function create()
    {
        // Simpan data baru
        $this->wilayahModel->save([
            'kecamatan' => $this->request->getPost('kecamatan')
        ]);

        // Atur pesan sukses
        session()->setFlashdata('success', 'Data wilayah berhasil ditambahkan.');

        // Kembali ke halaman daftar wilayah
        return redirect()->to('/wilayah');
    }

    public function edit($id)
    {
        $data = [
            'title'   => 'Edit Wilayah',
            'wilayah' => $this->wilayahModel->find($id) // Mencari data dengan ID dari URL
        ];

        // JIKA DATA KOSONG (KARENA ID TIDAK DITEMUKAN), TAMPILKAN 404
        if (empty($data['wilayah'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data wilayah tidak ditemukan.');
        }

        return view('wilayah/edit', $data);
    }

    /**
     * Memperbarui data di database.
     */
    public function update($id)
    {
        // Update data berdasarkan ID
        $this->wilayahModel->update($id, [
            'kecamatan' => $this->request->getPost('kecamatan')
        ]);

        // Atur pesan sukses
        session()->setFlashdata('success', 'Data wilayah berhasil diubah.');

        // Kembali ke halaman daftar wilayah
        return redirect()->to('/wilayah');
    }


    // Fungsi delete sudah ada sebelumnya
    public function delete($id)
    {
        $this->wilayahModel->delete($id);
        session()->setFlashdata('success', 'Data wilayah berhasil dihapus.');
        return redirect()->to('/wilayah');
    }
}
