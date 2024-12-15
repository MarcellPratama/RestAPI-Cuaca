<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CURLRequest;

class WeatherNotification extends Controller
{
    public function index()
    {
        $kodeWilayah = '34.04.07.2002';
        $nomorPengguna = session()->get('nomor'); // Ambil nomor pengguna dari sesi

        if (!$nomorPengguna) {
            return json_encode(['status' => 'error', 'message' => 'Nomor pengguna tidak ditemukan']);
        }

        $bmkgUrl = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=" . $kodeWilayah;
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get($bmkgUrl);
            $weatherData = json_decode($response->getBody(), true);

            if (!$weatherData || !isset($weatherData['data'][0]['cuaca'])) {
                return json_encode(['status' => 'error', 'message' => 'Data cuaca tidak ditemukan']);
            }

            $location = $weatherData['lokasi']['desa'];
            $cuacaSekarang = $weatherData['data'][0]['cuaca'][0][0];

            // Format pesan cuaca
            $message = "Cuaca Hari Ini di $location:\n";
            $message .= "Suhu: {$cuacaSekarang['t']}°\n";
            $message .= "Kelembapan: {$cuacaSekarang['hu']}%\n";
            $message .= "Kecepatan Angin: {$cuacaSekarang['ws']} km/jam\n";
            $message .= "Deskripsi Cuaca: {$cuacaSekarang['weather_desc']}\n";
            $message .= "Visibilitas: {$cuacaSekarang['vs_text']}\n\n";

            // Prediksi per 3 jam
            $message .= "Prediksi Cuaca Per 3 Jam:\n";
            foreach ($weatherData['data'][0]['cuaca'][0] as $index => $forecast) {
                $waktu = explode(' ', $forecast['local_datetime'])[1];
                $jam = implode(':', array_slice(explode(':', $waktu), 0, 2));
                $message .= "$jam - {$forecast['t']}°\n";
            }

            // Prediksi 3 hari
            $message .= "\nRamalan Cuaca 3 Hari Ke Depan:\n";
            foreach (array_slice($weatherData['data'][0]['cuaca'], 1) as $ramalan) {
                $hari = date('l', strtotime($ramalan[0]['local_datetime']));
                $message .= "$hari: {$ramalan[0]['weather_desc']}\n";
            }

            // Kirim notifikasi
            $this->sendWeatherNotification($nomorPengguna, $message);

            return json_encode(['status' => 'success', 'message' => 'Pesan cuaca berhasil dikirim']);
        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function sendWeatherNotification($nomor, $message)
    {
        $fonnteUrl = 'https://api.fonnte.com/send';
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->post($fonnteUrl, [
                'headers' => [
                    'Authorization' => 'bmvrY2R33YNkp3MKWwrM' // Ganti dengan token API Anda
                ],
                'form_params' => [
                    'target' => $nomor,
                    'message' => $message,
                    'countryCode' => '62' // Kode negara untuk Indonesia
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['status']) && $result['status'] == 'success') {
                log_message('info', 'Pesan terkirim: ' . json_encode($result));
            } else {
                log_message('error', 'Gagal mengirim pesan: ' . json_encode($result));
            }
        } catch (\Exception $e) {
            log_message('error', 'Error mengirim pesan: ' . $e->getMessage());
        }
    }

    // Di controller
    public function updateNotificationStatus()
    {
        $status = $this->request->getPost('status');
        session()->set('notifikasiAktif', $status);
        return json_encode(['status' => 'success']);
    }
}
