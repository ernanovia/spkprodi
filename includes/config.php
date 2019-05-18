<!--  note :
 analisiskos  :  prodi
 tabel rangking  = tabel bobot_alternatif
 tabel nilai = tabel subkriteria 

 
 nama atribut 
  analisiskos  :  prodi 
  CEK GAMBAR DESAIN DATABASE (IRSA & PRODI)


-->

<?php
    class Config{
        private $host = "localhost";
        private $db_name = "spkprodi2";
        private $username = "root";
        private $password = "";
        public $conn;

        public function getConnection(){
            $this->conn = null;

            try{
            
                $this->conn = new PDO("mysql:host=" .$this->host. ";dbname=" .$this->db_name, $this->username, $this->password);
            }catch(PDOException $exception){
                echo "Connection error:" .$exception->getMessage();
            }
            return $this->conn;
        }
    }
?>


