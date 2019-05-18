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


    <section class="pilihan" id="pilihan">
      <div class="container  ">
    <!-- Kriteria  -->
      <h3><b>Perhitungan SAW-TOPSIS</b></h3>
        <h3 class="text-uin">Kriteria</h3>
        <div class="row">
        <table class="table table-bordered" id="tabeldata">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Jenis</th>
                <th>Bobot</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no = 1;
                // menampilkan isi data kriteria
                $kriteria = $krit->readAll();
                $jml_kriteria = $kriteria->rowCount();
                while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){ 
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data_kriteria['nama_kriteria']; ?></td>
                <td><?php echo $data_kriteria['tipe_kriteria']; ?></td>
                <td><?php echo number_format($data_kriteria['bobot_kriteria'] ,3); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

    <!--Data Alternatif  -->
    <h3 class="text-uin">Data Prodi</h3>
        <div class="row">
        <table class="table table-bordered" id="tabeldata1">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Akreditasi</th>
                <th>Fakultas</th>
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
                <td><?php echo $no++; ?></td>
                <td><?php echo $data_alternatif['nama_prodi']; ?></td>
                <td><?php echo $data_alternatif['akreditasi']; ?></td>
                <td><?php echo $data_alternatif['fakultas']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>        

     <!-- matrix alternatif -->
        <h3 class="text-uin">Matrik Alternatif</h3>
          <div class="row">
          <table class="table table-bordered" id="tabeldata2">
                <thead>
                <?php 
                      $no = 1;
                      $kriteria = $krit->readAll();
                      $jml_kriteria = $kriteria->rowCount();
                      ?>
                    <tr>
                      <th rowspan="2"><center>No</center></th>
                      <th rowspan="2"><center>Prodi</center></th>
                      <th colspan="<?php echo $jml_kriteria?>"><center>Kriteria</center></th>
                    </tr>
                    <tr>
                      <?php 
                      // menampilkan isi data kriteria
                      while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                      ?>
                      <th><?php echo $data_kriteria['nama_kriteria']?></th>
                      <?php } ?>
                    </tr>
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
                          // memanggil bobot alternatif berdasarkan id alternatif
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $stmt = $bobot->readR($id_alternatif);
                          while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                          ?>
                          <td><?php echo number_format( $rowr['bobot_alternatif'],3)?></td>
                          <?php } ?>
                          
                      </tr>

                      <?php } ?>
                      
                </tbody>
            </table>
          </div>
          <br>
