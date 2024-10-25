<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('css/verifikasi.css') ?>">
    <title>Verifikasi</title>
</head>

<body>
    <div class="container">
        <img src="<?= base_url('images/verifikasi.png') ?>">
        <h1 class="text-header">VERIFIKASI</h1>
        <p class="span-text2">Anda mendapatkan OTP melalui WhatsApp</p>

        <form action="">
            <div class="d-flex justify-content-center">
                <input type="password" class="form-control mt-5 mb-4" placeholder="Kode OTP" required>
            </div>
            <button type="submit" class="btn btn-primary">Verifikasi</button>
            <div class="mt-3">
                <span class="span-text">Tidak menerima OTP verifikasi?</span>
                <a href="#" class="resend-link">Kirim ulang lagi</a>
            </div>
        </form>
    </div>
</body>

</html>