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

    // --- START WHATSAPP INTEGRATION CONFIG ---
    // GANTI DENGAN URL API WHATSAPP GATEWAY ANDA YANG SEBENARNYA
    // Contoh: 'https://your-whatsapp-gateway.com/send'
    private $whatsappApiUrl = 'https://wa.jasaawak.com/send-message';
    // GANTI DENGAN API KEY WHATSAPP GATEWAY ANDA YANG SEBENARNYA
    private $whatsappApiKey = 'OfZd22KyRNNgDdx0TPeGGF1YWgK3LJ';
    // --- END WHATSAPP INTEGRATION CONFIG ---

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

        // Generate Code Ticket Otomatis
        $codeTicket = 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4);
        // Opsional: Loop untuk memastikan keunikan jika sangat khawatir
        // while($this->ticketModel->where('code_ticket', $codeTicket)->first()){
        //     $codeTicket = 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4);
        // }

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
        // Tangkap semua data dari POST
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
            'tanggal_buat'           => date('Y-m-d H:i:s'), // Set tanggal_buat saat ini
            'petugas_id'             => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'    => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'   => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'    => $this->request->getPost('role_petugas_ticket'),
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

            // --- START WHATSAPP INTEGRATION: Send message on new ticket creation ---
            $customerPhoneNumber = $dataToSave['no_hp_customer_ticket'];
            $agentPhoneNumber = $dataToSave['no_hp_petugas_ticket']; // Nomor HP petugas yang ditugaskan

            // Pesan untuk Pelanggan
            $customerMessage = "Halo " . $dataToSave['nama_customer_ticket'] . ",\n"
                . "Tiket Anda berhasil dibuat!\n"
                . "Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "Keluhan: " . $dataToSave['keluhan'] . "\n"
                . "Status: " . $dataToSave['status'] . "\n"
                . "Prioritas: " . $dataToSave['prioritas'] . "\n"
                . "Petugas yang ditugaskan: " . $dataToSave['nama_petugas_ticket'] . "\n"
                . "Kami akan segera menindaklanjuti keluhan Anda. Terima kasih.";

            // Pesan untuk Petugas
            $agentMessage = "Halo " . $dataToSave['nama_petugas_ticket'] . ",\n"
                . "Anda mendapatkan tiket baru!\n"
                . "Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "Pelanggan: " . $dataToSave['nama_customer_ticket'] . "\n"
                . "No. HP Pelanggan: " . $dataToSave['no_hp_customer_ticket'] . "\n"
                . "Keluhan: " . $dataToSave['keluhan'] . "\n"
                . "Deskripsi: " . ($dataToSave['deskripsi'] ?: 'Tidak ada deskripsi tambahan.') . "\n"
                . "Status: " . $dataToSave['status'] . "\n"
                . "Prioritas: " . $dataToSave['prioritas'] . "\n"
                . "Mohon segera ditindaklanjuti.";

            // Kirim pesan ke pelanggan
            $this->sendWhatsAppMessage($customerPhoneNumber, $customerMessage);
            // Kirim pesan ke petugas
            $this->sendWhatsAppMessage($agentPhoneNumber, $agentMessage);
            // --- END WHATSAPP INTEGRATION ---

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
            'title'       => 'Edit Tiket',
            'ticket'      => $ticket,
            'validation'  => \Config\Services::validation(),
            'customers'   => $customers,
            'petugas'     => $petugas,
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
        $currentCodeTicket = $this->request->getPost('code_ticket');
        if ($currentCodeTicket === $oldTicket['code_ticket']) {
            $rules['code_ticket'] = 'required|max_length[50]';
        } else {
            $rules['code_ticket'] = 'required|is_unique[tickets.code_ticket]|max_length[50]';
        }

        // Hapus rule is_not_unique untuk customer_id dan petugas_id saat update
        // karena kita tidak selalu mengubah customer/petugas, dan validasi ini bisa mengganggu
        // jika ID yang sama dipilih lagi. Asumsi ID sudah valid saat dibuat.
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
            // 'tanggal_buat'           => ini tidak diupdate dari form, harusnya hanya di set sekali
            'petugas_id'             => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'    => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket'   => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'    => $this->request->getPost('role_petugas_ticket'),
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

            // --- START WHATSAPP INTEGRATION: Send message on ticket update ---
            // Hanya kirim notifikasi jika ada perubahan status atau prioritas
            if ($dataToUpdate['status'] !== $oldTicket['status'] || $dataToUpdate['prioritas'] !== $oldTicket['prioritas']) {
                $customerPhoneNumber = $dataToUpdate['no_hp_customer_ticket'];
                $agentPhoneNumber = $dataToUpdate['no_hp_petugas_ticket'];

                // Pesan untuk Pelanggan (jika status/prioritas berubah)
                $customerUpdateMessage = "Halo " . $dataToUpdate['nama_customer_ticket'] . ",\n"
                    . "Update Tiket Anda (Kode: *" . $dataToUpdate['code_ticket'] . "*):\n"
                    . "Status baru: *" . $dataToUpdate['status'] . "*\n"
                    . "Prioritas baru: *" . $dataToUpdate['prioritas'] . "*\n"
                    . "Keluhan: " . $dataToUpdate['keluhan'] . "\n"
                    . "Terima kasih atas kesabaran Anda.";

                // Pesan untuk Petugas (jika status/prioritas berubah)
                $agentUpdateMessage = "Halo " . $dataToUpdate['nama_petugas_ticket'] . ",\n"
                    . "Update Tiket (Kode: *" . $dataToUpdate['code_ticket'] . "*):\n"
                    . "Status baru: *" . $dataToUpdate['status'] . "*\n"
                    . "Prioritas baru: *" . $dataToUpdate['prioritas'] . "*\n"
                    . "Pelanggan: " . $dataToUpdate['nama_customer_ticket'] . "\n"
                    . "Keluhan: " . $dataToUpdate['keluhan'] . "\n"
                    . "Deskripsi: " . ($dataToUpdate['deskripsi'] ?: 'Tidak ada deskripsi tambahan.') . "\n"
                    . "Mohon periksa detail tiket.";

                $this->sendWhatsAppMessage($customerPhoneNumber, $customerUpdateMessage);
                $this->sendWhatsAppMessage($agentPhoneNumber, $agentUpdateMessage);
            }
            // --- END WHATSAPP INTEGRATION ---

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

    // --- START WHATSAPP INTEGRATION: Private Helper Function ---
    /**
     * Mengirim pesan ke WhatsApp melalui WhatsApp Gateway API.
     * PENTING: Ganti dengan implementasi API Gateway Anda yang sebenarnya.
     *
     * @param string $phoneNumber Nomor telepon tujuan (dengan kode negara, cth: "6281234567890")
     * @param string $message Isi pesan yang akan dikirim
     * @return bool True jika pengiriman berhasil dipicu, False jika gagal
     */
    private function sendWhatsAppMessage(string $phoneNumber, string $message): bool
    {
        // Hapus karakter non-digit dan pastikan format yang benar
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        // Pastikan nomor diawali dengan kode negara tanpa '+' atau '0' di awal jika gateway memerlukannya
        // Contoh: jika nomor 0812..., ubah jadi 62812...
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1); // Asumsi kode negara Indonesia
        }

        $payload = [
            'api_key' => $this->whatsappApiKey,
            'number'  => $phoneNumber,
            'message' => $message,
            // Tambahkan parameter lain sesuai dokumentasi WhatsApp Gateway Anda
            // Contoh: 'sender' => 'nama_pengirim_anda',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->whatsappApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout 10 detik untuk request cURL

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            log_message('error', 'WhatsApp API cURL Error: ' . $error);
            return false;
        }

        $result = json_decode($response, true);

        // Sesuaikan logika pengecekan sukses/gagal berdasarkan respons dari WhatsApp Gateway Anda
        if ($httpCode >= 200 && $httpCode < 300 && isset($result['status']) && $result['status'] === 'success') {
            log_message('info', 'WhatsApp message sent successfully to ' . $phoneNumber . ' for ticket.');
            return true;
        } else {
            log_message('error', 'Failed to send WhatsApp message to ' . $phoneNumber . '. HTTP Code: ' . $httpCode . ' Response: ' . $response);
            return false;
        }
    }
    // --- END WHATSAPP INTEGRATION: Private Helper Function ---
}
