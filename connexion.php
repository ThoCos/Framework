<?php
$description = "Vous êtes sur la page de connexion";
$title = "Connexion";

require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';
$pdo = obtenirConnexionBdd();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$formMessage = '';
$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $mdp = trim($_POST['mdp'] ?? '');

    /* Validation des champs */
    if ($pseudo === '') {
        $erreurs['pseudo'] = "<p>Le pseudo est requis!</p>";
    } elseif (mb_strlen($pseudo) < 2 || mb_strlen($pseudo) > 255) {
        $erreurs['pseudo'] = "<p>Le pseudo doit contenir entre 2 et 255 caractères!</p>";
    }

    if ($mdp === '') {
        $erreurs['mdp'] = "<p>Le mot de passe est requis!</p>";
    } elseif (mb_strlen($mdp) < 8 || mb_strlen($mdp) > 72) {
        $erreurs['mdp'] = "<p>Le mot de passe doit contenir entre 8 et 72 caractères!</p>";
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("SELECT id, pseudo,mdp, email FROM utilisateur WHERE pseudo = :pseudo");

        $stmt->execute(['pseudo' => $pseudo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['mdp'])) {
            $_SESSION['utilisateur'] = [
                'id' => $user['id'],
                'pseudo' => $user['pseudo'],
                'email' => $user['email']
            ];
            $formMessage = "<p class='retour'>Bienvenue " . htmlspecialchars($user['pseudo']) . "</p>";
        } else {
            $formMessage = "<p class='retour'>⚠ Mauvais identifiants</p>";
        }
    }
}
?>

<?php require 'template' . DIRECTORY_SEPARATOR . 'header.php' ?>
<h1> Connexion </h1>

<form action="" method="post">
    <p>
        <label for="pseudo">Pseudo: </label><br>
        <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($pseudo ?? '') ?>" minlength="2" maxlength="255" required>
        <?= $erreurs['pseudo'] ?? '' ?>
    </p>
    <p>
        <label for="mdp">Mot de passe: </label><br>
        <input type="password" id="mdp" name="mdp" minlength="8" maxlength="72" required>
        <?= $erreurs['mdp'] ?? '' ?>
    </p>

    <p id="connexion">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>

    <input type="submit" value="Se connecter">
    <?= $formMessage ?>
</form>

<?php require 'template' . DIRECTORY_SEPARATOR . 'footer.php' ?>