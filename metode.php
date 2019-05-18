<?php
  include_once 'header.php';
  include "includes/config.php";
  $config = new Config();
  $db = $config->getConnection();

  include_once 'includes/kriteria.inc.php';
  $krit = new Kriteria($db);

  include_once 'includes/alternatif.inc.php';
  $alter = new Alternatif($db);
  
  include_once 'includes/bobot_alter.inc.php';
  $bobot = new Bobot($db);

  
?>
<br>
    <section class="pilihan" id="pilihan">
      <div class="container-fluid">
        <div class="row">
        <!-- SAW -->
        <div class= "col-md-4">
           <div class="row">
                    <div class="col-xs-8"><br><h5 class="text-uin-left"><b>HASIL PERHITUNGAN SAW</b></h5></div>
                    <div class="col-xs-4 text-right"><br><a class="btn btn-uin-cream" href="saw.php">Hasil Lengkap</a></div> 
            </div>
                <div class="tabel-data">
                  <table class="table table-sm table-bordered" id="tabeldata">
                    <thead>
                    <tr>
                      <?php 
                          $no = 1;
                          // menampilkan isi data kriteria
                          $kriteria = $krit->readAll();
                          $jml_kriteria = $kriteria->rowCount();
                        ?>
                      <th>No</th>
                      <th>Prodi</th>
                      <th>Hasil</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        // memanggil semua data alternatif
                        $alternatif = $alter->readAll();
                        $jml_alter = $alternatif->rowCount();
                        while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                      ?>
                      <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $data_alternatif['nama_prodi']?></td>
                        <?php

                        $hasil_normalisasi = 0;
                        $id_alternatif = $data_alternatif['id_alternatif'];
                        // memanggil bobot alternatif berdasarkan id alternatif
                        $stmt = $bobot->readR($id_alternatif);
                        while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $id = $rowr['id_kriteria'];
                        $tipe = $rowr['tipe_kriteria'];
                        $bobot_kriteria = $rowr['bobot_kriteria'];
                         //proses normalisasi jika benefit
                        if($tipe=='benefit'){
                          // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
                            $stmtmax = $bobot->readMax($id);
                            $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                            // normalisasi
                            $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                            $hasil_kali = $nor * $bobot_kriteria;
                            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
                        }
                        //proses normalisasi jika cost
                        else{
                          // memanggil nilai min dari semua alternatif (bobot_alter.inc.php)
                            $stmtmin = $bobot->readMin($id);
                            $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                            // normalisasi
                            $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                            $hasil_kali = $nor * $bobot_kriteria;
                            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
                        }
                        
                        } ?>
                        <td><center>
                            <?php
                            echo number_format($hasil_normalisasi,3);
                            ?>
                        
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
            </div>
          <!-- SAW -->
          <!-- TOPSIS -->
        <div class= "col-md-4">
           <div class="row">
                    <div class="col-xs-8"><br><h5 class="text-uin-left"><b>HASIL PERHITUNGAN TOPSIS</b></h5></div>
                    <div class="col-xs-4 text-right"><br><a class="btn btn-uin-cream" href="topsis.php">Hasil Lengkap</a></div> 
            </div>
            <div class="tabel-data">
                  <table class="table table-sm table-bordered" id="tabeldata1">
                    <thead>
                    <tr>
                      <?php 
                          $no = 1;
                          $kriteria = $krit->readAll();
                          $jml_kriteria = $kriteria->rowCount();
                        ?>
                      <th>No</th>
                      <th>Prodi</th>
                      <th>Hasil</th>
                    </tr>
                    <?php
                      // menampilkan isi data kriteria
                        while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                          $id = $data_kriteria['id_kriteria'];
                           // inisialisai nilai max dan min khusus topsis
                          $max[$id] = 0;
                          $min[$id] = 10;
                          ?> 
                          <?php } ?>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        // memanggil semua data alternatif
                        $alternatif = $alter->readAll();
                        $jml_alter = $alternatif->rowCount();
                        while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          // memanggil bobot alternatif berdasarkan id alternatif
                          $bbt = $bobot->readR($id_alternatif);
                          while ($bobot1 = $bbt->fetch(PDO::FETCH_ASSOC)){
                           // memanggil function pembagi khusus topsis di bobot_alter.inc.php 
                          $pembagi = $bobot->pembagi($bobot1['id_kriteria']);
                          // manampung dalam variabel baru
                          $id_kriteria = $bobot1['id_kriteria'];
                          $id_alternatif = $bobot1['id_alternatif'];
                          $tipe = $bobot1['tipe_kriteria'];
                          $bobot_kriteria = $bobot1['bobot_kriteria'];
                          $bobot_alter = $bobot1['bobot_alternatif'];

                          // proses normalisasi
                          $nor = $bobot_alter/$pembagi;
                          $hasil_topsis[$id_kriteria][$id_alternatif] = $nor;
                          $pembobotan =  $hasil_topsis[$id_kriteria][$id_alternatif] * $bobot_kriteria;
                          
                          //nilai max min
                          $pembobotanKriteria[$id_alternatif][$id_kriteria] = $pembobotan;
                          if ($pembobotan > $max[$id_kriteria]){
                              $max[$id_kriteria] = $pembobotan;  
                          }
                          else if($pembobotan < $min[$id_kriteria]){
                              $min[$id_kriteria] = $pembobotan;
                          } 
                        }                
                    } //mencari nilai D+ D-
                    // memanggil semua data alternatif
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
                        // memanggil semua data kriteria
                        $kriteria = $krit->readAll();
                        // proses mencari nilai D+ D-
                        while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                        $id_kriteria = $data_kriteria['id_kriteria'];
                        // pangkat d+
                        $pangkatPlus = pow(($max[$id_kriteria] - $pembobotanKriteria[$id_alternatif][$id_kriteria]),2);
                        // pangkat d-
                        $pangkatMin = pow(($pembobotanKriteria[$id_alternatif][$id_kriteria])-$min[$id_kriteria],2);                         
                        $totalPlus += $pangkatPlus;
                        $totalMin += $pangkatMin;
                        }
                        $hasilPlus = sqrt($totalPlus);
                        $hasilMin = sqrt($totalMin);
                        ?>                          
                  <!-- hasil topsis -->
                        <td><?php 
                        // hasil akar d+ dan d-
                        $bagi = $hasilMin + $hasilPlus;
                        $hasil_v = $hasilMin / $bagi; 
                        echo number_format($hasil_v,3);
                        ?></td>
                      </tr>
                    <?php } ?> 
                    </tbody>
                  </table>
                </div>
            </div>
          <!-- TOPSIS -->

          <!-- SAW-TOPSIS -->
        <div class= "col-md-4">
           <div class="row">
                    <div class="col-xs-8"><br><h5 class="text-uin-left"><b>HASIL PERHITUNGAN SAW-TOPSIS</b></h5></div>
                    <div class="col-xs-4 text-right"><br><a class="btn btn-uin-cream" href="saw-topsis.php">Hasil Lengkap</a></div> 
            </div>
            <div class="tabel-data">
                  <table class="table table-sm table-bordered" id="tabeldata2">
                    <thead>
                    <tr>
                      <?php 
                          $no = 1;
                          $kriteria = $krit->readAll();
                          $jml_kriteria = $kriteria->rowCount();
                        ?>
                      <th>No</th>
                      <th>Prodi</th>
                      <th>Hasil</th>
                    </tr>
                    <?php
                        $bbt = array();
                        $nilaiMaxMins = array();
                        // menampilkan isi data kriteria
                        while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                          $id = $data_kriteria['id_kriteria'];
                          // inisialisai nilai max dan min khusus topsis
                          $max[$id] = 0;
                          $min[$id] = 10;
                          ?> 
                          <?php } ?>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        // memanggil semua data alternatif
                        $alternatif = $alter->readAll();
                        $jml_alter = $alternatif->rowCount();
                        while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          // memanggil bobot alternatif berdasarkan id alternatif
                          $bbt = $bobot->readR($id_alternatif);
                          while ($bobot1 = $bbt->fetch(PDO::FETCH_ASSOC)){
                             // memanggil function pembagi khusus topsis di bobot_alter.inc.php 
                          $pembagi = $bobot->pembagi($bobot1['id_kriteria']);
                          // menampung dalam variabel baru
                          $id_kriteria = $bobot1['id_kriteria'];
                          $tipe = $bobot1['tipe_kriteria'];
                          $bobot_kriteria = $bobot1['bobot_kriteria'];
                          $bobot_alter = $bobot1['bobot_alternatif'];

                          ///proses normalisasi jika benefit
                          if($tipe=='benefit'){
                            // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
                            $stmtmax = $bobot->readMax($id_kriteria);
                            $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                            $nor = $bobot1['bobot_alternatif']/$maxnr['max'];
                            // pembobotan
                            $pembobotan = $nor * $bobot_kriteria;
                          }
                          ///proses normalisasi jika cost
                          else{
                            // memanggil nilai min dari semua alternatif (bobot_alter.inc.php)
                            $stmtmin = $bobot->readMin($id_kriteria);
                            $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                            $nor = $maxnr['min']/$bobot1['bobot_alterinatif'];
                            // pembobotan
                            $pembobotan = $nor * $bobot_kriteria;
                          }
                          //nilai max min
                          $pembobotanKriteria[$id_alternatif][$id_kriteria] = $pembobotan;
                          if ($pembobotan > $max[$id_kriteria]){
                              $max[$id_kriteria] = $pembobotan;  
                          }
                          else if($pembobotan < $min[$id_kriteria]){
                              $min[$id_kriteria] = $pembobotan;
                          } 
                        }                
                    } //mencari nilai D+ D-
                    // memanggil semua data alternatif
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
                        // menampilkan isi data kriteria
                        $kriteria = $krit->readAll();
                        // proses mencari nilai D+ D-
                        while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                        $id_kriteria = $data_kriteria['id_kriteria'];
                        // pangkat d+
                        $pangkatPlus = pow(($max[$id_kriteria] - $pembobotanKriteria[$id_alternatif][$id_kriteria]),2);
                        // pangkat d-
                        $pangkatMin = pow(($pembobotanKriteria[$id_alternatif][$id_kriteria])-$min[$id_kriteria],2);                         
                        $totalPlus += $pangkatPlus;
                        $totalMin += $pangkatMin;
                        }
                         // hasil akar d+ dan d-
                        $hasilPlus = sqrt($totalPlus);
                        $hasilMin = sqrt($totalMin);
                        ?>                          
                  <!-- hasil topsis -->
                        <td><?php 
                         // hasil akhir untuk perangkingan
                        $bagi = $hasilMin + $hasilPlus;
                        $hasil_v = $hasilMin / $bagi; 
                        echo number_format($hasil_v,3);
                        ?></td>
                      </tr>
                    <?php } ?> 
                    </tbody>
                  </table>
                </div>
            </div>
          <!-- SAW-TOPSIS -->


          </div>
      </div>
      <div class="container">
    <div class="btn-analisis">
			<div class="col-md-3"></div>
				<div class="text-center col-md-6">
				<button type="button" class="btn btn-uin col-md-12" onclick="window.open('hitung_sensitifitas.php')">Analisis Sensitivitas</button>
				</div>
			<div class="col-md-3"></div>
	  </div>
	<br>
</div> 
    </section>
    <br>
    <?php
  include_once 'footer.php';
  ?>