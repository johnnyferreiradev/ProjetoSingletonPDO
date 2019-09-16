<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Endereco {

        private $endereco;
        private $endereco2;
        private $bairro;
        private $cidadeId;
        private $cep;
        private $telefone;
        private $enderecoId;

        // Geters...
        public function getCidadeId() {
            return $this->cidadeId;
        }

        public function getEnderecoId() {
            return $this->enderecoId;
        }

        // Seters...
        
        public function setCidadeId($cidadeId) {
            $this->cidadeId = $cidadeId;
        }

        public function setEnderecoId($enderecoId) {
            $this->enderecoId = $enderecoId;
        }

        // Other methods...
        public function __construct($endereco = null, $endereco2 = null, $bairro = null, $cidadeId = null, $cep = null, $telefone = null, $enderecoId = null) {
            $this->endereco = $endereco;
            $this->endereco2 = $endereco2;
            $this->bairro = $bairro;
            $this->cidadeId = $cidadeId;
            $this->cep = $cep;
            $this->telefone = $telefone;
            $this->enderecoId = $enderecoId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql =  "INSERT INTO endereco (endereco, endereco2, bairro, cidade_id, cep, telefone, ultima_atualizacao)
                    VALUES(?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                    $this->endereco,
                    $this->endereco2,
                    $this->bairro,
                    $this->cidadeId,
                    $this->cep,
                    $this->telefone,
                    date('Y-m-d H:i:s')
                ));
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
            $sql =  "UPDATE endereco set endereco = ?, endereco2 = ?, bairro = ?, cidade_id = ?, cep = ?, telefone = ?, ultima_atualizacao = ? 
                    WHERE endereco_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                $this->endereco,
                $this->endereco2,
                $this->bairro,
                $this->cidadeId,
                $this->cep,
                $this->telefone,
                date('Y-m-d H:i:s'),
                $this->enderecoId
            ));
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
            $sql .= "DELETE FROM endereco WHERE endereco_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->enderecoId));
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
            $sql = "SELECT * FROM endereco WHERE endereco_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->enderecoId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM endereco ORDER BY endereco_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM endereco ORDER BY endereco_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }