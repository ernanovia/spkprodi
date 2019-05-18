<?php
  include_once 'header.php';

  include "includes/config.php";
  $config = new Config();
  $db = $config->getConnection();

  include_once 'includes/alternatif.inc.php';
  $alter = new Alternatif($db);

?>

    <section class="pilihan" id="pilihan">
      <div class="container  ">
    <!--Data Alternatif  -->
    <br>
    <br>
    <h3 class="text-uin"><center><b>Data Prodi</b></center></h3>
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
            <tbody">
              <?php
                $no = 1;
                // membaca semua data kriteria
                $alternatif = $alter->readAll();
                // menghitung jumlah data alternatif
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
      </div>
    </section> 
     
              
  <?php
  include_once 'footer.php';
  ?>