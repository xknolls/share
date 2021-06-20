<?php 
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('./inc/functions.php');
require_once('inc/utils.php');
init_session();

if(is_logged() !== true) {
    header('Location:login.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$aUser = getUserById($id_user);
$id_user = $aUser['id_user']; 

$aErrorsPass = [];
$aUserInfos = [];
$aPassEdit = [];
$aErrors = [];

/* -------------------------------- Traitement du fomulaire exepté pour le mot de passe ------------------------------- */

// On ne veut traiter le fomrulaire que si une ou plusieurs des infos de $_POST est différente et que $_POST n'est pas vide
if (
    !empty($_POST)
    && (
       $_POST['firstname'] !== $aUser['firstname']
    || $_POST['lastname'] !== $aUser['lastname']
    || $_POST['email'] !== $aUser['email']
    || $_POST['pseudo'] !== $aUser['pseudo'])
    ) {

    if (empty($_POST['firstname'])) {
        $aErrors['firstname'] = 'Veuillez renseigner votre prénom ! ';
    }

    if (empty($_POST['lastname'])) {
        $aErrors['lastname'] = 'Veuillez renseigner votre nom ! ';
    }

    if (empty($_POST['email']) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $aErrors['email'] = 'Veuillez renseigner un email valide ! ';
    } else {
        // Seulement si le pseudo est modifié alors on test si il n'existe pas déja
        if ($aUser['email'] !== $_POST['email']) {
            $testEmail = get_user_by_login($_POST['email']);
            if ($testEmail !== false) {
                $aErrors['email'] ='L\'email ' . $_POST['email'] .  ' existe deja ! ';
            }
        }
    }

    if (empty($_POST['pseudo'])) {
        $aErrors['pseudo'] = 'Veuillez ajouter un pseudo ! ';
    } else {

        // Seulement si le pseudo est modifié alors on test si il n'existe pas déja
        if ($aUser['pseudo'] !== $_POST['pseudo']) {
            $testPseudo = get_user_by_pseudo($_POST['pseudo']);
            if ($testPseudo !== false) {
                $aErrors['pseudo'] ='Le pseudo ' . $_POST['pseudo'] .  ' existe deja ! ';
            }
        }
    }

    // Enregistrement des donnés de $_POST dans des variables intermédiares
    $aUserInfos['firstname'] = htmlspecialchars($_POST['firstname']);
    $aUserInfos['lastname'] = htmlspecialchars($_POST['lastname']);
    $aUserInfos['email'] = htmlspecialchars($_POST['email']);
    $aUserInfos['pseudo'] = htmlspecialchars($_POST['pseudo']);
    $aUserInfos['id_user'] = $id_user;

}

/* -------------- Traitement du formulaire concernant le mot de passe -------------- */

if (!empty($_POST['passwordCurrent'])) {

    if (password_verify(htmlspecialchars($_POST['passwordCurrent']), $aUser['password']) !== true) {
        $aErrorsPass['passwordCurrent'] = 'Le mot de passe saisie ne correspond pas ! ';
    }

    if (empty($_POST['password'])) {
        $aErrorsPass['password'] = 'Veuillez ajouter un nouveau mot de passe ! ';
    }

    if(check_mdp_format($_POST['password']) !== true) {
        $aErrorsPass['passwordFormat'] = true;
    }

    // Vérifier si les mdp sont identiques
    if (empty($_POST['confirmedPassword']) || $_POST['confirmedPassword'] !== $_POST['password']) {
        $aErrorsPass['confirmedPassword'] = 'Les mots de passe ne sont pas identiques ! ';
    }

    $aPassEdit['newPassword'] = password_hash($_POST['confirmedPassword'], PASSWORD_BCRYPT);
    $aPassEdit['id_user'] = $id_user;
}

// Enregistrement en BDD seulement si il y a eu une modification
if (!empty($aUserInfos) && empty($aErrors)) {
    edit_account($aUserInfos);
}

if (!empty($aPassEdit) && empty($aErrorsPass)) {
    edit_password($aPassEdit);
}

/* -------------------------------- Affichage ------------------------------- */
$theme_path =''; 

$template = 'edit_account';
include $theme_path . './views/layout.phtml';