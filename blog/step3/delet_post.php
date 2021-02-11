<?php 
require_once('models/utils.php');
init_session();
if(is_logged() !==true ) {
    header('Location:login.php');
    exit;
}

require_once('models/functions.php');

$id_post = array();

if (array_key_exists('id', $_GET) && (ctype_digit($_GET['id']))) {

    $id_post['id_post'] = $_GET['id'];

    delet_post($id_post);

    header('Location:admin.php');

}