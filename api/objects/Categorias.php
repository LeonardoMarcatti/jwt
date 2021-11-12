<?php
    namespace api\config\objetcs;

    use PDO;

    class Categorias
    {   
        private object $conn;
        private string $nome, $descricao;
        private int $id;

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

        public function getDescricao(int $id)
        {
            $sql = 'select descricao from categorias where id = :id';
            $select = $this->conn->prepare($sql);
            $select->bindValue(':id', $id);
            $select->execute();
            $result = $select->fetch(PDO::FETCH_ASSOC)['descricao'];
            return $result;
        }

        public function addCategoria($id, $cat)
        {
            $sql = "insert into categorias(id_ml, nome) values(:id_ml, :nome)";
            $insert = $this->conn->prepare($sql);
            $insert->bindValue(':id_ml', $id);
            $insert->bindValue(':nome', $cat);
            $insert->execute();
            return true;
        }

        public function getID($id)
        {
            $sql = 'select id from categorias where id_ml = :idml';
            $select = $this->conn->prepare($sql);
            $select->bindValue(':idml', $id);
            $select->execute();
            return $select->fetch(PDO::FETCH_ASSOC)['id'];
        }

    };

?>