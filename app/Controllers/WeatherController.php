<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class WeatherController extends BaseController
{
    public function cariKodeWilayah()
    {
        $wilayahInput = strtolower(trim($this->request->getPost('wilayah')));

        if (empty($wilayahInput)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Nama wilayah tidak boleh kosong.'
            ]);
        }

        $csvFile = ROOTPATH . 'public/fileKodeWilayah/base.csv';

        if (!file_exists($csvFile)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File CSV tidak ditemukan.'
            ]);
        }

        $handle = fopen($csvFile, "r");
        if ($handle === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal membaca file CSV.'
            ]);
        }

        $result = "Wilayah tidak ditemukan.";
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $kodeWilayah = $data[0];
            $namaWilayah = strtolower($data[1]);

            if ($namaWilayah === $wilayahInput) {
                $result = $kodeWilayah;
                break;
            }
        }
        fclose($handle);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => $result
        ]);
    }
    public function getWeatherByKodeWilayah($kodeWilayah)
    {
        $apiUrl = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=" . $kodeWilayah;

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->get($apiUrl);
            $data = json_decode($response->getBody(), true);

            if (isset($data['lokasi']) && isset($data['data'])) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $data
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data cuaca tidak ditemukan.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal Connect API BMKG: ' . $e->getMessage()
            ]);
        }
    }
}
