<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Ator {

        private $primeiroNome;
        private $ultimoNome;
        private $ultimaAtualizacao;

        // Geters...
        public function getPrimeiroNome() {
            return $this->primeiroNome;
        }

        public function getUltimoNome() {
            return $this->ultimoNome;
        }

        public function getUltimaAtualizacao() {
            return $this->ultimaAtualizacao;
        }

        // Seters...
        public function setPrimeiroNome($primeiroNome) {
            $this->primeiroNome = $primeiroNome;
        }

        public function setUltimoNome($ultimoNome) {
            $this->ultimoNome = $ultimoNome;
        }

        public function setUltimaAtualizacao($ultimaAtualizacao) {
            $this->ultimaAtualizacao = $ultimaAtualizacao;
        }

        // Other methods...
        public function __toString() {
            return
                "Primeiro nome: ".$this->primeiroNome.
                "\nUltimo nome: ".$this->ultimoNome.
                "\nUltima atualização: ".$this->ultimaAtualizacao;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO ator (primeiro_nome, ultimo_nome, ultima_atualizacao) VALUES(?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->primeiroNome, $this->ultimoNome, $this->ultimaAtualizacao));
            Conexao::disconnect();

            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function update() {
            // logica para atualizar cliente no banco
        }
        public function remove() {
            // logica para remover cliente do banco
        }
        public function listAll() {
            // logica para listar toodos os clientes do banco
        }    

        public function atorTeste() {
            echo "Funcionou";
        }
    }