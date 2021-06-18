<?php
require_once('models/utils.php');
init_session();


// Si $_GET['id'] n'est pas ce qu'on attend ; il n'existe pas ou il ne contient pas un nombre 
if ( 
    !array_key_exists('id', $_GET)
    || !ctype_digit($_GET['id'])
) {
    header('Location:index.php');
    exit;
}

require_once('models/functions.php');


//Récuperer les données du post 
$query_post = get_post($_GET['id']);

$post = $query_post -> fetch();

//Permet d'executer le requete de nouveau 
$query_post -> closeCursor();

//Récupère les commentaire de l'article : on écrase lla requete précédente si on l'appelle aussi $query
$query_comments = getcomments_post($_GET['id']);


//Récuperer le nombre de commentaires trouvés
$count_comments = countComments_post($_GET['id']);

$template = 'post';
include('./views/layout.phtml');