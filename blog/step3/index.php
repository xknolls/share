<?php


require('models/functions.php');
$limit = 4;
//offset = ?
//Au départ
$offset = 0;

$query = get_posts($limit, $offset);

/*
    Si $_GET['page'] existe 
        $page = $_GET['page']
    Sinon 
        $page= ?
    Ecriture en ternaire 
    $page = (condition) ? valeur si condition est vraie : valeur si la condition est fausse
*/

if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = (int) strip_tags($_GET['page']);
}else{
    $page = 1;
}

$template = 'index';
include_once 'views/layout.phtml';