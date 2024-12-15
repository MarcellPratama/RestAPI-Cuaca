<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('css/HomeStyl.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    #spinner {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      z-index: 9999;
    }

    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9998;
    }

    .forecast-day {
      padding: 10px;
      min-width: 80px;
      text-align: center;
    }

    .forecast-wrapper {
      overflow-x: auto;
      white-space: nowrap;
    }

    .forecast-day img {
      max-width: 40px;
    }

    #notificationBell {
      z-index: 1061;
      /* pastikan lebih tinggi dari modal atau overlay */
    }

    #notificationBell {
      position: relative;
    }

    #notificationBell.active i {
      color: #ff5733;
      /* Warna untuk menunjukkan notifikasi aktif */
    }

    #notificationBell i {
      font-size: 1.5rem;
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

    .modal-backdrop {
      z-index: 1050;
    }

    .modal {
      z-index: 1060;
    }

    .modal-body {
      color: #4CAF50;
    }

    .alert {
      color: #fff;
      /* Warna teks putih */
      background-color: #28a745;
      /* Latar belakang hijau */
    }
  </style>

</head>



<body>
  <div id="overlay"></div>

  <div id="spinner" class="spinner-border" role="status">
    <span class="sr-only"></span>
  </div>

  <div class="my-2 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <form action="" class="d-flex w-75 gap-3 " id="cariKode">
        <input type="text" class="form-control shadow " placeholder="Cari Wilayah" id="wilayah" style="background-color: #3f87a2; color: white; opacity: 0.7; border-style: none; ">
        <button class="btn btn-primary rounded bi bi-search shadow" type="submit" id="search"></button>
      </form>

      <div>
        <span>Selamat Datang, <?= session()->get('username'); ?>!</span>
        <span class="mx-3" id="notificationBell" style="cursor: pointer;">
          <i class="bi bi-bell" id="bellIcon"></i> <!-- Ikon lonceng -->
        </span>

        <span><a href="/logout"><i class="bi bi-box-arrow-right"></i></a></span>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="notificationModalLabel">Konfirmasi Notifikasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="modalText" class="text-dark">
            Apakah Anda ingin menerima notifikasi cuaca setiap hari melalui WhatsApp?
            Centang untuk YA dan Kosongkan untuk TIDAK
          </div>
          <div class="mb-3">
            <!-- Toggle Switch untuk Menyalakan/Mematikan Notifikasi -->
            <label for="notificationToggle" class="form-label">Aktifkan Notifikasi</label>
            <input type="checkbox" class="form-check-input" id="notificationToggle">
            <small class="form-text text-muted">Centang / Kosongkan</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" id="confirmNotification">Konfirmasi</button>
          </div>
        </div>
      </div>
    </div>



    <div class="row mt-3">
      <div class="col-8">
        <div class="row" style="margin-left: -100px;">
          <div class="col d-flex justify-content-around">
            <div class="row d-flex flex-column">
              <h1 id="Daerah" class="location" style="font-size: 3rem;">Yogyakarta</h1>
              <div id="suhu" class="temperature">38&deg;</div>
            </div>
            <div class="row">
              <div id="iconUtama" class=" p-0 icon-large text-warning">&#9728;</div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="card shadow">
            <div class="card-body">
              <div class="forecast-wrapper" style="overflow-x: auto; white-space: nowrap;">
                <div id="forecast-container" class="forecast d-inline-flex"></div>
              </div>
            </div>
          </div>
        </div>


        <div class="row text-center my-4">
          <div class="card shadow" style=" border-radius: 20px;">
            <div class="card-body">
              <div class="row text-white">
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
      </div>


      <div class="col-4">
        <div class="card shadow">
          <div class="card-header text-center text-light">
            <h5>Ramalan cuaca 3 hari ke depan</h5>
          </div>
          <div class="card-body text-light">
            <div id="ramalan" class="col d-flex flex-column gap-3 justify-content-around">
            </div>
          </div>
        </div>
      </div>

    </div>


    <div class="text-center mt-3">
      <small>Sumber Data diperoleh dari Badan Meteorologi, Klimatologi dan Geofisika</small>
    </div>
  </div>

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
            var nomorPengguna = '<?= session()->get('nomor'); ?>'; // Mengambil nomor pengguna dari session PHP
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