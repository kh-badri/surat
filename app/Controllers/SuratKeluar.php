<?php

namespace App\Controllers;

use App\Models\SuratKeluarModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class SuratKeluar extends BaseController
{
    protected $suratKeluarModel;

    public function __construct()
    {
        $this->suratKeluarModel = new SuratKeluarModel();
    }

    // ... (method index() dan show() tidak berubah) ...
    public function index()
    {
        $data = [
            'active_menu' => 'surat-keluar', // Variabel untuk menu aktif
            'title' => 'Daftar Surat Keluar',
            'surat_keluar' => $this->suratKeluarModel->findAll()
        ];
        return view('surat_keluar/index', $data);
    }

    public function show($id)
    {
        $data = [
            'title' => 'Detail Surat Keluar',
            'surat' => $this->suratKeluarModel->find($id)
        ];

        if (empty($data['surat'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('surat_keluar/show', $data);
    }


    public function new()
    {
        $data = [
            'title' => 'Pilih Template Surat Keluar'
        ];
        return view('surat_keluar/select_template', $data);
    }

    // === METHOD create() DIPERBAIKI ===
    public function create()
    {
        $template = $this->request->getGet('template');
        if (!$template) {
            return redirect()->to(site_url('surat-keluar/new'))->with('error', 'Silakan pilih template terlebih dahulu.');
        }

        // Menentukan judul berdasarkan template
        $template_titles = [
            'sk_pembimbing_kp' => 'Buat Usulan SK Dosen Pembimbing Kerja Praktek',
            'pengantar_kp' => 'Buat Permohonan Surat Pengantar Kerja Praktek',
            'sk_pembimbing_skripsi' => 'Buat Usulan SK Dosen Pembimbing Skripsi'
        ];

        $data = [
            'title' => 'Buat Surat Keluar Baru',
            'template' => $template,
            'template_title' => $template_titles[$template] ?? 'Buat Surat Baru' // Menambahkan template_title
        ];

        return view('surat_keluar/create', $data);
    }


    public function save()
    {
        $dataToSave = [
            'tipe_surat' => $this->request->getPost('tipe_surat'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'tanggal_surat' => $this->request->getPost('tanggal_surat'),
            'lampiran' => $this->request->getPost('lampiran'),
            'perihal' => $this->request->getPost('perihal'),
        ];

        // Mengolah data mahasiswa menjadi JSON
        $mahasiswa_data = [];
        $nama_mahasiswa = $this->request->getPost('nama_mahasiswa');

        if ($nama_mahasiswa) {
            foreach ($nama_mahasiswa as $key => $nama) {
                $mahasiswa_data[] = [
                    'nama' => $nama,
                    'npm' => $this->request->getPost('npm')[$key] ?? null,
                    'judul' => $this->request->getPost('judul')[$key] ?? null,
                    'dosen_pembimbing' => $this->request->getPost('dosen_pembimbing')[$key] ?? null,
                    'perusahaan' => $this->request->getPost('perusahaan')[$key] ?? null,
                    'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan')[$key] ?? null,
                    'waktu_pelaksanaan' => $this->request->getPost('waktu_pelaksanaan')[$key] ?? null,
                ];
            }
        }
        $dataToSave['detail_surat'] = json_encode($mahasiswa_data);

        $this->suratKeluarModel->save($dataToSave);
        return redirect()->to(site_url('surat-keluar'))->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    // === METHOD edit() DIPERBAIKI ===
    public function edit($id)
    {
        $surat = $this->suratKeluarModel->find($id);

        if (empty($surat)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Menentukan judul berdasarkan tipe surat yang sudah ada
        $template_titles = [
            'sk_pembimbing_kp' => 'Edit Usulan SK Dosen Pembimbing Kerja Praktek',
            'pengantar_kp' => 'Edit Permohonan Surat Pengantar Kerja Praktek',
            'sk_pembimbing_skripsi' => 'Edit Usulan SK Dosen Pembimbing Skripsi'
        ];

        $data = [
            'title' => 'Edit Surat Keluar',
            'surat' => $surat,
            'template_title' => $template_titles[$surat['tipe_surat']] ?? 'Edit Surat' // Menambahkan template_title
        ];

        return view('surat_keluar/edit', $data);
    }

    public function update($id)
    {
        $dataToUpdate = [
            'id' => $id,
            'tipe_surat' => $this->request->getPost('tipe_surat'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'tanggal_surat' => $this->request->getPost('tanggal_surat'),
            'lampiran' => $this->request->getPost('lampiran'),
            'perihal' => $this->request->getPost('perihal'),
        ];

        $mahasiswa_data = [];
        $nama_mahasiswa = $this->request->getPost('nama_mahasiswa');

        if ($nama_mahasiswa) {
            foreach ($nama_mahasiswa as $key => $nama) {
                $mahasiswa_data[] = [
                    'nama' => $nama,
                    'npm' => $this->request->getPost('npm')[$key] ?? null,
                    'judul' => $this->request->getPost('judul')[$key] ?? null,
                    'dosen_pembimbing' => $this->request->getPost('dosen_pembimbing')[$key] ?? null,
                    'perusahaan' => $this->request->getPost('perusahaan')[$key] ?? null,
                    'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan')[$key] ?? null,
                    'waktu_pelaksanaan' => $this->request->getPost('waktu_pelaksanaan')[$key] ?? null,
                ];
            }
        }
        $dataToUpdate['detail_surat'] = json_encode($mahasiswa_data);

        $this->suratKeluarModel->save($dataToUpdate);
        return redirect()->to(site_url('surat-keluar'))->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->suratKeluarModel->delete($id);
        return redirect()->to(site_url('surat-keluar'))->with('success', 'Surat keluar berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $surat = $this->suratKeluarModel->find($id);
        if (empty($surat)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat dengan ID ' . $id . ' tidak ditemukan.');
        }

        $templateView = 'surat_keluar/pdf_templates/' . $surat['tipe_surat'];
        if (!is_file(APPPATH . 'Views/' . $templateView . '.php')) {
            throw new \RuntimeException('Template PDF tidak ditemukan untuk tipe surat: ' . $surat['tipe_surat']);
        }

        $data['surat'] = $surat;
        $html = view($templateView, $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Times New Roman');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $cleanNomorSurat = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $surat['nomor_surat']);
        $dompdf->stream($cleanNomorSurat . ".pdf", array("Attachment" => 0));
    }
}
