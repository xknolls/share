<?php
//var_dump(password_hash('1302', PASSWORD_DEFAULT));
// MDP MyAdmin : 'CazEKLpwQmh4AjTu'

require_once('models/utils.php');
init_session();
if(is_logged() !==true ) {
    header('Location:login.php');
    exit;
}

// Si le formulaire est posté
// file_uploads on
// Récupérer le type d'extention ( strtolower(pathinfo($target_file,PATHINFO_EXTENSION)) )
// Vérifier si le fichier existe déjà
// Vérifier si le fichier n'est pas un faux
// Limitter la taille (post_max_size, max_file_uploads)
// Limitter le type de fichier
// Stocker dans un dossier (upload_tmp_dir)
// Message en cas d'erreurs

$errors = array();
$form_datas = array(
    'description' => '',
    'legende' => '',
    'name' => '',
    'type' => '',
    'size' => ''
);



if(array_key_exists('description', $_POST)) {

    require_once('models/medias.php');

    $document['description'] = htmlspecialchars($_POST['description']);
    $document['legend'] = htmlspecialchars($_POST['legend']);

    if(empty($_POST['description'])) {
        $errors['description'] = 'La description est obligatoire'; 
    }

    if ( ($code = $_FILES['formfile']['error'] > 0)) {
        $errors['formfile'] = get_error_upload($code);
    }

    if(empty($errors)) {
        
        require_once('models/functions.php');

        // Dossier de destination
        $dir_upload = './uploads/';

        // Nom d'origine
        $name = $_FILES['formfile']['name'];

        // Remplacer les espaces par des '_'
        $name = str_replace(' ','_', $name);

        // Déplacer le fichier du répertoir temporaire vers le dossier upload
        $tmp_name = $_FILES['formfile']['tmp_name'];

        $document['name'] = $name;
        $document['type'] = $_FILES['formfile']['type'];
        $document['size'] = $_FILES['formfile']['size'];

        move_uploaded_file($tmp_name, $dir_upload . $name);    
        
        add_document($document);
        header('Location:medias.php');
        exit;
    }









    if(!empty($errors)) {
        require('models/functions.php');
    }
}





// Securiser le chemin
$template = 'medias';

include_once 'views/layout.phtml';