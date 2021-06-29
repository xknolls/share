<?php 
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('inc/utils.php');
init_session();

if(is_logged() !== true) {
    header('Location:login.php');
    exit;
}

$id_user = $_SESSION['id_user'];

$aUser = getUserById($id_user);

/* -------------------------------- Affichage ------------------------------- */
$theme_path =''; 

$template = 'account';
include $theme_path . './views/layout.phtml';