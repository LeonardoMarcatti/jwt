<?php
    namespace api;

    include_once 'config/Database.php';
    include_once 'objects/Categorias.php';
    include_once 'objects/Subcategorias.php';
    use api\config\objetcs\CategoriasDAO;
    use api\config\objetcs\Subcategorias;
    use api\config\objetcs\SubcategoriasDAO;
    use api\config\Database;

    $db = new Database();
    $conn = $db->getConnection();
    $catDAO = new CategoriasDAO($conn);
    $sub = new Subcategorias();
    $subDAO = new SubcategoriasDAO($conn);
    $data = json_decode(file_get_contents("php://input"));
    $id = $catDAO->getID($data->id_mae);
    $sub->setIDMAE($id);
    $sub->setItens($data->element->total_items_in_this_category);
    $sub->setNome($data->element->name);
    $sub->setIDML($data->element->id);
    $subDAO->addSubcategoria($sub);    

    return true;
?>