<!-- Normalisasi matrixs -->
          <h3 class="text-uin">Normalisasi matriks</h3>
          <div class="row">
          <table class="table table-bordered" id="tabeldata3">
              <thead>
                <tr>
                   <?php 
                      $no = 1;
                      $kriteria = $krit->readAll();
                      $jml_kriteria = $kriteria->rowCount();
                    ?>
                  <th rowspan="2">No</th>
                  <th rowspan="2">Prodi</th>
                  <th colspan="<?php echo $jml_kriteria?>"><center>Kriteria</center></th>
                </tr>
                <tr>
                  <?php
                  // menampilkan isi data kriteria
                     while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                      ?>
                      <th><?php echo $data_kriteria['nama_kriteria']?></th>
                      <?php } 
                  ?>
                </tr>

              </thead>
              <tbody>
              <?php
                  // memanggil semua data alternatif
                    $alternatif = $alter->readAll();
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
                        // inisialisasi nilai max min khusus topsis
                        $max[$id] = 0;
                        $min[$id] = 10;
                        ?>
                        <td>
                            <?php
                            //proses normalisasi jika benefit
                            if($tipe=='benefit'){
                              // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
                                $stmtmax = $bobot->readMax($id);
                                $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                                $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                                echo number_format($nor = $rowr['bobot_alternatif']/$maxnr['max'],3);
                                $hasil_normalisasi = $hasil_normalisasi + $nor;
                            }
                            //proses normalisasi jika cost
                            else{
                              // memanggil nilai min dari semua alternatif (bobot_alter.inc.php)
                                $stmtmin = $bobot->readMin($id);
                                $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                                $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                                echo number_format($nor = $minnr['min']/$rowr['bobot_alternatif'],3);
                                $hasil_normalisasi = $hasil_normalisasi + $nor;
                            }
                            ?>  
                        </td>
                        <?php }
                        ?>
                        
                    </tr>

                    <?php } ?>     
              </tbody>
            </table>
           </div>
           <br/>
             <!--pembobotan nilai ustad -->
          <h3 class="text-uin">Pembobotan nilai Prodi</h3>
          <div class="row">
          <table class="table table-bordered" id="tabeldata4">
            
            <thead>
              <tr>
                <?php 
                    $no = 1;
                    // membaca semua data kriteria
                    $kriteria = $krit->readAll();
                    // menghitung jml data kriteria
                    $jml_kriteria = $kriteria->rowCount();
                  ?>
                <th rowspan="2">No</th>
                <th rowspan="2">Prodi</th>
                <th colspan="<?php echo $jml_kriteria?>"><center>Kriteria</center></th>
                
              </tr>
              <tr>
                <?php
                  $pembobotan = 0;
                  // array untung menampung hasil pembobotan
                  $max_min = array();
                  while ($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <th><?php echo $data_kriteria['nama_kriteria']?></th>
                    <?php } 
                ?>
              </tr>

            </thead>
            <tbody>
            <?php
                     // memanggil semua data alternatif
                    $alternatif = $alter->readAll();
                    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $data_alternatif['nama_prodi']?></td>
                          <?php
                           // memanggil bobot alternatif berdasarkan id alternatif
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $stmt = $bobot->readR($id_alternatif);
                          // memanggil data berdarsarkan kriteria untuk perkalian nilai max min berdasarkan kriteria dan nilai bobot berdasarkan id alternatif
                          $i=0;
                          while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                          $id = $rowr['id_kriteria'];
                          $tipe = $rowr['tipe_kriteria'];
                          $bobot_kriteria = $rowr['bobot_kriteria'];
                          ?>
                          <td>
                            <?php
                             // proses normalisasi jika tipe data benefit
                                if($tipe=='benefit'){
                                  $stmtmax = $bobot->readMax($id);
                                  $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                                  $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                                  $pembobotan = $nor * $bobot_kriteria;
                                  echo number_format($pembobotan,3);
                                }
                                // proses normalisasi jika tipe data cost
                                else{
                                  $stmtmin = $bobot->readMin($id);
                                  $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                                  $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                                  $pembobotan = $nor * $bobot_kriteria;
                                  echo number_format($pembobotan,3); 
                                }
                                  // menyimpan ke variabel baru berdasarkan  id alternatif dan id kriteria
                                $pembobotanKriteria[$id_alternatif][$id] = $pembobotan;

                                // mencari nilai max perkriteria untuk perhitungan topsis
                                if ($pembobotan > $max[$id]){
                                    $max[$id] = $pembobotan;
                                    
                                }
                                 // mencari nilai min perkriteria untuk perhitungan topsis
                                else if($pembobotan < $min[$id]){
                                    $min[$id] = $pembobotan;
                                }
                                
                                }
                            ?>  
                          </td>
                          <?php } ?> 
                    </tr> 
            </tbody>
            </table>
          </div>
          <br>
          
                    
          <h3 class="text-uin"> Max Min nilai Prodi</h3>
          <div class="row">
          <table class="table table-bordered" id="tabeldata5">
            
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
                      // menampilkan isi data kriteria
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
          <h3 class="text-uin">Nilai Pangkat</h3>
          <div class="row">
          <table class="table table-bordered" id="tabeldata6">
            
            <thead>
              <tr>
                <?php 
                    $no = 1;
                    $kriteria = $krit->readAll();
                    $jml_kriteria = $kriteria->rowCount();
                   
                  ?>
                <th>No</th>
                <th>Id Alternatif</th>
                <th>D+</th>
                <th>D-</th>
                <th>Hasil</th>
              </tr>
            </thead>
            <tbody>
            <?php
                      //array baru untuk menampung hasil rangking
                      $rangking = array();
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
                          while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                          $id = $data_kriteria['id_kriteria'];
                          // proses mencari nilai D+ D-
                          $pangkatPlus = pow(($max[$data_kriteria['id_kriteria']] - $pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']]),2);
                          $pangkatMin = pow(($pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']])-$min[$data_kriteria['id_kriteria']],2);                         
                          $totalPlus += $pangkatPlus;
                          $totalMin += $pangkatMin;
                          } 
                          // hasil akar d+ dan d- 
                          $hasilPlus = sqrt($totalPlus);
                          $hasilMin = sqrt($totalMin);
                          ?>                         
                          <td><?php 
                          echo number_format($hasilPlus,3)
                          ?></td>
                          <td><?php 
                          echo number_format($hasilMin,3)
                          ?></td>
                          <td><?php 
                          $bagi = $hasilMin + $hasilPlus;
                          $hasil_v = $hasilMin / $bagi; 
                          echo number_format($hasil_v,3)
                          ?></td>
                        <?php
                        // hasil akhir untuk perangkingan
                          $rangkings['hasil_v'] = $hasil_v;
                          $rangkings['nama_prodi'] = $data_alternatif['nama_prodi'];
                          $rangkings['id_alternatif'] = $data_alternatif['id_alternatif'];
                          array_push($rangking,$rangkings);
                        ?>
                        </tr>
                      <?php } ?>     
            </tbody>
            </table>
          </div>

          <h3 class="text-uin">Rangking</h3>
          <div class="row">
          <table class="table table-bordered" id="tabeldata7">
              <thead>
                <tr>
                  <th>Rangking</th>
                  <th>Nama Prodi</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $no = 1;
                  // menampilkan hasil rangking berdasarkan urutan paling besar
                  rsort($rangking);
                  foreach($rangking as $rang){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $rang['nama_prodi'];?></td>
                      <td><?php echo number_format($rang['hasil_v'],3)?></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- div pilihan -->
      </div>
    </section>
              
<?php
include_once 'footer.php';
?>