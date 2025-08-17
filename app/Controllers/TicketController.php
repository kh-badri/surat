<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\CustomerModel;
use App\Models\PetugasModel;

class TicketController extends BaseController
{
    protected $ticketModel;
    protected $customerModel;
    protected $petugasModel;

    // --- START WHATSAPP INTEGRATION CONFIG ---
    private $whatsappApiUrl = 'https://wa.jasaawak.com/send-message';
    private $whatsappApiKey = 'OfZd22KyRNNgDdx0TPeGGF1YWgK3LJ';
    // --- END WHATSAPP INTEGRATION CONFIG ---

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->customerModel = new CustomerModel();
        $this->petugasModel = new PetugasModel();
        helper(['url', 'form', 'text']);
    }

    public function index()
    {
        $data = [
            'title'       => 'Daftar Tiket',
            'tickets'     => $this->ticketModel->findAll(),
            'active_menu' => 'tickets',
        ];
        return view('tickets/index', $data);
    }

    public function create()
    {
        $data = [
            'title'                 => 'Buat Tiket Baru',
            'validation'            => \Config\Services::validation(),
            'customers'             => $this->customerModel->findAll(),
            'petugas'               => $this->petugasModel->findAll(),
            'code_ticket_generated' => 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4),
            'active_menu'           => 'tickets',
        ];
        return view('tickets/create', $data);
    }

    public function store()
    {
        $isCustomCustomer = empty($this->request->getPost('customer_id'));

        $rules = [
            'code_ticket'            => 'required|is_unique[tickets.code_ticket]',
            'tanggal_buat'           => 'required',
            'keluhan'                => 'required|min_length[5]',
            'status'                 => 'required|in_list[open,progress,closed]',
            'prioritas'              => 'required|in_list[low,medium,high,urgent]',
            'petugas_id'             => 'required|is_not_unique[petugas.id_petugas]',
            'nama_petugas_ticket'    => 'required',
            'no_hp_petugas_ticket'   => 'required',
            'role_petugas_ticket'    => 'required',
            'nama_customer_ticket'   => 'required|min_length[3]',
            'no_hp_customer_ticket'  => 'required|min_length[9]',
            'alamat_customer_ticket' => 'required|min_length[10]',
        ];

        if (!$isCustomCustomer) {
            $rules['customer_id'] = 'required|is_not_unique[customers.id]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataToSave = [
            'code_ticket'            => $this->request->getPost('code_ticket'),
            'customer_id'            => $isCustomCustomer ? null : $this->request->getPost('customer_id'),
            'nama_customer_ticket'   => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket'  => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'                => $this->request->getPost('keluhan'),
            'deskripsi'              => $this->request->getPost('deskripsi'),
            'status'                 => $this->request->getPost('status'),
            'prioritas'              => $this->request->getPost('prioritas'),
            'tanggal_buat'           => $this->request->getPost('tanggal_buat'),
            'petugas_id'             => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'    => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'   => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'    => $this->request->getPost('role_petugas_ticket'),
        ];

        if ($this->ticketModel->insert($dataToSave)) {
            session()->setFlashdata('success', 'Tiket baru berhasil dibuat.');
            // ... (Kode notifikasi WhatsApp Anda) ...
        } else {
            session()->setFlashdata('error', 'Gagal membuat tiket baru.');
        }

        return redirect()->to(base_url('tickets'));
    }

    public function edit($id)
    {
        $ticket = $this->ticketModel->find($id);
        if (!$ticket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket tidak ditemukan.');
        }

        $data = [
            'title'       => 'Edit Tiket: ' . $ticket['code_ticket'],
            'ticket'      => $ticket,
            'validation'  => \Config\Services::validation(),
            'customers'   => $this->customerModel->findAll(),
            'petugas'     => $this->petugasModel->findAll(),
            'active_menu' => 'tickets',
        ];
        return view('tickets/edit', $data);
    }

    public function update($id)
    {
        $oldTicket = $this->ticketModel->find($id);
        if (!$oldTicket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket tidak ditemukan.');
        }

        $isCustomCustomer = empty($this->request->getPost('customer_id'));

        $rules = [
            'tanggal_buat'           => 'required',
            'keluhan'                => 'required|min_length[5]',
            'status'                 => 'required|in_list[open,progress,closed]',
            'prioritas'              => 'required|in_list[low,medium,high,urgent]',
            'petugas_id'             => 'required|is_not_unique[petugas.id_petugas]',
            'nama_petugas_ticket'    => 'required',
            'no_hp_petugas_ticket'   => 'required',
            'role_petugas_ticket'    => 'required',
            'nama_customer_ticket'   => 'required|min_length[3]',
            'no_hp_customer_ticket'  => 'required|min_length[9]',
            'alamat_customer_ticket' => 'required|min_length[10]',
        ];

        $currentCodeTicket = $this->request->getPost('code_ticket');
        if ($currentCodeTicket !== $oldTicket['code_ticket']) {
            $rules['code_ticket'] = 'required|is_unique[tickets.code_ticket]';
        } else {
            $rules['code_ticket'] = 'required';
        }

        if (!$isCustomCustomer) {
            $rules['customer_id'] = 'required|is_not_unique[customers.id]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataToUpdate = [
            'code_ticket'            => $currentCodeTicket,
            'customer_id'            => $isCustomCustomer ? null : $this->request->getPost('customer_id'),
            'nama_customer_ticket'   => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket'  => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'                => $this->request->getPost('keluhan'),
            'deskripsi'              => $this->request->getPost('deskripsi'),
            'status'                 => $this->request->getPost('status'),
            'prioritas'              => $this->request->getPost('prioritas'),
            'tanggal_buat'           => $this->request->getPost('tanggal_buat'),
            'petugas_id'             => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'    => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'   => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'    => $this->request->getPost('role_petugas_ticket'),
        ];

        if ($this->ticketModel->update($id, $dataToUpdate)) {
            session()->setFlashdata('success', 'Tiket berhasil diperbarui.');
            // ... (Kode notifikasi WhatsApp Anda untuk update) ...
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui tiket.');
        }

        return redirect()->to(base_url('tickets'));
    }

    public function delete($id)
    {
        if ($this->ticketModel->delete($id)) {
            session()->setFlashdata('success', 'Tiket berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus tiket.');
        }
        return redirect()->to(base_url('tickets'));
    }

    public function getCustomerDetails($customer_id)
    {
        $customer = $this->customerModel->find($customer_id);
        if ($customer) {
            return $this->response->setJSON($customer);
        }
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Customer not found']);
    }

    public function getPetugasDetails($petugas_id)
    {
        $petugas = $this->petugasModel->where('id_petugas', $petugas_id)->first();
        if ($petugas) {
            return $this->response->setJSON($petugas);
        }
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Petugas not found']);
    }

    private function sendWhatsAppMessage(string $phoneNumber, string $message): bool
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $payload = [
            'api_key' => $this->whatsappApiKey,
            'sender'  => '6282124838685',
            'number'  => $phoneNumber,
            'message' => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->whatsappApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            log_message('error', 'WhatsApp API cURL Error: ' . $error);
            return false;
        }

        $result = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300 && isset($result['status']) && $result['status'] === 'success') {
            log_message('info', 'WhatsApp message sent successfully to ' . $phoneNumber);
            return true;
        } else {
            log_message('error', 'Failed to send WhatsApp message to ' . $phoneNumber . '. Response: ' . $response);
            return false;
        }
    }
}
