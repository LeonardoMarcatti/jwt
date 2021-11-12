<?php
    namespace api;
    setlocale(LC_ALL, "pt_BR.utf-8");
    header('Content-type: text/html; charset=utf-8');  

    include_once 'config/Database.php';
    include_once 'objects/Categorias.php';
    use api\config\objetcs\CategoriasDAO;
    use api\config\Database;

    $db = new Database();
    $conn = $db->getConnection();
    $categorias = new CategoriasDAO($conn);
    echo $categorias->getAll();

?>