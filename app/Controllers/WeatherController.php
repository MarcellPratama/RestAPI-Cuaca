<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Client;

class WeatherController extends BaseController
{
    public function cariKodeWilayah()
    {
        $wilayahInput = strtolower(trim($this->request->getPost('wilayah')));

        if (empty($wilayahInput)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama wilayah tidak boleh kosong.']);
        }
        $csvFile = ROOTPATH . 'public/fileKodeWilayah/base.csv';

        if (!file_exists($csvFile)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File CSV tidak ditemukan.']);
        }
        $handle = fopen($csvFile, "r");
        if ($handle === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal membaca file CSV.']);
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
        return $this->response->setJSON(['status' => 'success', 'message' => $result]);
    }
}
