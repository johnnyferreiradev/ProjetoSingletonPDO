<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Inventario {

        private $ultimaAtualizacao;
        private $inventarioId;
        private $filmeId;
        private $lojaId;

        // Geters...
        public function getUltimaAtualizacao() {
            return $this->ultimaAtualizacao;
        }

        public function getInventarioId() {
            return $this->inventarioId;
        }

        public function getFilmeId() {
            return $this->filmeId;
        }

        public function getLojaId() {
            return $this->lojaId;
        }

        // Seters...
        public function setUltimaAtualizacao($ultimaAtualizacao) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
        }

        public function setInventarioId($inventarioId) {
            $this->inventarioId = $inventarioId;
        }

        public function setFilmeId($filmeId) {
            $this->filmeId = $filmeId;
        }

        public function setLojaId($lojaId) {
            $this->lojaId = $lojaId;
        }

        // Other methods...
        public function __construct($inventarioId = null, $filmeId = null, $lojaId = null, $ultimaAtualizacao = null) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
            $this->inventarioId = $inventarioId;
            $this->filmeId = $filmeId;
            $this->lojaId = $lojaId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO inventario (filme_id, loja_id, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->filmeId, $this->lojaId, $this->ultimaAtualizacao));
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
            $sql .= "DELETE FROM inventario WHERE filme_id = ? OR loja_id = ? OR inventario_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->filmeId, $this->lojaId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }