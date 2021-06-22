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

/* --------------- récupération des infos du devis à afficher -------------- */

// Récupération de l'id_devis à modifier dans l'url
if (array_key_exists('id', $_GET) && (ctype_digit($_GET['id']))) {

    $id_devis = $_GET['id'];

    //Récupération du devis à afficher
    $aDevis = getDevisById($id_devis);
}

/* -------------------------------- Traitement du fomulaire ------------------------------- */



// Enregistrement en BDD de la modification de l'état du devis
if (!empty($_POST)) {

    $aInfosStatus['id_devis'] = $id_devis;
    $aInfosStatus['status'] = htmlspecialchars($_POST['status']);

    edit_status($aInfosStatus);
    header('Location:admin.php');
    exit;
}

/* -------------------------------- Affichage ------------------------------- */
$theme_path ='';

$template = 'display_devis';
include $theme_path . './views/layout.phtml';
