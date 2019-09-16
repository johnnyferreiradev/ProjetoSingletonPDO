<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Pais {

        private $pais;
        private $paisId;

        // Geters...
        public function getPais() {
            return $this->pais;
        }

        public function getPaisId() {
            return $this->paisId;
        }

        // Seters...
        public function setPais($pais) {
            $this->pais = $pais;
        }

        public function setPaisId($paisId) {
            $this->paisId = $paisId;
        }

        // Other methods...
        public function __construct($pais = null, $paisId = null) {
            $this->pais = $pais;
            $this->paisId = $paisId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO pais (pais, ultima_atualizacao) VALUES(?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->pais, date('Y-m-d H:i:s')));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function update() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE pais set pais = ?, ultima_atualizacao = ? WHERE pais_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->pais, date('Y-m-d H:i:s'), $this->paisId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        
        public function remove() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";
            $sql .= "DELETE FROM pais WHERE pais_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->paisId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function findById() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM pais WHERE pais_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->paisId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM pais ORDER BY pais_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM pais ORDER BY pais_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }