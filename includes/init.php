<?php

    include_once 'connection.php';
    

    
    for($i=1;$i<43;$i++) {
        $result = $conn->query("INSERT INTO `hasil`(`id_alternatif`) VALUES('$i')");
        if(!$result){
            echo "gagal";
        }
    }

?>