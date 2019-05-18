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

  include_once 'includes/hasil.inc.php';
  $hsl = new Hasil($db);
?>

    <section class="pilihan" id="pilihan">
      <div class="container  ">
    <!--Data Alternatif  -->
      <br>
      <br>
      <h3 class="text-uin"><center><b>Data Kriteria</b></center></h3>
        <div class="row">
          <table class="table table-bordered" id="tabelData01">
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
                // membaca semua data kriteria
                $kriteria = $krit->readAll();
                $jml_kriteria = $kriteria->rowCount();
                while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){ 
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data_kriteria['nama_kriteria']; ?></td>
                <td><?php echo $data_kriteria['tipe_kriteria']; ?></td>
                <td><?php echo number_format($data_kriteria['bobot_kriteria'],3); ?></td>
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