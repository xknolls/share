<?php 
/**
 * Stocker des chemins dans des constantes 
 * 
 */

/* ----------------------------------- BDD ---------------------------------- */

/*Non de la base de données */
define('DB_NAME', 'ectb');

/*Utilisateur de la base de donées */
define('DB_USER', 'root');

/*Mot de passe de la base de donées */
define('DB_PASSWORD', '');

/*Adresse de l'hebergement */
define('DB_HOST', 'localhost');

/*Port */
define('DB_PORT', '3306');

/*Mode debug : afficher les erreures sql */
define('DB_SQL_DEBUG', true);

/* ----------------------------------- Log ---------------------------------- */
define('PATH_LOG', '/logs/errors.log');