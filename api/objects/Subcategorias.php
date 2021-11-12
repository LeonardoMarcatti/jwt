<?php
    namespace api\config\objetcs;

    require_once 'Categorias.php';
    use PDO;

    interface SubcatDAO{
        public function addSubcategoria(Subcategorias $s);
    };
    class Subcategorias
    {
        private string $idml, $nome, $itens, $id_mae;

        public function setIDML(string $idml)
        {
            $this->idml = $idml;
        }

        public function setNome(string $nome)
        {
            $this->nome = $nome;
        }

        public function setItens(string $itens)
        {
            $this->itens = $itens;
        }

        public function setIDMAE(string $id_mae)
        {
            $this->id_mae = $id_mae;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function getIDML()
        {
            return $this->idml;
        }

        public function getItens()
        {
            return $this->itens;
        }

        public function getIDMAE()
        {
            return $this->id_mae;
        }
    }
    class SubcategoriasDAO implements SubcatDAO
    {   
        private object $conn;

        public function __construct(object $db)
        {
            $this->conn = $db;
        }

        public function addSubcategoria(Subcategorias $s)
        {
            $sql = "insert into subcategorias(id_ml, nome, itens, idcategoria) values(:id_ml, :nome, :itens, :id)";
            $insert = $this->conn->prepare($sql);
            $insert->bindValue(':id_ml', $s->getIDML());
            $insert->bindValue(':nome', $s->getNome());
            $insert->bindValue(':itens', $s->getItens());
            $insert->bindValue(':id', $s->getIDMAE());
            $insert->execute();
            return true;
        }
    };

?>