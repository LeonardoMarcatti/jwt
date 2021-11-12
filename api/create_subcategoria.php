<?php
    namespace api;

    include_once 'config/Database.php';
    include_once 'objects/Categorias.php';
    include_once 'objects/Subcategorias.php';
    use api\config\objetcs\Categorias;
    use api\config\objetcs\Subcategorias;
    use api\config\Database;

    $db = new Database();
    $conn = $db->getConnection();
    $cat = new Categorias($conn);
    $sub = new Subcategorias($conn);
    $data = json_decode(file_get_contents("php://input"));
    $id = $cat->getID($data->id_mae);
    $sub->addSubcategoria($data->element->id, $data->element->name, $data->element->total_items_in_this_category, $id);
    return true;
?>