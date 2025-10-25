<?php
    // Démarrage de la session PHP
    session_start();

    //Mise en place des constantes
    define('TL_ROOT', dirname(__DIR__)); // Chemin vers la racine du projet
    define('LOGIN', 'UEL311'); // Login de base
    define('PASSWORD', 'U31311'); // Mot de passe de base
    define('DB_ARTICLES', TL_ROOT.'/db/articles.json'); // Chemin vers le fichier json des articles

    // Fonction de connexion utilisateur    
    function connectUser($login = null, $password = null){
        if(!is_null($login) && !is_null($password)){
            if($login === LOGIN && $password === PASSWORD){
                return array(
                    'login'    => LOGIN,
                    'password' => PASSWORD
                );
            }
        }
        return null;
    }
    // Fonction de déconnexion utilisateur
    function setDisconnectUser(){
         unset($_SESSION['User']);
         session_destroy();
    }
    // Fonction de vérification de la connexion utilisateur
    function isConnected(){
        if(array_key_exists('User', $_SESSION) 
                && !is_null($_SESSION['User'])
                    && !empty($_SESSION['User'])){
            return true;
        }
        return false;
    }
    // Fonction de récupération du template de la page
    function getPageTemplate($page = null){
        $fichier = TL_ROOT.'/pages/'.(is_null($page) ? 'index.php' : $page.'.php');

        if(!file_exists($fichier)){
            include TL_ROOT.'/pages/index.php';
        }else{
            include $fichier;
        }
    }
    // Fonction de récupération des articles depuis le fichier JSON
    function getArticlesFromJson(){
        if(file_exists(DB_ARTICLES)) {
            $contenu_json = file_get_contents(DB_ARTICLES);
            return json_decode($contenu_json, true);
        }

        return null;
    }

    // Fonction pour récupérer les articles par ID depuis le fichier JSON
     function getArticleById($id_article = null){
       if(file_exists(DB_ARTICLES)) {
            $contenu_json = file_get_contents(DB_ARTICLES);
            $_articles    = json_decode($contenu_json, true);

            foreach($_articles as $article){
                if($article['id'] == $id_article){
                    return $article;
                }
            }
        }

        return null;
    }
