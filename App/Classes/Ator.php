<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Ator {

        private $primeiroNome;
        private $ultimoNome;
        private $ultimaAtualizacao;
        private $atorId;

        // Geters...
        public function getPrimeiroNome() {
            return $this->primeiroNome;
        }

        public function getUltimoNome() {
            return $this->ultimoNome;
        }

        public function getUltimaAtualizacao() {
            return $this->ultimaAtualizacao;
        }

        public function getAtorId() {
            return $this->atorId;
        }

        // Seters...
        public function setPrimeiroNome($primeiroNome) {
            $this->primeiroNome = $primeiroNome;
        }

        public function setUltimoNome($ultimoNome) {
            $this->ultimoNome = $ultimoNome;
        }

        public function setUltimaAtualizacao($ultimaAtualizacao) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
        }

        public function setAtorId($atorId) {
            $this->atorId = $atorId;
        }

        // Other methods...
        public function __toString() {
            return
                "Primeiro nome: ".$this->primeiroNome.
                "\nUltimo nome: ".$this->ultimoNome.
                "\nUltima atualização: ".$this->ultimaAtualizacao.
                "\nId: ".$this->atorId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO ator (primeiro_nome, ultimo_nome, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->primeiroNome, $this->ultimoNome, $this->ultimaAtualizacao));
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
            $sql = "UPDATE ator set primeiro_nome = ?, ultimo_nome = ?, ultima_atualizacao = ? WHERE ator_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->primeiroNome, $this->ultimoNome, $this->ultimaAtualizacao, $this->atorId));
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
            $sql = "DELETE FROM ator where ator_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->atorId));
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
            $sql = "SELECT * FROM ator where ator_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->atorId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM ator ORDER BY ator_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }