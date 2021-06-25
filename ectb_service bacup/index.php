<?php 
require_once('./config/config.php');
require_once('./inc/utils.php');
init_session();


/* -------------------------------- Affichage ------------------------------- */ 
$theme_path = '';

$template = 'index';
include $theme_path . './views/layout.phtml';