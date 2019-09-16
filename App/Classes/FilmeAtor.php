<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class FilmeAtor {

        private $atorId;
        private $filmeId;

        // Geters..
        public function getAtorId() {
            return $this->atorId;
        }

        public function getFilmeId() {
            return $this->filmeId;
        }

        // Seters...
        public function setAtorId($atorId) {
            $this->atorId = $atorId;
        }

        public function setFilmeId($filmeId) {
            $this->filmeId = $filmeId;
        }

        // Other methods...
        public function __construct($atorId = null, $filmeId = null) {
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
            $result = $q->execute(array($this->atorId, $this->filmeId, date('Y-m-d H:i:s')));
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
            $sql .= "DELETE FROM filme_ator WHERE ator_id = ? OR filme_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->atorId, $this->filmeId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }