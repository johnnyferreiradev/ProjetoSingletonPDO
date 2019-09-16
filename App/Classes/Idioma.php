<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Idioma {

        private $nome;
        private $idiomaId;

        // Geters...
        public function getNome() {
            return $this->nome;
        }

        public function getIdiomaId() {
            return $this->idiomaId;
        }

        // Seters...
        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setIdiomaId($idiomaId) {
            $this->idiomaId = $idiomaId;
        }

        // Other methods...
        public function __construct($nome = null, $idiomaId = null) {
            $this->nome = $nome;
            $this->idiomaId = $idiomaId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO idioma (nome, ultima_atualizacao) VALUES(?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->nome, date('Y-m-d H:i:s')));
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
            $sql = "UPDATE idioma set nome = ?, ultima_atualizacao = ? WHERE idioma_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->nome, date('Y-m-d H:i:s'), $this->idiomaId));
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
            $sql .= "DELETE FROM idioma WHERE idioma_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->idiomaId));
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
            $sql = "SELECT * FROM idioma WHERE idioma_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->idiomaId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM idioma ORDER BY idioma_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM idioma ORDER BY idioma_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }