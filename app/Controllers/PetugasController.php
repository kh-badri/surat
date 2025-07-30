<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PetugasModel;

class PetugasController extends BaseController
{
    protected $petugasModel;

    public function __construct()
    {
        $this->petugasModel = new PetugasModel();
        helper('url'); // Memuat URL helper
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Petugas',
            'petugas' => $this->petugasModel->findAll(),
            'active_menu' => 'petugas', // Konvensi penamaan active_menu
        ];
        return view('petugas/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Petugas Baru',
            'validation' => \Config\Services::validation(),
            'active_menu' => 'petugas', // Konvensi penamaan active_menu
        ];
        return view('petugas/create', $data);
    }

    public function store()
    {
        $dataToSave = [
            'nama_petugas'  => $this->request->getPost('nama_petugas'),
            'alamat_petugas' => $this->request->getPost('alamat_petugas'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
            'role'          => $this->request->getPost('role'),
        ];

        if (!$this->validate($this->petugasModel->validationRules, $dataToSave, $this->petugasModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        $insertResult = $this->petugasModel->insert($dataToSave);

        if ($insertResult !== false) {
            session()->setFlashdata('success', 'Data petugas berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data petugas. Terjadi kesalahan database.');
        }

        return redirect()->to(base_url('petugas'));
    }

    public function edit($id_petugas) // Parameter ini adalah Primary Key (id_petugas)
    {
        $petugas = $this->petugasModel->find($id_petugas);

        if (!$petugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data petugas tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Petugas',
            'petugas'    => $petugas,
            'validation' => \Config\Services::validation(),
            'active_menu' => 'petugas', // Konvensi penamaan active_menu
        ];
        return view('petugas/edit', $data);
    }

    public function update($id_petugas) // Parameter ini adalah Primary Key (id_petugas)
    {
        $oldPetugas = $this->petugasModel->find($id_petugas);

        if (!$oldPetugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data petugas yang akan diperbarui tidak ditemukan.');
        }

        $rules = $this->petugasModel->validationRules;

        $currentEmail = $this->request->getPost('email');
        if ($currentEmail === $oldPetugas['email']) {
            $rules['email'] = 'permit_empty|valid_email';
        } else {
            $rules['email'] = 'permit_empty|valid_email|is_unique[petugas.email]';
        }

        $dataToUpdate = [
            'nama_petugas'   => $this->request->getPost('nama_petugas'),
            'alamat_petugas' => $this->request->getPost('alamat_petugas'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'email'          => $this->request->getPost('email'),
            'role'           => $this->request->getPost('role'),
        ];

        if (!$this->validate($rules, $dataToUpdate, $this->petugasModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        // --- Perbaikan Krusial: Lewati Validasi Internal Model Saat Update ---
        // Karena validasi sudah dilakukan di controller dengan penyesuaian untuk unique email.
        $this->petugasModel->skipValidation(true);
        $updateResult = $this->petugasModel->update($id_petugas, $dataToUpdate);
        $this->petugasModel->skipValidation(false); // Penting: Setel kembali ke false untuk operasi lain
        // --- Akhir Perbaikan ---

        if ($updateResult !== false) {
            session()->setFlashdata('success', 'Data petugas berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data petugas. Terjadi kesalahan saat menyimpan perubahan.');
        }

        return redirect()->to(base_url('petugas'));
    }

    // --- FUNCTION DELETE INI DITAMBAHKAN/DIKONFIRMASI ---
    public function delete($id_petugas) // Parameter ini adalah Primary Key (id_petugas)
    {
        // Memanggil metode delete() dari model untuk menghapus data berdasarkan primary key (id_petugas)
        $this->petugasModel->delete($id_petugas);

        // Mengatur flashdata untuk pesan sukses setelah penghapusan
        session()->setFlashdata('success', 'Data petugas berhasil dihapus.');

        // Mengarahkan pengguna kembali ke halaman daftar petugas
        return redirect()->to(base_url('petugas'));
    }
    // --- AKHIR FUNCTION DELETE ---
}
