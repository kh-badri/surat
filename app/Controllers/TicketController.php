<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\CustomerModel; // Perlu model Customer
use App\Models\PetugasModel;  // Perlu model Petugas

class TicketController extends BaseController
{
    protected $ticketModel;
    protected $customerModel;
    protected $petugasModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->customerModel = new CustomerModel();
        $this->petugasModel = new PetugasModel();
        helper(['url', 'form', 'text']); // 'text' helper untuk random_string
    }

    // Menampilkan daftar tiket
    public function index()
    {
        $data = [
            'title'      => 'Daftar Tiket',
            'tickets'    => $this->ticketModel->findAll(),
            'active_menu' => 'tickets',
        ];
        return view('tickets/index', $data);
    }

    // Menampilkan form tambah tiket
    public function create()
    {
        $customers = $this->customerModel->findAll();
        $petugas = $this->petugasModel->findAll();

        // Generate Code Ticket Otomatis
        $codeTicket = 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4);
        // Pastikan code_ticket unik (sangat kecil kemungkinan duplikat dengan datetime+random)
        // Opsional: Loop untuk memastikan keunikan jika sangat khawatir
        // while($this->ticketModel->where('code_ticket', $codeTicket)->first()){
        //     $codeTicket = 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4);
        // }


        $data = [
            'title'      => 'Buat Tiket Baru',
            'validation' => \Config\Services::validation(),
            'customers'  => $customers,
            'petugas'    => $petugas,
            'code_ticket_generated' => $codeTicket,
            'active_menu' => 'tickets',
        ];
        return view('tickets/create', $data);
    }

    // Menyimpan data tiket baru
    public function store()
    {
        // Tangkap semua data dari POST
        $dataToSave = [
            'code_ticket'           => $this->request->getPost('code_ticket'),
            'customer_id'           => $this->request->getPost('customer_id'),
            'nama_customer_ticket'  => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket' => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'               => $this->request->getPost('keluhan'),
            'deskripsi'             => $this->request->getPost('deskripsi'),
            'status'                => $this->request->getPost('status'),
            'prioritas'             => $this->request->getPost('prioritas'),
            'tanggal_buat'          => date('Y-m-d H:i:s'), // Set tanggal_buat saat ini
            'petugas_id'            => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'   => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'  => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'   => $this->request->getPost('role_petugas_ticket'),
        ];

        // Validasi data
        if (!$this->validate($this->ticketModel->validationRules, $dataToSave, $this->ticketModel->validationMessages)) {
            // Jika validasi gagal, kembalikan ke form dengan input lama
            return redirect()->back()->withInput();
        }

        // Simpan data ke database
        $insertResult = $this->ticketModel->insert($dataToSave);

        if ($insertResult !== false) {
            session()->setFlashdata('success', 'Tiket baru berhasil dibuat.');
        } else {
            session()->setFlashdata('error', 'Gagal membuat tiket baru. Terjadi kesalahan database.');
        }

        return redirect()->to(base_url('tickets'));
    }

    // Menampilkan form edit tiket
    public function edit($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket tidak ditemukan.');
        }

        $customers = $this->customerModel->findAll();
        $petugas = $this->petugasModel->findAll();

        $data = [
            'title'      => 'Edit Tiket',
            'ticket'     => $ticket,
            'validation' => \Config\Services::validation(),
            'customers'  => $customers,
            'petugas'    => $petugas,
            'active_menu' => 'tickets',
        ];
        return view('tickets/edit', $data);
    }

    // Memperbarui data tiket
    public function update($id)
    {
        $oldTicket = $this->ticketModel->find($id);

        if (!$oldTicket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket yang akan diperbarui tidak ditemukan.');
        }

        // Ambil rules dari model
        $rules = $this->ticketModel->validationRules;

        // Logika penyesuaian validasi untuk code_ticket (is_unique)
        // Jika code_ticket tidak berubah, abaikan is_unique
        $currentCodeTicket = $this->request->getPost('code_ticket');
        if ($currentCodeTicket === $oldTicket['code_ticket']) {
            $rules['code_ticket'] = 'required|max_length[50]';
        } else {
            $rules['code_ticket'] = 'required|is_unique[tickets.code_ticket]|max_length[50]';
        }

        $dataToUpdate = [
            'code_ticket'           => $this->request->getPost('code_ticket'),
            'customer_id'           => $this->request->getPost('customer_id'),
            'nama_customer_ticket'  => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket' => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'               => $this->request->getPost('keluhan'),
            'deskripsi'             => $this->request->getPost('deskripsi'),
            'status'                => $this->request->getPost('status'),
            'prioritas'             => $this->request->getPost('prioritas'),
            // 'tanggal_buat'       => ini tidak diupdate dari form, harusnya hanya di set sekali
            'petugas_id'            => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'   => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'  => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'   => $this->request->getPost('role_petugas_ticket'),
        ];

        // Validasi data
        if (!$this->validate($rules, $dataToUpdate, $this->ticketModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        // Penting: Lewati validasi internal model karena sudah divalidasi di controller
        $this->ticketModel->skipValidation(true);
        $updateResult = $this->ticketModel->update($id, $dataToUpdate);
        $this->ticketModel->skipValidation(false); // Reset kembali

        if ($updateResult !== false) {
            session()->setFlashdata('success', 'Tiket berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui tiket. Terjadi kesalahan saat menyimpan perubahan.');
        }

        return redirect()->to(base_url('tickets'));
    }

    // Menghapus tiket
    public function delete($id)
    {
        $this->ticketModel->delete($id);
        session()->setFlashdata('success', 'Tiket berhasil dihapus.');
        return redirect()->to(base_url('tickets'));
    }

    // --- AJAX ENDPOINTS UNTUK LOOKUP OTOMATIS ---

    public function getCustomerDetails($customer_id)
    {
        $customer = $this->customerModel->find($customer_id);
        if ($customer) {
            return $this->response->setJSON($customer);
        }
        return $this->response->setJSON(['error' => 'Customer not found'], 404);
    }

    public function getPetugasDetails($petugas_id)
    {
        $petugas = $this->petugasModel->find($petugas_id);
        if ($petugas) {
            return $this->response->setJSON($petugas);
        }
        return $this->response->setJSON(['error' => 'Petugas not found'], 404);
    }
}
