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
      $('#cariKode').on('submit', function(e) {
        $("#spinner, #overlay").show();

        e.preventDefault();

        var wilayah = $('#wilayah').val();

        if (!wilayah) {
          $('#hasil').text('Nama wilayah tidak boleh kosong.');
          return;
        }

        $.ajax({
          url: '\cariKode',
          type: 'POST',
          data: {
            wilayah: wilayah
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);

            $.ajax({
              url: 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' + response.message,
              type: 'GET',
              dataType: 'json',
              success: function(response) {
                console.log(response);
                var location = response.lokasi.desa;
                var weatherData = response.data[0].cuaca[0][0];

                console.log(weatherData);
                $('#Daerah').text(location);
                $('#suhu').html(weatherData.t + '&deg;');
                $('#iconUtama').html('<img src="' + weatherData.image + '" alt="Cuaca" class="img-fluid">');
                $('#temp').html(weatherData.t + '&deg;');
                $('#kelembapan').html(weatherData.hu + '%');
                $('#kecAngin').html(weatherData.ws + ' Km/jam');
                $('#jarak').html(weatherData.vs_text);

                // memasukan data prediksi per 3 jam
                var forecastContainer = $('#forecast-container');
                forecastContainer.empty();

                console.log(weatherData.local_datetime.split(' ')[0]);
                var today = new Date().toISOString().split('T')[0];


                for (let index = 0; index < response.data[0].cuaca[0].length; index++) {
                  if (response.data[0].cuaca[0][index].local_datetime.split(' ')[0] === today) {
                    console.log(index);
                    var waktu = response.data[0].cuaca[0][index].local_datetime.split(' ')[1];
                    var forecastElement = `
                      <div class="forecast-day text-center mx-2">
                        <div>${waktu.split(':').slice(0,2).join(':')}</div>
                        <div class="icon text-warning">
                          <img src="${response.data[0].cuaca[0][index].image}" alt="Cuaca" style="width: 24px;">
                        </div>
                        <div>${response.data[0].cuaca[0][index].t}&deg;</div>
                      </div>
                      <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5;"></div>
                    `;
                    forecastContainer.append(forecastElement);
                  }
                }
                forecastContainer.find('.border-start:last').remove();

                // masukan data ke prediksi 3 hari 

                var ramalanContainer = $('#ramalan');
                ramalanContainer.empty();

                console.log(response.data[0].cuaca.length);

                for (let index = 1; index < response.data[0].cuaca.length; index++) {
                  // console.log(index);
                  var dataRamalan = response.data[0].cuaca[index][0];
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


              },
              complete: function() {
                $("#spinner, #overlay").hide();
                $('#wilayah').val(' ')

              },
              error: function(xhr, status, error) {
                console.error("API Error: " + error);
              }
            });
          },
        });

      });

    });



    $(document).ready(function() {
      var kodeWilayah = '34.04.07.2002';

      $.ajax({
        url: 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' + kodeWilayah,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          console.log(response);
          var location = response.lokasi.desa;
          var weatherData = response.data[0].cuaca[0][0];

          console.log(weatherData);

          // data pertama di masukan
          $('#Daerah').text(location);
          $('#suhu').html(weatherData.t + '&deg;');
          $('#iconUtama').html('<img src="' + weatherData.image + '" alt="Cuaca" class="img-fluid">');
          $('#temp').html(weatherData.t + '&deg;');
          $('#kelembapan').html(weatherData.hu + '%');
          $('#kecAngin').html(weatherData.ws + ' Km/jam');
          $('#jarak').html(weatherData.vs_text);

          // memasukan data prediksi per 3 jam
          var forecastContainer = $('#forecast-container');
          forecastContainer.empty();

          console.log(weatherData.local_datetime.split(' ')[0]);
          var today = new Date().toISOString().split('T')[0];


          for (let index = 0; index < response.data[0].cuaca[0].length; index++) {
            if (response.data[0].cuaca[0][index].local_datetime.split(' ')[0] === today) {
              // console.log(index);
              var waktu = response.data[0].cuaca[0][index].local_datetime.split(' ')[1];
              var forecastElement = `
                <div class="forecast-day text-center mx-2">
                  <div>${waktu.split(':').slice(0,2).join(':')}</div>
                  <div class="icon text-warning">
                    <img src="${response.data[0].cuaca[0][index].image}" alt="Cuaca" style="width: 24px;">
                  </div>
                  <div>${response.data[0].cuaca[0][index].t}&deg;</div>
                </div>
                <div class="border-start border-white" style="height: 80px; width: 2px; opacity: 0.5;"></div>
              `;
              forecastContainer.append(forecastElement);
            }
          }
          forecastContainer.find('.border-start:last').remove();


          // masukan data ke prediksi 3 hari 

          var ramalanContainer = $('#ramalan');
          ramalanContainer.empty();

          console.log(response.data[0].cuaca.length);

          for (let index = 1; index < response.data[0].cuaca.length; index++) {
            // console.log(index);
            var dataRamalan = response.data[0].cuaca[index][0];
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
        },
        error: function(xhr, status, error) {
          console.error("API Error: " + error);
        }
      });
    });
  </script>


</body>


</html>