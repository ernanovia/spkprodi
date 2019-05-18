<?php
    class Kriteria{
        private $conn;
        private $table_name = 'kriteria';

        public $id_kriteria;
        public $nama_kriteria;
        public $tipe_kriteria;
        public $bobot_kriteria;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        //fungsi read data
        function readAll(){
            $query = "SELECT * FROM ".$this->table_name." ORDER BY id_kriteria ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
        
        // read id kriteria
        function idKriteriaY(){
            $query = "SELECT id_kriteria FROM ".$this->table_name." WHERE status ='ya'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $kriteria_id = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
            return $kriteria_id;
        }
        // fungsi tipe berdasarkan kriteria
        function readTipe(){
            $query = "SELECT tipe_kriteria FROM ".$this->table_name." WHERE id_kriteria = ".$this->id_kriteria.";";
            $stmt = $this->conn->query($query);
            $result = $stmt->fetch();
            $tipe = $result[0];
            return $tipe;
        }
        // read jmlkriteriaYa
        function jmlYa(){
        $query = "SELECT COUNT(id_kriteria) FROM ".$this->table_name." WHERE status ='ya'";
        $stmt = $this->conn->query($query);
        $result = $stmt->fetch();
		$count = $result[0];

		return $count;
        }
        function readSumBobot(){    
            $query = " SELECT SUM(bobot_kriteria) as sum FROM " .$this->table_name;
            $stmt =$this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        function readSum(){    
            $query = " SELECT SUM(bobot_stvitas) as sum FROM " .$this->table_name;
            $stmt =$this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        }
        
    }
?>