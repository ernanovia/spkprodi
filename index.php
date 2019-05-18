
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <script src="js/jquery.min.js"></script>
    <link href="css/half-slider.css" rel="stylesheet">
    <title>Bootstrap4</title>
    <style>
      .screen2{
        background-image: url('images/bg-tanya.png');
      }
    </style>
  </head>
  <body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container">
        <a class="navbar-brand text-uin" href="#">
        <img src="images/uin.png" height="45px">  Uji Sensitifitas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto teks-navbar">
            <li class="nav-item active">
              <a class="nav-link text-uin" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-uin" href="data-prodi.php">Data prodi</a> 
            </li>
            <li class="nav-item">
              <a class="nav-link text-uin" href="data-kriteria.php">Data kriteria</a>
            </li>
            <li class="nav-item">
            <a class="nav-link text-uin" href="metode.php">Perhitungan Metode</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-uin" href="tentang.php">Tentang</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" style="background-image: url('images/uin5.jpg')">
            <div class="carousel-caption d-none d-md-block text-uin ">
              <h4 ><b>Analisi Sensitifitas metode SAW TOPSIS dan SAW-TOPSIS</b></h4>
              <h5>untuk pemilihan prodi terbaik di UIN Sunan Kalijaga</h5>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('images/uin3.png')">
            <div class="carousel-caption d-none d-md-block text-uin">
              <h4 ><b>Analisi Sensitifitas metode SAW TOPSIS dan SAW-TOPSIS</b></h4>
              <h5>untuk pemilihan prodi terbaik di UIN Sunan Kalijaga</h5>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('images/uin6.jpg')">
            <div class="carousel-caption d-none d-md-block text-uin">
              <h4 ><b>Analisi Sensitifitas metode SAW TOPSIS dan SAW-TOPSIS</b></h4>
              <h5>untuk pemilihan prodi terbaik di UIN Sunan Kalijaga</h5>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>
     
    <section class="sistem bg-white" id="sistem">
        <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="screen1">
                    <img src="images/tanya3.png" height="250px" class="fluid">
                </div>
              </div>
              <div class="col-md-6">
                <div >
                <h3 class="text-uin"><b>Apa itu Analisis Sensitifitas?</b></h3>
                    <br>
                    <p>Analisis Sensitifita dilakukan untuk mengetahui dan mendapatkan hasil dari perbandingan metode dari MADM untuk mengetahui mana yang lebih sensitif suatu metode dalam sebuah kasus dengan perubahan rangking di setiap metode. </p>
                  <button class="btn btn-uin" class="button">Uji Analisis Sensitifitas</button>
                </div>
              </div>
            </div> 
          </div>       
    </section>

    <section id="metode" class="sistem bg-grey">
        <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="text-spk">
                  <p>Simple Additive Weighting (SAW) sering dikenal dengan metode penjumlahan terbobot. Skor total diperoleh dengan menjumlahkan seluruh hasil perkalian antara rating yang dapat dibandingkan lintas atribut dan tiap bobot. Konsep dasar metode SAW adalah mencari penjumlahan bobot dari ranting kinerja pada setiap alternatif pada semua atribut</p>
                </div>
              </div>
              <div class="col-md-6">
              <div class="screen2">
                    <img src="images/sw.png" height="250px" class="fluid">
                </div>
              </div>
            </div> 
          </div>   
      </section>

      <section class="sistem bg-white" >
        <div class="container">
            <div class="row">
              <div class="col-md-6">
              <div class="screen1">
                    <img src="images/tp.png" height="250px" class="fluid">
                </div>
              
              </div>
              <div class="col-md-6">
              <div class="text-spk">
                    <p>(Technique for Order Preference by Similarity to Ideal Solution) yang  didasarkan pada konsep dimana alternatif terpilih yang terbaik tidak hanya dari jarak terpendek dari nilai solusi ideal positif, tetapi  juga  memiliki jarak terpanjang dan solusi ideal negatif.</p>
                  <br>
                </div>
              </div>
            </div> 
          </div>       
    </section>

    <section id="metode" class="sistem bg-grey">
        <div class="container">
            <div class="row">
              <div class="col-md-6">
              <div class="text-spk2">
                    <p>Metode SAW memiliki proses normalisasi yang sederhana dan Metode TOPSIS memiliki proses perangkingan yang cukup baik, jadi gabungan metode ini diharapkan memberikan hasil rekomendasi yang lebih baik</p>
                  <br>
                </div>
              </div>
              <div class="col-md-6">
                <div class="screen2">
                        <img src="images/st.png" height="250px" class="fluid">
                  </div>
              </div>
            </div> 
          </div>   
      </section>
      <footer class="foot">
        <div class="container"> 
        <img src="images/uin.png" height="40px">
            <p class="text-uin">&copy; Sistem Pendukung Keputusan 2019.</p>
            
        </div>
      </footer>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>