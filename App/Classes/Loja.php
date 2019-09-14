<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Loja {

        private $ultimaAtualizacao;
        private $enderecoId;
        private $gerenteId;
        private $lojaId;

        // Geters...
        public function getUltimaAtualizacao() {
            return $this->ultimaAtualizacao;
        }

        public function getEnderecoId() {
            return $this->enderecoId;
        }

        public function getGerenteId() {
            return $this->gerenteId;
        }

        public function getLojaId() {
            return $this->lojaId;
        }

        // Seters...
        public function setUltimaAtualizacao($ultimaAtualizacao) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
        }

        public function setEnderecoId($enderecoId) {
            $this->enderecoId = $enderecoId;
        }

        public function setGerenteId($gerenteId) {
            $this->gerenteId = $gerenteId;
        }

        public function setLojaId($lojaId) {
            $this->lojaId = $lojaId;
        }

        // Other methods...
        public function __construct($enderecoId = null, $gerenteId = null, $lojaId = null, $ultimaAtualizacao = null) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
            $this->enderecoId = $enderecoId;
            $this->gerenteId = $gerenteId;
            $this->lojaId = $lojaId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO loja (gerente_id, endereco_id, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->gerenteId, $this->enderecoId, $this->ultimaAtualizacao));
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
            $sql .= "DELETE FROM loja WHERE gerente_id = ? OR endereco_id = ? OR loja_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->gerenteId, $this->enderecoId, $this->lojaId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }