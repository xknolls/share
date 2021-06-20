<?php
require_once('./inc/bdd_functions.php');
require_once('./config/config.php');
require_once('./inc/utils.php');
init_session();

if (is_logged() == true) {
    header('Location:index.php');
}

// Si le formulaire à était posté
if (array_key_exists('email', $_POST) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false && array_key_exists('password', $_POST)) {
    
    $user = get_user_by_login($_POST['email']);

    /* 
        Si il existe un utilisateur avec cet email
        Et que le mot de passe saisie correspond au mot de passe chiffré stocké  
    */
    if (
        !empty($user)
        //TODO retirer la possibilite de MDP non ashé
        && (password_verify(htmlspecialchars($_POST['password']), $user['password']) == true || htmlspecialchars($_POST['password']) == $user['password'])
    ) {

        $id_user = intval($user['id_user']);

        // Vérification que l'utilisateur à bien confirmé son compte 
        if (is_confirmed_by_id($id_user) == false) {
            $error = "Votre compte n'as pas encore été confirmé ! ";
        } else {
            // Remplacer l'identifiant de session courant pas un nouveau
            session_regenerate_id();
            $_SESSION['id_user'] = $id_user;
            $_SESSION['pseudo'] = htmlspecialchars($user['pseudo']);

            header('Location:index.php');
            exit;
        }
    } else {
        $error = 'Les identifiants saisis ne sont pas valides';
    }
}


/* -------------------------------- Affichage ------------------------------- */
$theme_path = '';

$template = 'login';
include $theme_path . './views/layout.phtml';
