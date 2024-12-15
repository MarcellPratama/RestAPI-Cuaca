<?php

namespace App\Models;

use CodeIgniter\Model;

class WeatherModel extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'kode_wilayah';
    protected $allowedFields = ['nama_wilayah', 'kode_wilayah'];

    public function getKodeWilayah($wilayah)
    {
        return $this->where('nama_wilayah', $wilayah)->first()['kode_wilayah'] ?? null;
    }

    public function getWeatherData($kodeWilayah)
    {
        $apiUrl = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$kodeWilayah}";
        $client = \Config\Services::curlrequest();
        $response = $client->get($apiUrl);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        } else {
            return ['message' => 'Error fetching data from BMKG API'];
        }
    }
}
