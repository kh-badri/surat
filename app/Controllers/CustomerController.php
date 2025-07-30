<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        helper('url'); // Memuat URL helper
    }

    // Menampilkan daftar customer
    public function index()
    {
        $data = [
            'title'     => 'Data Customer',
            'customers' => $this->customerModel->findAll(),
            'active_menu' => 'customer', // Tambahkan ini
        ];
        return view('customer/index', $data);
    }

    // Menampilkan form tambah customer
    public function create()
    {
        $data = [
            'title'      => 'Tambah Customer Baru',
            'validation' => \Config\Services::validation(),
        ];
        return view('customer/create', $data);
    }

    // Menyimpan data customer baru
    public function store()
    {
        // Validasi input menggunakan rules dari model
        if (!$this->validate($this->customerModel->validationRules, $this->customerModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'id_customer'   => $this->request->getPost('id_customer'), // Ambil langsung dari input form
            'nama_customer' => $this->request->getPost('nama_customer'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
        ];

        $this->customerModel->insert($data);

        session()->setFlashdata('success', 'Data customer berhasil ditambahkan.');
        return redirect()->to(base_url('customer'));
    }

    // Menampilkan form edit customer
    public function edit($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data customer tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Customer',
            'customer'   => $customer,
            'validation' => \Config\Services::validation(),
        ];
        return view('customer/edit', $data);
    }

    // Memperbarui data customer
    public function update($id)
    {
        $oldCustomer = $this->customerModel->find($id);

        if (!$oldCustomer) { // Pastikan data customer yang akan diedit memang ada
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data customer yang akan diperbarui tidak ditemukan.');
        }

        // Ambil rules validasi dari model
        $rules = $this->customerModel->validationRules;

        // --- PERUBAHAN DI SINI: id_customer tidak perlu lagi dicek is_unique sama sekali ---
        // Cukup pastikan required dan max_length sesuai definisi di model
        $rules['id_customer'] = 'required|max_length[50]'; // Ini sudah sesuai dengan model yang baru

        // Jika Email yang diinput sama dengan Email lama, abaikan aturan 'is_unique'
        if ($this->request->getPost('email') === $oldCustomer['email']) {
            $rules['email'] = 'permit_empty|valid_email';
        } else {
            $rules['email'] = 'permit_empty|valid_email|is_unique[customer.email]';
        }

        // Jalankan validasi
        if (!$this->validate($rules, $this->customerModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        // Siapkan data untuk update
        $data = [
            'id_customer'   => $this->request->getPost('id_customer'),
            'nama_customer' => $this->request->getPost('nama_customer'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'email'         => $this->request->getPost('email'),
        ];

        // Lakukan update data di database
        $updateResult = $this->customerModel->update($id, $data);

        // Tambahkan kondisi untuk flashdata berdasarkan hasil update
        if ($updateResult) {
            session()->setFlashdata('success', 'Data customer berhasil diperbarui.');
        } else {
            // Ini akan muncul jika update tidak menyebabkan perubahan (misal data sama persis)
            // atau jika ada error lain di level model/database yang tidak tertangkap validasi
            session()->setFlashdata('error', 'Gagal memperbarui data customer atau tidak ada perubahan yang terdeteksi.');
        }

        return redirect()->to(base_url('customer'));
    }

    // Menghapus data customer
    public function delete($id)
    {
        $this->customerModel->delete($id);
        session()->setFlashdata('success', 'Data customer berhasil dihapus.');
        return redirect()->to(base_url('customer'));
    }
}
