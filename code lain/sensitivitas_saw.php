<!-- ANALISIS SENSITIFITAS SAW TOPSIS TOPSIS-SAW -->
<?php
 include_once 'header.php';

 include "includes/config.php";
 $config = new Config();
 $db = $config->getConnection();

 include_once 'includes/kriteria.inc.php';
 $krit = new Kriteria($db);

 include_once 'includes/alternatif.inc.php';
 $alter = new Alternatif($db);
 $jml_alter = $alter->jmlAlternativ();
 
 include_once 'includes/bobot_alter.inc.php';
 $bobot = new Bobot($db);

$jml_vektor_altv = 0;
$lp = 0;

$nilai_saw = array();
$altv_saw = array();

$nilai_topsis = array();
$altv_topsis = array();

$nilai_saw_topsis = array();
$altv_saw_topsi = array();

$basis_saw = array();
$basis_topsis = array();

$jml_urut_saw = 0;
$jml_urut_topsis = 0;
$jml_urut_saw_topsis = 0;

?>
<section class="kenaikan-bobot">
  <div class="container">
    <h3><center>CONTOH UNTUK PERHITUNGAN WP</center></h3>
    <div class="row">
      <form>
      <div class="form-group col-md-5">
          <h4>Pilih kenaikan bobot</h4>
          <input name="bobot" class="form-control positionTypes" type="number" step="0.01" values="0.1" min="0" max="1.5">
          <br>
        </div>
        <div class="col-md-1 b-pilih">
          <button type="button" class="btn btn-uin ">Pilih</button>
        </div>
        <div class="form-group col-md-6">
          
        </div>
        
      </form>
        <!-- div row -->              
      </div> 
  </div>
</section>        

<?php
// membuat semua bobot = 1 
// contoh kenaikan bobot = 0.1
  $perulangan = 0;
  for ($w=1; $w<2.1; $w+=0.1){
    $diff_saw[$perulangan] = 0;
    $alternatif = $alter->readAll();
    $a = 0;
    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
      // mengambil nilai bobot (alternatif)
      $jml_a_baris[$a] = 0;
      $s_altv[$a] = 1;
      $hasil_normalisasi = 0;

      $stmt = $bobot->readR($data_alternatif['id_alternatif']);
      while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
        $id = $rowr['id_kriteria'];
        $tipe = $rowr['tipe_kriteria'];
        $bobot_kriteria = $rowr['bobot_kriteria'];
          //proses normalisasi jika benefit
        if($tipe=='benefit'){
          // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
          $stmtmax = $bobot->readMax($id);
          $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
          $nor = $rowr['bobot_alternatif']/$maxnr['max'];
          $hasil_kali = $nor * $rowr['bobot_kriteria'];
          $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
        }else{
          // memanggil nilai min dari semua alternatif (bobot_alter.inc.php)
          $stmtmin = $bobot->readMin($id);
          $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
          $nor = $minnr['min']/$rowr['bobot_alternatif'];
          $hasil_kali = $nor * $w;
          $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
        }
        echo $nor." ";
        // echo $hasil_normalisasi*$w."<br>";
      }
      echo " |".$hasil_normalisasi."| ";
      $nilai_saw[$perulangan][$a]['nilai'] = $hasil_normalisasi;
      $nilai_saw[$perulangan][$a]['id'] = $data_alternatif['id_alternatif'];
      $nilai_saw[$perulangan][$a]['nama'] = $data_alternatif['nama_prodi'];

      $a++;
    }
    //   pengurutan niali terbesar->terkecil
    $tmp2 = array();
    for($b = 0 ; $b < count($nilai_saw[$perulangan])-1 ;$b++){
      for($a = $b+1; $a < count($nilai_saw[$perulangan]); $a++) {
          //pengurutan
        if($nilai_saw[$perulangan][$b]['nilai'] < $nilai_saw[$perulangan][$a]['nilai']) {
            $tmp2 = $nilai_saw[$perulangan][$b];
            $nilai_saw[$perulangan][$b] = $nilai_saw[$perulangan][$a];
            $nilai_saw[$perulangan][$a] = $tmp2;
        }
      }
    }
?>
<br>
<section class="sensitivitas" id="pilihan">
      <div class="container">
        <div class="row"> 
        <!-- perulangan  -->
            <?php if($lp>0) {
            ?>  
                <h4>Perulangan ke <?php echo  $lp ?></h4>
                <h4>Kenaikan bobot <?php echo "(kenaikan bobot dari inputan)?"?></h4>
                <h4>Nilai bobot <?php echo  $w ?></h4>
            <?php }
            else{ ?>
                <h4>Basis Pengetahuan <?php echo  $lp ?></h4>
                <h4>Kenaikan bobot <?php echo "(kenaikan bobot dari inputan)?"?></h4>
                <h4>Nilai bobot <?php echo  $w ?></h4>
           <?php } ?>
        </div>

        <table width="100%" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2">Rang</th>
                    <th colspan="2">SAW</th>
                    <th colspan="2">TOPSIS</th>
                    <th colspan="2">SAW-TOPSIS</th>
                </tr>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>

                    <th>Kode</th>
                    <th>Nama</th>

                    <th>Kode</th>
                    <th>Nama</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $urut_saw[$lp] = 0;

                for($baris = 0; $baris < $jml_alter; $baris++){
                    echo "<tr>";
                    echo "<td align='center'>".$no."</td>";
                    echo "<td align='center'>".$nilai_saw[$perulangan][$baris]['id']."</td>";
                    echo "<td align='center'>".$nilai_saw[$perulangan][$baris]['nama']." - ".$nilai_saw[$perulangan][$baris]['nilai']."</td>";
                    echo "</tr>";
                    $no++;

                }
                ?>
                
            </tbody>
        
        </table>
        <?php if($perulangan > 0 ) {
          for($a = 0; $a < count($nilai_saw[$perulangan]); $a++) {
            if($nilai_saw[$perulangan][$a]['id'] != $nilai_saw[$perulangan-1][$a]['id']) {
              $diff_saw[$perulangan]++;
            }
          }    
          echo "<h5>Perubahan WP pada Perulangan ke-".($perulangan+1)." = ".$diff_saw[$perulangan]."</h5>";
        } 
        ?>
      </div>

      <?php
        $jml_urut_saw += ($urut_saw[$lp]);
        $lp++;
      $perulangan++;
    }
    // presentase
    $presentase_wp = round($jml_urut_saw/(10*$node)*100/100,3);
    ?>
    <div class="col-md-8 col-md-offset-2">
        <div class= "row">
            <div class="col-md-6 text-left">
                <h4>Perubahan rangking</h4>
            </div>
        </div>
        <br>
        <h5>Total Perubahan Rangking pada WP = <?php echo $jml_urut_saw; ?></h5>
    </div>
<!-- presentase -->

   <div class="col-md-8 col-md-offset-2">
        <div class= "row">
            <div class="col-md-6 text-left">
                <h4>Presentase Perubahan rangking</h4>
            </div>
        </div>
        
        <h5>Presentase Total Perubahan Rangking pada WP = <?php echo $presentase_wp; ?>%</h5>
        <?php
        if($jml_urut_saw > $jml_urut_topsis ) {
            echo "<h5>Metode terpilih adalah WP</h5>";
            echo "<h5>Perhitungan metode terpilih : </h5><a href='saw.php' class='btn btn-success'>Metode WP</a>";
        }
        
        ?>
    </div>
    </section>
    <br>
    <?php
  include_once 'footer.php';
  ?>