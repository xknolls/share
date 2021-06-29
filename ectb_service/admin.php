<?php 
require_once('inc/bdd_functions.php');
require_once('./config/config.php');
require_once('inc/utils.php');
init_session();

if(is_logged() !== true) {
    header('Location:login.php');
    exit;
} elseif (is_modo() !== true) {
    header('Location:index.php');
    exit;
}
/* ------------------------------- Pagination ------------------------------- */

// On détermine la page sur laquelle on se trouve 
if(isset($_GET['page']) && !empty($_GET['page'])) {
    //strip_tags pour protéger des injection sql et int pour forcer à avoir un nombre entier
    $currentPage = (int) strip_tags($_GET['page']); 
} 
//si il n'y à pas de param get ou un param get erroné alors on revines sur la page 1
else { 
    $currentPage = 1;
}

// On récupère le nombre de devis
$query_nb = getCountDevis(); 
$nb_devis = $query_nb['nb_devis'];

// On récupère le paramètre GET dans le quel on choisi le nombre de demande de devis par page que l'on souhaite afficher
if (!empty($_GET) && isset($_GET['nb_devis']) && ($_GET['nb_devis'] > 0) && ($_GET['nb_devis'] <= 15)) {
    $nb_on_page = intval($_GET['nb_devis']);
} else {
    // On détermine le nombre de demande par page par défaut
    $nb_on_page = 5;
}

// On calcul le nombre de pages total et cela doit être un nombre entier
$nb_page = ceil($nb_devis / $nb_on_page);

// Calcul du premier article à afficher
$first = ($currentPage * $nb_on_page) - $nb_on_page;

/* --------------------------------- Filtres -------------------------------- */

if(!empty($_GET) && isset($_GET['filter']) && $_GET['filter'] !== 'all'){

    $query_devis = getDevisByStatus(htmlspecialchars($_GET['filter']));

} else {

    $query_devis = getEstimation($first, $nb_on_page);
}

/* -------------------------------- Affichage ------------------------------- */
$theme_path =''; 

$template = 'admin';
include $theme_path . './views/layout.phtml';