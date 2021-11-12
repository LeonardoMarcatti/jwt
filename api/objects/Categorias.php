<?php
    namespace api\config\objetcs;

    use PDO;

    interface CatDAO{
        public function getAll();
        public function addCategoria(Categorias $c);
        public function getID(string $id);
    }

    class Categorias
    {
        private string $idml, $nome;

        public function setIDML(string $idml)
        {
            $this->idml = $idml;
        }

        public function setNome(string $nome)
        {
            $this->nome = $nome;
        }

        public function getIDML()
        {
            return $this->idml;
        }

        public function getNome()
        {
            return $this->nome;
        }

    };
    
    class CategoriasDAO implements CatDAO
    {   
        private object $conn;

        public function __construct(object $db)
        {
            $this->conn = $db;
        }

        public function getAll()
        {
            $sql = 'select id, nome from categorias order by nome asc';
            $select = $this->conn->prepare($sql);
            $select->execute();
            $all = $select->fetchAll(PDO:: FETCH_ASSOC);
            $list = [];

            foreach ($all as $key => $value) {
                $list[] = $value;
            };

            return json_encode($list);
        }

        public function addCategoria(Categorias $c)
        {
            $sql = "insert into categorias(id_ml, nome) values(:id_ml, :nome)";
            $insert = $this->conn->prepare($sql);
            $insert->bindValue(':id_ml', $c->getIDML());
            $insert->bindValue(':nome', $c->getNome());
            $insert->execute();
            return true;
        }

        public function getID(string $id)
        {
            $sql = 'select id from categorias where id_ml = :idml';
            $select = $this->conn->prepare($sql);
            $select->bindValue(':idml', $id);
            $select->execute();
            return $select->fetch(PDO::FETCH_ASSOC)['id'];
        }

    };

?>