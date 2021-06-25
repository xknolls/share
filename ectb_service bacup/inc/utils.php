<?php
/* ----------- Fichier pour les fonctions concernant les sessions ----------- */

/**
 * init_session()
 * 
 * initialise les sessions et régénère l'id de session
 *
 * @return bool
 */
function init_session(): bool
{
    //si les sessions ne sont pas encore initialisées 
    if (!session_id()) {
        session_start();
        session_id();
        session_regenerate_id();
        return true;
    }
    return false;
}

/**
 * is_logged
 *
 * Vérifier si l'utilisateur est loggé
 * 
 * @return bool
 */
function is_logged(): bool
{

    if (array_key_exists('id_user', $_SESSION)) {
        return true;
    }

    return false;
}

/**
 * is_modo
 * 
 * Vérifier di l'utilisateur est modo
 *
 * @return bool
 */
function is_modo(): bool
{
    if (array_key_exists('id_user', $_SESSION)) {
        require_once('bdd_functions.php');
        $aUser = getUserById($_SESSION['id_user']);
        $id_permission = $aUser['id_permission'];
        if ($id_permission == 1) {
            return true;
        }
    }
    return false;
}

/**
 * verifier si l'utilisateur à confimer son compte
 *
 * @param  int $id
 * @return bool
 */
function is_confirmed_by_id($id): bool
{
    $aUser = getUserById($id);
    if (array_key_exists('confirmation_token', $aUser) && $aUser['confirmation_token'] === NULL) {
        return true;
    }

    return false;
}

/**
 * clean_php_session
 *
 * Fonction pour se déconnecter !!!
 * 
 * @return void
 */
function clean_php_session(): void
{
    session_unset();
    session_destroy();
    $_SESSION = array();
}
