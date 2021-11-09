<?php
    namespace api\config;

    error_reporting(E_ALL);
    date_default_timezone_set('America/Sao_Paulo');

    $key = 'rebimboca da parafuzeta';
    $issued_at = time();
    $expiration_time = $issued_at + (60*60*24);
    $issuer = "GoolHub";

?>