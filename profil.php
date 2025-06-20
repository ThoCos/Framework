<?php
/* ______________________Profil___________________________________ */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$description = "Vous êtes sur la page profil";
$title = "Profil";

if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}

$pseudo = htmlspecialchars($_SESSION['utilisateur']['pseudo']);
$email = htmlspecialchars($_SESSION['utilisateur']['email']);
?>

<?php require 'template' . DIRECTORY_SEPARATOR . 'header.php' ?>
<article class="profil">
    <div>
        <i class="fa-solid fa-user"></i>
        <p><span>Utilisateur:</span> <?= $pseudo ?></p>
        <p><span>Email:</span> <?= $email ?></p>
    </div>
</article>
<?php require 'template' . DIRECTORY_SEPARATOR . 'footer.php' ?>