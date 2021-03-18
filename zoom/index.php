<?php 
require_once('./config/config.php');
require_once('./inc/medias-lazy.php');

/* --------------------------------- Galerie -------------------------------- */

$galleries = listDirectory(PATH_MEDIAS);
$media = MEDIAS_DEFAULT;
$gallery_path = PATH_MEDIAS . $media . '/';

if (array_key_exists('galerie', $_GET) && in_array($_GET['galerie'], $galleries)) {
    $media = $_GET['galerie'];
    
    $gallery_path = PATH_MEDIAS . $media . '/';    
}

$gallery = lazyGallery($gallery_path);
/* -------------------------------- Affichage ------------------------------- */
$theme_path = THEMES_PATH . THEME_DEFAULT . '/'; 




include $theme_path . 'views/index.phtml';