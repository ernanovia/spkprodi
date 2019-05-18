
<?php
    include_once 'header.php';

    include "includes/config.php";
    $config = new Config();
    $db = $config->getConnection();

    include_once 'includes/kriteria.inc.php';
    $krit = new Kriteria($db);
    $node = $krit->jmlYa();
    $id_kriteria  = $krit->idKriteriaY();

    include_once 'includes/alternatif.inc.php';
    $alter = new Alternatif($db);
    //  ambil id peralternatif
    $id_alternatif = $alter->readId();
    // ambil count alternatif
    $jml_alter = $alter->jmlAlternativ();
    // ambil nama prodi
    $nm_prodi = $alter->readNama();
    
    include_once 'includes/bobot_alter.inc.php';
    $bobot = new Bobot($db);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $jml_vektor_altv = 0;
    $lp = 0;

    $nilai_wp = array();
    $altv_wp = array();

    $basis_wp = array();
    $jml_urut_ahp = 0;
    $jml_urut_wp = 0;
?>  
<section class="analisis">
  <div class="container">
    <h3><center>CONTOH UNTUK PERHITUNGAN WP</center></h3>
        <div class="row">
            <form method="post" action="hitung_sensitifitas2.php">
                <div class="form-group col-md-5">
                    <h4>Pilih kenaikan bobot</h4>
                    <select class="form-control positionTypes" id="krit" name="krit" required>
                        <option value="" disabled selected> Pilih kriteria </option>
                        <?php
                        $kriteria = $krit->readAll();
                        $jml_kriteria = $kriteria->rowCount();
                        while($data_kriteria = $kriteria->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?= $data_kriteria['id_kriteria'] ?>"><?php echo $data_kriteria['nama_kriteria']; ?></option>
                                
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <h4 style="text-align: center;">Kenaikan bobot.</h4>
                    <div class="col-xs-12" style="padding-bottom: 5px;">
                        <input name="bobot" class="form-control positionTypes" type="number" step="0.01" value="0.1" max="2">
                    </div>
                </div>
                <div class="col-md-2 b-pilih">
                    <button type="submit" class="btn btn-uin ">Pilih</button>
                </div>
                <div class="form-group col-md-6">
                </div>
            </form>
        <!-- div row -->              
      </div> 
  </div>
</section>   

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
                <td><?php echo $data_kriteria['bobot_kriteria']; ?></td>
                <td><?php echo $data_kriteria['bobot_stvitas']; ?></td>
                <?php
                $bobot_normal = $data_kriteria['bobot_stvitas']/$maxsum['sum'];
                $bobot += $bobot_normal;
                ?>
                <td><?php echo number_format ($bobot_normal,5)?></td>
                
              </tr>
              <?php } ?>
              <tr style="background-color: #D5AB57; color: #fff">
                    <td colspan="3" >Jumlah Bobot </td>
                    <td><?php echo number_format($maxsumbobot['sum'],1)?></td>
                    <td><?php echo number_format($maxsum['sum'],1)?></td>
                    <td><?php echo number_format($bobot,1)?></td>
              </tr>
            </tbody>
          </table>
        </div> 
        <br> 
        <!-- hasil analisis -->
        <h3 class="text-analisis"><center><b>Hasil Analisis</b></center></h3>
        <div class="row">
          <table class="table table-bordered" id="tabeldata">
            <thead style="background-color: #D5AB57; color: #fff">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Prodi</th>
                <th scope="col">Nilai Normal SAW</th>
                <th scope="col">Nilai Uji Sensitifitas SAW</th>
                <th scope="col">Nilai Normal TOPSIS</th>
                <th scope="col">Nilai Uji Sensitifitas TOPSIS</th>
                <th scope="col">Nilai Normal SAW-TOPSIS</th>
                <th scope="col">Nilai Uji Sensitifitas SAW-TOPSIS</th>
              </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT a.`id_alternatif`,a.`nama_prodi`, h.`nilai_saw`, h.`nilai_saw_sen`, h.`nilai_topsis`, h.`nilai_topsis_sen`, h.`nilai_saw_topsis`, h.`nilai_saw_topsis_sen` FROM `alternatif` a JOIN `analisis_sensitifitas` h ON a.`id_alternatif` = h.`id_alternatif`";
                    $result = $conn->query($sql);
                    while($alternatif = $result->fetch_assoc()) {
                        $nilaiS = 1;
                        $nilaiS2 = 1;
                        $hasil = 0;
                        $hasilSen= 0;
                        // $id = $alternatif['id_alternatif'];
                        // $sqlKrit = "SELECT a.`id_alternatif`,a.`nama_alternatif`, h.`hasil_wp`, h.`hasil_wp_sensitifitas`, h.`hasil_saw`, h.`hasil_saw_sensitifitas` FROM `alternatif` a JOIN `hasil` h ON a.`id_alternatif` = h.`id_alternatif`";
                        // $result2 = $conn->query($sqlKrit);
                        // $hasil = mysqli_fetch_assoc($result2);
                ?>
                    <tr>
                        <td>
                            <?= $alternatif['id_alternatif'] ?>
                        </td>
                        <td>
                            <?= $alternatif['nama_prodi'] ?>
                        </td>
                        <td><?= number_format($alternatif['nilai_saw'],5); ?></td>
                        <td><?= number_format($alternatif['nilai_saw_sen'],5); ?></td>
                        <td><?= number_format($alternatif['nilai_topsis'],5); ?></td>
                        <td><?= number_format($alternatif['nilai_topsis_sen'],5); ?></td>
                        <td><?= number_format($alternatif['nilai_saw_topsis'],5); ?></td>
                        <td><?= number_format($alternatif['nilai_saw_topsis_sen'],5); ?></td>
                        
                    </tr>
                <?php
                    }
                ?>
            </tbody>
          </table>
        </div> 
        <!-- hasil analiss -->

        <!-- Rangking analisis -->
        <h3 class="text-analisis"><center><b>Hasil Rangking</b></center></h3>
        <div class="row">
          <table class="table table-bordered" id="tabeldata1">
          <thead style="background-color: #D5AB57; color: #fff">
                <tr>
                <th scope="col">No</th>
                <th scope="col">Prodi</th>
                <th scope="col">Rangking SAW</th>
                <th scope="col">Rangking Sensitifitas SAW</th>
                <th scope="col">Rangking TOPSIS</th>
                <th scope="col">Rangking Sensitifitas TOPSIS</th>
                <th scope="col">Rangking SAW-TOPSIS</th>
                <th scope="col">Rangking Sensitifitas SAW-TOPSIS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT a.`id_alternatif`,a.`nama_prodi`, h.`saw`, h.`saw_sen`, h.`topsis`, h.`topsis_sen`, h.`saw_topsis`, h.`saw_topsis_sen` FROM `alternatif` a JOIN `analisis_sensitifitas` h ON a.`id_alternatif` = h.`id_alternatif`";
                    $result = $conn->query($sql);
                    while($alternatif = $result->fetch_assoc()) {
                        $nilaiS = 1;
                        $nilaiS2 = 1;
                        $hasil = 0;
                        $hasilSen= 0;
                        // $id = $alternatif['id_alternatif'];
                        // $sqlKrit = "SELECT a.`id_alternatif`,a.`nama_alternatif`, h.`hasil_wp`, h.`hasil_wp_sensitifitas`, h.`hasil_saw`, h.`hasil_saw_sensitifitas` FROM `alternatif` a JOIN `hasil` h ON a.`id_alternatif` = h.`id_alternatif`";
                        // $result2 = $conn->query($sqlKrit);
                        // $hasil = mysqli_fetch_assoc($result2);
                ?>
                    <tr>
                        <td>
                            <?= $alternatif['id_alternatif'] ?>
                        </td>
                        <td>
                            <?= $alternatif['nama_prodi'] ?>
                        </td>
                        <td><?= $alternatif['saw']; ?></td>
                        <td><?= $alternatif['saw_sen']; ?></td>
                        <td><?= $alternatif['topsis']; ?></td>
                        <td><?= $alternatif['topsis_sen']; ?></td>
                        <td><?= $alternatif['saw_topsis']; ?></td>
                        <td><?= $alternatif['saw_topsis_sen']; ?></td>
                        
                    </tr>
                <?php
                    }
                ?>
            </tbody>
          </table>
        </div> 

        <!-- Rangking analisis -->

        <!-- Hasil tes sensitivitas -->
        <h3 class="text-analisis"><center><b>Hasil Tes Sensitivitas</b></center></h3>
        <a class="btn btn-danger btn-md pull-right" href="del-history.php?id=all">Reset</a><br>
        <br>
        <div class="row">
            <table class="table table-bordered" id="tabeldata2">
            <thead style="background-color: #D5AB57; color: #fff">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Perubahan Bobot Kriteria</th>
                    <th scope="col">Perubahan Rangking SAW</th>
                    <th scope="col">Perubahan Rangking TOPSIS</th>
                    <th scope="col">Perubahan Rangking SAW-TOPSIS</th>
                </tr>
            </thead>
            <tbody >
                <?php
                    $i=1;
                    $sql = "SELECT * FROM hasil_sensitifitas";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                            <?= $i++; ?>
                    </td>
                    <td>
                            <?= $row['perubahan'] ?>
                    </td>
                    <td>
                            <?= $row['saw'] ?>
                    </td>
                    <td>
                            <?= $row['topsis'] ?>
                    </td>
                    <td>
                            <?= $row['saw_topsis'] ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            </table>
        </div> 

        <!-- Hasil tes sensitivitas -->

        <!-- Hasil rekomendasi -->
      <?php 
        $sqlPerubahan = "SELECT COUNT(*) as `perulangan`, SUM(`topsis`) as `topsis` , SUM(`saw`) as `saw`, SUM(`saw_topsis`) as `saw_topsis` FROM `hasil_sensitifitas`";
        $exePerubahan = $conn->query($sqlPerubahan);
        $totalPerubahan = mysqli_fetch_assoc($exePerubahan);
        
        $sqlJumlahKrit = "SELECT COUNT(*) as `jumlahKrit` FROM `kriteria`";
        $exeJumlahKrit = $conn->query($sqlJumlahKrit);
        $jumlahKrit = mysqli_fetch_assoc($exeJumlahKrit)['jumlahKrit'];
        if($totalPerubahan['perulangan'] != 0){
          $diffsaw = $totalPerubahan['saw'] / ($totalPerubahan['perulangan'] * $jumlahKrit);
          $difftopsis = $totalPerubahan['topsis'] / ($totalPerubahan['perulangan'] * $jumlahKrit);
          $diffsawtopsis = $totalPerubahan['saw_topsis'] / ($totalPerubahan['perulangan'] * $jumlahKrit);
          $totalPerulangan = $totalPerubahan['perulangan'];
          ?>
          <p>Total Perulangan <?= $totalPerulangan ?></p>
          <p>Perubahan SAW <?= $diffsaw ?>%</p>
          <p>Perubahan TOPSIS <?= $difftopsis ?>%</p>
          <p>Perubahan SAW-TOPSIS <?= $diffsawtopsis ?>%</p>

        <!-- CEK METODE TERPILIH -->
        <?php
        if ($diffsaw > $difftopsis && $diffsaw > $diffsawtopsis)  { ?> 
        <div class="metode-terpilih"> 
            <div class="row">
                <div class="col-md-6">   
                    <h4 class="text-terpilih"><b>Metode Terpilih adalah SAW </b></h4>
                    <a class="btn btn-uin btn-md pull-left" href="saw.php">Perhitungan Lengkap SAW</a>
                </div>
                <div class="col-md-6"><br></div>
            </div>
        </div>
        <?php } 

        else if ($difftopsis > $diffsaw  && $difftopsis > $diffsawtopsis)  { ?> 
        <div class="metode-terpilih"> 
            <div class="row">
                <div class="col-md-6">   
                    <h4 class="text-terpilih"><b>Metode Terpilih adalah TOPSIS </b></h4>
                    <a class="btn btn-uin btn-md pull-left" href="topsis.php">Perhitungan Lengkap TOPSIS</a>
                </div>
                <div class="col-md-6"><br></div>
            </div>
        </div>
        <?php }

        else if ($diffsawtopsis > $diffsaw  && $diffsawtopsis > $difftopsis )  { ?> 
        <div class="metode-terpilih"> 
            <div class="row">
                <div class="col-md-6">   
                    <h4 class="text-terpilih"><b>Metode Terpilih adalah  SAW-TOPSIS </b></h4>
                    <a class="btn btn-uin btn-md pull-left" href="topsis.php">Perhitungan Lengkap SAW-TOPSIS</a>
                </div>
                <div class="col-md-6"><br></div>
            </div>
        </div>
        <?php } ?>

        <!-- CEK METODE TERPILIH -->
        <?php
          $sqlRekomendasi = "SELECT * FROM `alternatif` a JOIN `analisis_sensitifitas` h ON a.`id_alternatif` = h.`id_alternatif` ORDER BY h.`nilai_saw` DESC LIMIT 10";
          if(($difftopsis>$diffsaw) && ($difftopsis>$diffsawtopsis)){
            $sqlRekomendasi = "SELECT * FROM `alternatif` a JOIN `analisis_sensitifitas` h ON a.`id_alternatif` = h.`id_alternatif` ORDER BY h.`nilai_topsis` DESC LIMIT 10";
          } else if (($diffsawtopsis>$diffsaw) && ($diffsawtopsis>$difftopsis)) {
          	$sqlRekomendasi = "SELECT * FROM `alternatif` a JOIN `analisis_sensitifitas` h ON a.`id_alternatif` = h.`id_alternatif` ORDER BY h.`nilai_saw_topsis` DESC LIMIT 10";
          }
          $exeRekomendasi = $conn->query($sqlRekomendasi);
          if (mysqli_num_rows($exeRekomendasi) ) { ?>
        <h3 class="text-analisis"><center><b>Hasil Rekomendasi</b></center></h3>
        <table class="table table-bordered" id="">
            <thead style="background-color: #D5AB57; color: #fff">
            <tr>
			      <th scope="col">No</th>
			      <th scope="col">Rekomendasi Kos</th>

			    </tr>
			  </thead>
			  <tbody >
          <?php
			$i=0;
			while($row = $exeRekomendasi->fetch_assoc()) { ?>

					<tr>
							<td>
									<?= ++$i; ?>
							</td>
							<td>
									<?= $row['nama_prodi'] ?>
							</td>
					</tr>
	
      <?php } ?>
      			<?php
			}
						}
            ?>
			  </tbody>
        </table>
      </div>

    

<?php
    include_once 'footer.php';
?>