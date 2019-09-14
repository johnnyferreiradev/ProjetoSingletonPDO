<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Pagamento {

        private $clienteId;
        private $funcionarioId;
        private $aluguelId;
        private $valor;
        private $dataPagamento;
        private $ultimaAtualizacao;
        private $pagamentoId;

        // Geters...
        public function getClienteId() {
            return $this->clienteId;
        }

        public function getFuncionarioId() {
            return $this->funcionarioId;
        }

        public function getAluguelId() {
            return $this->aluguelId;
        }

        public function getPagamentoId() {
            return $this->pagamentoId;
        }

        // Seters...
        public function setClienteId($clienteId) {
            $this->clienteId = $clienteId;
        }

        public function setFuncionarioId($funcionarioId) {
            $this->funcionarioId = $funcionarioId;
        }

        public function setAluguelId($aluguelId) {
            $this->aluguelId = $aluguelId;
        }

        public function setPagamentoId($pagamentoId) {
            $this->pagamentoId = $pagamentoId;
        }

        // Other methods...
        public function __construct($clienteId = null, $funcionarioId = null, $aluguelId = null, $valor =null, $dataPagamento = null, $ultimaAtualizacao = null, $pagamentoId = null) {
            // $this->clienteId = $clienteId;
            // $this->ultimaAtualizacao = $ultimaAtualizacao;
            // $this->pagamentoId = $pagamentoId;
        }

        public function __toString() {
            return
                "clienteId: ".$this->clienteId.
                "\nUltima atualização: ".$this->ultimaAtualizacao.
                "\nId: ".$this->pagamentoId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO clienteId (clienteId, ultima_atualizacao) VALUES(?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->clienteId, $this->ultimaAtualizacao));
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
            $sql = "UPDATE clienteId set clienteId = ?, ultima_atualizacao = ? WHERE clienteId_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->clienteId, $this->ultimaAtualizacao, $this->pagamentoId));
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
            $sql .= "DELETE FROM clienteId WHERE clienteId_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->pagamentoId));
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
            $sql = "SELECT * FROM clienteId WHERE clienteId_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->pagamentoId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM clienteId ORDER BY clienteId_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM clienteId ORDER BY clienteId_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }