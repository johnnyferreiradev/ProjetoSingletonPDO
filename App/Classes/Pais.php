<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Pais {

        private $pais;
        private $ultimaAtualizacao;
        private $paisId;

        // Geters...
        public function getPais() {
            return $this->pais;
        }

        public function getUltimaAtualizacao() {
            return $this->ultimaAtualizacao;
        }

        public function getPaisId() {
            return $this->paisId;
        }

        // Seters...
        public function setPais($pais) {
            $this->pais = $pais;
        }

        public function setUltimaAtualizacao($ultimaAtualizacao) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
        }

        public function setPaisId($paisId) {
            $this->paisId = $paisId;
        }

        // Other methods...
        public function __construct($pais = null, $ultimaAtualizacao = null, $paisId = null) {
            $this->pais = $pais;
            $this->ultimaAtualizacao = $ultimaAtualizacao;
            $this->paisId = $paisId;
        }

        public function __toString() {
            return
                "Pais: ".$this->pais.
                "\nUltima atualização: ".$this->ultimaAtualizacao.
                "\nId: ".$this->paisId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO pais (pais, ultima_atualizacao) VALUES(?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->pais, $this->ultimaAtualizacao));
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
            $result = $q->execute(array($this->pais, $this->ultimaAtualizacao, $this->paisId));
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
            $sql = "DELETE FROM pais WHERE pais_id = ?";
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
    }