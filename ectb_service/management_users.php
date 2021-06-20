<?php 
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('inc/utils.php');
init_session();

if(is_logged() !== true) {
    header('Location:login.php');
    exit;
} elseif (is_modo() !== true) {
    header('Location:index.php');
    exit;
}

/* -------------------------------- Affichage ------------------------------- */
$users = get_users();

$theme_path =''; 

$template = 'management_users';
include $theme_path . './views/layout.phtml';