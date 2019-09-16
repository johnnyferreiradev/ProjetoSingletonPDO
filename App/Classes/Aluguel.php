<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Aluguel {

        private $dataAluguel;
        private $inventarioId;
        private $clienteId;
        private $dataDevolucao;
        private $funcionarioId;
        private $aluguelId;

        // Geters...
        
        public function getInventarioId() {
            return $this->inventarioId;
        }

        public function getClienteId() {
            return $this->clienteId;
        }

        public function getFuncionarioId() {
            return $this->funcionarioId;
        }

        public function getAluguelId() {
            return $this->aluguelId;
        }

        // Seters...
        public function setInventarioId($inventarioId) {
            $this->inventarioId = $inventarioId;
        }

        public function setClienteId($clienteId) {
            $this->clienteId = $clienteId;
        }

        public function setFuncionarioId($funcionarioId) {
            $this->funcionarioId = $funcionarioId;
        }

        public function setAluguelId($aluguelId) {
            $this->aluguelId = $aluguelId;
        }

        // Other methods...
        public function __construct($dataAluguel = null, $inventarioId = null, $clienteId = null, $dataDevolucao = null, $funcionarioId = null, $aluguelId = null) {
            $this->dataAluguel = $dataAluguel;
            $this->inventarioId = $inventarioId;
            $this->clienteId = $clienteId;
            $this->dataDevolucao = $dataDevolucao;
            $this->funcionarioId = $funcionarioId;
            $this->aluguelId = $aluguelId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql =  "INSERT INTO aluguel (
                        data_de_aluguel,
                        inventario_id,
                        cliente_id,
                        data_de_devolucao,
                        funcionario_id,
                        ultima_atualizacao
                    )
                    VALUES(?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                        $this->dataAluguel,
                        $this->inventarioId,
                        $this->clienteId,
                        $this->dataDevolucao,
                        $this->funcionarioId,
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
            $sql =  "UPDATE aluguel set data_de_aluguel = ?, inventario_id = ?, cliente_id = ?, data_de_devolucao = ?, funcionario_id = ?, ultima_atualizacao = ? 
                    WHERE aluguel_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                        $this->dataAluguel,
                        $this->inventarioId,
                        $this->clienteId,
                        $this->dataDevolucao,
                        $this->funcionarioId,
                        date('Y-m-d H:i:s'),
                        $this->aluguelId
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
            $sql .= "DELETE FROM aluguel WHERE aluguel_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->aluguelId));
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
            $sql = "SELECT * FROM aluguel WHERE aluguel_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->aluguelId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM aluguel ORDER BY aluguel_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM aluguel ORDER BY aluguel_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }