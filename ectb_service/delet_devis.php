<?php
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('inc/utils.php');
init_session();

if (is_logged() !== true) {
    header('Location:login.php');
    exit;
} elseif (is_modo() !== true) {
    header('Location:index.php');
    exit;
}

// Récupération de l'id_devis à supprimer dans l'url
if (array_key_exists('id', $_GET) && ctype_digit($_GET['id'])) {
    deleteDevis($_GET['id']);
    header('Location: admin.php');
    exit;
}
