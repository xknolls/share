<?php

/**
 * check_mdp_format
 *
 * @param  string $password
 * @return void
 */
function check_mdp_format(string $password): bool
{
    $majuscule = preg_match('@[A-Z]@', $password);
    $minuscule = preg_match('@[a-z]@', $password);
    $chiffre = preg_match('@[0-9]@', $password);

    if (!$majuscule || !$minuscule || !$chiffre || strlen($password) < 8) {
        return false;
    } else {
        return true;
    }
}

/**
 * Création d'un token d'une longueur $length
 *
 * @param mixed $length
 */
function str_random($length)
{
    // je déclare les caractères autorisés
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    
    // Je repète les caractère $length fois afin de pouvoir avoir plusieurs fois le même caractère 
    // Avec str_shuffle je mélange les caractères entre eux
    // Avec substr je ne récupère que les $length premiers caractères
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}
