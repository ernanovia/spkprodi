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

                for($baris = 0; $baris < $jml_a; $baris++){
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