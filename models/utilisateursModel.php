<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'gestionBdd.php';

function selectionnerUtilisateur()
{
    $config = obtenirConfigBdd();

    $dsn = "mysql:host={$config['serveur']};dbname={$config['bdd']};charset=utf8mb4";

    $pdo = new PDO($dsn, $config['utilisateur'], $config['mdp']);


    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
};
