<?php
require_once('./inc/bdd_functions.php');
require_once('./inc/functions.php');
require_once('inc/utils.php');

/* -------------------------------- Session ------------------------------- */

init_session();

/* ------------------------------ Zone de test ------------------------------ */


/* -------------------------------- Traitement du fomulaire ------------------------------- */

$aUserInfos = array();
$aUserInfos['firstname'] = '';
$aUserInfos['lastname'] = '';
$aUserInfos['email'] = '';
$aUserInfos['pseudo'] = '';


if (!empty($_POST)) {

    // Ici on gère les erreurs dans le remplissage du formulaire
    // Si le champ es vide on génère un message d'erreur pour le champ qui n'as pas étais remplis
    $aErrors = [];

    if (empty($_POST['firstname'])) {
        $aErrors['firstname'] = ' Veuillez renseigner votre prénom ! ';
    }

    if (empty($_POST['lastname'])) {
        $aErrors['lastname'] = ' Veuillez renseigner votre nom ! ';
    }

    if (empty($_POST['email']) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $aErrors['email'] = ' Veuillez renseigner un email valide ! ';
    }

    // Test pour vérifier qu'un utilisateur avec l'email renseigner n'existe pas déja
    $testEmail = get_user_by_login($_POST['email']);
    if ($testEmail) {
        $aErrors['email'] = ' L\'email ' . $_POST['email'] .  ' existe deja ! ';
    }

    if (empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'] )) {
        $aErrors['pseudo'] = " Votre pseudo n'est pas valide ";
    }

    $testPseudo = get_user_by_pseudo($_POST['pseudo']);
    if ($testPseudo !== false) {
        $aErrors['pseudo'] = ' Le pseudo ' . $_POST['pseudo'] . ' existe deja ! ';
    }

    if (empty($_POST['password'])) {
        $aErrors['password'] = ' Veuillez ajouter un mot de passe ! ';
    }

    if (check_mdp_format($_POST['password']) !== true) {
        $aErrors['passwordFormat'] = true;
    }

    // Vérifier si les mdp sont identiques
    if (empty($_POST['confirmedPassword']) || $_POST['confirmedPassword'] !== $_POST['password']) {
        $aErrors['confirmedPassword'] = ' Les mots de passes ne sont pas identiques ! ';
    }

    // Création du'un token de confirmation 
    $token = str_random(60);

    // Enregistrement des données de $_POST dans des variables intermédiares
    $aUserInfos['firstname'] = htmlspecialchars($_POST['firstname']);
    $aUserInfos['lastname'] = htmlspecialchars($_POST['lastname']);
    $aUserInfos['email'] = $_POST['email'];
    $aUserInfos['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $aUserInfos['pseudo'] = htmlspecialchars($_POST['pseudo']);
    $aUserInfos['token'] = $token;

    if (empty($aErrors)) {
        $user_id = register($aUserInfos);
        //mail($aUserInfos['email'], 'Confirmer votre adresse email', "Pour confirmer votre adresse email veuillez cliquez sur le lien suivant : \n\n http://quentin.greta/ectb_service/confirm.php?id=$user_id&token=$token");
        //TODOO boite modale pour indiquer de confirmer son compte
        header('Location:login.php');
        exit;
    }
}

/* -------------------------------- Affichage ------------------------------- */
$theme_path = '';

$template = 'register';
include $theme_path . './views/layout.phtml';