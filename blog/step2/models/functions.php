<?php 


function connect() {
    // Tenter de se connecter à la base de données
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

        return $pdo;
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
}






/**
 * getposts ()
 *
 * @return $query
 */
function getposts() {
    $pdo = connect();
    //Transmission de la requête
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
    return $query;
}