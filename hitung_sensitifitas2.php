<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";
    $saw = array();
    $saw_sen = array();

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    // include "includes/config.php";
    // $config = new Config();
    // $db = $config->getConnection();

    // include_once 'includes/kriteria.inc.php';
    // $krit = new Kriteria($db);
    // $node = $krit->jmlYa();
    // $id_kriteria  = $krit->idKriteriaY();

    // include_once 'includes/alternatif.inc.php';
    // $alter = new Alternatif($db);
    // //  ambil id peralternatif
    // $id_alternatif = $alter->readId();
    // // ambil count alternatif
    // $jml_alter = $alter->jmlAlternativ();
    // // ambil nama prodi
    // $nm_prodi = $alter->readNama();
    
    // include_once 'includes/bobot_alter.inc.php';
    // $bobot = new Bobot($db);

    $id = $_POST['krit'];
    $bobotTambah = $_POST['bobot'];

    $sqlKrit = "SELECT * FROM kriteria where `id_kriteria` = '$id' LIMIT 1";
    $exeKrit = $conn->query($sqlKrit);
    $kritPerubahan = mysqli_fetch_assoc($exeKrit);
    $bobot = number_format($kritPerubahan['bobot_stvitas']+$bobotTambah,2);
    $perubahan = $kritPerubahan['nama_kriteria']." ditambah ".$bobotTambah;

    
    // echo $bobot;

    $sqlReset = "SELECT * FROM kriteria";
    $resultReset = $conn->query($sqlReset);

    while($kriteria = $resultReset->fetch_assoc()){
        $idKrit = $kriteria['id_kriteria'];
        if($idKrit == $id){
          $namaKrit = $kriteria['nama_kriteria'];
        }
        $conn->query("UPDATE `kriteria` set `bobot_stvitas` =  `bobot_kriteria` where `id_kriteria` = $idKrit ");
    }


    $query  = $conn->query("UPDATE `kriteria` set `bobot_stvitas` =  '$bobot' where `id_kriteria` = $id ");

    include "includes/config.php";
    $config = new Config();
    $db = $config->getConnection();

    include_once 'includes/kriteria.inc.php';
    $krit = new Kriteria($db);

    include_once 'includes/alternatif.inc.php';
    $alter = new Alternatif($db);
    
    include_once 'includes/bobot_alter.inc.php';
    $bobot = new Bobot($db);

    // memanggil semua data alternatif
    // SAW
    $alternatif = $alter->readAll();
    $urutan = 0;
    $stmt = $bobot->readAll();
    while ($rowr2 = $stmt->fetch(PDO::FETCH_ASSOC)){
        $maxTopsis[$rowr2['id_kriteria']] = 0;
        $minTopsis[$rowr2['id_kriteria']] = 10;
        $maxTopsisSen[$rowr2['id_kriteria']] = 0;
        $minTopsisSen[$rowr2['id_kriteria']] = 10;
        $maxSawTopsis[$rowr2['id_kriteria']] = 0;
        $minSawTopsis[$rowr2['id_kriteria']] = 10;
        $maxSawTopsisSen[$rowr2['id_kriteria']] = 0;
        $minSawTopsisSen[$rowr2['id_kriteria']] = 10;
    }
    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
        $hasil_normalisasi = 0;
        $hasil_normalisasi_sensitifitas = 0;
        $id_alternatif = $data_alternatif['id_alternatif'];
        // memanggil bobot alternatif berdasarkan id alternatif
        $stmt = $bobot->readR($id_alternatif);
        $stmtsum = $krit->readSum();
        $maxsum = $stmtsum->fetch(PDO::FETCH_ASSOC);
        $solusiIdealPositif[$id_alternatif] = 0;
        $solusiIdealNegatif[$id_alternatif] = 0;
        $solusiIdealPositifSen[$id_alternatif] = 0;
        $solusiIdealNegatifSen[$id_alternatif] = 0;
        $solusiIdealPositifST[$id_alternatif] = 0;
        $solusiIdealNegatifST[$id_alternatif] = 0;
        $solusiIdealPositifSTSen[$id_alternatif] = 0;
        $solusiIdealNegatifSTSen[$id_alternatif] = 0;
        
        $stmt = $bobot->readR($id_alternatif);
        while ($rowr = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = $rowr['id_kriteria'];
            $tipe = $rowr['tipe_kriteria'];
            $bobot_kriteria = $rowr['bobot_kriteria'];
            $bobot_sen = $rowr['bobot_stvitas']/$maxsum['sum'];
            $pembagi = $bobot->pembagi($rowr['id_kriteria']);
            $norTopsis = $rowr['bobot_alternatif']/$pembagi;
            // echo $id_alternatif.' = '.$norTopsis.'<br>';
            $terbobot = $norTopsis * $bobot_kriteria;
            $terbobotSen = $norTopsis * $bobot_sen;
            $terbobotArray[$id_alternatif][$id] = $terbobot;
            $terbobotArraySen[$id_alternatif][$id] = $terbobotSen;
            // echo $id_alternatif.' = '.$terbobot.' sen = '.$terbobotSen.'<br>';
            if($terbobotSen>$maxTopsisSen[$id]){
                $maxTopsisSen[$id] = $terbobotSen;
            }
            if($terbobot>$maxTopsis[$id]){
                $maxTopsis[$id] = $terbobot;
            }
            if($terbobotSen<$minTopsisSen[$id]){
                $minTopsisSen[$id] = $terbobotSen;
            }
            if($terbobot<$minTopsis[$id]){
                $minTopsis[$id] = $terbobot;
            }
            //proses normalisasi jika benefit
            if($tipe=='benefit'){
            // memanggil nilai max dari semua alternatif (bobot_alter.inc.php)
            $stmtmax = $bobot->readMax($id);
            $maxnr = $stmtmax->fetch(PDO::FETCH_ASSOC);
            $nor = $rowr['bobot_alternatif']/$maxnr['max'];
            // echo number_format($hasil_kali = $nor * 1.1,3);
            $hasil_kali = $nor * $bobot_kriteria;
            $hasil_kali_sen = $nor * $bobot_sen;
            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali;
            $hasil_normalisasi_sensitifitas = $hasil_normalisasi_sensitifitas + $hasil_kali_sen;
            }else{
            // memanggil nilai min dari semua alternatif (bobot_alter.inc.php)
            $stmtmin = $bobot->readMin($id);
            $minnr = $stmtmin->fetch(PDO::FETCH_ASSOC);
            $nor = $maxnr['min']/$rowr['bobot_alternatif'];
            $hasil_kali = $nor * $bobot_kriteria;
            $hasil_kali_sen = $nor * $bobot_sen;
            $hasil_normalisasi = $hasil_normalisasi + $hasil_kali; 
            $hasil_normalisasi_sensitifitas = $hasil_normalisasi_sensitifitas + $hasil_kali_sen;
            }
            $terbobotSTArray[$id_alternatif][$id] = $hasil_kali;
            $terbobotSTArraySen[$id_alternatif][$id] = $hasil_kali_sen;
            if($hasil_kali_sen>$maxSawTopsisSen[$id]){
                $maxSawTopsisSen[$id] = $hasil_kali_sen;
            }
            if($hasil_kali>$maxSawTopsis[$id]){
                $maxSawTopsis[$id] = $hasil_kali;
            }
            if($hasil_kali_sen<$minSawTopsisSen[$id]){
                $minSawTopsisSen[$id] = $hasil_kali_sen;
            }
            if($hasil_kali<$minSawTopsis[$id]){
                $minSawTopsis[$id] = $hasil_kali;
            }

        }
        $saw[$urutan]['nilai'] = $hasil_normalisasi; 
        $saw[$urutan]['id'] = $id_alternatif; 
        $saw_sen[$urutan]['id'] = $id_alternatif; 
        $saw_sen[$urutan]['nilai'] = $hasil_normalisasi_sensitifitas; 
        $urutan++;
    }
    // itung solusi ideal positif negatif
    $alternatif = $alter->readAll();
    $urutan = 0;
    
    while($data_alternatif = $alternatif->fetch(PDO::FETCH_ASSOC)){
        $id_alternatif = $data_alternatif['id_alternatif'];
        $stmt = $krit->readAll();
        while ($rowr2 = $stmt->fetch(PDO::FETCH_ASSOC)){
            $id = $rowr2['id_kriteria'];
            $solusiIdealPositif[$id_alternatif] += pow(($terbobotArray[$id_alternatif][$id] - $maxTopsis[$id]), 2);
            $solusiIdealNegatif[$id_alternatif] += pow(($terbobotArray[$id_alternatif][$id] - $minTopsis[$id]), 2);
            $solusiIdealPositifSen[$id_alternatif] += pow(($terbobotArray[$id_alternatif][$id] - $maxTopsisSen[$id]), 2);
            $solusiIdealNegatifSen[$id_alternatif] += pow(($terbobotArray[$id_alternatif][$id] - $minTopsisSen[$id]), 2);
            $solusiIdealPositifST[$id_alternatif] += pow(($terbobotSTArray[$id_alternatif][$id] - $maxSawTopsis[$id]), 2);
            $solusiIdealNegatifST[$id_alternatif] += pow(($terbobotSTArray[$id_alternatif][$id] - $minSawTopsis[$id]), 2);
            $solusiIdealPositifSTSen[$id_alternatif] += pow(($terbobotSTArray[$id_alternatif][$id] - $maxSawTopsisSen[$id]), 2);
            $solusiIdealNegatifSTSen[$id_alternatif] += pow(($terbobotSTArray[$id_alternatif][$id] - $minSawTopsisSen[$id]), 2);
        }
        $solusiIdealPositif[$id_alternatif] = sqrt($solusiIdealPositif[$id_alternatif]);
        $solusiIdealNegatif[$id_alternatif] = sqrt($solusiIdealNegatif[$id_alternatif]);
        $solusiIdealPositifSen[$id_alternatif] = sqrt($solusiIdealPositifSen[$id_alternatif]);
        $solusiIdealNegatifSen[$id_alternatif] = sqrt($solusiIdealNegatifSen[$id_alternatif]);

        $topsis[$urutan]['nilai'] = $solusiIdealNegatif[$id_alternatif]/($solusiIdealNegatif[$id_alternatif]+$solusiIdealPositif[$id_alternatif]); 
        $topsis[$urutan]['id'] = $id_alternatif; 
        $topsis_sen[$urutan]['id'] = $id_alternatif; 
        $topsis_sen[$urutan]['nilai'] = $solusiIdealNegatifSen[$id_alternatif]/($solusiIdealNegatifSen[$id_alternatif]+$solusiIdealPositifSen[$id_alternatif]);  

        $solusiIdealPositifST[$id_alternatif] = sqrt($solusiIdealPositifST[$id_alternatif]);
        $solusiIdealNegatifST[$id_alternatif] = sqrt($solusiIdealNegatifST[$id_alternatif]);
        $solusiIdealPositifSTSen[$id_alternatif] = sqrt($solusiIdealPositifSTSen[$id_alternatif]);
        $solusiIdealNegatifSTSen[$id_alternatif] = sqrt($solusiIdealNegatifSTSen[$id_alternatif]);

        $saw_topsis[$urutan]['nilai'] = $solusiIdealNegatifST[$id_alternatif]/($solusiIdealNegatifST[$id_alternatif]+$solusiIdealPositifST[$id_alternatif]); 
        $saw_topsis[$urutan]['id'] = $id_alternatif; 
        $saw_topsis_sen[$urutan]['id'] = $id_alternatif; 
        $saw_topsis_sen[$urutan]['nilai'] = $solusiIdealNegatifSTSen[$id_alternatif]/($solusiIdealNegatifSTSen[$id_alternatif]+$solusiIdealPositifSTSen[$id_alternatif]);  
        $urutan++;
    }
    $tmp2 = array();
    // urutin saw
    for($b = 0 ; $b < count($saw)-1 ;$b++){
        for($a = $b+1; $a < count($saw); $a++) {
            //pengurutan
            if($saw[$b]['nilai'] < $saw[$a]['nilai']) {
                $tmp2 = $saw[$b];
                $saw[$b] = $saw[$a];
                $saw[$a] = $tmp2;
            }
        }
    }
    for($b = 0 ; $b < count($saw) ;$b++){
        $rang = $b+1;
        $conn->query(" UPDATE `analisis_sensitifitas` SET `saw` = '$rang',`nilai_saw` = ".$saw[$b]['nilai']." WHERE `analisis_sensitifitas`.`id_alternatif` = ".$saw[$b]['id']);
    }
    // urutin saw sensitifitas
    for($b = 0 ; $b < count($saw_sen)-1 ;$b++){
        for($a = $b+1; $a < count($saw_sen); $a++) {
            //pengurutan
            if($saw_sen[$b]['nilai'] < $saw_sen[$a]['nilai']) {
                $tmp2 = $saw_sen[$b];
                $saw_sen[$b] = $saw_sen[$a];
                $saw_sen[$a] = $tmp2;
            }
        }
    }
    for($b = 0 ; $b < count($saw_sen) ;$b++){
        $rang = $b+1;
        $conn->query(" UPDATE `analisis_sensitifitas` SET `saw_sen` = '$rang',`nilai_saw_sen` = ".$saw_sen[$b]['nilai']." WHERE `analisis_sensitifitas`.`id_alternatif` = ".$saw_sen[$b]['id']);
    }
   // urutin topsis
   for($b = 0 ; $b < count($topsis)-1 ;$b++){
    for($a = $b+1; $a < count($topsis); $a++) {
        //pengurutan
        if($topsis[$b]['nilai'] < $topsis[$a]['nilai']) {
            $tmp2 = $topsis[$b];
            $topsis[$b] = $topsis[$a];
            $topsis[$a] = $tmp2;
        }
    }
    }
    for($b = 0 ; $b < count($topsis) ;$b++){
        $rang = $b+1;
        $conn->query(" UPDATE `analisis_sensitifitas` SET `topsis` = '$rang',`nilai_topsis` = ".$topsis[$b]['nilai']." WHERE `analisis_sensitifitas`.`id_alternatif` = ".$topsis[$b]['id']);
    }
    // urutin topsis sensitifitas
    for($b = 0 ; $b < count($topsis_sen)-1 ;$b++){
        for($a = $b+1; $a < count($topsis_sen); $a++) {
            //pengurutan
            if($topsis_sen[$b]['nilai'] < $topsis_sen[$a]['nilai']) {
                $tmp2 = $topsis_sen[$b];
                $topsis_sen[$b] = $topsis_sen[$a];
                $topsis_sen[$a] = $tmp2;
            }
        }
    }
    for($b = 0 ; $b < count($topsis_sen) ;$b++){
        $rang = $b+1;
        $conn->query(" UPDATE `analisis_sensitifitas` SET `topsis_sen` = '$rang',`nilai_topsis_sen` = ".$topsis_sen[$b]['nilai']." WHERE `analisis_sensitifitas`.`id_alternatif` = ".$topsis_sen[$b]['id']);
    }
    // urutin saw_topsis
   for($b = 0 ; $b < count($saw_topsis)-1 ;$b++){
    for($a = $b+1; $a < count($saw_topsis); $a++) {
        //pengurutan
        if($saw_topsis[$b]['nilai'] < $saw_topsis[$a]['nilai']) {
            $tmp2 = $saw_topsis[$b];
            $saw_topsis[$b] = $saw_topsis[$a];
            $saw_topsis[$a] = $tmp2;
        }
    }
    }
    for($b = 0 ; $b < count($saw_topsis) ;$b++){
        $rang = $b+1;
        $conn->query(" UPDATE `analisis_sensitifitas` SET `saw_topsis` = '$rang',`nilai_saw_topsis` = ".$saw_topsis[$b]['nilai']." WHERE `analisis_sensitifitas`.`id_alternatif` = ".$saw_topsis[$b]['id']);
    }
    // urutin saw_topsis sensitifitas
    for($b = 0 ; $b < count($saw_topsis_sen)-1 ;$b++){
        for($a = $b+1; $a < count($saw_topsis_sen); $a++) {
            //pengurutan
            if($saw_topsis_sen[$b]['nilai'] < $saw_topsis_sen[$a]['nilai']) {
                $tmp2 = $saw_topsis_sen[$b];
                $saw_topsis_sen[$b] = $saw_topsis_sen[$a];
                $saw_topsis_sen[$a] = $tmp2;
            }
        }
    }
    for($b = 0 ; $b < count($saw_topsis_sen) ;$b++){
        $rang = $b+1;
        $conn->query(" UPDATE `analisis_sensitifitas` SET `saw_topsis_sen` = '$rang',`nilai_saw_topsis_sen` = ".$saw_topsis_sen[$b]['nilai']." WHERE `analisis_sensitifitas`.`id_alternatif` = ".$saw_topsis_sen[$b]['id']);
    }

    $sqlAnalisis = "SELECT * FROM analisis_sensitifitas";
    $resultAnalisis = $conn->query($sqlAnalisis);

    $diffSaw = 0;
    $diffTopsis = 0;
    $diffSawTopsis = 0;
    while($analisis = $resultAnalisis->fetch_assoc()){
        if($analisis['saw'] != $analisis['saw_sen']){
            $diffSaw++;
        }
        if($analisis['topsis'] != $analisis['topsis_sen']){
            $diffTopsis++;
        }
        if($analisis['saw_topsis'] != $analisis['saw_topsis_sen']){
            $diffSawTopsis++;
        }
    }
    $sqlHasil = "INSERT INTO `hasil_sensitifitas` (`id`, `perubahan`, `saw`, `topsis`, `saw_topsis`) VALUES ('', '$perubahan', '$diffSaw', '$diffTopsis', '$diffSawTopsis')";
    $resultHasil = $conn->query($sqlHasil);

    header('location: form_analisis2.php');

?>