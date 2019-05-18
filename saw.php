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
    <h3>Perhitungan SAW</h3>
    <section class="pilihan" id="pilihan">
      <div class="container  ">
      <!-- Kriteria  -->
      <h3 class="text-uin">Kriteria</h3>
        <div class="row">
          <table class="table table-bordered" id="">
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
          <table class="table table-bordered" id="tabeldata">
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
            <table class="table table-striped table-bordered" id="tabeldata1">
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
                      <!-- menampilkan isi data kriteria -->
                      <?php 
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
                          //menampilkan bobot peralternatif
                          $id_alternatif = $data_alternatif['id_alternatif'];
                          $stmt = $bobot->readR($id_alternatif);
                          while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
                          ?>
                          <td><?php echo number_format($rowr['bobot_alternatif'],3)?></td>
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
          <table class="table table-striped table-bordered" id="tabeldata2">
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
                  <!-- menampilkan isi data kriteria -->
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
                      // memanggil data peralternatif
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
                            $bobot_kriteria = $rowr['bobot_kriteria']
                            ?>
                            <td>
                              <?php
                                //proses normalisasi jika tipe data benefit
                                if($tipe=='benefit'){
                                  // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
                                  $stmtmax = $bobot->readMax($id);
                                  $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                                  // setiap bobot dibagi dengan nilai max 
                                  $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                                  echo number_format($nor = $rowr['bobot_alternatif']/$maxnr['max'],3);
                                  $hasil_normalisasi = $hasil_normalisasi + $nor;
                                }
                                //proses normalisasi jika tipe data cost
                                else{
                                  // memanggil nilai min dari  semua alternatif (bobot_alter.inc.php)
                                  $stmtmin = $bobot->readMin($id);
                                  $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                                  $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                                  // nilai min dibagi dengan setiap alternatif
                                  echo number_format($nor = $minnr['min']/$rowr['bobot_alternatif'],3);
                                  $hasil_normalisasi = $hasil_normalisasi + $nor;
                                }
                              ?>  
                            </td>
                            <?php } ?> 
                      </tr>
                      <?php } ?>   
              </tbody>
            </table>
           </div>
           <br/>
          <!--pembobotan nilai prodi -->
          <h3 class="text-uin">Pembobotan nilai Prodi</h3>
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
                <th rowspan="2"><center>Hasil</center></th>
              </tr>
              <tr>
                <?php
                // array baru untuk menyimpan data rangking sementara
                 $rangking = array();
                //  memanggil data kriteria
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
                      ?>
                      <td>
                        <?php
                          //proses normalisasi jika benefit
                          if($tipe=='benefit'){
                            // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
                            $stmtmax = $bobot->readMax($id);
                            $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
                            $nor = $rowr['bobot_alternatif']/$maxnr['max'];
                            // echo number_format($hasil_kali = $nor * 1.1,3);
                            echo number_format($hasil_kali = $nor * $bobot_kriteria,3);
                            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
                          }else{
                            // memanggil nilai min dari semua alternatif (bobot_alter.inc.php)
                            $stmtmin = $bobot->readMin($id);
                            $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
                            $nor = $maxnr['min']/$rowr['bobot_alterinatif'];
                            echo number_format($hasil_kali = $nor * $bobot_kriteria,3);
                            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
                          }
                        ?>  
                      </td>
                      <?php } ?>
                      <td><center>
                        <?php
                        // menampung sementara nama prodi dan hasil normalisasi di array
                        $rangkings['hasil_v'] = $hasil_normalisasi;
                        $rangkings['nama_prodi'] = $data_alternatif['nama_prodi'];
                        $rangkings['id_alternatif'] = $data_alternatif['id_alternatif'];
                        
                        array_push($rangking,$rangkings);
                        echo number_format($hasil_normalisasi,3);
                        ?>
                      </center></td> 
                </tr>       
              <?php } ?>   
            </tbody>
            </table>
          </div>
          <br>
        <!-- Hasil Rangking -->
        <h3 class="text-uin">Rangking</h3>
                  <div class="row">
                  <table class="table table-bordered" id="tabeldata4">
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
                              <td><?php echo number_format($rang['hasil_v'],3);?></td>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
<!-- div container -->
          </div> 
    </section>  
  <br>
     
              
<?php
include_once 'footer.php';
?>