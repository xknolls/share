<?php
require_once('inc/utils.php');
init_session();
clean_php_session();
header('Location:index.php');