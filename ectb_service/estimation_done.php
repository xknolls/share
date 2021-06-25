<?php 
    require_once('inc/bdd_functions.php');
    require_once('./config/config.php');
    require_once('inc/utils.php');
    init_session();
?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="description" content="ECTB-Service - Traitement du devis">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="./css/styles.css">
	<link rel="stylesheet" href="./css/normalize.css">
	<link rel="stylesheet" href="./css/burger.css">
</head>

<body>

    <header class="topnav">
        <a href="index.php" class="title-menu">
            <h1 class="logo1">E.C.T.B</h1>
		    <h2 class="logo2">Service</h2>
        </a>
        <nav id="myLinks">
            <a href="estimate.php">Demande de devis</a>
            <a href="about.php">Qui sommes nous ?</a>
            <?php if (is_logged() !== true) : ?>
                <a href="login.php">Se connecter</a>
            <?php elseif (is_modo() == true) : ?>
                <a href="admin.php">Administration</a>
                <a href="logout.php">Se deconnecter</a>
            <?php elseif (is_logged() == true) : ?>
                <a href="account.php">Profil</a>
                <a href="logout.php">Se deconnecter</a>
            <?php endif; ?>
        </nav>
        <a href="javascript:void(0);" title="menu" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </header>

    <main class="estimation-done">
        <h1>Votre demande de devis a bien été prise en compte</h1>
        <a class="devis-btn" href="index.php">Retourner à l'accueil</a>
    </main>

    <footer class="footer">
        <div>
            <a href="#" class="title-menu">
                <h1 class="logo1">E.C.T.B</h1>
		        <h2 class="logo2">Service</h2>
            </a>
        </div>
        <div class="footer-contact">
            <div>
	            <h3 class="footer-title"><span class="first-letter">T</span><strong>éléphone : </strong><a class="footer-num" href="tel:+330659068072">0659068072</a></h3>
            </div>
            <div>
	            <h3 class="footer-title"><span class="first-letter">E</span><strong>mail : </strong><a class="footer-email" href="mailto:ectbservice@hotmail.com">ectbservice@hotmail.com</a></h3>
            </div>
        </div>
    </footer>
    <script src="js/password.js"></script>
    <script src="js/confirm.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/filterAjax.js"></script>
</body>

</html>

