<!DOCTYPE html>  
<html lang="en">  

<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- Latest compiled and minified CSS -->  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">  
    <title>Login</title>  
    <style>  
        body {  
            background-color: #f8f9fa; /* Change this to your desired background color */  
            height: 100vh;  
            display: flex;  
            justify-content: center;  
            align-items: center;  
        }  

        .container {  
            background: white;  
            border-radius: 10px;  
            padding: 30px;  
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);  
            max-width: 400px;  
            width: 100%;  
        }  

        .text-header {  
            text-align: center;  
            margin-bottom: 20px;  
            font-size: 24px;  
            color: #333;  
        }  

        .input-group-text {  
            background-color: #f5f5f5;  
            border: 1px solid #ced4da;  
        }  

        .form-control {  
            border: 1px solid #ced4da;  
            border-radius: 5px;  
            transition: border-color 0.3s;  
        }  

        .form-control:focus {  
            border-color: #007bff;  
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);  
        }  

        .btn-primary {  
            width: 100%;  
            margin-top: 10px;  
            transition: background-color 0.3s, transform 0.2s;  
        }  

        .btn-primary:hover {  
            background-color: #0056b3;  
            transform: translateY(-2px);  
        }  

        .span-text {  
            color: #666;  
        }  

        .register-link {  
            color: #007bff;  
            text-decoration: none;  
        }  

        .register-link:hover {  
            text-decoration: underline;  
        }  

        .error-message {  
            color: red;  
            text-align: center;  
        }  
    </style>  
</head>  

<body>  
    <div class="container">  
        <h1 class="text-header">SELAMAT DATANG</h1>  

        <form action="/auth/login" method="post">  
            <div class="mb-4 input-group">  
                <span class="input-group-text">  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">  
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />  
                    </svg>  
                </span>  
                <input type="text" name="username" class="form-control" placeholder="Nama Pengguna" required>  
            </div>  
            <div class="mb-5 input-group">  
                <span class="input-group-text">  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">  
                        <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />  
                    </svg>  
                </span>  
                <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>  
            </div>  
            <?php if (session()->getFlashdata('error')): ?>  
                <p class="error-message"><?= session()->getFlashdata('error') ?></p>  
            <?php endif; ?>  
            <button type="submit" class="btn btn-primary">Masuk</button>  
            <div class="mt-3 text-center">  
                <span class="span-text">Belum punya akun?</span>  
                <a href="/pendaftaran" class="register-link">Daftar sekarang</a>  
            </div>  
        </form>  
    </div>  
</body>  

</html>