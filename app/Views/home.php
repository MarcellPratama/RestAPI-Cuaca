<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #3f87a2, #2c3e50);
      color: white;
      height: 100vh;
      overflow: hidden;
      margin: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .container {
      max-height: 100%;
    }

    .card {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .card-header {
      background: rgba(255, 255, 255, 0.2);
      border-bottom: none;
      border-radius: 15px 15px 0 0;
    }

    #wilayah {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 10px 15px;
    }

    #search {
      background-color: #00aaff;
      border: none;
      border-radius: 10px;
    }

    #search:hover {
      background-color: #008ecc;
    }

    .forecast-day img {
      max-width: 50px;
      margin: 5px 0;
    }

    .location {
      font-size: 2.5rem;
      font-weight: 700;
    }

    .temperature {
      font-size: 3rem;
      font-weight: 500;
    }

    .icon-large {
      font-size: 3rem;
    }

    .card .text-start {
      font-size: 0.9rem;
    }

    #notificationBell {
      cursor: pointer;
      position: relative;
    }

    #notificationBell.active i {
      color: #ff5733;
    }

    #notificationBell.active::after {
      content: "";
      position: absolute;
      top: -5px;
      right: -5px;
      width: 10px;
      height: 10px;
      background-color: red;
      border-radius: 50%;
    }

    .modal-header,
    .modal-body {
      background: rgba(255, 255, 255, 0.1);
    }

    .modal-footer .btn-primary {
      background-color: #00aaff;
      border: none;
    }

    footer {
      margin-top: 10px;
      text-align: center;
      font-size: 0.8rem;
    }
  </style>
</head>

<body>
  <div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <form action="" class="d-flex w-75 gap-3" id="cariKode">
        <input type="text" class="form-control shadow" placeholder="Cari Wilayah" id="wilayah">
        <button class="btn btn-primary shadow" type="submit" id="search">
          <i class="bi bi-search"></i>
        </button>
      </form>
      <div>
        <span>Selamat Datang, <?= session()->get('username'); ?>!</span>
        <span class="mx-3" id="notificationBell">
          <i class="bi bi-bell"></i>
        </span>
        <span><a href="/logout" class="text-light"><i class="bi bi-box-arrow-right"></i></a></span>
      </div>
    </div>

    <div class="row g-3">
      <!-- Weather Overview -->
      <div class="col-lg-8">
        <div class="card p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h1 id="Daerah" class="location">Yogyakarta</h1>
              <div id="suhu" class="temperature">38&deg;</div>
            </div>
            <div id="iconUtama" class="icon-large text-warning">&#9728;</div>
          </div>
        </div>

        <!-- Forecast -->
        <div class="card mt-3">
          <div class="card-body">
            <div class="forecast-wrapper d-flex gap-3">
              <div id="forecast-container" class="forecast"></div>
            </div>
          </div>
        </div>

        <!-- Weather Details -->
        <div class="card mt-3">
          <div class="card-body">
            <div class="row text-center text-light">
              <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-thermometer" style="font-size: 1.5rem; margin-right: 8px;"></i>
                <div class="text-start">
                  <div>Suhu</div>
                  <div id="temp" class="fw-bold" style="font-size: 1.5rem;">38&deg;</div>
                </div>
              </div>
              <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-wind" style="font-size: 1.5rem; margin-right: 8px;"></i>
                <div class="text-start">
                  <div>Angin</div>
                  <div id="kecAngin" class="fw-bold" style="font-size: 1.5rem;">0.2 Km/jam</div>
                </div>
              </div>
              <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-droplet" style="font-size: 1.5rem; margin-right: 8px;"></i>
                <div class="text-start">
                  <div>Kelembapan</div>
                  <div id="kelembapan" class="fw-bold" style="font-size: 1.5rem;">10%</div>
                </div>
              </div>
              <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-eye" style="font-size: 1.5rem; margin-right: 8px;"></i>
                <div class="text-start">
                  <div>Jarak Pandang</div>
                  <div id="jarak" class="fw-bold" style="font-size: 1.5rem;">5 M</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 3-Day Forecast -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header text-center">
            <h5>Ramalan Cuaca 3 Hari</h5>
          </div>
          <div class="card-body">
            <div id="ramalan" class="d-flex flex-column gap-3"></div>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <small>Sumber Data diperoleh dari Badan Meteorologi, Klimatologi dan Geofisika</small>
    </footer>
  </div>
</body>




