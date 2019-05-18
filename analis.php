<section class="analisis" id="pilihan">
      <div class="container  ">
      <h3 class="text-analisis"><center><b>Data Kriteria</b></center></h3>
        <div class="row">
          <table class="table table-bordered" id="">
            <thead style="background-color: #D5AB57; color: #fff">
              <tr>
               
                
                <th>Bobot Normalisasi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no = 1;
                // membaca semua data kriteria
                $kriteria = $krit->readAll();
                $jml_kriteria = $kriteria->rowCount();
                $bobot=0;
                while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){ 
                    $stmtsum = $krit->readSum();
                    $maxsum = $stmtsum->fetch(PDO::FETCH_ASSOC);  
                    $stmtsumbobot = $krit->readSumBobot();
                    $maxsumbobot = $stmtsumbobot->fetch(PDO::FETCH_ASSOC);    
              ?>
              <tr>
                
                
                <?php
                $bobot_normal = $data_kriteria['bobot_stvitas']/$maxsum['sum'];
                $bobot += $bobot_normal;
                ?>
                <td><?php echo number_format ($bobot_normal,3)?></td>
                
              </tr>
              <?php } ?>
              <tr style="background-color: #D5AB57; color: #fff">
                    
                    
                    <td><?php echo number_format($bobot,3)?></td>
              </tr>
            </tbody>
          </table>
        </div> 
        <br> 
    <section class="analisis" id="pilihan">
      <div class="container  ">
      <h3 class="text-analisis"><center><b>Data Kriteria</b></center></h3>
        <div class="row">
          <table class="table table-bordered" id="">
            <thead style="background-color: #D5AB57; color: #fff">
            <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Jenis</th>
                <th>Bobot Asli</th>
                <th>Bobot Sensitifitas</th>
                <th>Bobot Normalisasi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $no = 1;
                // membaca semua data kriteria
                $kriteria = $krit->readAll();
                $jml_kriteria = $kriteria->rowCount();
                $bobot=0;
                while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){ 
                    $stmtsum = $krit->readSum();
                    $maxsum = $stmtsum->fetch(PDO::FETCH_ASSOC);  
                    $stmtsumbobot = $krit->readSumBobot();
                    $maxsumbobot = $stmtsumbobot->fetch(PDO::FETCH_ASSOC);    
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data_kriteria['nama_kriteria']; ?></td>
                <td><?php echo $data_kriteria['tipe_kriteria']; ?></td>
                <td><?php echo number_format ($data_kriteria['bobot_kriteria'],3); ?></td>
                <td><?php echo number_format ($data_kriteria['bobot_stvitas'],3); ?></td>
                <?php
                $bobot_normal = $data_kriteria['bobot_stvitas']/$maxsum['sum'];
                $bobot += $bobot_normal;
                ?>
                <td><?php echo number_format ($bobot_normal,3)?></td>
                
              </tr>
              <?php } ?>
              <tr style="background-color: #D5AB57; color: #fff">
                    <td colspan="3" >Jumlah Bobot </td>
                    <td><?php echo number_format($maxsumbobot['sum'],3)?></td>
                    <td><?php echo number_format($maxsum['sum'],3)?></td>
                    <td><?php echo number_format($bobot,3)?></td>
              </tr>
            </tbody>
          </table>
        </div> 
        <br> 
        <!-- hasil analisis -->