
<!--test d+ -->
<h3 class="text-uin">TEST DATA D+</h3>
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
                    $totalPlus = 0;
                        $totalMin = 0;
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
                                $plus = ($max[$rowr['id_kriteria']] - $pembobotanKriteria[$id_alternatif][$id_kriteria]);
                                $pangkatPlus = pow(($max[$rowr['id_kriteria']] - $pembobotanKriteria[$id_alternatif][$id_kriteria]),2);
                                echo number_format( $plus, 3);
                                $totalPlus += $pangkatPlus;
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

          <!--test pangkatd+ -->
<h3 class="text-uin">TEST DATA pangkat D+</h3>
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
                    $totalPlus = 0;
                        $totalMin = 0;
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
                                $plus = ($max[$rowr['id_kriteria']] - $pembobotanKriteria[$id_alternatif][$id_kriteria]);
                                $pangkatPlus = pow(($max[$rowr['id_kriteria']] - $pembobotanKriteria[$id_alternatif][$id_kriteria]),2);
                                echo number_format( $pangkatPlus, 3);
                                $totalPlus += $pangkatPlus;
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