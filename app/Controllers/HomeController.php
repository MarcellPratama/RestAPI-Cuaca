<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $kodeWilayah = session()->get('kode_wilayah');

        return view('home', ['kodeWilayah' => $kodeWilayah]);
    }
}
