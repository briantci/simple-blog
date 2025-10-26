<?php
// -----------------------------------------------------------------------------
// Initialisation de la session et configuration de base
// -----------------------------------------------------------------------------
declare(strict_types=1);
session_start(); // Démarrage de la session avant toute utilisation de $_SESSION

// (Optionnel en développement) : activer l’affichage complet des erreurs
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$message = null; // Message d’erreur ou de succès initialisé à null

// -----------------------------------------------------------------------------
// Vérification de la méthode de la requête
// -----------------------------------------------------------------------------
// Erreur d’origine : "RQUEST_METHOD" → orthographe incorrecte.
// Correction : utilisation correcte de $_SERVER['REQUEST_METHOD']
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

    // -------------------------------------------------------------------------
    // Récupération et validation des entrées utilisateur
    // -------------------------------------------------------------------------
    // Utilisation de filter_input pour éviter l’accès direct à $_POST
    // et garantir que les valeurs sont bien récupérées sous forme de chaînes.
    $login    = filter_input(INPUT_POST, 'login', FILTER_UNSAFE_RAW, ['options' => ['default' => null]]);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW, ['options' => ['default' => null]]);

    // Nettoyage des entrées (suppression des espaces inutiles)
    $login    = is_string($login) ? trim($login) : null;
    $password = is_string($password) ? $password : null;

    // Vérifie si les champs sont remplis
    if ($login === null || $login === '' || $password === null || $password === '') {
        $message = "Nom d'utilisateur et mot de passe sont requis.";
    } else {
        // ---------------------------------------------------------------------
        // Prévention des attaques de fixation de session
        // ---------------------------------------------------------------------
        session_regenerate_id(true);

        // Erreur d’origine : appel de connectUser() avec $_GET['login']
        // Correction : utilisation de la valeur provenant de POST ($login)
        // connectUser doit être une fonction sécurisée (requêtes préparées + password_verify)
        $user = connectUser($login, $password);

        // ---------------------------------------------------------------------
        // 🟢 Vérification du résultat de l’authentification
        // ---------------------------------------------------------------------
        if ($user !== null) {
            // Stocke les informations de l’utilisateur dans la session
            $_SESSION['User'] = $user;

            // Régénère l’ID de session après connexion (bonne pratique)
            session_regenerate_id(true);

            // Redirige vers la page d’accueil et arrête l’exécution du script
            header('Location: index.php', true, 302);
            exit;
        }

        // Si l’authentification échoue, on renvoie un message neutre
        $message = "Mauvais login ou mot de passe";
    }
}
?>

<!-- --------------------------------------------------------------------------
Partie HTML – Formulaire de connexion
Correction des erreurs de structure et amélioration de la sécurité
-------------------------------------------------------------------------- -->

<section class="wrapper style1 align-center">
    <div class="inner">
        <div class="index align-left">
            <section>
                <header>
                    <h3>Se connecter</h3>
                    <!-- Erreur d’origine : </li> isolé supprimé -->
                    <a href="index.php" class="button big wide smooth-scroll-middle">Revenir à l'accueil</a>
                </header>

                <div class="content">
                    <!-- Affiche le message d’erreur ou de succès, avec protection XSS -->
                    <?php if ($message !== null): ?>
                        <p><?= htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
                    <?php endif; ?>

                    <!-- Action vide = envoi du formulaire sur la même page -->
                    <form method="post" action="">
                        <div class="fields">
                            <div class="field half">
                                <label for="login">Nom d'utilisateur</label>
                                <input type="text"
                                       name="login"
                                       id="login"
                                       value=""
                                       autocomplete="username"
                                       required />
                            </div>

                            <div class="field half">
                                <label for="password">Mot de passe</label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       value=""
                                       autocomplete="current-password"
                                       required />
                            </div>
                        </div>

                        <ul class="actions">
                            <li>
                                <input type="submit"
                                       name="submit"
                                       id="submit"
                                       value="Se connecter" />
                            </li>
                        </ul>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>