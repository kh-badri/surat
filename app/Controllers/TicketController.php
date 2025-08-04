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
    // GANTI DENGAN NOMOR GRUP WHATSAPP ANDA (contoh: '6281234567890-123456@g.us' atau '6281234567890' jika gateway mendukung nomor biasa untuk grup)
    // Pastikan format nomor grup sesuai dengan dokumentasi WhatsApp Gateway Anda.
    private $whatsappGroupNumber = ''; // <-- ISI DENGAN GROUP JID ANDA DI SINI
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
            'code_ticket'          => $this->request->getPost('code_ticket'),
            'customer_id'          => $this->request->getPost('customer_id'),
            'nama_customer_ticket' => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket' => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'              => $this->request->getPost('keluhan'),
            'deskripsi'            => $this->request->getPost('deskripsi'),
            'status'               => $this->request->getPost('status'),
            'prioritas'            => $this->request->getPost('prioritas'),
            'tanggal_buat'         => date('Y-m-d H:i:s'), // Set tanggal_buat saat ini
            'petugas_id'           => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'  => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket' => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'  => $this->request->getPost('role_petugas_ticket'),
        ];

        // Tambahkan data untuk Petugas 2 jika ada
        if ($this->request->getPost('petugas_id_2')) {
            $dataToSave['petugas_id_2'] = $this->request->getPost('petugas_id_2');
            $dataToSave['nama_petugas_ticket_2'] = $this->request->getPost('nama_petugas_ticket_2');
            $dataToSave['no_hp_petugas_ticket_2'] = $this->request->getPost('no_hp_petugas_ticket_2');
            $dataToSave['role_petugas_ticket_2'] = $this->request->getPost('role_petugas_ticket_2');
        } else {
            // Pastikan kolom di-NULL-kan jika petugas 2 tidak dipilih
            $dataToSave['petugas_id_2'] = null;
            $dataToSave['nama_petugas_ticket_2'] = null;
            $dataToSave['no_hp_petugas_ticket_2'] = null;
            $dataToSave['role_petugas_ticket_2'] = null;
        }

        // Validasi data (Anda mungkin perlu menambahkan aturan validasi untuk petugas_id_2, dll. di TicketModel)
        if (!$this->validate($this->ticketModel->validationRules, $dataToSave, $this->ticketModel->validationMessages)) {
            return redirect()->back()->withInput();
        }

        // Simpan data ke database
        $insertResult = $this->ticketModel->insert($dataToSave);

        if ($insertResult !== false) {
            session()->setFlashdata('success', 'Tiket baru berhasil dibuat.');

            // --- START WHATSAPP INTEGRATION: Send message on new ticket creation ---
            $customerPhoneNumber = $dataToSave['no_hp_customer_ticket'];
            $agentPhoneNumber = $dataToSave['no_hp_petugas_ticket']; // Nomor HP petugas 1 yang ditugaskan

            // Pesan untuk Pelanggan (Tiket Berhasil Dibuat)
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
                . "Tim Layanan Pelanggan \n*Indomedia Solusi Net*"; // Ganti dengan nama ISP Anda

            // Pesan untuk Petugas 1 (Tiket Baru Masuk)
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

            // Pesan untuk Petugas 2 (jika ada)
            if (!empty($dataToSave['no_hp_petugas_ticket_2'])) {
                $agent2Message = "🔔 *Pemberitahuan: Anda Ditugaskan ke Tiket Baru*\n"
                    . "Yth. Bapak/Ibu *" . $dataToSave['nama_petugas_ticket_2'] . "*,\n\n"
                    . "Anda juga telah ditugaskan untuk membantu menangani tiket layanan baru dengan informasi sebagai berikut:\n"
                    . "• Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                    . "• Pelanggan: *" . $dataToSave['nama_customer_ticket'] . "*\n"
                    . "• Keluhan: _" . $dataToSave['keluhan'] . "_\n"
                    . "• Petugas Utama: *" . $dataToSave['nama_petugas_ticket'] . "*\n"
                    . "• Status Awal: *" . $dataToSave['status'] . "*\n"
                    . "• Prioritas: *" . $dataToSave['prioritas'] . "*\n\n"
                    . "Mohon koordinasi dengan petugas utama dan tindak lanjuti sesuai kebutuhan. Terima kasih.";
                $this->sendWhatsAppMessage($dataToSave['no_hp_petugas_ticket_2'], $agent2Message);
            }

            // Pesan untuk Grup (Tiket Baru Masuk)
            $groupMessage = "🚨 *NOTIFIKASI GRUP: Tiket Layanan Baru*\n"
                . "Tiket baru telah dibuat dengan detail:\n"
                . "• Kode Tiket: *" . $dataToSave['code_ticket'] . "*\n"
                . "• Pelanggan: *" . $dataToSave['nama_customer_ticket'] . "*\n"
                . "• Keluhan: _" . $dataToSave['keluhan'] . "_\n"
                . "• Petugas Ditugaskan: *" . $dataToSave['nama_petugas_ticket'] . "*";
            if (!empty($dataToSave['nama_petugas_ticket_2'])) {
                $groupMessage .= " dan *" . $dataToSave['nama_petugas_ticket_2'] . "*";
            }
            $groupMessage .= "\n• Status: *" . $dataToSave['status'] . "*\n"
                . "• Prioritas: *" . $dataToSave['prioritas'] . "*\n\n"
                . "Mohon perhatian dari tim terkait untuk memantau dan mendukung penanganan tiket ini.";

            // Kirim pesan ke pelanggan
            $this->sendWhatsAppMessage($customerPhoneNumber, $customerMessage);
            // Kirim pesan ke petugas 1
            $this->sendWhatsAppMessage($agentPhoneNumber, $agentMessage);
            // Kirim pesan ke grup (jika nomor grup diatur)
            if (!empty($this->whatsappGroupNumber)) {
                $this->sendWhatsAppMessage($this->whatsappGroupNumber, $groupMessage);
            }
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
        unset($rules['customer_id']);
        unset($rules['petugas_id']);

        $dataToUpdate = [
            'code_ticket'          => $this->request->getPost('code_ticket'),
            'customer_id'          => $this->request->getPost('customer_id'),
            'nama_customer_ticket' => $this->request->getPost('nama_customer_ticket'),
            'alamat_customer_ticket' => $this->request->getPost('alamat_customer_ticket'),
            'no_hp_customer_ticket' => $this->request->getPost('no_hp_customer_ticket'),
            'keluhan'              => $this->request->getPost('keluhan'),
            'deskripsi'            => $this->request->getPost('deskripsi'),
            'status'               => $this->request->getPost('status'),
            'prioritas'            => $this->request->getPost('prioritas'),
            'petugas_id'           => $this->request->getPost('petugas_id'),
            'nama_petugas_ticket'  => $this->request->getPost('nama_petugas_ticket'),
            'no_hp_petugas_ticket' => $this->request->getPost('no_hp_petugas_ticket'),
            'role_petugas_ticket'  => $this->request->getPost('role_petugas_ticket'),
        ];

        // Tambahkan data untuk Petugas 2 jika ada
        if ($this->request->getPost('petugas_id_2')) {
            $dataToUpdate['petugas_id_2'] = $this->request->getPost('petugas_id_2');
            $dataToUpdate['nama_petugas_ticket_2'] = $this->request->getPost('nama_petugas_ticket_2');
            $dataToUpdate['no_hp_petugas_ticket_2'] = $this->request->getPost('no_hp_petugas_ticket_2');
            $dataToUpdate['role_petugas_ticket_2'] = $this->request->getPost('role_petugas_ticket_2');
        } else {
            // Jika petugas 2 tidak dipilih/dihapus, pastikan kolomnya di database di-NULL-kan
            $dataToUpdate['petugas_id_2'] = null;
            $dataToUpdate['nama_petugas_ticket_2'] = null;
            $dataToUpdate['no_hp_petugas_ticket_2'] = null;
            $dataToUpdate['role_petugas_ticket_2'] = null;
        }

        // Validasi data (Anda mungkin perlu menambahkan aturan validasi untuk petugas_id_2, dll. di TicketModel)
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
            if ($dataToUpdate['status'] !== $oldTicket['status'] || $dataToUpdate['prioritas'] !== $oldTicket['prioritas'] ||
                $dataToUpdate['petugas_id'] !== $oldTicket['petugas_id'] || $dataToUpdate['petugas_id_2'] !== ($oldTicket['petugas_id_2'] ?? null)) { // Cek perubahan petugas juga
                
                $customerPhoneNumber = $dataToUpdate['no_hp_customer_ticket'];
                $agentPhoneNumber1 = $dataToUpdate['no_hp_petugas_ticket']; // Nomor HP petugas 1
                $agentPhoneNumber2 = $dataToUpdate['no_hp_petugas_ticket_2'] ?? null; // Nomor HP petugas 2

                $customerUpdateMessage = "";
                $agentUpdateMessage1 = "";
                $agentUpdateMessage2 = "";
                $groupUpdateMessage = "";

                // Konversi status ke huruf kecil untuk perbandingan yang konsisten
                $newStatus = strtolower($dataToUpdate['status']);
                $oldStatus = strtolower($oldTicket['status']);

                // Logika pesan berdasarkan perubahan status
                if ($newStatus === 'open' && $oldStatus !== 'open') {
                    // Pesan untuk Pelanggan (Tiket Open)
                    $customerUpdateMessage = "🔔 *Pemberitahuan Status Tiket Anda: Dibuka*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Tiket layanan Anda dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah *dibuka* dan sedang dalam antrean untuk segera diproses oleh tim kami.\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Terima kasih atas kesabaran dan pengertian Anda. Kami akan segera memberikan pembaruan.\n\n"
                        . "Hormat kami,\n\n"
                        . "Tim Layanan Pelanggan \n*Indomedia Solusi Net*";

                    // Pesan untuk Petugas 1 (Tiket Open)
                    $agentUpdateMessage1 = "� *Pembaruan Status Tiket: Menjadi 'Open'*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Status tiket dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah diperbarui menjadi *'Open'*.\n"
                        . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Mohon segera lakukan peninjauan dan tindak lanjut. Terima kasih.";

                    // Pesan untuk Petugas 2 (jika ada)
                    if (!empty($agentPhoneNumber2)) {
                        $agentUpdateMessage2 = "📝 *Pembaruan Status Tiket: Menjadi 'Open'*\n"
                            . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket_2'] . "*,\n\n"
                            . "Tiket *" . $dataToUpdate['code_ticket'] . "* yang Anda bantu tangani telah diperbarui menjadi *'Open'*.\n"
                            . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                            . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                            . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                            . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                            . "Mohon diperhatikan dan koordinasi dengan petugas utama. Terima kasih.";
                    }

                    // Pesan untuk Grup (Tiket Open)
                    $groupUpdateMessage = "📊 *Pembaruan Status Grup: Tiket Dibuka*\n"
                        . "Tiket *" . $dataToUpdate['code_ticket'] . "* (Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*) telah diubah statusnya menjadi *'Open'*.\n"
                        . "Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "Prioritas: *" . $dataToUpdate['prioritas'] . "*\n"
                        . "Petugas: *" . $dataToUpdate['nama_petugas_ticket'] . "*";
                    if (!empty($dataToUpdate['nama_petugas_ticket_2'])) {
                        $groupUpdateMessage .= " dan *" . $dataToUpdate['nama_petugas_ticket_2'] . "*";
                    }
                    $groupUpdateMessage .= "\n\nMohon pantau progressnya.";

                } elseif ($newStatus === 'diproses' && $oldStatus !== 'diproses') {
                    // Pesan untuk Pelanggan (Tiket Progress)
                    $customerUpdateMessage = "🛠️ *Pembaruan Status Tiket Anda: Sedang Diproses*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Tiket layanan Anda dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* saat ini *sedang dalam proses penanganan* oleh tim teknis kami.\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Tim kami sedang bekerja untuk menyelesaikannya. Terima kasih atas kepercayaan Anda. Kami akan segera memberikan pembaruan setelah penanganan selesai.";

                    // Pesan untuk Petugas 1 (Tiket Progress)
                    $agentUpdateMessage1 = "🔄 *Pembaruan Status Tiket: Menjadi 'Diproses'*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Status tiket dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah diperbarui menjadi *'Diproses'*.\n"
                        . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "Pastikan Anda terus memantau dan memperbarui progres penanganan hingga tiket ini dapat diselesaikan. Terima kasih.";
                    
                    // Pesan untuk Petugas 2 (jika ada)
                    if (!empty($agentPhoneNumber2)) {
                        $agentUpdateMessage2 = "🔄 *Pembaruan Status Tiket: Menjadi 'Diproses'*\n"
                            . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket_2'] . "*,\n\n"
                            . "Tiket *" . $dataToUpdate['code_ticket'] . "* yang Anda bantu tangani telah diperbarui menjadi *'Diproses'*.\n"
                            . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                            . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                            . "• Status Terbaru: *" . $dataToUpdate['status'] . "*\n"
                            . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                            . "Mohon diperhatikan dan koordinasi dengan petugas utama. Terima kasih.";
                    }

                    // Pesan untuk Grup (Tiket Progress)
                    $groupUpdateMessage = "📈 *Pembaruan Status Grup: Tiket Diproses*\n"
                        . "Tiket *" . $dataToUpdate['code_ticket'] . "* (Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*) telah diubah statusnya menjadi *'Diproses'*.\n"
                        . "Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "Prioritas: *" . $dataToUpdate['prioritas'] . "*\n"
                        . "Petugas: *" . $dataToUpdate['nama_petugas_ticket'] . "*";
                    if (!empty($dataToUpdate['nama_petugas_ticket_2'])) {
                        $groupUpdateMessage .= " dan *" . $dataToUpdate['nama_petugas_ticket_2'] . "*";
                    }
                    $groupUpdateMessage .= "\n\nTim sedang dalam penanganan. Mohon dukungan dan pantau progresnya.";

                } elseif (($newStatus === 'closed' || $newStatus === 'selesai') && $oldStatus !== 'closed' && $oldStatus !== 'selesai') {
                    // Pesan untuk Pelanggan (Tiket Closed)
                    $customerUpdateMessage = "✅ *Tiket Layanan Anda Telah Selesai Ditangani*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Dengan ini kami informasikan bahwa tiket layanan Anda dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* telah *berhasil diselesaikan* oleh tim kami.\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Akhir: *" . $dataToUpdate['status'] . "*\n\n"
                        . "Terima kasih atas kepercayaan Anda kepada layanan kami. Jika ada hal lain yang perlu dibantu, jangan ragu untuk menghubungi kami kembali.\n\n"
                        . "Hormat kami,\n\n"
                        . "Tim Layanan Pelanggan \n*Indomedia Solusi Net*";

                    // Pesan untuk Petugas 1 (Tiket Closed)
                    $agentUpdateMessage1 = "🎉 *Pemberitahuan: Tiket Layanan Telah Ditutup*\n"
                        . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Tiket dengan Kode Tiket *" . $dataToUpdate['code_ticket'] . "* yang Anda tangani telah *berhasil ditutup*.\n"
                        . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "• Status Akhir: *" . $dataToUpdate['status'] . "*\n\n"
                        . "Terima kasih atas kerja keras dan kontribusi Anda dalam menyelesaikan tiket ini. Silakan lanjutkan dengan tugas berikutnya.";

                    // Pesan untuk Petugas 2 (jika ada)
                    if (!empty($agentPhoneNumber2)) {
                        $agentUpdateMessage2 = "🎉 *Pemberitahuan: Tiket Layanan Telah Ditutup*\n"
                            . "Yth. Bapak/Ibu *" . $dataToUpdate['nama_petugas_ticket_2'] . "*,\n\n"
                            . "Tiket *" . $dataToUpdate['code_ticket'] . "* yang Anda bantu tangani telah diperbarui menjadi *'Closed'*.\n"
                            . "• Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                            . "• Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                            . "• Status Akhir: *" . $dataToUpdate['status'] . "*\n\n"
                            . "Terima kasih atas kerja keras dan kontribusi Anda dalam menyelesaikan tiket ini.";
                    }

                    // Pesan untuk Grup (Tiket Closed)
                    $groupUpdateMessage = "✅ *Pembaruan Status Grup: Tiket Ditutup*\n"
                        . "Tiket *" . $dataToUpdate['code_ticket'] . "* (Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*) telah *berhasil ditutup*.\n"
                        . "Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "Prioritas: *" . $dataToUpdate['prioritas'] . "*\n"
                        . "Petugas: *" . $dataToUpdate['nama_petugas_ticket'] . "*";
                    if (!empty($dataToUpdate['nama_petugas_ticket_2'])) {
                        $groupUpdateMessage .= " dan *" . $dataToUpdate['nama_petugas_ticket_2'] . "*";
                    }
                    $groupUpdateMessage .= "\n\nTerima kasih atas kerja sama tim dalam penanganan tiket ini.";
                } else {
                    // Pesan default untuk perubahan status/prioritas lainnya yang tidak spesifik
                    $customerUpdateMessage = "📢 *Pembaruan Tiket Anda*\n"
                        . "Halo *" . $dataToUpdate['nama_customer_ticket'] . "*,\n\n"
                        . "Berikut pembaruan status tiket Anda dengan kode *" . $dataToUpdate['code_ticket'] . "*:\n"
                        . "• Status: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "📝 Keluhan: _" . $dataToUpdate['keluhan'] . "_\n\n"
                        . "Terima kasih atas kepercayaan dan kesabaran Anda. Kami akan terus memberikan layanan terbaik.";

                    $agentUpdateMessage1 = "📌 *Pembaruan Tiket Pelanggan*\n"
                        . "Halo *" . $dataToUpdate['nama_petugas_ticket'] . "*,\n\n"
                        . "Berikut detail tiket yang perlu diperbarui:\n"
                        . "• Kode Tiket: *" . $dataToUpdate['code_ticket'] . "*\n"
                        . "• Status: *" . $dataToUpdate['status'] . "*\n"
                        . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                        . "👤 Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*\n"
                        . "📝 Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "📄 Deskripsi Tambahan: " . ($dataToUpdate['deskripsi'] ?: '_Tidak ada deskripsi tambahan_') . "\n\n"
                        . "Silakan segera tindak lanjuti melalui dashboard tiket Anda. Terima kasih atas kerja samanya.";
                    
                    if (!empty($agentPhoneNumber2)) {
                        $agentUpdateMessage2 = "📌 *Pembaruan Tiket Pelanggan*\n"
                            . "Halo *" . $dataToUpdate['nama_petugas_ticket_2'] . "*,\n\n"
                            . "Ada pembaruan pada tiket *" . $dataToUpdate['code_ticket'] . "* yang Anda bantu tangani.\n"
                            . "• Status: *" . $dataToUpdate['status'] . "*\n"
                            . "• Prioritas: *" . $dataToUpdate['prioritas'] . "*\n\n"
                            . "Mohon diperhatikan dan koordinasi dengan petugas utama. Terima kasih.";
                    }

                    $groupUpdateMessage = "ℹ️ *Pembaruan Umum Tiket Grup*\n"
                        . "Ada pembaruan pada tiket *" . $dataToUpdate['code_ticket'] . "* (Pelanggan: *" . $dataToUpdate['nama_customer_ticket'] . "*).\n"
                        . "Status terbaru: *" . $dataToUpdate['status'] . "*\n"
                        . "Prioritas terbaru: *" . $dataToUpdate['prioritas'] . "*\n"
                        . "Keluhan: _" . $dataToUpdate['keluhan'] . "_\n"
                        . "Petugas: *" . $dataToUpdate['nama_petugas_ticket'] . "*";
                    if (!empty($dataToUpdate['nama_petugas_ticket_2'])) {
                        $groupUpdateMessage .= " dan *" . $dataToUpdate['nama_petugas_ticket_2'] . "*";
                    }
                    $groupUpdateMessage .= "\n\nMohon diperhatikan.";
                }

                // Kirim pesan hanya jika ada pesan yang dibuat
                if (!empty($customerUpdateMessage)) {
                    $this->sendWhatsAppMessage($customerPhoneNumber, $customerUpdateMessage);
                }
                if (!empty($agentUpdateMessage1)) {
                    $this->sendWhatsAppMessage($agentPhoneNumber1, $agentUpdateMessage1);
                }
                if (!empty($agentUpdateMessage2)) {
                    $this->sendWhatsAppMessage($agentPhoneNumber2, $agentUpdateMessage2);
                }
                // Kirim pesan ke grup (jika nomor grup diatur)
                if (!empty($this->whatsappGroupNumber) && !empty($groupUpdateMessage)) {
                    $this->sendWhatsAppMessage($this->whatsappGroupNumber, $groupUpdateMessage);
                }
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
     * @param string $phoneNumber Nomor telepon tujuan (dengan kode negara, cth: "6281234567890" atau Group ID)
     * @param string $message Isi pesan yang akan dikirim
     * @return bool True jika pengiriman berhasil dipicu, False jika gagal
     */
    private function sendWhatsAppMessage(string $phoneNumber, string $message): bool
    {
        // Hapus karakter non-digit jika bukan Group ID (yang mungkin mengandung '@')
        // Asumsi Group ID memiliki format 'number-g.us'
        if (strpos($phoneNumber, '@g.us') === false) {
            $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
            // Pastikan nomor diawali dengan kode negara tanpa '+' atau '0' di awal jika gateway memerlukannya
            // Contoh: jika nomor 0812..., ubah jadi 62812...
            if (substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = '62' . substr($phoneNumber, 1); // Asumsi kode negara Indonesia
            }
        }

        $payload = [
            'api_key' => $this->whatsappApiKey,
            'sender'  => '6281436069634', // Nomor perangkat pengirim dari MPWA V7
            'number'  => $phoneNumber,
            'message' => $message,
            // Tambahkan parameter lain sesuai dokumentasi WhatsApp Gateway Anda
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
