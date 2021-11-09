<?php
    //namespace api;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'config/Database.php';
    include_once 'objects/User.php';
    use api\config\Database;
    use api\config\objetcs\User;

    $db = new Database();
    $conn = $db->getConnection();
    $user = new User($conn);
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->firstname) && !empty($data->lastname) && !empty($data->password) && !empty($data->email)) {
        $user->firstname = filter_var($data->firstname, FILTER_SANITIZE_STRING);
        $user->lastname = filter_var($data->lastname, FILTER_SANITIZE_STRING) ;
        $user->password = filter_var($data->password, FILTER_SANITIZE_STRING);
        $user->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        $user->create();
        http_response_code(200);
        echo json_encode(["message" => "User has been created!"]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "User creation error!"]);
    };

?>
