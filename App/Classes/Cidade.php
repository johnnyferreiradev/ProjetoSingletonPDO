<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Cidade {

        private $paisId;
        private $cidade;
        private $cidadeId;

        // Geters...
        public function getPaisId() {
            return $this->paisId;
        }

        public function getCidade() {
            return $this->cidade;
        }

        public function getCidadeId() {
            return $this->cidadeId;
        }

        // Seters...
        public function setPaisId($paisId) {
            $this->paisId = $paisId;
        }

        public function setCidade($cidade) {
            $this->cidade = $cidade;
        }

        public function setCidadeId($cidadeId) {
            $this->cidadeId = $cidadeId;
        }

        // Other methods...
        public function __construct($paisId = null, $cidade = null, $cidadeId = null) {
            $this->paisId = $paisId;
            $this->cidade = $cidade;
            $this->cidadeId = $cidadeId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO cidade (cidade, pais_id, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->cidade, $this->paisId, date('Y-m-d H:i:s')));
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
            $sql = "SET FOREIGN_KEY_CHECKS = 0;";
            $sql .= "UPDATE cidade set cidade = ?, pais_id = ?, ultima_atualizacao = ? WHERE cidade_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->cidade, $this->paisId, date('Y-m-d H:i:s'), $this->cidadeId));
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
            $sql .= "DELETE FROM cidade WHERE cidade_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->cidadeId));
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
            $sql = "SELECT * FROM cidade WHERE cidade_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->cidadeId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM cidade ORDER BY cidade_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM cidade ORDER BY cidade_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }