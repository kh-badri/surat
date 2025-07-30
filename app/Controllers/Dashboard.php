<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel; // Import CustomerModel Anda
use App\Models\PetugasModel;  // Import PetugasModel Anda
use App\Models\TicketModel;   // Import TicketModel Anda

class Dashboard extends BaseController
{
    protected $customerModel;
    protected $petugasModel;
    protected $ticketModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->petugasModel = new PetugasModel();
        $this->ticketModel = new TicketModel();
        helper('url'); // Pastikan helper url dimuat untuk fungsi base_url()
    }

    public function index()
    {
        // Mendapatkan total jumlah dari setiap tabel
        $totalCustomers = $this->customerModel->countAllResults();
        $totalPetugas = $this->petugasModel->countAllResults();
        $totalTickets = $this->ticketModel->countAllResults();

        // Mendapatkan jumlah tiket berdasarkan status
        $ticketsOpen = $this->ticketModel->where('status', 'open')->countAllResults();
        $ticketsProgress = $this->ticketModel->where('status', 'progress')->countAllResults();
        $ticketsClosed = $this->ticketModel->where('status', 'closed')->countAllResults();

        // Mendapatkan jumlah tiket berdasarkan prioritas
        $priorityLow = $this->ticketModel->where('prioritas', 'low')->countAllResults();
        $priorityMedium = $this->ticketModel->where('prioritas', 'medium')->countAllResults();
        $priorityHigh = $this->ticketModel->where('prioritas', 'high')->countAllResults();
        $priorityUrgent = $this->ticketModel->where('prioritas', 'urgent')->countAllResults();

        // Mendapatkan 5 tiket terbaru (opsional, bisa disesuaikan jumlahnya)
        $recentTickets = $this->ticketModel->orderBy('created_at', 'DESC')->limit(5)->findAll();


        $data = [
            'title'             => 'Dashboard Overview',
            'totalCustomers'    => $totalCustomers,
            'totalPetugas'      => $totalPetugas,
            'totalTickets'      => $totalTickets,
            'ticketsOpen'       => $ticketsOpen,
            'ticketsProgress'   => $ticketsProgress,
            'ticketsClosed'     => $ticketsClosed,
            'priorityLow'       => $priorityLow,
            'priorityMedium'    => $priorityMedium,
            'priorityHigh'      => $priorityHigh,
            'priorityUrgent'    => $priorityUrgent,
            'recentTickets'     => $recentTickets,
            'active_menu'       => 'dashboard', // Untuk penanda menu aktif di navigasi
        ];
        return view('dashboard/index', $data); // Mengirim data ke view dashboard/index.php
    }
}
