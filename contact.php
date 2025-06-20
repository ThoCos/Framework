<?php
/* ______________________Formulaire___________________________________ */

$description = "Vous êtes sur la page contact";
$title = "contact";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $erreurs = [];

    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['mail'] ?? '');
    $message = trim($_POST['message'] ?? '');

    /* Validation des champs REQUIS */
    if ($nom == '') {
        $erreurs['nom'] = "<p>Le nom est requis!</p>";
    } elseif (mb_strlen($nom) < 2 || mb_strlen($nom) > 255) {
        $erreurs['nom'] = "<p>Le nom doit contenir entre 2 et 255 caractères!</p>";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = "<p>L'adresse e-mail est invalide!</p>";
    }

    if ($message == '') {
        $erreurs['message'] = "<p>Le message est requis!</p>";
    } elseif (mb_strlen($message) < 10 || mb_strlen($message) > 3000) {
        $erreurs['message'] = "<p>Le message doit contenir entre 10 et 3000 caractères!</p>";
    }

    if ($prenom != '' && (mb_strlen($prenom) < 2 || mb_strlen($prenom) > 255)) {
        $erreurs['prenom'] = "<p>Le prénom doit contenir entre 2 et 255 caractères!</p>";
    }

    if (empty($erreurs)) {
        $to = "thomas.cosin3@gmail.com";
        $subject = "Projet Framework - Formulaire de contact";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $emailBody = "Nom: $nom\n";
        $emailBody .= "Prénom: $prenom\n";
        $emailBody .= "Email: $email\n";
        $emailBody .= "Message:\n$message\n";

        if (mail($to, $subject, $emailBody, $headers)) {
            $formMessage = "<p>Votre message a bien été envoyé !</p>";
        } else {
            $formMessage = "<p>Une erreur est survenue lors de l'envoi du message.</p>";
        }
    }
}
?>
<?php require 'template' . DIRECTORY_SEPARATOR . 'header.php' ?>
<h1>Contact </h1>

<form action="" method="post">
    <p>
        <label for="nom">Nom <span class="alert">*</span>: </label><br>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" minlength=" 2" maxlength="255" required>
        <?= $erreurs['nom'] ?? '' ?>
    </p>
    <p>
        <label for="prenom">Prénom: </label><br>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" minlength="2" maxlength="255">
        <?= $erreurs['prenom'] ?? '' ?>
    </p>

    <p>
        <label for="email">Mail <span class="alert">*</span>: </label><br>
        <input type="email" id="email" name="mail" value="<?= htmlspecialchars($email ?? '') ?>" required>
        <?= $erreurs['email'] ?? '' ?>
    </p>
    <p>
        <label for="message"> Message: </label><br>
        <textarea id="message" name="message" minlength="10" maxlength="3000" rows="5"><?= htmlspecialchars($message ?? '') ?></textarea>
        <?= $erreurs['message'] ?? '' ?>
    </p>

    <input type="submit" value="Envoyer">
    <?= $formMessage ?? '' ?>
</form>

<?php require 'template' . DIRECTORY_SEPARATOR . 'footer.php' ?>