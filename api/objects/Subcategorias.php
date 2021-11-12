<?php
    namespace api\config\objetcs;

    require_once 'Categorias.php';
    use Caregorias;

    use PDO;

    class Subcategorias
    {   
        private object $conn;
        private string $nome, $descricao;

        public function __construct(object $db)
        {
            $this->conn = $db;
        }

        public function addSubcategoria($id, $nome, $itens, $idcat)
        {
            $sql = "insert into subcategorias(id_ml, nome, itens, idcategoria) values(:id_ml, :nome, :itens, :id)";
            $insert = $this->conn->prepare($sql);
            $insert->bindValue(':id_ml', $id);
            $insert->bindValue(':nome', $nome);
            $insert->bindValue(':itens', $itens);
            $insert->bindValue(':id', $idcat);
            $insert->execute();
            return true;
        }
    };

?>