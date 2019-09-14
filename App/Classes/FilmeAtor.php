<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class FilmeAtor {

        private $ultimaAtualizacao;
        private $atorId;
        private $filmeId;

        // Geters...
        public function getUltimaAtualizacao() {
            return $this->ultimaAtualizacao;
        }

        public function getAtorId() {
            return $this->atorId;
        }

        public function getFilmeId() {
            return $this->filmeId;
        }

        // Seters...
        public function setUltimaAtualizacao($ultimaAtualizacao) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
        }

        public function setAtorId($atorId) {
            $this->atorId = $atorId;
        }

        public function setFilmeId($filmeId) {
            $this->filmeId = $filmeId;
        }

        // Other methods...
        public function __construct($atorId = null, $filmeId = null, $ultimaAtualizacao = null) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
            $this->atorId = $atorId;
            $this->filmeId = $filmeId;
        }

        public function __toString() {
            return
                "\nUltima atualização: ".$this->ultimaAtualizacao.
                "\nId do ator: ".$this->atorId.
                "\nId do filme: ".$this->filmeId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO filme_ator (ator_id, filme_id, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->atorId, $this->filmeId, $this->ultimaAtualizacao));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        // public function update() {
        //     $pdo = Conexao::getInstance();
        //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     $sql = "UPDATE filme_ator set ator_id = ?, filme_id = ?, ultima_atualizacao = ? WHERE ator_id = ? AND filme_id = ?";
        //     $q = $pdo->prepare($sql);
        //     $result = $q->execute(array($this->primeiroNome, $this->ultimoNome, $this->ultimaAtualizacao, $this->atorId));
        //     Conexao::disconnect();

        //     if ($result) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        
        public function remove() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM filme_ator WHERE ator_id = ? OR filme_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->atorId, $this->filmeId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        // public function findById() {
        //     $pdo = Conexao::getInstance();
        //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     $sql = "SELECT * FROM ator where ator_id = ?";
        //     $q = $pdo->prepare($sql);
        //     $q->execute(array($this->atorId));
        //     $data = $q->fetch(PDO::FETCH_ASSOC);
        //     Conexao::disconnect();

        //     return $data;
        // }  
        
        // public static function listAll() {
        //     $pdo = Conexao::getInstance();
        //     $sql = 'SELECT * FROM ator ORDER BY ator_id DESC';
        //     $q = $pdo->query($sql);
        //     $data = $q->fetchAll();
        //     Conexao::disconnect();

        //     return $data;
        // }

        // public static function paginate($start, $end) {
        //     $pdo = Conexao::getInstance();
        //     $sql = "SELECT * FROM ator ORDER BY ator_id DESC LIMIT $start, $end";
        //     $q = $pdo->query($sql);
        //     $data = $q->fetchAll();
        //     Conexao::disconnect();

        //     return $data;
        // }
    }