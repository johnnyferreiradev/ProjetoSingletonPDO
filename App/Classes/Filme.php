<?php

    namespace App\Classes;

    use DB\Conexao;
    use PDO;

    class Filme {

        private $titulo;
        private $descricao;
        private $anoLancamento;
        private $idiomaId;
        private $idiomaOriginalId;
        private $duracaoLocacao;
        private $precoLocacao;
        private $duracaoFilme;
        private $custoSubstituicao;
        private $classificacao;
        private $recursosEspeciais;
        private $filmeId;

        // Geters...
        public function getIdiomaId() {
            return $this->idiomaId;
        }

        public function getIdiomaOriginalId() {
            return $this->idiomaOriginalId;
        }

        public function getFilmeId() {
            return $this->filmeId;
        }

        // Seters...
        public function setIdiomaId($idiomaId) {
            $this->idiomaId = $idiomaId;
        }

        public function setIdiomaOriginalId($idiomaOriginalId) {
            $this->idiomaOriginalId = $idiomaOriginalId;
        }

        public function setfilmeId($filmeId) {
            $this->filmeId = $filmeId;
        }

        // Other methods...
        public function __construct($titulo = null, $descricao = null, $anoLancamento = null, $idiomaId = null, $idiomaOriginalId = null, $duracaoLocacao = null, $precoLocacao = null, $duracaoFilme = null, $custoSubstituicao = null, $classificacao = null, $recursosEspeciais = null, $filmeId = null) {
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->anoLancamento = $anoLancamento;
            $this->idiomaId = $idiomaId;
            $this->idiomaOriginalId = $idiomaOriginalId;
            $this->duracaoLocacao = $duracaoLocacao;
            $this->precoLocacao = $precoLocacao;
            $this->duracaoFilme = $duracaoFilme;
            $this->custoSubstituicao = $custoSubstituicao;
            $this->classificacao = $classificacao;
            $this->recursosEspeciais = $recursosEspeciais;
            $this->filmeId = $filmeId;
        }

        public function save() {
            $pdo = Conexao::getInstance();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql =  "INSERT INTO filme (titulo, descricao, ano_de_lancamento, idioma_id, idioma_original_id, duracao_da_locacao, preco_da_locacao, duracao_do_filme, custo_de_substituicao, classificacao, recursos_especiais, ultima_atualizacao)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                    $this->titulo,
                    $this->descricao,
                    $this->anoLancamento,
                    $this->idiomaId,
                    $this->idiomaOriginalId,
                    $this->duracaoLocacao,
                    $this->precoLocacao,
                    $this->duracaoFilme,
                    $this->custoSubstituicao,
                    $this->classificacao,
                    $this->recursosEspeciais,
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
            $sql =  "UPDATE filme set titulo = ?, descricao = ?, ano_de_lancamento = ?, idioma_id = ?, idioma_original_id = ?, duracao_da_locacao = ?, preco_da_locacao = ?, duracao_do_filme = ?, custo_de_substituicao = ?, classificacao = ?, recursos_especiais = ?, ultima_atualizacao = ?
                    WHERE filme_id = ?";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array(
                $this->titulo,
                $this->descricao,
                $this->anoLancamento,
                $this->idiomaId,
                $this->idiomaOriginalId,
                $this->duracaoLocacao,
                $this->precoLocacao,
                $this->duracaoFilme,
                $this->custoSubstituicao,
                $this->classificacao,
                $this->recursosEspeciais,
                date('Y-m-d H:i:s'),
                $this->filmeId
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
            $sql .= "DELETE FROM filme WHERE filme_id = ?";
            $sql .= ";SET FOREIGN_KEY_CHECKS = 1;";
            $q = $pdo->prepare($sql);
            $result = $q->execute(array($this->filmeId));
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
            $sql = "SELECT * FROM filme WHERE filme_id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($this->filmeId));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Conexao::disconnect();

            return $data;
        }  
        
        public static function listAll() {
            $pdo = Conexao::getInstance();
            $sql = 'SELECT * FROM filme ORDER BY filme_id DESC';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }

        public static function paginate($start, $end) {
            $pdo = Conexao::getInstance();
            $sql = "SELECT * FROM filme ORDER BY filme_id DESC LIMIT $start, $end";
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
            Conexao::disconnect();

            return $data;
        }
    }