<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Auth extends BaseController
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        return view('auth/login');
    }

    /**
     * Memproses upaya login dari pengguna.
     */
    public function login()
    {
        $session = session();
        $model = new LoginModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'isLoggedIn' => true
            ]);

            // Tambahkan baris ini untuk mengirim pesan sukses
            $session->setFlashdata('success', 'Selamat datang kembali!');

            // --- PERBAIKAN DI SINI ---
            // Arahkan langsung ke halaman dashboard
            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('error', 'Username atau Password salah');
            return redirect()->to('/login');
        }
    }
    /**
     * Menghancurkan sesi dan mengeluarkan pengguna.
     */
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Anda berhasil logout.');
        return redirect()->to('/login');
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function register()
    {
        return view('auth/register');
    }

    /**
     * Memproses data registrasi pengguna baru.
     */
    public function processRegister()
    {
        // **PERBAIKAN DI SINI**
        // Validasi is_unique sekarang memeriksa tabel 'login'
        $rules = [
            'username'         => 'required|is_unique[login.username]|min_length[3]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new LoginModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $model->registerUser($data);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }
}
