<?php
require_once('models/utils.php');
init_session();
if(is_logged() !==true ) {
    header('Location:login.php');
    exit;
}

/*
    Pour inserer un comentaire, il faut 

    id_user d'un utilisateur connecté
        Il existe une session 
            dans laquelle on peut récupérer l'id 
    date_create : date de création du commentaire -> faire attention 
    commentaire : il est posté
    id-post de l'article 

*/


//Pour l'instant 
$id_user = $_SESSION['id_user'];

//Si les données sont incomplète ou eronées : redirection vers pot.ph
if (
    !array_key_exists('id_post', $_POST)
    || !ctype_digit($_POST['id_post'])
) {
    header('Location:index.php');
    exit;
}

require_once('models/functions.php');

$comment = array();

$comment['comment'] = $_POST['comment'];
$comment['id_post'] = $_POST['id_post'];
$comment['id_user'] = $id_user;

add_comment($comment);

header('Location:post.php?id=' . intval($_POST['id_post']));
