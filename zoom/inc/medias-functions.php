<?php

/** 
 * make_thumbnail
 *
 * @param  mixed $source
 * @param  mixed $reduction
 * @param  mixed $destination
 * @return void
 */

function make_thumbnail($source, $reduction, $destination)
{

    //Créer le sous-dossier $destination s'il n'existe pas 
    if (!is_dir(pathinfo($destination, PATHINFO_DIRNAME))) {
        @mkdir(pathinfo($destination, PATHINFO_DIRNAME));
    }

    //si le dossier n'est pas accessible, sortir de la fonction
    if (!is_writable(pathinfo($destination, PATHINFO_DIRNAME))) {
        return;
    }
    // imagecreatefrom....extension...(jpg=jpeg) que l'on stock dans $resource
    $ext = pathinfo($source, PATHINFO_EXTENSION);
    $ext = strtolower($ext);

    switch ($ext) {
        case 'jpeg':
        case 'jpg':
            $resource = imagecreatefromjpeg($source);
            break;

        case 'png':
            $resource = imagecreatefrompng($source);
            break;

        case 'gif':
            $resource = imagecreatefromgif($source);
            break;

        case 'webm':
            $resource = imagecreatefromwebp($source);
            break;

        default:
            copy($source, $destination);
    }
    //Pour obtenir la taille en x et y 
    $width = imagesx($resource);
    $height = imagesy($resource);

    //Calcul des dimmenssions souhaité en fonction coef de reduction souhaité
    $new_height = $height * $reduction;
    $new_width = $width * $reduction;

    //creation d'une image noir à al taile de la mminiature 
    $thumbnail = imagecreatetruecolor($new_width, $new_height);

    //Création de la miniature 
    imagecopyresampled($thumbnail, $resource, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    //Enregistrement de la miniature 

    //Rcupération du nom du fichier dans le chemin de la source
    //$filename = pathinfo($source,PATHINFO_BASENAME);


    switch ($ext) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($thumbnail, $destination);
            break;

        case 'png':
            imagepng($thumbnail,  $destination);
            break;

        case 'gif':
            imagegif($thumbnail, $destination);
            break;

        case 'webm':
            imagewbmp($thumbnail, $destination);
            break;

        default:
            return;
    }
}

function listDirectory($path): array
{
    $directories = [];

    if (is_readable($path)) {
        $dir_handle = opendir($path);

        while (false !== ($entry = readdir($dir_handle))) {

            if (is_dir($path . $entry) && !in_array($entry, array('.', '..'))) {
                //array_push($directories, $entry);
                $directories[] = $entry;
            }
        }
    }

    return $directories;
}
