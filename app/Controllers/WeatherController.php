<?php

namespace App\Controllers;
use CodeIgniter\HTTP\Client;

class WeatherController extends BaseController{
    public function getWeatherData($kode_wilayah_tingkat_iv)
    {
        $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$kode_wilayah_tingkat_iv}";
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url);
        $data = json_decode($response->getBody(), true);
        return view('weather_view', ['weatherData' => $data]);
    }
}