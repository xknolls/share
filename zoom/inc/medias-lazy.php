<?php
require_once( __DIR__ . './medias-functions.php');

/*
    Si on arrive à ouvrir le dossier :
    $dir_handle = dossier ouvert
*/

//Definir les constantes 
function lazyGallery($path)
{
    //Tableau dans lequel seront stocké le nom des photos à afficher 
    $lazy_gallery = array();
    $exts_granted = array('jpg', 'jpeg', 'png', 'gif', 'webm', 'svg'); //extension recherché
    $pathThumbnails = $path . "thumbnails/";

    //if( $dir_handle = opendir('img') ) {
    if (is_readable($path)) {

        $dir_handle = opendir($path);

        while (false !== ($entry = readdir($dir_handle))) {
            $ext = pathinfo($entry, PATHINFO_EXTENSION);
            $ext = strtolower($ext);

            //Si $ext est une extension autorisé (jpg,jpeg,png,gif,webm,svg)
            if (in_array($ext, $exts_granted)) {
                //Stocker le nom des fichiers à afficher
                //$lazy_gallery[] = $entry;

                //Passer le nom, sans l'extension en majuscule
                $alt = ucfirst(pathinfo($entry, PATHINFO_FILENAME));
                //Supprimer tout ce qui se trouve apres le premier '_'
                $alt = strstr($alt, '_', true);

                //Créer la miniature si elle n'existe pas 
                if (!file_exists($pathThumbnails . $entry)) {
                    make_thumbnail($path . $entry , 0.50, $pathThumbnails . $entry);
                }

                $lazy_gallery[] = array(
                    'src' => $entry,
                    'src_thumbnails' => $path,
                    'alt' => $alt,
                );

            }
        }
    }
    return $lazy_gallery;
}