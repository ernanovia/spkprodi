<?php
    class Bobot{
        private $conn;
        private $table_name = 'bobot_alternatif';

        public $id_bobot_alter;
        public $id_alternatif;
        public $id_kriteria;
        public $bobot_alternatif;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        //fungsi menampilkan semua data 
        function readAll(){
            $query = "SELECT * FROM ".$this->table_name." ORDER BY id_bobot_alter ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
        // fungsi memanggil nilai berdsarkan id alternatif
        function readR($a){
            $query = " SELECT * FROM alternatif a, kriteria k, bobot_alternatif r WHERE a.id_alternatif=r.id_alternatif and k.id_kriteria=r.id_kriteria and r.id_alternatif='$a'";
            $stmt =$this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
         // fungsi untuk mencari nilai min saw
        function readMax($b){    
            $query = " SELECT max(bobot_alternatif) as max FROM " .$this->table_name. " WHERE id_kriteria='$b' LIMIT 0,1";
            $stmt =$this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        // fungsi untuk mencari nilai max saw
        function readMin($b){    
            $query = " SELECT min(bobot_alternatif) as min FROM " .$this->table_name. " WHERE id_kriteria='$b' LIMIT 0,1";
            $stmt =$this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        
        // fungsi pembagi untuk normalisasi topsis
        public function pembagi($id){
            $query = "SELECT bobot_alternatif from bobot_alternatif WHERE id_kriteria='$id' ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $pembagi = 0;
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pangkat = pow($data['bobot_alternatif'],2);
                $pembagi += $pangkat;
            }
            $hasil = sqrt($pembagi);
            return $hasil;
        }

        function readBobot(){
            $query = "SELECT bobot_alternatif FROM ".$this->table_name." 
                    WHERE 
                        id_kriteria = ".$this->id_kriteria." 
                    AND 
                        id_alternatif = ".$this->id_alternatif.";";
            $stmt = $this->conn->query($query);
            $result = $stmt->fetch();
    
            $bobot = $result[0];
    
            return $bobot;
        }
        // READ BOBOT
        // function readBobot(){
        //     $query = "SELECT bobot_alternatif FROM ".$this->table_name." 
        //     WHERE 
        //         id_kriteria = ".$this->id_kriteria." 
        //     AND
        //         id_alternatif = ".$this->id_alternatif.";";
        //     $stmt = $this->conn->query($query);
        //     $result->$stmt->fetch();

        //     $bobot = $result[0];
            
        //     return $bobot;
        // }
    }
?>



