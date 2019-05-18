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
        <h3><b>Perhitungan TOPSIS</b></h3>
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
        <table class="table table-striped table-bordered" id="tabeldata1">
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
                // memanggil data peralternatif
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
          <table class="table table-striped table-bordered" id="tabeldata2">
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
                      // memanggil data peralternatif
                      $alternatif = $alter->readAll();
                      while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
                      ?>
                      <tr>
                          <td><?php echo $no++?></td>
                          <td><?php echo $data_alternatif['nama_prodi']?></td>
                          <?php
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          // memanggil bobot alternatif berdasarkan id alternatif
                          $stmt = $bobot->readR($id_alternatif);
                          // menampilkan semua bobot 
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
          <table class="table table-striped table-bordered" id="tabeldata3">
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
                            $id_alternatif = $data_alternatif['id_alternatif'];
                            // memanggil bobot alternatif berdasarkan id alternatif
                            $stmt = $bobot->readR($id_alternatif);
                            while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                            // memanggil function pembagi khusus topsis di bobot_alter.inc.php 
                            $pembagi = $bobot->pembagi($rowr['id_kriteria']);

                            $id = $rowr['id_kriteria'];
                            $tipe = $rowr['tipe_kriteria'];
                            $bobot_kriteria = $rowr['bobot_kriteria'];
                            
                            ?> 
                            <td>
                              <?php
                              // inisialisai nilai max dan min
                                $max[$id] = 0;
                                $min[$id] = 10;
                                // proses normalisasi topsis
                                $nor = $rowr ['bobot_alternatif']/$pembagi;
                                echo number_format($nor,3);
                                $hasil_normalisasi[$id][$rowr['id_alternatif']] = $nor;  
                               }
                              ?>  
                            </td>
                            <?php }
                          ?> 
                      </tr>  
              </tbody>
            </table>
           </div>
           <br/>

             <!--pembobotan nilai prodi -->
          <h3 class="text-uin">Pembobotan nilai Prodi</h3>
          <div class="row">
          <table class="table table-striped table-bordered" id="tabeldata4">
            
            <thead>
              <tr>
                <?php 
                    $no = 1;
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
                  // array untung menampung hasil pembobotan
                  $nilaiMaxMins = array();
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
                      $id_alter = $rowr['id_alternatif'];
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
                          $id_kriteria = $rowr['id_kriteria'];
                          $tipe = $rowr['tipe_kriteria'];
                          $bobot_kriteria = $rowr['bobot_kriteria'];
                          ?>
                          <td>
                            <?php
                                // perkalian hasil normalisasi dengan bobot perkriteria
                                $pembobotan =  $hasil_normalisasi[$id_kriteria][$rowr['id_alternatif']] * $bobot_kriteria;
                                // menyimpan ke variabel baru berdasarkan  id alternatif dan id kriteria
                                $pembobotanKriteria[$id_alternatif][$id_kriteria] = $pembobotan;
                                echo number_format( $pembobotanKriteria[$id_alternatif][$id_kriteria], 3);

                                // mencari nilai max perkriteria  
                                if ($pembobotan > $max[$id_kriteria]){
                                    $max[$id_kriteria] = $pembobotan;
                                    
                                }
                                // mencari nilai min perkriteria 
                                else if($pembobotan < $min[$id_kriteria]){
                                    $min[$id_kriteria] = $pembobotan;
                                }
                              } 
                            ?>  
                          </td>
                          <?php 
                        
                        } ?> 
                    </tr> 
            </tbody>
            </table>
          </div>
          <br>

          <h3 class="text-uin"> Max Min nilai Prodi</h3>
          <div class="row">
          <table class="table table-striped table-bordered" id="tabeldata5">
            
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
                          $id_kriteria = $data_kriteria['id_kriteria'];
                      ?>
                      <tr>
                          <td><?php echo $no++?></td>
                          <td><?php echo $data_kriteria['nama_kriteria']?></td>
                          <td><?php echo number_format($max[$id_kriteria],3)?></td>
                          <td><?php echo number_format($min[$id_kriteria],3)?></td>
                          <?php
                          
                        }
                         ?>
                            
                      </tr>      
            </tbody>
            </table>
          </div>


          <h3 class="text-uin">Nilai Pangkat</h3>
          <div class="row">
          <table class="table table-striped table-bordered" id="tabeldata6">
            
            <thead>
              <tr>
                <?php 
                    $no = 1;
                    $kriteria = $krit->readAll();
                    $jml_kriteria = $kriteria->rowCount();
                   
                  ?>
                <th>No</th>
                <th>Id Alternatif</th>
                <!-- <th>SUM D+</th> -->
                <th>D+</th>
                <th>D-</th>
                <!-- <th>D-</th> -->
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
                          // proses mencari nilai D+ D-
                          while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){
                          $id = $data_kriteria['id_kriteria'];
                          // pangkat d+
                          $pangkatPlus = pow(($max[$data_kriteria['id_kriteria']] - $pembobotanKriteria[$data_alternatif['id_alternatif']][$data_kriteria['id_kriteria']]),2);
                          // pangkat d-
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
                          // hasil akhir untuk perangkingan
                          $bagi = $hasilMin + $hasilPlus;
                          $hasil_v = $hasilMin / $bagi; 
                          echo number_format($hasil_v,3);
                          ?></td>
                        <?php
                        // menampung sementara nilai 
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
          <table class="table table-striped table-bordered" id="tabeldata7">
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

      </div>
    </section>
              
<?php
include_once 'footer.php';
?>