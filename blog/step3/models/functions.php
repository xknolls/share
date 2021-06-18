<?php


function connect()
{

    require_once('config/config.php');

    // Tenter de se connecter à la base de données
    try {
        $pdo = new PDO(
            // Source de données : DSN (Date Source Name)
            'mysql:host='. DB_HOST .';dbname='. DB_NAME .';charset=UTF8;port= ' . DB_PORT,
            // Identification
            DB_USER,
            // Mot de passe
            DB_PASSWORD
        );
        /* 
            https://www.php.net/manual/fr/pdostatement.fetch.php 
    
            PDO::FETCH_BOTH (défault)
        
        */
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        //Uniquement en dev 
        if (defined('DB_SQL_DEBUG')) {
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
       

        return $pdo;
    } 
    catch (PDOException $error) {
        //echo 'Erreur : ' . $error -> getMessage();
        error_log(
            // Message
            $error->getMessage(),
            // Envoi dans l'historique d'erreurs que l'on as défini
            3,
            './log/errors.log'
        );
        // Envoi email à l'adresse choisi :qui plante en l'absence de serveur de mail 
        // error_log('Problème d\'accès à la base données sur quentin.greta',1,'adresse@mail.greta');
        header('Location:404.php?er=503');
        exit;
    }
    return $pdo;
}

/**
 * getposts ()
 *
 * @return $query
 */
function get_posts($limit=10, $offset=0) {
    $pdo = connect();
    //Transmission de la requête
    $query = $pdo-> prepare('
        SELECT 
            id_post,
            title,
            DATE_FORMAT(date_update, "%e/%c/%Y") AS date, 
            content,
            label, 
            firstname, 
            lastname,
            pseudo
        
        FROM posts 

        INNER JOIN category ON category.id_category = posts.id_category 
        INNER JOIN users ON users.id_user = posts.id_user

        ORDER BY date_update DESC, id_post DESC
        LIMIT :limit OFFSET :offset
    ');
    /*
    $query->execute(array(
        'limit' => $limit,
        'offset' => $offset
    ));
    */

    // Les valeurs de LIMIT et de OFFSET doivent être un entier
    $query->bindValue(':limit', $limit, PDO::PARAM_INT);
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();



    return $query;
}

function get_post($id_post) {
    $pdo = connect();

    $query = $pdo -> prepare('
    SELECT 
        id_post,
        title,
        DATE_FORMAT(date_update, "%e/%c/%Y") AS date, 
        content,
        label, 
        pseudo,
        posts.id_user,
        posts.id_category

    FROM posts 

    INNER JOIN category ON category.id_category = posts.id_category 
    INNER JOIN users ON users.id_user = posts.id_user
    
    WHERE id_post = :id_post
    ');
    $query->bindValue(':id_post', $id_post, PDO::PARAM_INT);
    $query ->execute();

    return $query;
}


function getcomments_post($id_post) {

    $pdo = connect();

    $query = $pdo -> prepare('
    SELECT 
        id_comment,
        pseudo,
        DATE_FORMAT(date_create, "%e/%c/%Y") AS date, 
        comment,
        id_post

    FROM comments 

    INNER JOIN users ON users.id_user = comments.id_user

    WHERE id_post = :id_post

    ORDER BY date ASC, id_comment ASC
    
    ');

    $query->bindValue(':id_post', $id_post, PDO::PARAM_INT);
    $query ->execute();

    return $query;
}

function countComments_post($id_post) {
    $pdo = connect();

    $query = $pdo -> prepare('

        SELECT COUNT(*)
        FROM comments
        WHERE id_post = :id_post
    ');

    $query->bindValue(':id_post', $id_post, PDO::PARAM_INT);
    $query ->execute();

    return $query ->fetchColumn();
}

function add_comment( $comment = array()) {
    $pdo = connect();
    $query = $pdo -> prepare('
        INSERT INTO comments
            (comment, date_create, id_user, id_post)
        VALUES
            (:comment, NOW(), :id_user, :id_post)
        ');

        $query -> execute($comment);
}

function add_post( $add_post) {
    $pdo = connect();
    $query = $pdo -> prepare('
        INSERT INTO posts
            (title, date_update, content, id_user, id_category)
        VALUES
            (:title, NOW(), :content, :id_user, :id_category)
        ');

        $query->execute($add_post);
}

function get_users() {
    $pdo = connect();
    $query = $pdo -> prepare('
    SELECT 
        id_user, pseudo
    
    FROM `users` 
    ');

    $query ->execute();
    return $query;
}

function get_category() {
    $pdo = connect();
    $query = $pdo -> prepare('
    SELECT 
        id_category, label
    
    FROM `category` 
    ');

    $query ->execute();
    return $query;
}

function get_one_category($id_category) {
    $pdo = connect();
    $query = $pdo -> prepare('
    SELECT 
        id_category, label
    
    FROM `category` 

    WHERE id_category = :id_category
    ');

    $query->bindValue(':id_category', $id_category, PDO::PARAM_INT);
    $query ->execute();
    return $query;
}

function delet_post($id_post) {
    $pdo = connect();
    $query = $pdo -> prepare('
    DELETE FROM 
    `posts` 
    WHERE `posts`.`id_post` = :id_post
    ');

    $query->execute($id_post);

}

function edit_post($id_post) {
    $pdo = connect();
    $query = $pdo -> prepare('
        UPDATE posts
        SET 
            id_user= :id_user,
            id_category= :id_category,
            title= :title,
            content= :content,
            date_update= NOW()
        WHERE id_post = :id_post
        ');
        
        $query -> execute($id_post); 
        
}

function get_user_by_login($login) {
    $pdo = connect();
    $query = $pdo -> prepare('
        SELECT
            id_user,
            pseudo,
            pass
        FROM users
        WHERE email = :login
    ');
    
    $query -> execute(
        array(
            ':login' => $login
        )
    );
    $user = $query->fetch();
    return $user;

}

function add_document($document = array() ) {
    $pdo = connect();
    $query = $pdo -> prepare('
        INSERT INTO documents
            (name,type,size,description,legend,date_upload)
        VALUES
            (:name,:type,:size,:description,:legend,NOW())
    ');

    $query -> execute($document);
}