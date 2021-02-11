<?php

//var_dump(password_hash('1302', PASSWORD_DEFAULT));

// MDP MyAdmin : 'CazEKLpwQmh4AjTu'
require('models/functions.php');
$query = getposts();




// Securiser le chemin
$template = 'admin';

include_once 'views/layout.phtml';
