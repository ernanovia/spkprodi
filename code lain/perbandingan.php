<?php
  include "includes/config.php";
  $config = new Config();
  $db = $config->getConnection();

  include_once 'includes/kriteria.inc.php';
  $krit = new Kriteria($db);

  include_once 'includes/alternatif.inc.php';
  $alter = new Alternatif($db);
  
  include_once 'includes/bobot_alter.inc.php';
  $bobot = new Bobot($db);

  include_once 'includes/max_min.inc.php';
  $mxmin = new MaxMin($db);
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"></script>
    <title>Bootstrap4</title>
    <style>
     .tabel-data{
  padding-left: 10px;
  padding-right: 10px;
}
    </style>
  </head>
  <body>
   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-purple-studio">
      <div class="container">
        <a class="navbar-brand" href="#">
          Analisis Sensitifitas
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle Navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="saw.php">SAW</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="topsis.php">TOSIS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="saw-topsis.php">SAW-TOPSISA</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>
    
    

  <div class="container">
	<div class="row">
			<div class="col-md-3"></div>
			<div class="text-center col-md-6" style="padding-top: 30px;">
				<button type="button" class="btn btn-primary col-md-12" >Uji Sensitivitas</button>

			</div>
			<div class="col-md-3"></div>
	</div>
	<br>
    </div>
    <section class="pilihan" id="pilihan">
      <div class="container">
        <div class="row">
            <!-- SAW -->
            <div class= "col-lg-4">
              <div class="tabel-data">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4"></div> 
                </div>
                <br>
                <h3 class="text-pilihan">HASIL PERHITUNGAN SAW</h3>
                <!-- TABEL SAW -->
                <table class="table table-hover" id="tabelData111">
                  <thead>
                    <tr>
                      <?php 
                          $no = 1;
                          $kriteria = $krit->readAll();
                          $jml_kriteria = $kriteria->rowCount();
                        ?>
                      <th rowspan="2">No</th>
                      <th rowspan="2">Prodi</th>
                      <th>Hasil</th>
                    </tr>
                    <tr></tr>
                  </thead>
                  <tbody>
                  <?php
                    $alternatif = $alter->readAll();
                    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $data_alternatif['nama_prodi']?></td>
                        <?php
                        $hasil_normalisasi = 0;
                        $id_alternatif = $data_alternatif['id_alternatif'];
                        $stmt = $bobot->readR($id_alternatif);
                        while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $id = $rowr['id_kriteria'];
                        $tipe = $rowr['tipe_kriteria'];
                        $bobot_kriteria = $rowr['bobot_kriteria'];
                        if($tipe=='benefit'){
                            $stmtmax = $bobot->readMax($id);
                            $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                            $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                            $hasil_kali = $nor * $bobot_kriteria;
                            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
                        }else{
                            $stmtmin = $bobot->readMin($id);
                            $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                            $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                            $hasil_kali = $nor * $bobot_kriteria;
                            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
                        }
                        
                        } ?>
                        <td><center>
                            <?php
                            echo $hasil_normalisasi;
                            ?>
                        </center></td> 
                    </tr>              
                  <?php } ?>  
                  </tbody>
                  </table>
            </div>
          </div>
           <!-- AKHIR SAW -->
            <!-- TOPSIS -->
            <div class= "col-lg-4">
                <div class="tabel-data">
                <h3 class="text-pilihan">HASIL PERHITUNGAN TOPSIS</h3>
                <!-- TABEL TOPSIS -->
                <table class="table table-hover" id="tabelData">
                  <thead>
                    <tr>
                      <?php 
                          $no = 1;
                          $kriteria = $krit->readAll();
                          $jml_kriteria = $kriteria->rowCount();
                        ?>
                      <th rowspan="2">No</th>
                      <th rowspan="2">Prodi</th>
                      <th>Hasil</th>
                    </tr>
                    <tr>
                      <?php
                        $bbt = array();
                        $nilaiMaxMins = array();
                        
                        while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                          $id = $data_kriteria['id_kriteria'];
                          $max[$id] = 0;
                          $min[$id] = 10;
                          ?> 
                          <?php } ?>
                    </tr>
                  </thead>
                  <!-- ISI -->
                  <tbody>
                  <?php
                    $alternatif = $alter->readAll();
                    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){ 
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $stmt = $bobot->readR($id_alternatif);
                          while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                          $pembagi = $bobot->pembagi($rowr['id_kriteria']);
                          $id = $rowr['id_kriteria'];
                          $tipe = $rowr['tipe_kriteria'];
                          $bobot_kriteria = $rowr['bobot_kriteria'];
                          
                          $nor = $rowr ['bobot_alternatif']/$pembagi;
                          $hasil_topsis[$id][$rowr['id_alternatif']] = $nor;
                          $pembobotan =  $hasil_topsis[$id][$rowr['id_alternatif']] * $bobot_kriteria;
                          $bbts['pembobotan'] = $pembobotan;
                          $bbts['id_alternatif'] = $rowr['id_alternatif'];
                        
                          $pembobotanKriteria[$id_alternatif][$id] = $pembobotan;
                          if ($pembobotan > $max[$id]){
                              $max[$id] = $pembobotan;  
                          }
                          if($pembobotan < $min[$id]){
                              $min[$id] = $pembobotan;
                          } 
                        }
                                    
                        } 
                      
                        $alternatif = $alter->readAll();
                        
                        while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $nm_alter = $data_alternatif['nama_prodi'];
                          $totalPlus = 0;
                          $totalMin = 0;
                          ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $nm_alter; ?></td>
                            <?php
                            $kriteria = $krit->readAll();
                            while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                            $id = $data_kriteria['id_kriteria'];
                            $pangkatPlus = pow(($max[$data_kriteria['id_kriteria']] - $pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']]),2);
                            $pangkatMin = pow(($pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']])-$min[$data_kriteria['id_kriteria']],2);                         
                            $totalPlus += $pangkatPlus;
                            $totalMin += $pangkatMin;
                            }
                            $hasilPlus = sqrt($totalPlus);
                            $hasilMin = sqrt($totalMin);
                            ?>                         
                            
                            <td><?php 
                            $bagi = $hasilMin + $hasilPlus;
                            $hasil_v = $hasilMin / $bagi; 
                            echo number_format($hasil_v,3)
                            ?></td>
                          </tr>
                        <?php } ?> 
                  </tbody>
            </table>
                </div>
            </div>
            <h3 class="text-pilihan"> Max Min nilai Prodi</h3>
          <div class="row">
            <table class="table table-hover" id="tabelData3">
            
            <thead>
              <tr>
                <?php 
                    $no = 1;
                    $kriteria = $krit->readAll();
                    $jml_kriteria = $kriteria->rowCount();
                   
                  ?>
                <th>No</th>
                <th>Kriteria</th>
                <th>A+</th>
                <th>A-</th>
              </tr>
            </thead>
            <tbody>
            <?php
                      $maxMin = array();
                      $alternatif = $alter->readAll();
                      $kriteria = $krit->readAll();
                      while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                          $id = $data_kriteria['id_kriteria'];
                      ?>
                      <tr>
                          <td><?php echo $no++?></td>
                          <td><?php echo $data_kriteria['nama_kriteria']?></td>
                          <td><?php echo number_format($max[$id],3)?></td>
                          <td><?php echo number_format($min[$id],3)?></td>
                          <?php
                          
                        }
                         ?>
                            
                      </tr>      
            </tbody>
            </table>
          </div>
             <!-- SAW-TOPSIS -->
             <div class= "col-lg-4">
                <div class="tabel-data">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4"></div> 
                </div>
                <br>
                <h3 class="text-pilihan">HASIL PERHITUNGAN SAW-TOPSIS</h3>
                
                <table class="table table-hover" id="tabelData0111">
            
            <thead>
              <tr>
                <?php 
                    $no = 1;
                    $kriteria = $krit->readAll();
                    $jml_kriteria = $kriteria->rowCount();
                  ?>
                <th rowspan="2">No</th>
                <th rowspan="2">Prodi</th>
                <th>Hasil</th>
                
              </tr>
              <tr>
                <?php
                  $bbt = array();
                  $nilaiMaxMins = array();
                  
                  while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                    $id = $data_kriteria['id_kriteria'];
                    $max[$id] = 0;
                    $min[$id] = 10;
                    ?>
                    
                    <?php } 
                ?>
              </tr>

            </thead>
            <tbody>
            <?php

                    $alternatif = $alter->readAll();
                    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){ 
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $stmt = $bobot->readR($id_alternatif);
                          while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                          $pembagi = $bobot->pembagi($rowr['id_kriteria']);
                          // $id = $rowr['id_kriteria'];
                          // $tipe = $rowr['tipe_kriteria'];
                          // $bobot_kriteria = $rowr['bobot_kriteria'];
                          
                          $id_kriteria = $rowr['id_kriteria'];
                          //$id_alternatif = $rowr['id_alternatif'];
                          $tipe = $rowr['tipe_kriteria'];
                          $bobot_kriteria = $rowr['bobot_kriteria'];
                          $bobot_alter = $rowr['bobot_alternatif'];

                          if($tipe=='benefit'){
                            $stmtmax = $bobot->readMax($id_kriteria);
                            $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                            $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                            $pembobotan = $nor * $bobot_kriteria;
                          
                            // $pembobotan = $pembobotan + $hasil_kali; 
                          }else{
                            $stmtmin = $bobot->readMin($id_kriteria);
                            $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                            $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                            $pembobotan = $nor * $bobot_kriteria;
                            
                            // $pembobotan = $pembobotan + $hasil_kali;  
                          }
                        
                          $pembobotanKriteria[$id_alternatif][$id_kriteria] = $pembobotan;
                          if ($pembobotan > $max[$id_kriteria]){
                              $max[$id_kriteria] = $pembobotan;  
                          }
                          if($pembobotan < $min[$id_kriteria]){
                              $min[$id_kriteria] = $pembobotan;
                          } 
                        }
                                              
                        }  
                       
                        $alternatif = $alter->readAll();
                        
                        while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $nm_alter = $data_alternatif['nama_prodi'];
                          $totalPlus = 0;
                          $totalMin = 0;
                          ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $nm_alter; ?></td>
                            <?php
                            $kriteria = $krit->readAll();
                            while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                            $id = $data_kriteria['id_kriteria'];
                            $pangkatPlus = pow(($max[$data_kriteria['id_kriteria']] - $pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']]),2);
                            $pangkatMin = pow(($pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']])-$min[$data_kriteria['id_kriteria']],2);                         
                            $totalPlus += $pangkatPlus;
                            $totalMin += $pangkatMin;
                            }
                            $hasilPlus = sqrt($totalPlus);
                            $hasilMin = sqrt($totalMin);
                            ?>                         
                            
                            <td><?php 
                            $bagi = $hasilMin + $hasilPlus;
                            $hasil_v = $hasilMin / $bagi; 
                            echo number_format($hasil_v,3)
                            ?></td>
                          </tr>
                        <?php } ?> 
            </tbody>
            </table>
                </div>
            </div>
      </div>
    </section>
    <br>
    <?php
  include_once 'footer.php';
  ?>