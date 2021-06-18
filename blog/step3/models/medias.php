<?php

function get_error_upload($code) {
    switch ($code) {
        case 0:
            $error = "Le fichier a été téléchargé avec succès"; // UPLOAD_ERR_INI_SIZE: 0
            break;

        case 1:
            $error = "Fichier dépassant la taille maximale autorisée par le serveur"; // UPLOAD_ERR_INI_SIZE: 1
            break;

        case 2:
            $error = "Fichier dépassant la taille maximale autorisée"; // UPLOAD_ERR_FORM_SIZE: 2
            break;

        case 3:
            $error = "Fichier transféré partiellement"; // UPLOAD_ERR_PARTIAL: 3
            break;

        case 4:
            $error = "Aucun fichier n'a été sélectionné depuis votre système !";
            break;

        case 6:
            $error = "Pas de répertoire temporaire"; // UPLOAD_ERR_NO_TMP_DIR: 6
            break;

        case 7:
            $error = "Ecriture du fichier impossible"; // UPLOAD_ERR_CANT_WRITE: 7
            break;

        case 8:
            $error = "Erreur d'extension"; // UPLOAD_ERR_EXTENSION: 8
            break;

        default:
            $error = "Erreur inconnue";
    }

    return $error;
}
