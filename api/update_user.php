<?php
    namespace api;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'config/core.php';
    include_once 'libs/php-jwt-master/src/BeforeValidException.php';
    include_once 'libs/php-jwt-master/src/ExpiredException.php';
    include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
    include_once 'libs/php-jwt-master/src/JWT.php';
    include_once 'config/Database.php';
    include_once 'objects/User.php';

    use api\config\Database;
    use api\config\objetcs\User;
    use \Firebase\JWT\JWT;
    
    $db = new Database();
    $conn = $db->getConnection();
    $user = new User($conn);
    $data = json_decode(file_get_contents("php://input"));
    $jwt = isset($data->jwt) ? $data->jwt : null;

    if (!empty($jwt)) {
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            $user->firstname = filter_var($data->firstname, FILTER_SANITIZE_STRING);
            $user->lastname = filter_var($data->lastname, FILTER_SANITIZE_STRING) ;
            $user->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
            $user->password = filter_var($data->password, FILTER_SANITIZE_STRING);
            $user->id = $decoded->data->id;
            echo $decoded->data->id; 
            if ($user->update()) {
                $token = array("iat" => $issued_at, "exp" => $expiration_time, "iss" => $issuer, "data" => array("id" => $user->id,"firstname" => $user->firstname, "lastname" => $user->lastname, "email" => $user->email));
                $jwt = JWT::encode($token, $key);
                http_response_code(200);
                echo json_encode(array("message" => "User was updated.", "jwt" => $jwt));
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "Unable to update user."));
            };

        } catch (\Throwable $th) {
            http_response_code(401);
            echo json_encode(array("message" => "Access denied.", "error" => $th->getMessage()));
        };

    }else{
        http_response_code(401);
        echo json_encode(array("message" => "Token denied."));
    };



?>