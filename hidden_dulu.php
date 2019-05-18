<?php
//  include_once 'header.php';

  include "includes/config.php";
  $config = new Config();
  $db = $config->getConnection();

  include_once 'includes/kriteria.inc.php';
  $krit = new Kriteria($db);
  $node = $krit->jmlYa();
  $id_kriteria  = $krit->idKriteriaY();

  include_once 'includes/alternatif.inc.php';
  $alter = new Alternatif($db);
  $id_alternatif = $alter->readId();
  $jml_alter = $alter->jmlAlternativ();
  $nm_prodi = $alter->readNama();
  
  include_once 'includes/bobot_alter.inc.php';
  $bobot = new Bobot($db);

$jml_vektor_altv = 0;
$lp = 0;

$nilai_wp = array();
$altv_wp = array();

$basis_wp = array();
$jml_urut_ahp = 0;
$jml_urut_wp = 0;

  for ($w=1; $w<2.1; $w+=0.1){
      for($a=0; $a < $jml_alter; $a++){
          $bobot->id_alternatif = $id_alternatif[$a];
          $jml_a_baris[$a] = 0;
          $s_altv[$a] = 1;

          for($k= 0;$k < $node ; $k++) {
              $bobot->id_kriteria = $id_kriteria[$k];
              $krit->id_kriteria = $id_kriteria[$k];
              $b_altv = $bobot->readBobot();
              $tipe = $krit->readTipe();
            //   echo $b_altv;

            //   wp
            if ($tipe == 'benefit') {
				$tmp_pow[$k] = pow($b_altv, $w);
			}
			else{
				$tmp_pow[$k] = pow($b_altv, -$w);
			}
            $s_altv[$a] *= $tmp_pow[$k];
            // echo $s_altv[$a];
			//oper untuk peralternativ
		}

        $jml_vektor_altv += $s_altv[$a];
        // echo  $jml_vektor_altv;
		//nambahib s_altv
        //     if($tipe =='benefit') {
        //         $tmp_pow[$k] = pow($b_altv, $w);
        //     }
        //     else{
        //         $tmp_pow[$k] = pow($b_altv, -$w);
        //     }
        //     $s_altv *= $tmp_pow[$k];
        //   }
        //   $jml_vektor_altv += $s_altv[$a];
        //   echo $jml_vektor_altv;
      }
    //   hidden dulu
      for ($t = 0; $t < $jml_alter ; $t++) {
          $vektor_altv[$t] = $s_altv[$t]/$jml_vektor_altv;
          $nilai_wp[$t][1][$lp] = $vektor_altv[$t];
          $nilai_wp[$t][2][$lp] = $id_alternatif[$t];
          $nilai_wp[$t][3][$lp] = $nm_prodi[$t];

      }

    //   $tmp2 = array();
    //   for($b = 0 ; $b < count($nilai_wp)-1 ;$b++){
    //       for($a = $b+1; $a < count($nilai_wp); $a++) {
    //           //pengurutan
    //           if($nilai_wp[$b][1][$lp] < $nilai_wp[$a][1][$lp]) {
    //               $tmp2 = $nilai_wp[$b];
    //               $nilai_wp[$b] = $nilai_wp[$a];
    //               $nilai_wp[$a] = $tmp2;
    //           }
    //           elseif($nilai_wp[$b][1][1] < $nilai_wp[$a][1][0]){
    //             $tmp2 = $nilai_wp[$b];
    //             $nilai_wp[$b] = $nilai_wp[$a];
    //             $nilai_wp[$a] = $tmp2;
    //           }
    //       }
    //   }
    
    
?>

<section class="pilihan" id="pilihan">
      <div class="container  ">
        <div class="row"> 
            <?php if($lp>0) {
            ?>
                <h4>Perulangan ke <?php echo  $lp ?></h4>
                <h4>Perulangan ke <?php echo  $w ?></h4>
            <?php }
            else{ ?>
                <h4>Basis Pengetahuan <?php echo  $lp ?></h4>
                <h4>Nilai bobot <?php echo  $w ?></h4>
           <?php } ?>
        </div>

        <table width="100%" class="table table-striped" id="tabeldata">
            <thead>
                <tr>
                    <th rowspan="2">Rang</th>
                    <th rowspan="2">WP</th>
                </tr>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $urut_wp[$lp] = 0;

                for($baris = 0; $baris < $jml_alter; $baris++){
                    echo "<tr>";
                    echo "<td align='center'>".$no."</td>";
                    echo "<td align='center'>".$nilai_wp[$baris][2][$lp]."</td>";
                    echo "<td align='center'>".$nilai_wp[$baris][3][$lp]."</td>";
                    if($lp == 0) {
                        $baris_wp[$baris] = $nilai_wp[$baris][2][$lp];
                    }
                    else{
                        if($nilai_wp[$baris][2][$lp] != $baris_wp[$baris]) {
                            $urut_wp[$lp]++;
                        }
                    }


                    echo "</tr>";
                    $no++;

                }
                ?>
                
            </tbody>
        
        </table>
        <?php if($lp > 0 ) {
            
            echo "<h5>Perubahan WP pada Perulangan ke-".$lp." = ".$urut_wp[$lp]."</h5>";
        } ?>
      </div>

      <?php
        $jml_urut_wp += ($urut_wp[$lp]);
        $lp++;
    
    }
    // presentase
    $presentase_wp = round($jml_urut_wp/(10*$node)*100/100,3);
    ?>
    <div class="col-md-8">
        <div class= "row">
            <div class="col-md-6 text-left">
                <h4>Perubahan rangking</h4>
                <h5>Total perubahan rangking</h5>
            </div>
        </div>
        <br>
        <h5>Total Perubahan Rangking pada WP = <?php echo $jml_urut_wp; ?></h5>
    </div>
<!-- presentase -->

   <div class="col-md-8">
        <div class= "row">
            <div class="col-md-6 text-left">
                <h4>Presentase Perubahan rangking</h4>
                <h5>Presentase Total perubahan rangking</h5>
            </div>
        </div>
        <br>
        <h5>Presentase Total Perubahan Rangking pada WP = <?php echo $jml_urut_wp; ?></h5>
        <?php
        if($jml_urut_wp > $jml_urut_ahp ) {
            echo "<h5>Metode terpilih adalah WP</h5>";
            echo "<h5>Perhitungan metode terpilih : </h5><a href='saw.php' class='btn btn-success'>Metode WP</a>";
        }
        
        ?>
    </div>
    </section>

