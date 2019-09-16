<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Cliente {

        private $lojaId;
        private $primeiroNome;
        private $ultimoNome;
        private $email;
        private $enderecoId;
        private $ativo;
        private $dataCriacao;
        private $clienteId;

        // Geters...
        public function getLojaId() {
            return $this->lojaId;
        }

        public function getEnderecoId() {
            return $this->enderecoId;
        }

        public function getClienteId() {
            return $this->clienteId;
        }

        // Seters...
        
        public function setLojaId($lojaId) {
            $this->lojaId = $lojaId;
        }

        public function setEnderecoId($enderecoId) {
            $this->enderecoId = $enderecoId;
        }

        public function setClienteId($clienteId) {
            $this->clienteId = $clienteId;
        }

        // Other methods...
        public function __construct($lojaId = null, $primeiroNome = null, $ultimoNome = null, $email = null, $enderecoId = null, $ativo = null, $dataCriacao = null, $clienteId = null) {
            $this->lojaId = $lojaId;
            $this->primeiroNome = $primeiroNome;
            $this->ultimoNome = $ultimoNome;
            $this->email = $email;
            $this->enderecoId = $enderecoId;
            $this->ativo = $ativo;
            $this->dataCriacao = $dataCriacao;
            $this->clienteId = $clienteId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql =  "INSERT INTO cliente (loja_id, primeiro_nome, ultimo_nome, email, endereco_id, ativo, data_criacao, ultima_atualizacao)
                    VALUES(?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                    $this->lojaId,
                    $this->primeiroNome,
                    $this->ultimoNome,
                    $this->email,
                    $this->enderecoId,
                    $this->ativo,
                    $this->dataCriacao,
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
            $sql =  "UPDATE cliente set loja_id = ?, primeiro_nome = ?, ultimo_nome = ?, email = ?, endereco_id = ?, ativo = ?, data_criacao = ?, ultima_atualizacao = ? 
                    WHERE cliente_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                $this->lojaId,
                $this->primeiroNome,
                $this->ultimoNome,
                $this->email,
                $this->enderecoId,
                $this->ativo,
                $this->dataCriacao,
                date('Y-m-d H:i:s'),
                $this->clienteId
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
            $sql .= "DELETE FROM cliente WHERE cliente_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->clienteId));
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
            $sql = "SELECT * FROM cliente WHERE cliente_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->clienteId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM cliente ORDER BY cliente_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM cliente ORDER BY cliente_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }