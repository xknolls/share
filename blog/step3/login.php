<?php
require_once('models/utils.php');
init_session();
/** On souhaite se connecter grace à et notre email et notre mot de passe
 * Si le formulaire à était posté
 * Il faut appeller nos users dans la bases de données
 *      Il nous faut donc le pseudo et le mdp de chaque utilisateur 
 * Comparer le pseudo et le mot de passe saisie dans le formulaire avec les users de notre base 
 *      Si correspondance, 
 *          accés à la page admin
 *      Sinon redirection vers l'index
*/

// Si le formulaire à était posté
if(
    array_key_exists('email',$_POST)
    && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false
    && array_key_exists('pass',$_POST)
) {

    require_once 'models/functions.php';
    $user = get_user_by_login($_POST['email']);

    /* 
        Si il existe un utilisateur avec cet email
        Et que le mot de passe saisie correspond au mot de passe chiffré stocké  
    */
    if (
        !empty($user)
        && password_verify($_POST['pass'], $user['pass']) == true
    ) {
        // Remplacer l'identifiant de session courant pas un nouveau
        session_regenerate_id();
        $_SESSION['id_user'] = intval($user['id_user']);
        $_SESSION['pseudo'] = htmlspecialchars($user['pseudo']);
        

        header('Location: admin.php');
        exit;
    }

    $error = 'Les identifiants saisient ne sont pas valides';

}


$template = 'login';
include_once 'views/layout.phtml';