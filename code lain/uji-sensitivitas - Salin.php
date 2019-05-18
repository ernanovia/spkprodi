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
        <div class="container">
        <div class="row">
            <form>
                <div class="form-group col-md-5">
                <h4>Pilih kriteria</h4>
                <select class="form-control positionTypes" id="kriteria" required>
                    <option value="" disabled selected><h4>Pilih kriteria</h4></option>
                    <?php 
                        $kriteria = $krit->readAll();
                        while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){ 
                            extract($data_kriteria);
                            echo "<option value='{$id_kriteria}'>{$nama_kriteria}</option>";
                        }?>
                </select>
                </div>
                <div class="form-group col-md-5">
                    <h4>Pilih kenaikan bobot</h4>
                    <input name="bobot" class="form-control positionTypes" type="number" step="0.01" values="0.1" min="0" max="1.5">
                    <br>
                </div>
                <div class="col-md-1 b-pilih">
                        <button type="button" class="btn btn-uin ">Pilih</button>
                   
                </div>
            </form>
    <!-- div row -->
        </div>
    <!-- TABEL KRITERIA -->
        <h3 class="text-uin-left">Kriteria yang dimasukan</h3>
        <div class="row">
          <table class="table table-bordered" id="">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Jenis</th>
                <th>Bobot</th>
                <th>Bobot Sensitivitas</th>
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
                <td><?php echo $data_kriteria['bobot_kriteria']; ?></td>
                <td><?php echo $data_kriteria['bobot_stvitas']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
    <!-- TABEL KRITERIA -->
    <!-- TABEL PEMBOBOTAN ANALISIS -->
    <h3 class="text-uin-left">Pembobotan Uji Sensitifitas</h3>
        <div class="row">
          <table class="table table-bordered" id="tabeldata1">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kriteria</th>
                <th>Nilai SAW</th>
                <th>Nilai Uji Sensitifitas SAW</th>
                <th>Nilai TOPSIS</th>
                <th>Nilai Uji Sensitifitas TOPSIS</th>
                <th>Nilai SAW-TOPSIS</th>
                <th>Nilai Uji Sensitifitas SAW-TOPSIS</th>
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
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
    <!-- TABEL PEMBOBOTAN ANALISIS -->
    <!-- TABEL HASIL SENsitifitas -->
    <h3 class="text-uin-left">Hasil Uji Sensitifitas</h3>
        <div class="row">
          <table class="table table-bordered" id="tabeldata2">
            <thead>
              <tr>
                <th>No</th>
                <th>Perubahan Bobot</th>
                <th>Perubahan Rangking SAW</th>
                <th>Perubahan Rangking TOPSIS</th>
                <th>Perubahan Rangking SAW-TOPSIS</th>
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
                
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
    <!-- TABEL HASIL SENsitifitas -->
    <!-- TABEL HASIL TERPILIH -->
    <h3 class="text-uin-left">Hasil Rekomendasi berdarsarkan metode terpilih</h3>
        <div class="row">
          <table class="table table-bordered" id="tabeldata2">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Prodi</th>
                <th>Akreditasi</th>
                
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
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
    <!-- TABEL HASIL TERPILIH -->

    <!-- div container -->
        </div> 
    </section>
    <br>
    <?php
  include_once 'footer.php';
  ?>