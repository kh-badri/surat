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

    private $whatsappApiUrl = 'https://wa.jasaawak.com/send-message';
    private $whatsappApiKey = 'OfZd22KyRNNgDdx0TPeGGF1YWgK3LJ';

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->customerModel = new CustomerModel();
        $this->petugasModel = new PetugasModel();
        helper(['url', 'form', 'text']);
    }

    // Menampilkan daftar tiket
    public function index()
    {
        $data = [
            'title'       => 'Daftar Tiket',
            'tickets'     => $this->ticketModel->findAll(),
            'active_menu' => 'tickets',
        ];
        return view('tickets/index', $data);
    }

    // Menampilkan form tambah tiket
    public function create()
    {
        $customers = $this->customerModel->findAll();
        $petugas = $this->petugasModel->findAll();
        $codeTicket = 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4);

        $data = [
            'title'       => 'Buat Tiket Baru',
            'validation'  => \Config\Services::validation(),
            'customers'   => $customers,
            'petugas'     => $petugas,
            'code_ticket_generated' => $codeTicket,
            'active_menu' => 'tickets',
        ];
        return view('tickets/create', $data);
    }

    // Menyimpan data tiket baru
    public function store()
    {
        $dataToSave = [
            'code_ticket'            => $this->request->getPost('code_ticket'),
            'customer_id'            => $this->request->getPost('customer_id'),
            'nama_customer_ticket'   => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket'  => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'                => $this->request->getPost('keluhan'),
            'deskripsi'              => $this->request->getPost('deskripsi'),
            'status'                 => $this->request->getPost('status'),
            'prioritas'              => $this->request->getPost('prioritas'),
            'tanggal_buat'           => date('Y-m-d H:i:s'),
            'petugas_id'             => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'    => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'   => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'    => $this->request->getPost('role_petugas_ticket'),
        ];

        if (!$this->validate($this->ticketModel->validationRules, $dataToSave, $this->ticketModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        $insertResult = $this->ticketModel->insert($dataToSave);

        if ($insertResult !== false) {
            session()->setFlashdata('success', 'Tiket baru berhasil dibuat.');

            $customerPhoneNumber = $dataToSave['no_hp_customer_ticket'];
            $agentPhoneNumber = $dataToSave['no_hp_petugas_ticket'];

            $statusLabel = $this->formatStatus($dataToSave['status']);

            $customerMessage = "✅ *Tiket Berhasil Dibuat*\n"
                . "Halo *" . $dataToSave['nama_customer_ticket'] . "*,\n\n"
                . "Tiket Anda telah berhasil direkam dalam sistem kami.\n"
                . "Berikut detail tiket Anda:\n"
                . "• Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "• Keluhan: _" . $dataToSave['keluhan'] . "_\n"
                . "• Status: *" . $statusLabel . "*\n"
                . "• Prioritas: *" . $dataToSave['prioritas'] . "*\n"
                . "• Petugas Penanganan: *" . $dataToSave['nama_petugas_ticket'] . "*\n\n"
                . "📍 Kami akan segera memproses keluhan Anda. Terima kasih atas kepercayaannya.";

            $agentMessage = "🆕 *Tiket Baru Masuk*\n"
                . "Halo *" . $dataToSave['nama_petugas_ticket'] . "*,\n\n"
                . "Anda telah ditugaskan untuk menangani tiket baru:\n"
                . "• Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "• Pelanggan: *" . $dataToSave['nama_customer_ticket'] . "*\n"
                . "• No. HP: _" . $dataToSave['no_hp_customer_ticket'] . "_\n"
                . "• Keluhan: _" . $dataToSave['keluhan'] . "_\n"
                . "• Status: *" . $statusLabel . "*\n"
                . "• Prioritas: *" . $dataToSave['prioritas'] . "*\n\n"
                . "🚨 Mohon segera ditindaklanjuti melalui sistem tiket. Terima kasih.";

            $this->sendWhatsAppMessage($customerPhoneNumber, $customerMessage);
            $this->sendWhatsAppMessage($agentPhoneNumber, $agentMessage);
        } else {
            session()->setFlashdata('error', 'Gagal membuat tiket baru. Terjadi kesalahan database.');
        }

        return redirect()->to(base_url('tickets'));
    }

    // Mengupdate tiket
    public function update($id)
    {
        $oldTicket = $this->ticketModel->find($id);

        if (!$oldTicket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket yang akan diperbarui tidak ditemukan.');
        }

        $rules = $this->ticketModel->validationRules;
        $currentCodeTicket = $this->request->getPost('code_ticket');
        if ($currentCodeTicket === $oldTicket['code_ticket']) {
            $rules['code_ticket'] = 'required|max_length[50]';
        } else {
            $rules['code_ticket'] = 'required|is_unique[tickets.code_ticket]|max_length[50]';
        }

        unset($rules['customer_id']);
        unset($rules['petugas_id']);

        $dataToUpdate = [
            'code_ticket'            => $this->request->getPost('code_ticket'),
            'customer_id'            => $this->request->getPost('customer_id'),
            'nama_customer_ticket'   => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket'  => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'                => $this->request->getPost('keluhan'),
            'deskripsi'              => $this->request->getPost('deskripsi'),
            'status'                 => $this->request->getPost('status'),
            'prioritas'              => $this->request->getPost('prioritas'),
            'petugas_id'             => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'    => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'   => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'    => $this->request->getPost('role_petugas_ticket'),
        ];

        if (!$this->validate($rules, $dataToUpdate, $this->ticketModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        $this->ticketModel->skipValidation(true);
        $updateResult = $this->ticketModel->update($id, $dataToUpdate);
        $this->ticketModel->skipValidation(false);

        if ($updateResult !== false) {
            session()->setFlashdata('success', 'Tiket berhasil diperbarui.');

            if ($dataToUpdate['status'] !== $oldTicket['status'] || $dataToUpdate['prioritas'] !== $oldTicket['prioritas']) {
                $customerPhoneNumber = $dataToUpdate['no_hp_customer_ticket'];
                $agentPhoneNumber = $dataToUpdate['no_hp_petugas_ticket'];

                $statusLabel = $this->formatStatus($dataToUpdate['status']);

                $customerUpdateMessage = "📢 *Pembaruan Tiket Anda*\n"
                    . "Halo *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                    . "Berikut pembaruan status tiket Anda dengan kode *" . $dataToUpdate['code_ticket'] . "*:\n"
                    . "• Status: *" . $statusLabel . "*\n"
                    . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                    . "📝 Keluhan: _" . $dataToUpdate['keluhan'] . "_\n\n"
                    . "Terima kasih atas kepercayaan dan kesabaran Anda. Kami akan terus memberikan layanan terbaik.";

                $agentUpdateMessage = "📌 *Pembaruan Tiket Pelanggan*\n"
                    . "Halo *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                    . "Berikut detail tiket yang perlu diperbarui:\n"
                    . "• Kode Tiket: *" . $dataToUpdate['code_ticket'] . "*\n"
                    . "• Status: *" . $statusLabel . "*\n"
                    . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                    . "👤 Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                    . "📝 Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                    . "📄 Deskripsi Tambahan: " . ($dataToUpdate['deskripsi'] ?: '_Tidak ada deskripsi tambahan_') . "\n\n"
                    . "Silakan segera tindak lanjuti melalui dashboard tiket Anda. Terima kasih atas kerja samanya.";

                $this->sendWhatsAppMessage($customerPhoneNumber, $customerUpdateMessage);
                $this->sendWhatsAppMessage($agentPhoneNumber, $agentUpdateMessage);
            }
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

    // Fungsi format status
    private function formatStatus(string $status): string
    {
        switch (strtolower($status)) {
            case 'sedang dibuat':
                return '⏳ Tiket sedang dibuat';
            case 'dalam proses':
                return '🔧 Tiket sedang ditangani';
            case 'closed':
                return '✅ Tiket telah diselesaikan';
            default:
                return '❓ Status tidak diketahui';
        }
    }

    // Mengirim pesan ke WhatsApp
    private function sendWhatsAppMessage(string $phoneNumber, string $message): bool
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $payload = [
            'api_key' => $this->whatsappApiKey,
            'sender'  => '6281436069634',
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
            log_message('info', 'WhatsApp message sent successfully to ' . $phoneNumber . ' for ticket.');
            return true;
        } else {
            log_message('error', 'Failed to send WhatsApp message to ' . $phoneNumber . '. HTTP Code: ' . $httpCode . ' Response: ' . $response);
            return false;
        }
    }
}
