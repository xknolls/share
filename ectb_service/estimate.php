<?php
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('./inc/functions.php');
require_once('inc/utils.php');
init_session();

if ($_SESSION) {
    $id_user = $_SESSION['id_user'];
    $aUser = getUserById($id_user);
}

if(!empty($_POST)){

    $errors = [];
    
    if (empty($_POST['firstname'])) {
        $errors['firstname'] = 'Veuillez renseigner votre prénom';
    }
    
    if(empty($_POST['lastname'])){
        $errors['lastname'] = 'Veuillez renseigner votre nom';
    }

    if (empty($_POST['email']) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'Veuillez renseigner un email valide ! ';
    }
    
    if(empty($_POST['tel'])){
        $errors['tel'] = 'Veuillez renseigner votre numéro de téléphone';
    }

    if(empty($_POST['city'])){
        $errors['city'] = 'Veuillez renseigner la ville dans la quelle les travaux sont à effectuer';
    }
    
    if(empty($_POST['subject'])){
        $errors['subject'] = 'Veuillez renseigner le sujet du devis';
    }
    
    if(empty($_POST['message'])){
        $errors['message'] = 'Veuillez renseigner plus d\'informations concernant votre demande';
    }

    $data = [];
    $data['firstname'] = htmlspecialchars($_POST['firstname']);
    $data['lastname'] = htmlspecialchars($_POST['lastname']);
    $data['email'] = htmlspecialchars($_POST['email']);
    $data['tel'] = htmlspecialchars($_POST['tel']);
    $data['city'] = htmlspecialchars($_POST['city']);
    $data['subject'] = htmlspecialchars($_POST['subject']);
    $data['message'] = htmlspecialchars($_POST['message']);

    

    if(empty($errors)){
        add_estimation($data);
        header('Location: estimation_done.php');
    }
    

}

/* -------------------------------- Affichage ------------------------------- */
$theme_path ='';

$template = 'estimate';
include $theme_path . './views/layout.phtml';