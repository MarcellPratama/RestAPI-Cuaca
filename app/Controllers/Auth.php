<?php

namespace App\Controllers;

use App\Models\otpModel;
use App\Models\penggunaModel;

class Auth extends BaseController
{
    protected $otpModel;
    protected $penggunaModel;

    public function __construct()
    {
        $this->otpModel = new otpModel();
        $this->penggunaModel = new penggunaModel();
    }

    public function viewLogin(): string
    {
        return view('login');
    }

    public function Login()
    {
        // Ambil data dari form login
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari pengguna berdasarkan username
        $user = $this->penggunaModel->find($username);

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session pengguna
                session()->set('isLoggedIn', true);
                session()->set('username', $user['username']);
                session()->set('nomor', $user['nomor']);

                // Redirect ke dashboard
                return redirect()->to('/home');
            } else {
                // Password salah
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            // Username tidak ditemukan
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }
    }

    public function viewPendaftaran()
    {
        return view('pendaftaran');
    }

    public function requestOtp()
    {
        $data = $this->request->getPost();
        $otp = rand(100000, 999999);

        // Simpan OTP ke database
        $this->otpModel->where('nomor', $data['nomor'])->delete();
        $this->otpModel->insert([
            'nomor' => $data['nomor'],
            'otp'   => $otp,
            'waktu' => time(),
        ]);

        // Kirim OTP
        $message = "*$otp* adalah kode OTP Anda. Demi keamanan jangan bagikan kode ini.";
        $this->sendOtp($data['nomor'], $message);

        // Simpan data sementara untuk proses verifikasi
        session()->set('temp_user', [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'nomor'    => $data['nomor'],
        ]);

        return view('verifikasi');
    }

    public function verifyOtp()
    {
        $otp = $this->request->getPost('otp');
        $tempUser = session()->get('temp_user');

        $otpData = $this->otpModel->where([
            'nomor' => $tempUser['nomor'],
            'otp'   => $otp,
        ])->first();

        if ($otpData && (time() - $otpData['waktu']) <= 30) {
            // Simpan pengguna
            $this->penggunaModel->insert($tempUser);

            // Hapus sesi sementara
            session()->remove('temp_user');

            return redirect()->to('/login');
        }

        // Set pesan kesalahan
        session()->setFlashdata('error', 'OTP tidak valid atau sudah kadaluarsa.');
        return redirect()->to('/verifikasi');
    }

    public function resendOtp()
    {
        $tempUser = session()->get('temp_user');

        if (!$tempUser) {
            // Jika tidak ada data sementara, arahkan kembali ke pendaftaran
            return redirect()->to('/pendaftaran')->with('error', 'Silakan daftar ulang.');
        }

        $otp = rand(100000, 999999);

        // Hapus OTP lama dan simpan OTP baru
        $this->otpModel->where('nomor', $tempUser['nomor'])->delete();
        $this->otpModel->insert([
            'nomor' => $tempUser['nomor'],
            'otp'   => $otp,
            'waktu' => time(),
        ]);

        // Kirim OTP baru
        $message = "*$otp* adalah kode OTP Anda. Demi keamanan jangan bagikan kode ini.";
        $this->sendOtp($tempUser['nomor'], $message);

        // Redirect ke halaman verifikasi
        return redirect()->to('/verifikasi');
    }

    public function sendOtp($nomor, $message)
    {
        $data = ['target' => $nomor, 'message' => $message];
        $ch = curl_init('https://api.fonnte.com/send');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: E8QFC9dgUXvKnXzbjsYA"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function viewVerifikasi()
    {
        // Tampilkan halaman verifikasi
        return view('verifikasi'); // Pastikan view ini sesuai dengan nama file Anda
    }

    public function Logout()
    {
        // Hapus semua data sesi
        session()->destroy();

        return view('login');
    }
}
