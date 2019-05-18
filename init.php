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

for($i=1;$i<=42;$i++) {
        $result = $conn->query("INSERT INTO `analisis_sensitifitas`(`id_alternatif`) VALUES('$i')");
        if(!$result){
            echo "gagal";
        }
    }
?>