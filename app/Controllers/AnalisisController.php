<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\CURLRequest; // Import CURLRequest

class AnalisisController extends BaseController
{
    public function index()
    {
        return view('analisis/index', ['active_menu' => 'analisis']);
    }

    public function performAnalysis()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Akses tidak diizinkan.']);
        }

        $pythonApiUrl = 'http://localhost:5000/analyze-sleep-data'; // URL API Flask Anda

        // Menggunakan CodeIgniter's CURLRequest untuk mengirim permintaan HTTP
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->post($pythonApiUrl, [
                'json' => [], // Kirim body kosong atau data yang diperlukan oleh API Anda
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'timeout' => 60 // Timeout 60 detik untuk analisis
            ]);

            // Periksa status kode respons dari API Python
            if ($response->getStatusCode() === 200) {
                $analysisResult = json_decode($response->getBody(), true);

                // Pastikan JSON valid dan status sukses
                if (json_last_error() === JSON_ERROR_NONE && isset($analysisResult['status']) && $analysisResult['status'] === 'success') {
                    return $this->response->setJSON($analysisResult);
                } else {
                    // Jika respons API tidak valid atau status bukan 'success'
                    return $this->response->setStatusCode(500)->setJSON([
                        'message' => 'Respons dari API Python tidak valid atau analisis gagal.',
                        'raw_response' => $response->getBody() // Untuk debugging
                    ]);
                }
            } else {
                // Jika API Python mengembalikan status error (misal 400, 500)
                $errorBody = json_decode($response->getBody(), true);
                $errorMessage = $errorBody['message'] ?? 'Terjadi kesalahan pada API Python.';
                return $this->response->setStatusCode($response->getStatusCode())->setJSON([
                    'message' => 'Gagal terhubung ke API Python: ' . $errorMessage,
                    'raw_response' => $response->getBody() // Untuk debugging
                ]);
            }
        } catch (\Exception $e) {
            // Tangani error jaringan atau timeout
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Terjadi kesalahan saat memanggil API Python: ' . $e->getMessage()]);
        }
    }
}
