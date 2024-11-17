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

</head>

<body>

  <div class="my-2 px-4">
    <div class="d-flex justify-content-between align-items-center">
      <input type="text" class="form-control w-75 shadow" placeholder="Cari Wilayah" style="background-color: #3f87a2; color: white; opacity: 0.7; border-style: none; ">
      <div>
        <span>Welcome, Anselmus Erik!</span>
        <span class="mx-3"><i class="bi bi-bell"></i></span>
        <span><i class="bi bi-box-arrow-right"></i></span>
      </div>
    </div>


    <div class="row mt-3">
      <div class="col-8">
        <div class="row" style="margin-left: -100px;">
          <div class="col d-flex justify-content-around">
            <div class="row d-flex flex-column">
              <h1 id="Daerah" class="location">Yogyakarta</h1>
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
              <div class="forecast">
                <div class="forecast-day">
                  <div>00:00 AM</div>
                  <div class="icon text-warning">&#9728;</div>
                  <div>27&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5; "></div>
                <div class="forecast-day">
                  <div>03:00 AM</div>
                  <div class="icon text-warning">&#9728;</div>
                  <div>29&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5; "></div>
                <div class="forecast-day">
                  <div>06:00 AM</div>
                  <div class="icon text-primary">&#9889;</div>
                  <div>21&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5; "></div>
                <div class="forecast-day">
                  <div>09:00 AM</div>
                  <div class="icon text-primary">&#9729;</div>
                  <div>23&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5; "></div>
                <div class="forecast-day">
                  <div>12:00 PM</div>
                  <div class="icon text-warning">&#9728;</div>
                  <div>33&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5; "></div>
                <div class="forecast-day">
                  <div>03:00 PM</div>
                  <div class="icon text-warning">&#9728;</div>
                  <div>28&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5; "></div>
                <div class="forecast-day">
                  <div>06:00 PM</div>
                  <div class="icon text-primary">&#9729;</div>
                  <div>24&deg;</div>
                </div>
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
            <div id="forecast" class="col d-flex flex-column gap-3 justify-content-around">
              <div class="row ">
                <div class="d-flex justify-content-center align-items-center gap-3">
                  <div>Selasa</div>
                  <div class="icon text-warning" id="icon-ramalan">&#9728;</div>
                  <div>Cerah</div>
                </div>
              </div>
              <div class="border-top border-white my-2" style="height: 2px;"></div>
              <div class="row">
                <div class="d-flex justify-content-center align-items-center gap-3">
                  <div>Rabu</div>
                  <div class="icon text-primary" id="icon-ramalan">&#9729;</div>
                  <div>Hujan</div>
                </div>
              </div>
              <div class="border-top border-white my-2" style="height: 2px;"></div>

              <div class="row">
                <div class="d-flex justify-content-center align-items-center gap-3">
                  <div>Kamis</div>
                  <div class="icon text-dark" id="icon-ramalan">&#9928;</div>
                  <div>Hujan Badai</div>
                </div>
              </div>
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
      var kodeWilayah = '33.03.05.1006';

      $.ajax({
        url: 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' + kodeWilayah,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          console.log(response);
          var location = response.lokasi.desa;
          var weatherData = response.data;

          console.log(weatherData);
          $('#Daerah').text(location);
          $('#suhu').html(weatherData.cuaca[0][0].t + '&deg;');
          $('#iconUtama').html('<img src="' + weatherData.current.icon + '" alt="Cuaca" class="img-fluid">');
          $('#temp').html(weatherData.current.temp + '&deg;');
          $('#kelembapan').html(weatherData.current.hu + '%');
          $('#kecAngin').html(weatherData.current.ws + ' Km/jam');
          $('#jarak').html(weatherData.current.vs_text);
          

        },
        error: function(xhr, status, error) {
          console.error("API Error: " + error);
        }
      });
    });
  </script>


</body>


</html>