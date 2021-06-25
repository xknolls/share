<?php
require_once('./config/config.php');
require_once('./inc/bdd_functions.php');
require_once('inc/utils.php');
init_session();

if(is_logged() !== true) {
    header('Location:login.php');
    exit;
} elseif (is_modo() !== true) {
    header('Location:index.php');
    exit;
}

/* --------------- récupération des infos du compte à modifier -------------- */

// Récupération de l'id_user à modifier dans l'url
if (array_key_exists('id', $_GET) && (ctype_digit($_GET['id']))) {

    $id_user = $_GET['id'];

    //Récupération du compte à modifier
    $aUser = getUserById($id_user);
}

/* -------------------------------- Traitement du fomulaire ------------------------------- */

if(!empty($_POST)) {
    $aUserInfos['id_permission'] = $_POST['id_permission'];
    $aUserInfos['id_user'] = $aUser['id_user'];
}
    
// Enregistrement en BDD
if (!empty($_POST)) {
    editUser($aUserInfos);
    header('Location:admin.php');
    exit;
}
/* -------------------------------- Affichage ------------------------------- */

// Récupération des diférentes permissions
$query_permissions = getPermissions();

$theme_path ='';

$template = 'edit_user';
include $theme_path . './views/layout.phtml';
