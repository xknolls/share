<?php 
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('inc/utils.php');
init_session();

// Test de la présence de paramètre dans l'url
if (array_key_exists('id', $_GET) && ctype_digit($_GET['id']) && array_key_exists('token', $_GET)) {
    
    // Récupération de l'id_user et du token dans $_GET
    $id_user = $_GET['id'];
    $token = $_GET['token'];
    
    // Récupération de l'utilisateur grace à son id
    $aUser = getUserById($id_user);
    
    // Test pour vérifier que l'id appartient bien à un utilisateur enregsitré en bdd 
    if($aUser == false) {
        header('Location:index.php');
        exit;
    }    

    // Test pour vérifier que le token récupéré est identique à celui enregistré en bdd
    if ($aUser['confirmation_token'] !== $token) {
        header('Location:index.php');
        exit;
    }

    // Confirmation du compte en retirant le token et en éditant la date de confirmation du compte
    edit_status_confimation_user_account($id_user);

    // Connection de l'utilisateur
    session_regenerate_id();
    $_SESSION['id_user'] = intval($id_user);
    $_SESSION['pseudo'] = htmlspecialchars($aUser['pseudo']);


} else {
    header('Location:index.php');
}



/* -------------------------------- Affichage ------------------------------- */
$theme_path = ''; 

$template = 'confirm';
include $theme_path . './views/layout.phtml';