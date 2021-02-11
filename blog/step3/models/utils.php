<?php //fichier pour les fonctions concernant les sessions 

/**
 * init_session()
 * 
 * initialise les sessions et régénère l'id de session
 *
 * @return bool
 */
function init_session() : bool {
    
    //si le sessions ne sont pas encore initialisées 
    if ( !session_id()) {
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
function is_logged() : bool {
    
    if( array_key_exists('id_user', $_SESSION)) {
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
function clean_php_session() : void {
    session_unset();
    session_destroy();
    $_SESSION = array();
}