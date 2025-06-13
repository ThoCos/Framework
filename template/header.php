<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?? "" ?>">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/bb465da9b8.js" crossorigin="anonymous"></script>
    <title> <?= $title ?> </title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a class="<?= $_SERVER['REQUEST_URI'] == DIRECTORY_SEPARATOR ? 'active' : '' ?>" href="/"><i class="fa-solid fa-house"></i></a>
                </li>
                <li>
                    <a class="<?= $_SERVER['REQUEST_URI'] == DIRECTORY_SEPARATOR . 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a>
                </li>
                <div id="compte">
                    <!--
                    <li>
                        <a class="<?= $_SERVER['REQUEST_URI'] == DIRECTORY_SEPARATOR . 'inscription.php' ? 'active' : '' ?>" href="inscription.php">Inscription</a>
                    </li>
                    -->
                    <li>
                        <a class="<?= $_SERVER['REQUEST_URI'] == DIRECTORY_SEPARATOR . 'connexion.php' ? 'active' : '' ?>" href="connexion.php">Connexion</a>
                    </li>
                    <li id="profil">
                        <a class="<?= $_SERVER['REQUEST_URI'] == DIRECTORY_SEPARATOR . 'profil.php' ? 'active' : '' ?>" href="profil.php"><i class="fa-solid fa-user"></i></a>
                    </li>
                </div>
            </ul>
        </nav>
    </header>
    <main>