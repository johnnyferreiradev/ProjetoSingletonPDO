<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Funcionario {

        private $primeiroNome;
        private $ultimoNome;
        private $enderecoId;
        private $foto;
        private $email;
        private $lojaId;
        private $ativo;
        private $usuario;
        private $senha;
        private $ultimaAtualizacao;
        private $funcionarioId;

        // Geters...
        public function getEnderecoId() {
            return $this->enderecoId;
        }

        public function getLojaId() {
            return $this->lojaId;
        }

        public function getFuncionarioId() {
            return $this->funcionarioId;
        }

        // Seters...
        public function setEnderecoId($enderecoId) {
            $this->enderecoId = $enderecoId;
        }

        public function setLojaId($lojaId) {
            $this->lojaId = $lojaId;
        }

        public function setFuncionarioId($funcionarioId) {
            $this->funcionarioId = $funcionarioId;
        }

        // Other methods...
        public function __construct($primeiroNome = null, $ultimoNome = null, $enderecoId = null, $foto = null, $email = null, $lojaId = null, $ativo = null, $usuario = null, $senha = null, $ultimaAtualizacao = null, $funcionarioId = null) {
            $this->primeiroNome = $primeiroNome;
            $this->ultimoNome = $ultimoNome;
            $this->enderecoId = $enderecoId;
            $this->foto = $foto;
            $this->email = $email;
            $this->lojaId = $lojaId;
            $this->ativo = $ativo;
            $this->usuario = $usuario;
            $this->senha = $senha;
            $this->ultimaAtualizacao = $ultimaAtualizacao;
            $this->funcionarioId = $funcionarioId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql =  "INSERT INTO funcionario (primeiro_nome, ultimo_nome, endereco_id, foto, email, loja_id, ativo, usuario, senha, ultima_atualizacao)
                    VALUES(?,?,?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                    $this->primeiroNome,
                    $this->ultimoNome,
                    $this->enderecoId,
                    $this->foto,
                    $this->email,
                    $this->lojaId,
                    $this->ativo,
                    $this->usuario,
                    $this->senha,
                    $this->ultimaAtualizacao
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
            $sql = "UPDATE ator set primeiro_nome = ?, ultimo_nome = ?, endereco_id = ?, foto = ?, email = ?, loja_id = ?, ativo = ?, usuario = ?, senha = ?, ultima_atualizacao = ? WHERE funcionario_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                    $this->primeiroNome,
                    $this->ultimoNome,
                    $this->enderecoId,
                    $this->foto,
                    $this->email,
                    $this->lojaId,
                    $this->ativo,
                    $this->usuario,
                    $this->senha,
                    $this->ultimaAtualizacao,
                    $this->funcionarioId
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
            $sql .= "DELETE FROM funcionario WHERE funcionario_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->funcionarioId));
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
            $sql = "SELECT * FROM funcionario WHERE funcionario_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->funcionarioId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM funcionario ORDER BY funcionario_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM funcionario ORDER BY funcionario_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }