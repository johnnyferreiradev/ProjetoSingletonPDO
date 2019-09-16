<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class FilmeCategoria {

        private $categoriaId;
        private $filmeId;

        // Geters...

        public function getCategoriaId() {
            return $this->categoriaId;
        }

        public function getFilmeId() {
            return $this->filmeId;
        }

        // Seters...

        public function setCategoriaId($categoriaId) {
            $this->categoriaId = $categoriaId;
        }

        public function setFilmeId($filmeId) {
            $this->filmeId = $filmeId;
        }

        // Other methods...
        public function __construct($categoriaId = null, $filmeId = null) {
            $this->categoriaId = $categoriaId;
            $this->filmeId = $filmeId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO filme_categoria (filme_id, categoria_id, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->filmeId, $this->categoriaId, date('Y-m-d H:i:s')));
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
            $sql .= "DELETE FROM filme_categoria WHERE categoria_id = ? OR filme_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->categoriaId, $this->filmeId));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }