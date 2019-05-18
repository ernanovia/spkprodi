<?php
    class Alternatif{
        private $conn;
        private $table_name = 'alternatif';

        public $id_alternatif;
        public $nama_prodi;
        public $akreditasi;
        public $fakultas;

        public function __construct($db)
        {
            $this->conn = $db;
        }



        //membaca semua data alternatif
        function readAll(){
            
            $query = "SELECT * FROM ".$this->table_name." ORDER BY id_alternatif ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        function readOne(){
            $query = "SELECT * FROM " .$this->table_name. " WHERE id_alternatif=? Limit 0,1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id_alternatif'];
            $this->nama = $row['nama_prodi'];
            $this->akreditasi = $row['akreditasi'];
            $this->fakultas = $row['fakultas'];
        }
        
        function readId(){
            $query = "SELECT id_alternatif FROM ".$this->table_name.";";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $id_alternatif = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            return $id_alternatif;
        }

        // read nama alternatif
        function readNama(){
            $query = "SELECT nama_prodi FROM ".$this->table_name.";";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $nama_prodi = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
            return $nama_prodi;
        }

        function jmlAlternativ(){
            $query = "SELECT COUNT(id_alternatif) FROM ".$this->table_name.";";
            $stmt = $this->conn->query($query);
            $result = $stmt->fetch();

            $count = $result[0];

            return $count;
        }
        
    }
?>