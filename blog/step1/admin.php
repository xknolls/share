<?php

//var_dump(password_hash('1302', PASSWORD_DEFAULT));

// MDP MyAdmin : 'CazEKLpwQmh4AjTu'



// Tenter de se connecter à la base de donées blog du serveur mysql local
try {
    $pdo = new PDO(
        // Source de données : DSN (Date Source Name)
        'mysql:host=localhost;dbname=blog;charset=UTF8;port=3306',
        // Identification
        'knolls',
        // Mot de passe
        'CazEKLpwQmh4AjTu'
    );

    /* 
        https://www.php.net/manual/fr/pdostatement.fetch.php 

        PDO::FETCH_BOTH (défault)
    
    */
    $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
}
// Si un problème : on capture l'erreur et on affiche un message
/*catch (PDOException $error) {
    //echo 'Erreur : ' . $error -> getMessage();
    error_log(
        // Message
        $error -> getMessage(),
        // Envoi dans l'historique d'erreurs défini par PHP
        0,
    );
}*/

catch (PDOException $error) {
    //echo 'Erreur : ' . $error -> getMessage();
    error_log(
        // Message
        $error -> getMessage(),
        // Envoi dans l'historique d'erreurs que l'on as défini
        3,
        './log/errors.log'
    );


    // Envoi email à l'adresse choisi :qui plante en l'absence de serveur de mail 
    // error_log('Problème d\'accès à la base données sur quentin.greta',1,'adresse@mail.greta');




    header('Location:404.php?er=500');
    exit;
}

// Transmission de la rquêtte en créant un objet $query hérite des propriétés de $pdo
$query = $pdo -> query('
    SELECT 
    id_post,
    title,
    DATE_FORMAT(date_update, "%e/%c/%Y") AS date, 
    label, 
    firstname, 
    lastname 
    
    FROM posts 

    INNER JOIN category ON category.id_category = posts.id_category 
    INNER JOIN users ON users.id_user = posts.id_user

    ORDER BY date_update DESC, id_post DESC
');

/*
    Récupérer tous les résultats dans un tableau php à 2 dimensions $posts 
    Chaque ligne correspond à un tableau représentant un post 
        -> les données du post sont stockées en double avec, pour chaque champ :
            - une clé correspondant au nom de la colonne
            - une clé numérique 

    Pour avoir un tableau associatif simple, voir set_attribute() plus haut
    $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

    On pourrait lire $posts avec une boucle foreach() au moment de l'affichage
    Problème possible : saturation de la mémoire
 */
//$posts = $query -> fetchAll();
//var_dump($posts);

// Récuperer la premiere ligne de résultat dans un tableau associatif $post 
//$post = $query -> fetch();
//var_dump($post);

// Cette fois la deuxième ligne qui es récuperé car le curseur s'est déplacé !
//$post = $query -> fetch();
//var_dump($post);



// Securiser le chemin
$template = 'admin';

include 'views/layout.phtml';
