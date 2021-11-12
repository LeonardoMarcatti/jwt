<?php
    namespace api;

    include_once 'config/Database.php';
    include_once 'objects/Categorias.php';
    use api\config\objetcs\Categorias;
    use api\config\objetcs\CategoriasDAO;
    use api\config\Database;

    $db = new Database();
    $conn = $db->getConnection();
    $cat = new Categorias();
    $dao = new CategoriasDAO($conn);
    $data = json_decode(file_get_contents("php://input"));
    $cat->setIDML($data->id);
    $cat->setNome($data->name);
    $dao->addCategoria($cat);
    
?>