<?php
    class Hasil{
        private $conn;
        private $table_name = 'hasil';

        public $id_hasil;
        public $id_alternatif;
        public $hasil_saw;
        public $hasil_topsis;

        public function __construct($db)
        {
            $this->conn = $db;
        }
        public function insertHasilSAW(){
            $query = "INSERT INTO ".$this->table_name." VALUES('',?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->$id_alternatif);
            $stmt->bindParam(2, $this->$hasilSAW);
            return $stmt;
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
    }
?>    