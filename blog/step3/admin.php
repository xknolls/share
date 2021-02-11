<?php
//var_dump(password_hash('1302', PASSWORD_DEFAULT));
// MDP MyAdmin : 'CazEKLpwQmh4AjTu'

require_once('models/utils.php');
init_session();
if(is_logged() !==true ) {
    header('Location:login.php');
    exit;
}

require('models/functions.php');

$query = get_posts();



// Securiser le chemin
$template = 'admin';

include_once 'views/layout.phtml';
