<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Akun extends BaseController
{
    /**
     * Menampilkan halaman utama akun pengguna.
     */
    public function index()
    {
        $model = new LoginModel();
        $userId = session()->get('id');

        $data = [
            'title'       => 'Halaman Akun',
            'active_menu' => 'akun', // Untuk menu aktif di sidebar
            'user'        => $model->find($userId)
        ];
        return view('akun/index', $data);
    }

    /**
     * Memproses pembaruan data profil (nama, email, foto).
     */
    public function updateProfil()
    {
        $model = new LoginModel();
        $userId = session()->get('id');
        $user = $model->find($userId);

        // Aturan validasi untuk nama dan email
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'email'        => "required|valid_email|is_unique[login.email,id,{$userId}]"
        ];

        // Aturan validasi tambahan jika ada file foto yang di-upload
        $foto = $this->request->getFile('foto');
        if ($foto->isValid() && !$foto->hasMoved()) {
            $rules['foto'] = 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->to('/akun')->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToSave = [
            'id'           => $userId,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
        ];

        // Proses file foto jika ada yang baru
        if ($foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama untuk menghemat ruang, kecuali jika itu foto default
            if ($user['foto'] != 'default.jpg') {
                @unlink('uploads/foto_profil/' . $user['foto']);
            }
            $namaFotoBaru = $foto->getRandomName();
            $foto->move('uploads/foto_profil', $namaFotoBaru);
            $dataToSave['foto'] = $namaFotoBaru;
        }

        $model->save($dataToSave);
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to('/akun');
    }

    /**
     * Memproses pembaruan password pengguna.
     */
    public function updateSandi()
    {
        $model = new LoginModel();
        $userId = session()->get('id');
        $user = $model->find($userId);

        // Aturan validasi untuk password
        $rules = [
            'password_lama'       => 'required',
            'password_baru'       => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password_baru]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/akun')->withInput()->with('errors', 'Kolom password tidak boleh kosong');
        }

        // Verifikasi kecocokan password lama
        if (!password_verify($this->request->getPost('password_lama'), $user['password'])) {
            return redirect()->to('/akun')->with('errors', ['password_lama' => 'Password lama salah.']);
        }

        // Simpan password baru yang sudah di-hash
        $dataToSave = [
            'id'       => $userId,
            'password' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT)
        ];
        $model->save($dataToSave);

        session()->setFlashdata('success', 'Password berhasil diubah.');
        return redirect()->to('/akun');
    }
}
