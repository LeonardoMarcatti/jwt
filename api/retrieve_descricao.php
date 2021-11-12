<?php
    namespace api;

    include_once 'config/Database.php';
    include_once 'objects/Categorias.php';
    use api\config\objetcs\Categorias;
    use api\config\Database;

    $db = new Database();
    $conn = $db->getConnection();
    $descricao = new Categorias($conn);
    $id = json_decode(file_get_contents("php://input"));
    echo $descricao->getDescricao($id);

?>