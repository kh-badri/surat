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

    /**
     * Menampilkan daftar tiket dengan filter dan pencarian.
     */
    public function index()
    {
        // Tangkap parameter pencarian dan filter dari URL
        $search = $this->request->getVar('search');
        $status = $this->request->getVar('status');

        $tickets = $this->ticketModel; // Inisialisasi query builder

        // Terapkan filter pencarian jika ada
        if (!empty($search)) {
            $tickets->like('code_ticket', $search)
                ->orLike('nama_customer_ticket', $search)
                ->orLike('keluhan', $search)
                ->orLike('nama_petugas_ticket', $search);
        }

        // Terapkan filter status jika ada
        if (!empty($status)) {
            $tickets->where('status', $status);
        }

        $data = [
            'title' => 'Daftar Tiket',
            'tickets' => $tickets->findAll(), // Eksekusi query
            'active_menu' => 'tickets',
            'search' => $search, // Kirim kembali nilai search ke view
            'status' => $status, // Kirim kembali nilai status ke view
        ];
        return view('tickets/index', $data);
    }

    // Metode create, store, edit, update, delete, getCustomerDetails, getPetugasDetails, sendWhatsAppMessage
    // tetap sama seperti yang Anda miliki sebelumnya atau seperti yang saya berikan di perbaikan terakhir.
    // Pastikan Anda hanya memperbarui metode index() ini.

    public function create()
    {
        $customers = $this->customerModel->findAll();
        $petugas = $this->petugasModel->findAll();
        $codeTicket = 'TKT-' . date('YmdHis') . '-' . random_string('numeric', 4);

        $data = [
            'title' => 'Buat Tiket Baru',
            'validation' => \Config\Services::validation(),
            'customers' => $customers,
            'petugas' => $petugas,
            'code_ticket_generated' => $codeTicket,
            'active_menu' => 'tickets',
        ];
        return view('tickets/create', $data);
    }

    public function store()
    {
        $dataToSave = [
            'code_ticket' => $this->request->getPost('code_ticket'),
            'customer_id' => $this->request->getPost('customer_id') ?: null,
            'nama_customer_ticket' => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket' => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan' => $this->request->getPost('keluhan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'prioritas' => $this->request->getPost('prioritas'),
            'tanggal_buat' => date('Y-m-d H:i:s'),
            'petugas_id' => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket' => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket' => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket' => $this->request->getPost('role_petugas_ticket'),
        ];

        if (!empty($dataToSave['customer_id'])) {
            $customer = $this->customerModel->find($dataToSave['customer_id']);
            if ($customer) {
                $dataToSave['nama_customer_ticket'] = $customer['nama_customer'];
                $dataToSave['alamat_customer_ticket'] = $customer['alamat'];
                $dataToSave['no_hp_customer_ticket'] = $customer['no_hp'];
            }
        }

        if (!empty($dataToSave['petugas_id'])) {
            $petugas = $this->petugasModel->find($dataToSave['petugas_id']);
            if ($petugas) {
                $dataToSave['nama_petugas_ticket'] = $petugas['nama_petugas'];
                $dataToSave['no_hp_petugas_ticket'] = $petugas['no_hp'];
                $dataToSave['role_petugas_ticket'] = $petugas['role'];
            }
        }

        $dataToSave['no_hp_customer_ticket'] = (string) $dataToSave['no_hp_customer_ticket'];
        $dataToSave['no_hp_petugas_ticket'] = (string) $dataToSave['no_hp_petugas_ticket'];

        $validationGroup = !empty($dataToSave['customer_id']) ? 'createFromCustomer' : 'createFromCustom';

        if (!$this->ticketModel->validate($dataToSave, $validationGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->ticketModel->errors());
        }

        if ($this->ticketModel->save($dataToSave)) {
            session()->setFlashdata('success', 'Tiket baru berhasil dibuat.');

            $customerPhoneNumber = $dataToSave['no_hp_customer_ticket'];
            $agentPhoneNumber = $dataToSave['no_hp_petugas_ticket'];

            $customerMessage = "✅ *Konfirmasi Pembuatan Tiket Layanan Anda*\n"
                . "Yth. Bapak/Ibu *" . $dataToSave['nama_customer_ticket'] . "*,\n\n"
                . "Kami informasikan bahwa tiket layanan Anda dengan detail berikut telah berhasil dibuat dan tercatat dalam sistem kami:\n"
                . "• Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "• Jenis Keluhan: _" . $dataToSave['keluhan'] . "_\n"
                . "• Status Saat Ini: *" . $dataToSave['status'] . "*\n"
                . "• Prioritas: *" . $dataToSave['prioritas'] . "*\n"
                . "• Petugas Penanganan: *" . $dataToSave['nama_petugas_ticket'] . "*\n\n"
                . "Tim kami akan segera menindaklanjuti keluhan Anda. Kami berkomitmen penuh untuk memberikan solusi terbaik secepatnya. Terima kasih atas kepercayaan Anda kepada layanan kami.\n\n"
                . "Hormat kami,\n\n"
                . "Tim Layanan Pelanggan \n*Indomedia Solusi Net*";

            $agentMessage = "🔔 *Pemberitahuan: Tiket Layanan Baru Telah Diterbitkan*\n"
                . "Yth. Bapak/Ibu *" . $dataToSave['nama_petugas_ticket'] . "*,\n\n"
                . "Anda telah ditugaskan untuk menangani tiket layanan baru dengan informasi sebagai berikut:\n"
                . "• Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "• Pelanggan: *" . $dataToSave['nama_customer_ticket'] . "* (No. HP: _" . $dataToSave['no_hp_customer_ticket'] . "_)\n"
                . "• Keluhan: _" . $dataToSave['keluhan'] . "_\n"
                . "• Deskripsi: " . ($dataToSave['deskripsi'] ?: '_Tidak ada deskripsi tambahan_') . "\n"
                . "• Status Awal: *" . $dataToSave['status'] . "*\n"
                . "• Prioritas: *" . $dataToSave['prioritas'] . "*\n\n"
                . "Mohon segera lakukan peninjauan dan tindak lanjut sesuai prosedur operasional standar. Akses detail lengkap melalui dashboard sistem tiket. Terima kasih atas dedikasi Anda.";

            $this->sendWhatsAppMessage($customerPhoneNumber, $customerMessage);
            $this->sendWhatsAppMessage($agentPhoneNumber, $agentMessage);
        } else {
            session()->setFlashdata('error', 'Gagal membuat tiket baru. Terjadi kesalahan database.');
            log_message('error', 'Database Error on Ticket Creation: ' . json_encode($this->ticketModel->errors()));
        }

        return redirect()->to(base_url('tickets'));
    }

    public function edit($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket tidak ditemukan.');
        }

        $customers = $this->customerModel->findAll();
        $petugas = $this->petugasModel->findAll();

        $data = [
            'title' => 'Edit Tiket',
            'ticket' => $ticket,
            'validation' => \Config\Services::validation(),
            'customers' => $customers,
            'petugas' => $petugas,
            'active_menu' => 'tickets',
        ];
        return view('tickets/edit', $data);
    }

    public function update($id)
    {
        $oldTicket = $this->ticketModel->find($id);

        if (!$oldTicket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tiket yang akan diperbarui tidak ditemukan.');
        }

        $dataToUpdate = [
            'id' => $id,
            'code_ticket' => $this->request->getPost('code_ticket'),
            'customer_id' => $this->request->getPost('customer_id') ?: null,
            'nama_customer_ticket' => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket' => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan' => $this->request->getPost('keluhan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'prioritas' => $this->request->getPost('prioritas'),
            'petugas_id' => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket' => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket' => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket' => $this->request->getPost('role_petugas_ticket'),
        ];

        // --- START: Pastikan detail customer/petugas terisi dari database jika ID dipilih ---
        if (!empty($dataToUpdate['customer_id'])) {
            $customer = $this->customerModel->find($dataToUpdate['customer_id']);
            if ($customer) {
                $dataToUpdate['nama_customer_ticket'] = $customer['nama_customer'];
                $dataToUpdate['alamat_customer_ticket'] = $customer['alamat'];
                $dataToUpdate['no_hp_customer_ticket'] = $customer['no_hp'];
            }
        } else {
            // Jika customer_id kosong, pastikan juga data detail customernya tidak kosong
            // Ini penting jika field di frontend menjadi "required" untuk custom input
            if (empty($dataToUpdate['nama_customer_ticket']) || empty($dataToUpdate['no_hp_customer_ticket'])) {
                // Logika tambahan jika ingin memberi error atau mengelola ini lebih lanjut
            }
        }

        if (!empty($dataToUpdate['petugas_id'])) {
            $petugas = $this->petugasModel->find($dataToUpdate['petugas_id']);
            if ($petugas) {
                $dataToUpdate['nama_petugas_ticket'] = $petugas['nama_petugas'];
                $dataToUpdate['no_hp_petugas_ticket'] = $petugas['no_hp'];
                $dataToUpdate['role_petugas_ticket'] = $petugas['role'];
            }
        } else {
            // Logika tambahan jika ingin memberi error atau mengelola ini lebih lanjut
            if (empty($dataToUpdate['nama_petugas_ticket']) || empty($dataToUpdate['no_hp_petugas_ticket']) || empty($dataToUpdate['role_petugas_ticket'])) {
                // Logika tambahan jika ingin memberi error atau mengelola ini lebih lanjut
            }
        }
        // --- END: Pastikan detail customer/petugas terisi dari database jika ID dipilih ---

        $dataToUpdate['no_hp_customer_ticket'] = (string) $dataToUpdate['no_hp_customer_ticket'];
        $dataToUpdate['no_hp_petugas_ticket'] = (string) $dataToUpdate['no_hp_petugas_ticket'];

        $validationGroup = !empty($dataToUpdate['customer_id']) ? 'createFromCustomer' : 'createFromCustom';

        if (!$this->ticketModel->validate($dataToUpdate, $validationGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->ticketModel->errors());
        }

        if ($this->ticketModel->save($dataToUpdate)) {
            session()->setFlashdata('success', 'Tiket berhasil diperbarui.');

            if ($dataToUpdate['status'] !== $oldTicket['status'] || $dataToUpdate['prioritas'] !== $oldTicket['prioritas']) {
                $customerPhoneNumber = $dataToUpdate['no_hp_customer_ticket'];
                $agentPhoneNumber = $dataToUpdate['no_hp_petugas_ticket'];

                $customerUpdateMessage = "";
                $agentUpdateMessage = "";

                $newStatus = strtolower($dataToUpdate['status']);
                $oldStatus = strtolower($oldTicket['status']);

                if ($newStatus === 'open' && $oldStatus !== 'open') {
                    $customerUpdateMessage = "🔔 *Pemberitahuan Status Tiket Anda: Dibuka*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Tiket layanan Anda dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah *dibuka* dan sedang dalam antrean untuk segera diproses oleh tim kami.\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Terima kasih atas kesabaran dan pengertian Anda. Kami akan segera memberikan pembaruan.\n\n"
                        . "Hormat kami,\n\n"
                        . "Tim Layanan Pelanggan \n*Indomedia Solusi Net*";

                    $agentUpdateMessage = "📝 *Pembaruan Status Tiket: Menjadi 'Open'*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Status tiket dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah diperbarui menjadi *'Open'*.\n"
                        . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Mohon segera lakukan peninjauan dan tindak lanjut. Terima kasih.";
                } elseif ($newStatus === 'diproses' && $oldStatus !== 'diproses') {
                    $customerUpdateMessage = "🛠️ *Pembaruan Status Tiket Anda: Sedang Diproses*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Tiket layanan Anda dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* saat ini *sedang dalam proses penanganan* oleh tim teknis kami.\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Tim kami sedang bekerja untuk menyelesaikannya. Terima kasih atas kepercayaan Anda. Kami akan segera memberikan pembaruan setelah penanganan selesai.";

                    $agentUpdateMessage = "🔄 *Pembaruan Status Tiket: Menjadi 'Diproses'*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Status tiket dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah diperbarui menjadi *'Diproses'*.\n"
                        . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Pastikan Anda terus memantau dan memperbarui progres penanganan hingga tiket ini dapat diselesaikan. Terima kasih.";
                } elseif (($newStatus === 'closed' || $newStatus === 'selesai') && $oldStatus !== 'closed' && $oldStatus !== 'selesai') {
                    $customerUpdateMessage = "✅ *Tiket Layanan Anda Telah Selesai Ditangani*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Dengan ini kami informasikan bahwa tiket layanan Anda dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah *berhasil diselesaikan* oleh tim kami.\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Akhir: *" . $dataToUpdate['status'] . "*\n\n"
                        . "Terima kasih atas kepercayaan Anda kepada layanan kami. Jika ada hal lain yang perlu dibantu, jangan ragu untuk menghubungi kami kembali.\n\n"
                        . "Hormat kami,\n\n"
                        . "Tim Layanan Pelanggan \n*Indomedia Solusi Net*";

                    $agentUpdateMessage = "🎉 *Pemberitahuan: Tiket Layanan Telah Ditutup*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Tiket dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* yang Anda tangani telah *berhasil ditutup*.\n"
                        . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Akhir: *" . $dataToUpdate['status'] . "*\n\n"
                        . "Terima kasih atas kerja keras dan kontribusi Anda dalam menyelesaikan tiket ini. Silakan lanjutkan dengan tugas berikutnya.";
                } else {
                    $customerUpdateMessage = "📢 *Pembaruan Tiket Anda*\n"
                        . "Halo *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Berikut pembaruan status tiket Anda dengan kode *" . $dataToUpdate['code_ticket'] . "*:\n"
                        . "• Status: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "📝 Keluhan: _" . $dataToUpdate['keluhan'] . "_\n\n"
                        . "Terima kasih atas kepercayaan dan kesabaran Anda. Kami akan terus memberikan layanan terbaik.";

                    $agentUpdateMessage = "📌 *Pembaruan Tiket Pelanggan*\n"
                        . "Halo *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Berikut detail tiket yang perlu diperbarui:\n"
                        . "• Kode Tiket: *" . $dataToUpdate['code_ticket'] . "*\n"
                        . "• Status: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "👤 Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "📝 Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "📄 Deskripsi Tambahan: " . ($dataToUpdate['deskripsi'] ?: '_Tidak ada deskripsi tambahan_') . "\n\n"
                        . "Silakan segera tindak lanjuti melalui dashboard tiket Anda. Terima kasih atas kerja samanya.";
                }

                if (!empty($customerUpdateMessage)) {
                    $this->sendWhatsAppMessage($customerPhoneNumber, $customerUpdateMessage);
                }
                if (!empty($agentUpdateMessage)) {
                    $this->sendWhatsAppMessage($agentPhoneNumber, $agentUpdateMessage);
                }
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui tiket. Terjadi kesalahan saat menyimpan perubahan.');
            log_message('error', 'Database Error on Ticket Update: ' . json_encode($this->ticketModel->errors()));
        }

        return redirect()->to(base_url('tickets'));
    }

    public function delete($id)
    {
        $this->ticketModel->delete($id);
        session()->setFlashdata('success', 'Tiket berhasil dihapus.');
        return redirect()->to(base_url('tickets'));
    }

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

    private function sendWhatsAppMessage(string $phoneNumber, string $message): bool
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $payload = [
            'api_key' => $this->whatsappApiKey,
            'sender' => '6282124838685',
            'number' => $phoneNumber,
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
