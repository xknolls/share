<?php 


// Pour bien faire les choses il faudrait tester le type d'erreur avec un switch par exemple

// Récuperer le code de répponse http
$http_response = http_response_code();
var_dump($http_response);

$error = array_key_exists('er', $_GET) ? intval($_GET['er']) : $http_response;

switch($error) {
    case 401:
        header("HTTP/1.1 401 Unauthorized");
        $description = 'Accès non autorisé';
    break;

    case 503 :
        header("HTTP/1.0 503 Service Temporarily Unavailable");
        $description = 'Le site est momantannément indisponible';
    break;

    default :
        header("HTTP/1.0 404 Not Found");
        $description = 'La page demané n\'est pas disponible';
    break;

}

$template = '404';
include 'views/404.phtml';