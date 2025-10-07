<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuratKeluarModel;
use App\Models\MahasiswaModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProdiSuratController extends BaseController
{
    protected $suratKeluarModel;
    protected $mahasiswaModel;

    public function __construct()
    {
        $this->suratKeluarModel = new SuratKeluarModel();
        $this->mahasiswaModel = new MahasiswaModel();
        helper(['url', 'form']);
    }

    /**
     * Menampilkan daftar semua surat keluar prodi.
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Surat Keluar Prodi',
            'surat_keluar' => $this->suratKeluarModel->where('jenis_surat', 'prodi')->orderBy('id', 'DESC')->paginate(10, 'surat_prodi'),
            'pager' => $this->suratKeluarModel->pager,
            'active_menu' => 'surat-prodi'
        ];
        return view('prodi/index', $data);
    }

    /**
     * Menampilkan halaman pilih template surat.
     */
    public function new()
    {
        $data = [
            'title' => 'Pilih Template Surat Prodi',
            'active_menu' => 'surat-prodi'
        ];
        return view('prodi/select_template', $data);
    }

    /**
     * Menampilkan form untuk membuat surat baru berdasarkan template,
     * lengkap dengan nomor surat otomatis.
     */
    public function create()
    {
        $template = $this->request->getGet('template');
        if (!$template) {
            return redirect()->to(site_url('prodi/new'))->with('error', 'Silakan pilih template terlebih dahulu.');
        }

        $nomorSuratOtomatis = $this->suratKeluarModel->generateNomorSurat($template);

        // PERBAIKAN: Menambahkan 2 template baru ke dalam array
        $template_titles = [
            'sk_pembimbing_kp'      => 'Usulan SK Dosen Pembimbing Kerja Praktek',
            'pengantar_kp'          => 'Permohonan Surat Pengantar Kerja Praktek',
            'sk_pembimbing_skripsi' => 'Usulan SK Dosen Pembimbing Skripsi',
            'usulan_sk_sempro'      => 'Usulan SK Seminar Proposal',
            'usulan_sk_sidang'      => 'Usulan SK Sidang Meja Hijau'
        ];

        $data = [
            'title'                 => 'Buat Surat Keluar Baru',
            'template'              => $template,
            'template_title'        => $template_titles[$template] ?? 'Buat Surat Baru',
            'active_menu'           => 'surat-prodi',
            'nomor_surat_otomatis'  => $nomorSuratOtomatis,
            'validation'            => \Config\Services::validation()
        ];
        return view('prodi/create', $data);
    }


    public function save()
    {
        if (!$this->validate($this->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $suratId = $this->suratKeluarModel->insert([
                'login_id'      => session()->get('id'),
                'jenis_surat'   => 'prodi',
                'tipe_surat'    => $this->request->getPost('tipe_surat'),
                'nomor_surat'   => $this->request->getPost('nomor_surat'),
                'tanggal_surat' => $this->request->getPost('tanggal_surat'),
                'perihal'       => $this->request->getPost('perihal'),
                'lampiran'      => $this->request->getPost('lampiran'),
            ], true);

            $npmArray = $this->request->getPost('npm') ?? [];
            foreach ($npmArray as $key => $npm) {
                if (empty($npm) || empty($this->request->getPost('nama_mahasiswa')[$key])) {
                    continue;
                }

                // PERBAIKAN: Menggabungkan input dosen pembanding/penguji
                $pembanding1 = $this->request->getPost('dosen_pembanding_1')[$key] ?? '';
                $pembanding2 = $this->request->getPost('dosen_pembanding_2')[$key] ?? '';
                $dosenPembanding = trim("1. {$pembanding1}\n2. {$pembanding2}");

                $penguji1 = $this->request->getPost('dosen_penguji_1')[$key] ?? '';
                $penguji2 = $this->request->getPost('dosen_penguji_2')[$key] ?? '';
                $dosenPenguji = trim("1. {$penguji1}\n2. {$penguji2}");

                $this->mahasiswaModel->insert([
                    'surat_keluar_id'   => $suratId,
                    'npm'               => $npm,
                    'nama_mahasiswa'    => $this->request->getPost('nama_mahasiswa')[$key],
                    'perusahaan'        => $this->request->getPost('perusahaan')[$key] ?? null,
                    'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan')[$key] ?? null,
                    'judul'             => $this->request->getPost('judul')[$key] ?? null,
                    'dosen_pembimbing'  => $this->request->getPost('dosen_pembimbing')[$key] ?? null,
                    'waktu_pelaksanaan' => $this->request->getPost('waktu_pelaksanaan')[$key] ?? null,
                    'dosen_pembanding'  => $dosenPembanding ?: null,
                    'dosen_penguji'     => $dosenPenguji ?: null,
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan data ke database.');
            }

            return redirect()->to(site_url('prodi'))->with('success', 'Surat keluar berhasil dibuat.');
        } catch (\Exception $e) {
            log_message('error', '[ERROR] ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan internal saat menyimpan data.');
        }
    }

    /**
     * Menampilkan detail satu surat.
     */
    public function show($id = null)
    {
        $surat = $this->_findSuratOr404($id);
        $mahasiswa = $this->mahasiswaModel->where('surat_keluar_id', $id)->findAll();

        $data = [
            'title'       => 'Detail Surat Keluar',
            'surat'       => $surat,
            'mahasiswa'   => $mahasiswa,
            'active_menu' => 'surat-prodi'
        ];
        return view('prodi/show', $data);
    }

    /**
     * Menampilkan form untuk mengedit surat.
     */
    public function edit($id = null)
    {
        $surat = $this->_findSuratOr404($id);
        $mahasiswa = $this->mahasiswaModel->where('surat_keluar_id', $id)->findAll();

        $template_titles = [
            'sk_pembimbing_kp'      => 'Edit Usulan SK Dosen Pembimbing KP',
            'pengantar_kp'          => 'Edit Permohonan Surat Pengantar KP',
            'sk_pembimbing_skripsi' => 'Edit Usulan SK Dosen Pembimbing Skripsi',
            'usulan_sk_sempro'      => 'Edit Usulan SK Seminar Proposal',
            'usulan_sk_sidang'      => 'Edit Usulan SK Sidang Meja Hijau'
        ];

        $data = [
            'title'          => 'Edit Surat Keluar',
            'surat'          => $surat,
            'mahasiswa'      => $mahasiswa,
            'template_title' => $template_titles[$surat['tipe_surat']] ?? 'Edit Surat',
            'active_menu'    => 'surat-prodi',
            'validation'     => \Config\Services::validation()
        ];
        return view('prodi/edit', $data);
    }

    /**
     * Memperbarui data surat di database.
     */
    public function update($id = null)
    {
        $this->_findSuratOr404($id);

        if (!$this->validate($this->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $this->suratKeluarModel->update($id, [
                'nomor_surat'   => $this->request->getPost('nomor_surat'),
                'tanggal_surat' => $this->request->getPost('tanggal_surat'),
                'perihal'       => $this->request->getPost('perihal'),
                'lampiran'      => $this->request->getPost('lampiran'),
            ]);

            $this->mahasiswaModel->where('surat_keluar_id', $id)->delete();

            $npmArray = $this->request->getPost('npm') ?? [];
            foreach ($npmArray as $key => $npm) {
                if (empty($npm) || empty($this->request->getPost('nama_mahasiswa')[$key])) {
                    continue;
                }

                // PERBAIKAN: Menggabungkan input dosen pembanding/penguji
                $pembanding1 = $this->request->getPost('dosen_pembanding_1')[$key] ?? '';
                $pembanding2 = $this->request->getPost('dosen_pembanding_2')[$key] ?? '';
                $dosenPembanding = trim("1. {$pembanding1}\n2. {$pembanding2}");

                $penguji1 = $this->request->getPost('dosen_penguji_1')[$key] ?? '';
                $penguji2 = $this->request->getPost('dosen_penguji_2')[$key] ?? '';
                $dosenPenguji = trim("1. {$penguji1}\n2. {$penguji2}");

                $this->mahasiswaModel->insert([
                    'surat_keluar_id'   => $id,
                    'npm'               => $npm,
                    'nama_mahasiswa'    => $this->request->getPost('nama_mahasiswa')[$key],
                    'perusahaan'        => $this->request->getPost('perusahaan')[$key] ?? null,
                    'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan')[$key] ?? null,
                    'judul'             => $this->request->getPost('judul')[$key] ?? null,
                    'dosen_pembimbing'  => $this->request->getPost('dosen_pembimbing')[$key] ?? null,
                    'waktu_pelaksanaan' => $this->request->getPost('waktu_pelaksanaan')[$key] ?? null,
                    'dosen_pembanding'  => $dosenPembanding ?: null,
                    'dosen_penguji'     => $dosenPenguji ?: null,
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal memperbarui data di database.');
            }

            return redirect()->to(site_url('prodi'))->with('success', 'Surat keluar berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', '[ERROR] ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan internal saat memperbarui data.');
        }
    }

    /**
     * Menghapus data surat dari database.
     */
    public function delete($id = null)
    {
        $this->_findSuratOr404($id);

        if ($this->suratKeluarModel->delete($id)) {
            return redirect()->to(site_url('prodi'))->with('success', 'Surat keluar berhasil dihapus.');
        }

        return redirect()->to(site_url('prodi'))->with('error', 'Gagal menghapus surat keluar.');
    }

    /**
     * Mengekspor detail surat ke format PDF.
     */
    public function exportPdf($id = null)
    {
        $surat = $this->_findSuratOr404($id);
        $mahasiswa = $this->mahasiswaModel->where('surat_keluar_id', $id)->findAll();
        $templateView = 'pdf_templates/' . $surat['tipe_surat'];

        if (!is_file(APPPATH . 'Views/' . $templateView . '.php')) {
            throw new \RuntimeException('Template PDF tidak ditemukan: ' . esc($templateView));
        }

        $data = ['surat' => $surat, 'mahasiswa' => $mahasiswa];
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

    /**
     * Metode privat untuk mencari surat berdasarkan ID atau menampilkan 404.
     */
    private function _findSuratOr404($id)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID Surat tidak disediakan.');
        }
        $surat = $this->suratKeluarModel->where(['id' => $id, 'jenis_surat' => 'prodi'])->first();
        if (!$surat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Surat dengan ID ' . $id . ' tidak ditemukan.');
        }
        return $surat;
    }

    /**
     * Metode privat untuk mendefinisikan aturan validasi.
     */
    private function getValidationRules(): array
    {
        return [
            'nomor_surat'       => 'required|max_length[100]',
            'tanggal_surat'     => 'required|valid_date',
            'perihal'           => 'required|max_length[255]',
            'npm.*'             => 'required|numeric|max_length[20]',
            'nama_mahasiswa.*'  => 'required|string|max_length[255]',
        ];
    }
}
