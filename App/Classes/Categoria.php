<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Categoria {

        private $nome;
        private $categoriaId;

        // Geters...
        public function getNome() {
            return $this->nome;
        }

        public function getCategoriaId() {
            return $this->categoriaId;
        }

        // Seters...
        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setCategoriaId($categoriaId) {
            $this->categoriaId = $categoriaId;
        }

        // Other methods...
        public function __construct($nome = null, $categoriaId = null) {
            $this->nome = $nome;
            $this->categoriaId = $categoriaId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO categoria (nome, ultima_atualizacao) VALUES(?,?)";
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
            $sql = "UPDATE categoria set nome = ?, ultima_atualizacao = ? WHERE categoria_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->nome, date('Y-m-d H:i:s'), $this->categoriaId));
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
            $sql .= "DELETE FROM categoria WHERE categoria_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->categoriaId));
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
            $sql = "SELECT * FROM categoria where categoria_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->categoriaId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM categoria ORDER BY categoria_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM categoria ORDER BY categoria_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }