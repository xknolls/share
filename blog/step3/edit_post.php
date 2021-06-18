<?php
require_once('models/utils.php');
init_session();
if(is_logged() !==true ) {
    header('Location:login.php');
    exit;
}

require_once('models/functions.php');


if (array_key_exists('id', $_GET) && (ctype_digit($_GET['id']))) {

    $query_category = get_category();
    
    $query_users = get_users();

    $query_post = get_post($_GET['id']);
    
    $no_edit_post = $query_post->fetch();

    $edit_post['id_category'] = $no_edit_post['id_category'];
    $edit_post['id_user'] = $no_edit_post['id_user'];
    $edit_post['title'] = $no_edit_post['title'];
    $edit_post['content'] = $no_edit_post['content'];
    $edit_post['id_post'] = $no_edit_post['id_post'];



    if (!empty($_POST)) {

        $errors = array();

        if (empty($_POST['id_category'])) {
            $errors['id_category'] = 'Veuillez choisir une catégorie ! ';
        }

        if (empty($_POST['id_user'])) {
            $errors['id_user'] = 'Veuillez choisir un auteur ! ';
        }

        if (empty($_POST['title'])) {
            $errors['title'] = 'Veuillez ajouter un titre ! ';
        }
        
        if (empty($_POST['content'])) {
            $errors['content'] = 'Veuillez ajouter un contenu ! ';
        }

        $edit_post['id_category'] = $_POST['id_category'];
        $edit_post['id_user'] = $_POST['id_user'];
        $edit_post['title'] = $_POST['title'];
        $edit_post['content'] = $_POST['content'];
        $edit_post['id_post'] = $_POST['id_post'];

        

    } 

    if(!empty($_POST) AND empty($errors)) {
        edit_post($edit_post);
        header('Location:admin.php');
        exit;
    }

}



$template = 'edit_post';
include_once 'views/layout.phtml';