<!-- Ubah tampilannya -->



  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script>
    $(document).ready(function() {
      var kodeWilayah = '34.04.07.2002';
      var isNotificationActive = false; // Status notifikasi (aktif atau nonaktif)

      // Event listener untuk klik pada ikon lonceng
      $('#notificationBell').click(function() {
        // Toggle status notifikasi
        isNotificationActive = !isNotificationActive;

        // Ubah kelas untuk menampilkan status aktif/nonaktif
        $(this).toggleClass('active');

        // Tampilkan pesan di konsol
        if (isNotificationActive) {
          console.log("Notifikasi diaktifkan.");
          kirimCuaca();
        } else {
          console.log("Notifikasi dimatikan.");
        }
      });

      function kirimCuaca() {
        $.ajax({
          url: 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' + kodeWilayah,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            var location = response.lokasi.desa;
            var weatherData = response.data[0].cuaca[0][0];

            // format pesan cuaca
            var message = `Cuaca Hari Ini di ${location}:\n`;
            message += `Suhu: ${weatherData.t}°\n`;
            message += `Kelembapan: ${weatherData.hu}%\n`;
            message += `Kecepatan Angin: ${weatherData.ws} km/jam\n`;
            message += `Deskripsi Cuaca: ${weatherData.weather_desc}\n`;
            message += `Visibilitas: ${weatherData.vs_text}\n\n`;

            // Prediksi per 3 jam
            message += "Prediksi Cuaca Per 3 Jam:\n";
            var forecastData = response.data[0].cuaca[0];
            for (let index = 0; index < forecastData.length; index++) {
              var waktu = forecastData[index].local_datetime.split(' ')[1];
              message += `${waktu.split(':').slice(0, 2).join(':')} - ${forecastData[index].t}°\n`;
            }

            // Prediksi 3 Hari
            message += "\nRamalan Cuaca 3 Hari Ke Depan:\n";
            var ramalanData = response.data[0].cuaca;
            for (let index = 1; index < ramalanData.length; index++) {
              var dataRamalan = ramalanData[index][0];
              var hari = new Date(dataRamalan.local_datetime.split(' ')[0]).toLocaleDateString('id-ID', {
                weekday: 'long'
              });
              message += `${hari}: ${dataRamalan.weather_desc}\n`;
            }

            // Ambil nomor dari session dan kirim notifikasi
            var nomorPengguna = '<?= session()->get('nomor'); ?>';
            console.log(nomorPengguna); // Mengambil nomor pengguna dari session PHP
            sendWeatherNotification(nomorPengguna, message); // Kirim pesan ke nomor pengguna
          },
          error: function(xhr, status, error) {
            console.error("API Error: " + error);
          }
        });
      }

      function sendWeatherNotification(nomor, message) {
        $.ajax({
          url: 'https://api.fonnte.com/send',
          type: 'POST',
          data: {
            target: nomor,
            message: message,
            countryCode: '62' // Kode negara untuk Indonesia
          },
          headers: {
            'Authorization': 'bmvrY2R33YNkp3MKWwrM' // Ganti dengan token API Anda
          },
          success: function(response) {
            console.log("Pesan terkirim:", response);
          },
          error: function(xhr, status, error) {
            console.error("Error mengirim pesan:", error);
          }
        });
      }
    });

    $(document).ready(function() {
      var defaultKodeWilayah = '34.04.07.2002';

      function fetchWeatherData(kodeWilayah) {
        $("#spinner, #overlay").show();

        $.ajax({
          url: '/api/cuaca/' + kodeWilayah,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              var data = response.data;
              var location = data.lokasi.desa;
              var weatherData = data.data[0].cuaca[0][0];

              $('#Daerah').text(location);
              $('#suhu').html(weatherData.t + '&deg;');
              $('#iconUtama').html('<img src="' + weatherData.image + '" alt="Cuaca" class="img-fluid">');
              $('#temp').html(weatherData.t + '&deg;');
              $('#kelembapan').html(weatherData.hu + '%');
              $('#kecAngin').html(weatherData.ws + ' Km/jam');
              $('#jarak').html(weatherData.vs_text);
              var forecastContainer = $('#forecast-container');
              forecastContainer.empty();
              var today = new Date().toISOString().split('T')[0];

              data.data[0].cuaca[0].forEach(function(item) {
                if (item.local_datetime.split(' ')[0] === today) {
                  var waktu = item.local_datetime.split(' ')[1];
                  var forecastElement = `
                <div class="forecast-day text-center mx-2">
                  <div>${waktu.split(':').slice(0, 2).join(':')}</div>
                  <div class="icon text-warning">
                    <img src="${item.image}" alt="Cuaca" style="width: 24px;">
                  </div>
                  <div>${item.t}&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5;"></div>
              `;
                  forecastContainer.append(forecastElement);
                }
              });
              forecastContainer.find('.border-start:last').remove();

              var ramalanContainer = $('#ramalan');
              ramalanContainer.empty();

              for (let i = 1; i < data.data[0].cuaca.length; i++) {
                var dataRamalan = data.data[0].cuaca[i][0];
                var hari = new Date(dataRamalan.local_datetime.split(' ')[0]).toLocaleDateString('id-ID', {
                  weekday: 'long'
                });

                var ramalanHTML = `
              <div class="row">
                <div class="d-flex justify-content-center align-items-center gap-3">
                  <div>${hari}</div>
                  <div class="icon text-warning">
                    <img src="${dataRamalan.image}" alt="Cuaca" style="width: 100px;">
                  </div>
                  <div>${dataRamalan.weather_desc}</div>
                </div>
              </div>
              <div class="border-top border-white my-2" style="height: 2px;"></div>
            `;
                ramalanContainer.append(ramalanHTML);
              }
              ramalanContainer.find('.border-top:last').remove();
            } else {
              $('#hasil').text('Data cuaca tidak ditemukan.');
            }
          },
          error: function() {
            $('#hasil').text('Gagal mengambil data cuaca.');
          },
          complete: function() {
            $("#spinner, #overlay").hide();
          }
        });
      }

      fetchWeatherData(defaultKodeWilayah);

      $('#cariKode').on('submit', function(e) {
        e.preventDefault();

        var wilayah = $('#wilayah').val().trim();

        if (!wilayah) {
          $('#hasil').text('Nama wilayah tidak boleh kosong.');
          return;
        }

        $.ajax({
          url: '/api/cariKode',
          type: 'POST',
          data: {
            wilayah: wilayah
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              var kodeWilayah = response.message;
              fetchWeatherData(kodeWilayah);
            } else {
              $('#hasil').text(response.message);
            }
          },
          error: function() {
            $('#hasil').text('Gagal mencari kode wilayah.');
          }
        });
      });
    });
  </script>


</body>


</html>