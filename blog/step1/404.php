<?php 

var_dump($_SERVER);
// Pour bien faire les choses il faudrait tester le type d'erreur avec un switch par exemple

// Si la page n'as pas été trouvé : 404 
header('HTTP/1.1 404 Not Found');
$template = '404';
include 'views/404.phtml';