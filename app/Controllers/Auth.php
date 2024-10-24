<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function Login(): string
    {
        return view('login');
    }

    public function Register(): string
    {
        return view('pendaftaran');
    }
}
