<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new LoginModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {

            // =======================================================
            // == PERBAIKAN DI SINI: Gunakan strtolower() untuk membandingkan ==
            // =======================================================
            if (strtolower($user['role']) !== strtolower($role)) {
                $session->setFlashdata('error', 'Role tidak sesuai.');
                return redirect()->to(site_url('login'))->withInput();
            }
            // =======================================================

            // Jika semua cocok, buat sesi login
            $session->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'], // Simpan role asli dari DB
                'foto'       => $user['foto'],
                'isLoggedIn' => true
            ]);

            $session->setFlashdata('success', 'Selamat datang kembali, ' . esc($user['username']) . '!');
            return redirect()->to(site_url('dashboard'));
        } else {
            $session->setFlashdata('error', 'Username, Password, atau Role salah.');
            return redirect()->to(site_url('login'))->withInput();
        }
    }

    public function logout()
    {
        session()->setFlashdata('success', 'Anda berhasil logout.');
        session()->remove(['id', 'username', 'role', 'foto', 'isLoggedIn']);
        return redirect()->to(site_url('login'));
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $rules = [
            'nama_lengkap'     => 'required|min_length[3]',
            'email'            => 'required|valid_email|is_unique[login.email]',
            'username'         => 'required|is_unique[login.username]|min_length[3]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'role'             => 'required' // Tambahkan validasi untuk role
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('register'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new LoginModel();
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role'), // Simpan role dari form
            'foto'         => 'default.png'
        ];

        $model->save($data); // Gunakan method save() dari Model

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to(site_url('login'));
    }
}
