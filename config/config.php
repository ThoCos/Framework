<?php

define('DEV_MODE', true);

function obtenirConfigBdd(): array
{
    return [
        'serveur'     => 'localhost',
        'bdd'         => 'utilisateur',
        'utilisateur' => 'root',
        'mdp'         => ''
    ];
}
