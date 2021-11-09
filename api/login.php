<?php
    namespace api;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'config/Database.php';
    include_once 'objects/User.php';
    include_once 'config/core.php';
    include_once 'libs/php-jwt-master/src/BeforeValidException.php';
    include_once 'libs/php-jwt-master/src/ExpiredException.php';
    include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
    include_once 'libs/php-jwt-master/src/JWT.php';

    use \Firebase\JWT\JWT;
    use api\config\Database;
    use api\config\objetcs\User;

    $db = new Database();
    $conn = $db->getConnection();
    $user = new User($conn);
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->email)) {
        $user->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        $email = $user->emailExists();
    
        if($email && password_verify($data->password, $user->password)){
            $token = ['iat' => $issued_at, 'exp' => $expiration_time, 'iss' => $issuer, 'data' => ['id' => $user->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname, 'email' => $user->email]];
            http_response_code(200);
            $jwt = JWT::encode($token, $key);
            echo json_encode(['message' => 'Successful login', 'jwt'=>$jwt]);
        } else{
            http_response_code(401);
            echo json_encode(['message' => 'Login failed.']);
        };
    } else {
       http_response_code(401);
        echo json_encode(['message' => 'Please insert email.']);
    };
?>