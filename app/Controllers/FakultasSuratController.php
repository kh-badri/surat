<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuratKeluarModel;
use App\Models\MahasiswaModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class FakultasSuratController extends BaseController
{
    protected $suratKeluarModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->suratKeluarModel = new SuratKeluarModel();
        $this->mahasiswaModel = new MahasiswaModel();
        helper(['form', 'url']);
    }

    /**
     * Menampilkan daftar surat keluar yang dibuat oleh Fakultas.
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Surat Keluar Fakultas',
            'surat_keluar' => $this->suratKeluarModel->where('jenis_surat', 'fakultas')->paginate(10, 'surat_fakultas'),
            'pager' => $this->suratKeluarModel->pager,
            'active_menu' => 'surat-fakultas'
        ];
        return view('fakultas/index', $data);
    }

    /**
     * Menampilkan detail satu surat.
     */
    public function show($id = null)
    {
        $surat = $this->suratKeluarModel->find($id);
        if (empty($surat) || $surat['jenis_surat'] !== 'fakultas') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Surat Keluar Fakultas',
            'surat' => $surat,
            'active_menu' => 'surat-fakultas'
        ];
        return view('fakultas/show', $data);
    }

    /**
     * Menampilkan halaman pilih template surat.
     */
    public function new()
    {
        $data = [
            'title' => 'Pilih Template Surat Fakultas',
            'active_menu' => 'surat-fakultas'
        ];
        return view('fakultas/select_template', $data);
    }

    /**
     * Menampilkan form untuk membuat surat baru berdasarkan template.
     */
    public function create()
    {
        $template = $this->request->getGet('template');
        if (!$template) {
            return redirect()->to(site_url('fakultas/surat/new'))->with('error', 'Silakan pilih template terlebih dahulu.');
        }

        // Daftar template khusus untuk Fakultas
        $template_titles = [
            'sk_aktif_kuliah' => 'Buat Surat Keterangan Aktif Kuliah',
            'surat_tugas_dosen' => 'Buat Surat Tugas Dosen',
        ];

        $data = [
            'title' => 'Buat Surat Fakultas Baru',
            'template' => $template,
            'template_title' => $template_titles[$template] ?? 'Buat Surat Baru',
            'mahasiswa' => $this->mahasiswaModel->findAll(),
            'active_menu' => 'surat-fakultas',
            'validation' => \Config\Services::validation()
        ];

        return view('fakultas/create', $data);
    }

    /**
     * Menyimpan surat baru ke database.
     */
    public function save()
    {
        $dataToSave = [
            'login_id' => session()->get('id'), // Ambil ID user dari session
            'jenis_surat' => 'fakultas', // Otomatis set sebagai surat fakultas
            'tipe_surat' => $this->request->getPost('tipe_surat'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'tanggal_surat' => $this->request->getPost('tanggal_surat'),
            'perihal' => $this->request->getPost('perihal'),
        ];

        // Logika untuk menangani detail surat (jika ada)
        // Disesuaikan dengan kebutuhan form surat fakultas
        $mahasiswa_data = [];
        $npm_mahasiswa = $this->request->getPost('npm');

        if ($npm_mahasiswa) {
            foreach ($npm_mahasiswa as $key => $npm) {
                $mahasiswa_data[] = [
                    'nama' => $this->request->getPost('nama_mahasiswa')[$key] ?? null,
                    'npm' => $npm,
                ];
            }
        }
        $dataToSave['detail_mahasiswa'] = json_encode($mahasiswa_data);

        if ($this->suratKeluarModel->save($dataToSave)) {
            // Surat fakultas mungkin tidak mengubah status utama mahasiswa,
            // jadi logika update status bisa dikosongkan atau disesuaikan.
            return redirect()->to(site_url('fakultas/surat'))->with('success', 'Surat keluar fakultas berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->suratKeluarModel->errors());
        }
    }

    /**
     * Menampilkan form edit surat.
     */
    public function edit($id = null)
    {
        $surat = $this->suratKeluarModel->find($id);
        if (empty($surat) || $surat['jenis_surat'] !== 'fakultas') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat tidak ditemukan.');
        }

        $template_titles = [
            'sk_aktif_kuliah' => 'Edit Surat Keterangan Aktif Kuliah',
            'surat_tugas_dosen' => 'Edit Surat Tugas Dosen',
        ];

        $data = [
            'title' => 'Edit Surat Keluar Fakultas',
            'surat' => $surat,
            'template_title' => $template_titles[$surat['tipe_surat']] ?? 'Edit Surat',
            'mahasiswa' => $this->mahasiswaModel->findAll(),
            'active_menu' => 'surat-fakultas',
            'validation' => \Config\Services::validation()
        ];

        return view('fakultas/edit', $data);
    }

    /**
     * Memperbarui data surat di database.
     */
    public function update($id = null)
    {
        $surat = $this->suratKeluarModel->find($id);
        if (empty($surat) || $surat['jenis_surat'] !== 'fakultas') {
            return redirect()->to(site_url('fakultas/surat'))->with('error', 'Surat tidak valid.');
        }

        $dataToUpdate = [
            'id' => $id,
            'tipe_surat' => $this->request->getPost('tipe_surat'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'tanggal_surat' => $this->request->getPost('tanggal_surat'),
            'perihal' => $this->request->getPost('perihal'),
        ];

        $mahasiswa_data = [];
        $npm_mahasiswa = $this->request->getPost('npm');

        if ($npm_mahasiswa) {
            foreach ($npm_mahasiswa as $key => $npm) {
                $mahasiswa_data[] = [
                    'nama' => $this->request->getPost('nama_mahasiswa')[$key] ?? null,
                    'npm' => $npm,
                ];
            }
        }
        $dataToUpdate['detail_mahasiswa'] = json_encode($mahasiswa_data);

        if ($this->suratKeluarModel->save($dataToUpdate)) {
            return redirect()->to(site_url('fakultas/surat'))->with('success', 'Surat keluar fakultas berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->suratKeluarModel->errors());
        }
    }

    /**
     * Menghapus data surat.
     */
    public function delete($id = null)
    {
        $surat = $this->suratKeluarModel->find($id);
        if (empty($surat) || $surat['jenis_surat'] !== 'fakultas') {
            return redirect()->to(site_url('fakultas/surat'))->with('error', 'Surat tidak valid.');
        }

        $this->suratKeluarModel->delete($id);
        return redirect()->to(site_url('fakultas/surat'))->with('success', 'Surat keluar fakultas berhasil dihapus.');
    }

    /**
     * Mengekspor surat ke format PDF.
     */
    public function exportPdf($id = null)
    {
        $surat = $this->suratKeluarModel->find($id);
        if (empty($surat) || $surat['jenis_surat'] !== 'fakultas') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat tidak ditemukan.');
        }

        $templateView = 'pdf_templates/' . $surat['tipe_surat'];

        if (!is_file(APPPATH . 'Views/' . $templateView . '.php')) {
            throw new \RuntimeException('Template PDF tidak ditemukan: ' . $surat['tipe_surat']);
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
        $dompdf->stream($cleanNomorSurat . ".pdf", ["Attachment" => 0]);
    }
}
