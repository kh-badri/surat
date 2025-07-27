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

        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $session->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'foto'       => $user['foto'], // <-- PERBAIKAN PENTING
                'isLoggedIn' => true
            ]);

            $session->setFlashdata('success', 'Selamat datang kembali, ' . esc($user['username']) . '!');
            return redirect()->to('/dashboard');
        } else {
            $session->setFlashdata('error', 'Username atau Password salah');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->setFlashdata('success', 'Anda berhasil logout.');
        session()->remove(['id', 'username', 'foto', 'isLoggedIn']); // <-- PERBAIKAN KECIL
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
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
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'foto'     => 'default.png' // <-- PERBAIKAN PENTING
        ];

        $model->registerUser($data);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }
}
