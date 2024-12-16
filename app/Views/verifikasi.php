<!DOCTYPE html>  
<html lang="en">  

<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- Latest compiled and minified CSS -->  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="<?= base_url('css/verifikasi.css') ?>">  
    <title>Verifikasi</title>
</head>  

<body>  
    <div class="container">  
        <img src="<?= base_url('images/verifikasi.png') ?>" alt="Verifikasi" class="img-fluid mb-3">  
        <h1 class="text-header">VERIFIKASI</h1>  
        <p class="span-text2">Anda mendapatkan OTP melalui WhatsApp</p>  

        <?php if (session()->getFlashdata('error')): ?>  
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>  
        <?php endif; ?>  
        
        <form method="post" action="/verify-otp">  
            <?= csrf_field() ?>  
            <div class="d-flex justify-content-center">  
                <input type="password" class="form-control mt-5 mb-4" name="otp" placeholder="Kode OTP" required>  
            </div>  
            <button type="submit" class="btn btn-primary">Verifikasi</button>  
            <div class="mt-3">  
                <span class="span-text">Tidak menerima OTP verifikasi?</span>  
                <a id="resend-link" href="/resend-otp" class="resend-link" style="pointer-events: none;">Kirim ulang lagi dalam <span id="timer">30</span> detik</a>  
            </div>  
        </form>  
    </div>  

    <script>  
        // Hitung mundur timer  
        let countdown = 30; // Detik  
        const timerElement = document.getElementById('timer');  
        const resendLink = document.getElementById('resend-link');  

        const interval = setInterval(() => {  
            countdown--;  
            timerElement.textContent = countdown;  

            // Aktifkan link jika timer selesai  
            if (countdown <= 0) {  
                clearInterval(interval);  
                resendLink.style.pointerEvents = 'auto';  
                resendLink.style.color = 'blue';  
                resendLink.textContent = 'Kirim ulang lagi';  
            }  
        }, 1000);  
    </script>  
</body>  
</html>