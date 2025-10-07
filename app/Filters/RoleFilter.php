<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Method ini dipanggil sebelum controller dieksekusi.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments Berisi peran yang diizinkan dari file Routes.
     * Contoh: ['filter' => 'role:prodi']
     * akan menghasilkan $arguments = ['prodi']
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Pastikan pengguna sudah login.
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        // 2. Pastikan ada argumen peran yang diberikan di file Routes.
        if (empty($arguments)) {
            session()->setFlashdata('error', 'Akses ditolak karena kesalahan konfigurasi rute.');
            return redirect()->to('/');
        }

        // 3. Ambil peran pengguna dari session dan ubah menjadi huruf kecil.
        $userRole = strtolower(session()->get('role')); // Diubah menjadi lowercase

        // ==========================================================
        // == START: LOGIKA BARU UNTUK HAK AKSES PRODI & FAKULTAS ==
        // ==========================================================

        // 4. Pengecualian: Jika role pengguna adalah 'prodi', berikan akses ke mana saja.
        if ($userRole === 'prodi') {
            // 'prodi' adalah super admin, jangan lakukan pengecekan lebih lanjut
            // dan langsung izinkan request untuk melanjutkan.
            return;
        }

        // 5. Aturan Standar: Jika role BUKAN 'prodi' (misalnya 'fakultas'),
        //    periksa apakah perannya cocok dengan yang diizinkan di rute.
        //    Ubah argumen menjadi lowercase untuk konsistensi.
        $allowedRoles = array_map('strtolower', $arguments);
        if (! in_array($userRole, $allowedRoles)) {
            // Jika peran tidak cocok (misal: user 'fakultas' mencoba akses rute 'prodi'),
            // kembalikan pengguna dengan pesan error.
            session()->setFlashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            return redirect()->back();
        }

        // ========================================================
        // == END: LOGIKA BARU                                   ==
        // ========================================================
    }

    // --------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa pun di sini.
    }
}
