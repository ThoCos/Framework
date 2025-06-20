<?php
/* ______________________Inscription___________________________________ */

$description = "Vous êtes sur la page d'inscription";
$title = "Inscription";
require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';

/* jeton */
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$inscriptionPseudo = '';
$inscriptionMdp = '';
$inscriptionMdpConfirmation = '';
$inscriptionEmail = '';
$erreurs = [];
$formMessage = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $erreurs = [];

    $inscriptionPseudo = trim($_POST['inscriptionPseudo'] ?? '');
    $inscriptionMdp = trim($_POST['inscriptionMdp'] ?? '');
    $inscriptionMdpConfirmation = trim($_POST['inscriptionMdpConfirmation'] ?? '');
    $inscriptionEmail = trim($_POST['inscriptionEmail'] ?? '');

    /* Validation */
    if ($inscriptionPseudo == '') {
        $erreurs['inscriptionPseudo'] = "<p>Le pseudo est requis !</p>";
    } elseif (mb_strlen($inscriptionPseudo) < 2 || mb_strlen($inscriptionPseudo) > 255) {
        $erreurs['inscriptionPseudo'] = "<p>Le pseudo doit contenir entre 2 et 255 caractères !</p>";
    }

    if (!filter_var($inscriptionEmail, FILTER_VALIDATE_EMAIL)) {
        $erreurs['inscriptionEmail'] = "<p>L'adresse e-mail est invalide !</p>";
    }

    if ($inscriptionMdp == '') {
        $erreurs['inscriptionMdp'] = "<p>Le mot de passe est requis !</p>";
    } elseif (mb_strlen($inscriptionMdp) < 8 || mb_strlen($inscriptionMdp) > 72) {
        $erreurs['inscriptionMdp'] = "<p>Le mot de passe doit contenir entre 8 et 72 caractères !</p>";
    } elseif ($inscriptionMdp !== $inscriptionMdpConfirmation) {
        $erreurs['inscriptionMdp'] = "<p>Les mots de passe ne correspondent pas !</p>";
    }

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $erreurs['csrf'] = "<p>Mauvaise combinaison d'utilisateur</p>";
    }
    if (empty($erreurs)) {
        $hash = password_hash($inscriptionMdp, PASSWORD_DEFAULT);

        try {
            $pdo = obtenirConnexionBdd();
            $stmt = $pdo->prepare("INSERT INTO utilisateur (pseudo, mdp, email) VALUES (?, ?, ?)");
            $stmt->execute([$inscriptionPseudo, $hash, $inscriptionEmail]);

            $formMessage = "<p>Inscription réussie !</p>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $formMessage = "<p>Ce pseudo ou cet email existe déjà.</p>";
            } else {
                $formMessage = "<p>Erreur PDO : " . $e->getMessage() . "</p>";
            }
        }
    }
}

?>
<?php require 'template' . DIRECTORY_SEPARATOR . 'header.php' ?>
<h1> Inscription </h1>

<form action="" method="post">
    <p>
        <label for="inscriptionPseudo">Pseudo: </label><br>
        <input type="text" id="inscriptionPseudo" name="inscriptionPseudo" value="<?= htmlspecialchars($inscriptionPseudo ?? '') ?>" minlength="2" maxlength="255" required>
        <?= $erreurs['inscriptionPseudo'] ?? '' ?>
    </p>
    <p>
        <label for="inscriptionMdp">Mot de passe: </label><br>
        <input type="password" id="inscriptionMdp" name="inscriptionMdp" value="<?= htmlspecialchars($inscriptionMdp ?? '') ?>" minlength="8" maxlength="72">
        <?= $erreurs['inscriptionMdp'] ?? '' ?>
    </p>

    <p>
        <label for="inscriptionMdpConfirmation">Confirmer mot de passe: </label><br>
        <input type="password" id="inscriptionMdpConfirmation" name="inscriptionMdpConfirmation" minlength="8" maxlength="72">
        <?= $erreurs['inscriptionMdp'] ?? '' ?>
    </p>

    <p>
        <label for="inscriptionEmail">Mail: </label><br>
        <input type="email" id="inscriptionEmail" name="inscriptionEmail" required>
        <?= $erreurs['inscriptionEmail'] ?? '' ?>
    </p>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="submit" value="S'inscrire">
    <?= $formMessage ?? '' ?>
</form>


<?php require 'template' . DIRECTORY_SEPARATOR . 'footer.php' ?>