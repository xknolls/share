<?php

/* --------------------------- Conection à la BDD -------------------------- */

/**
 * Connection à la BDD
 *
 * @return object
 */
function connect(): object
{

    require_once('config/config.php');

    // Tenter de se connecter à la base de données
    try {
        $pdo = new PDO(
            // Source de données : DSN (Date Source Name)
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=UTF8;port= ' . DB_PORT,
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
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }


        return $pdo;
    } catch (PDOException $error) {
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

/* ----------------------- Toutes les fonctions get... ---------------------- */

/**
 * Get tous les utilisateurs enregistré dans la BDD
 *
 * return tous les utilisateur
 */
function get_users()
{
    $pdo = connect();
    $query = $pdo->prepare('
    SELECT 
        id_user, 
        pseudo, 
        firstname, 
        lastname, 
        email,
        password,
        users.id_permission,
        permissions.permission
    
    FROM `users` 

    INNER JOIN permissions ON permissions.id_permission = users.id_permission
    ');

    $query->execute();
    return $query;
}

/**
 * getUserById
 *
 * @param  mixed $id_user
 */
function getUserById(int $id_user)
{
    $oPdo = connect();
    $query = $oPdo->prepare('
    SELECT 
        *

    FROM `users`
    
    INNER JOIN permissions ON permissions.id_permission = users.id_permission

    WHERE id_user= :id_user
    ');

    $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $query->execute();
    $aUser = $query->fetch();
    return $aUser;
}

/**
 * Get user par son login
 *
 * @param  string $login
 * @return $aUser avec les infos d'un utilisateur
 */
function get_user_by_login(string $sLogin)
{
    $pdo = connect();
    $query = $pdo->prepare('
        SELECT
            id_user,
            pseudo,
            password
        FROM users
        WHERE email = :login
    ');

    $query->execute(
        array(
            ':login' => $sLogin
        )
    );
    $aUser = $query->fetch();
    return $aUser;
}

/**
 * Get user par son pseudo
 *
 * @param  string $sPseudo
 * @return $aUser avec les infos d'un utilisateur
 */
function get_user_by_pseudo(string $sPseudo)
{
    $pdo = connect();
    $query = $pdo->prepare('
        SELECT
            id_user,
            email
        FROM users
        WHERE pseudo = :pseudo
    ');

    $query->execute(
        array(
            ':pseudo' => $sPseudo
        )
    );
    $aUser = $query->fetch();
    return $aUser;
}

/**
 * get all permissions
 *
 * @return void
 */
function get_permissions()
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        SELECT * 
        FROM permissions
    ');

    $query->execute();
    return $query;
}

/**
 * get_estimation
 *
 */
function get_estimation($first, $nb_on_page)
{
    $pdo = connect();
    
    $query = $pdo -> prepare('
        SELECT * 
        FROM devis
        ORDER BY `date` DESC
        LIMIT :first, :nb_on_page
    ');
    $query->bindValue(':first', $first, PDO::PARAM_INT);
    $query->bindValue(':nb_on_page', $nb_on_page, PDO::PARAM_INT);
    $query ->execute();

    return $query;
 
}

/**
 * getDevisById
 *
 * @param  int $id_devis
 */
function getDevisById($id_devis)
{
    $pdo = connect();
    $query = $pdo -> prepare('
        SELECT
            *
        FROM devis
        WHERE id_devis = :id_devis
    ');

    $query->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
    $query->execute();
    $aDevis = $query->fetch();

    return $aDevis;
}

/**
 * getDevisByStatus
 *
 * @param  string $status
 */
function getDevisByStatus($status){
    $pdo = connect();
    $query = $pdo -> prepare('
        SELECT
            *
        FROM devis
        WHERE status = :status
    ');

    $query->bindValue(':status', $status, PDO::PARAM_STR);
    $query->execute();

    return $query;
}

/**
 * getCountDevis
 *
 */
function getCountDevis()
{
    $pdo = connect();
    $query = $pdo -> prepare('
        SELECT
        COUNT(*) AS nb_devis FROM `devis`
    '); 
    $query->execute();
    $nb_devis = $query->fetch();

    return $nb_devis;
}

/**
 * get_subjects
 * requête SQL qui recupere dans une variable tout les sujets de la base de donnée
 *
 * @return void
 */
function get_subjects()
{
    $pdo = connect();
    $query = $pdo->prepare('
    SELECT
        *
    FROM `subject`
    ');

    $query->execute();
    return $query;
}

/* ---------------------------- Ajout dans la BDD --------------------------- */

/**
 * ajout un document en BDD
 *
 * @param  array $aDocument qui contient toute les infos du document à uploader
 * 
 * @return void
 */
function add_document(array $aDocument): void
{

    $pdo = connect();
    $query = $pdo->prepare('
        INSERT INTO documents
            (name,type,size,description,legend,date_upload, id_user)
        VALUES
            (:name,:type,:size,:description,:legend,NOW(),:id_user)
    ');

    $query->execute($aDocument);
}

/**
 * Enregistrement en BDD de notre nouvel utilisateur
 *
 * @param  array $aUserInfos
 * @return void
 */
function register(array $aUserInfos): void
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        INSERT INTO users 
            (firstname, lastname, pseudo, email, password) 
        VALUES 
            (:firstname, :lastname, :pseudo, :email, :password);
    ');

    $query->execute($aUserInfos);
}

/**
 * add_estimation
 *
 * @param  array $data
 */
function add_estimation($data = array())
{
    $pdo = connect();
    
    $query = $pdo -> prepare('
    INSERT INTO devis
    (firstname, lastname, email, tel, city, subject, message, date, id_user) 
    VALUES (:firstname, :lastname, :email, :tel, :city, :subject, :message, NOW(), 1)
    ');


    $query -> execute($data);
 
}

/**
 * add_subject
 * 
 * @param string
 */
function add_subject($label)
{
    $pdo = connect();
    
    $query = $pdo -> prepare('
    INSERT INTO subject
        label_subject
    VALUES
        :label_subject
    ');

    $query -> bindValue(':label_subject', $label, PDO::PARAM_STR);
    $query -> execute();
}

/* ---------------------------- Edit dans la BDD ---------------------------- */

/**
 * edit_user
 *
 * @param  array $aUserInfos
 * @return void
 */
function edit_user(array $aUserInfos): void
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        UPDATE `users`
        SET 
            id_permission= :id_permission
            
        WHERE id_user= :id_user
    ');
    $query->execute($aUserInfos);
}

/**
 * edit_account
 *
 * @param  array $aUserInfos
 * @return void
 */
function edit_account(array $aUserInfos): void
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        UPDATE `users`
        SET 
            firstname= :firstname,
            lastname= :lastname,
            pseudo= :pseudo, 
            email= :email
            
        WHERE id_user= :id_user
    ');
    $query->execute($aUserInfos);
}

/**
 * edit_password
 *
 * @param  string $sPassword
 * @return void
 */
function edit_password(array $sPassword): void
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        UPDATE `users`
        SET 
            password= :newPassword
        WHERE id_user= :id_user
    ');
    $query->execute($sPassword);
}

/**
 * edit_status d'une demande de devi
 *
 * @param  array $aDatas
 */
function edit_status($aDatas)
{
    $pdo = connect();

    $query = $pdo -> prepare('
        UPDATE devis
        SET 
            status = :status
        WHERE id_devis = :id_devis
    ');

    $query -> execute($aDatas);

    return $query;
}

/**
 * edit_subject
 * requête SQL permettant de modifier un sujet de devis
 * 
 * @param  mixed $aLabel
 * @return void
 */
function edit_subject($aLabel)
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        UPDATE `subject`
        SET 
            label_subject= :label_subject
            
        WHERE id_subject= :id_subject
    ');
    $query->execute($aLabel);
}

/**
 * confirmation du compte
 *
 * @param  int $id_user
 * @return void
 */
function edit_status_confimation_user_account($id_user)
{
    $oPdo = connect();
    $query = $oPdo->prepare('
        UPDATE users
        SET 
            confirmation_token = NULL,
            confirmed_at = NOW()
        WHERE id_user = :id_user
    ');

    $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $query->execute();
}

/* ------------------------- Supression dans la BDD ------------------------- */

/**
 * deleteUser
 *
 * @param  mixed $user
 * @return void
 */
function deleteUser($user): void
{
    $oPdo = connect();
    $query = $oPdo->prepare('
            DELETE FROM `users` 
            WHERE `users`.`id_user` = :id_user;
        ');

    $query->execute($user);
}

/**
 * delete_devis
 *
 * @param  int $id_devis
 * @return void
 */
function delete_devis($id_devis)
{
    $pdo = connect();
    $query = $pdo -> prepare('
        DELETE FROM 
        `devis`
        WHERE id_devis = :id_devis
    ');
    $query->bindValue(':id_devis', $id_devis, PDO::PARAM_INT);
    $query->execute();
}

/**
 * delete_subject
 * requête SQL permettant de supprimer des sujets de devis
 *
 * @param  mixed $id_subject
 * @return void
 */
function delete_subject($id_subject)
{
    $pdo = connect();
    $query = $pdo -> prepare('
        DELETE FROM
            `subject`
        WHERE id_subject= :id_subject
    ');
    $query->bindValue(':id_subject', $id_subject, PDO::PARAM_INT);
    $query->execute();
}
