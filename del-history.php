<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "spkprodi2";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $id = $_GET['id'];

    $sql = "DELETE FROM `hasil_sensitifitas` WHERE `hasil_history`.`id` = $id";

    if($id == "all"){
        $sql =  "TRUNCATE TABLE `hasil_sensitifitas`";
    }

    $conn->query($sql);


    $sqlKrit = "SELECT * FROM kriteria";
    $result = $conn->query($sqlKrit);
    while($row = $result->fetch_assoc()) {
        $sqlUpdate = "UPDATE kriteria SET bobot_stvitas = ".$row['bobot_kriteria']." WHERE id_kriteria = ".$row['id_kriteria'];
        echo $sqlUpdate;
        $conn->query($sqlUpdate);
    }

    header('location: form_analisis.php');


?>