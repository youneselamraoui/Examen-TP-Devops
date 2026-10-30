
<?php

// Tests de la classe Bibliotheque

$bibliotheque = new Bibliotheque();

// Création des livres
$livre1 = new Livre('9782100545261', 'Algorithmique', 'Cormen');
$livre2 = new Livre('2100545264', 'PHP', 'Dupont');
$livre3 = new Livre('9780132350884', 'Clean Code', 'Cormen');

// Test : ajouter des livres
$bibliotheque->ajouter($livre1);
$bibliotheque->ajouter($livre2);
$bibliotheque->ajouter($livre3);

verifier($bibliotheque->compter() === 3, 'Ajouter trois livres');

// Test : trouver un livre
verifier(
    $bibliotheque->trouver('9782100545261') === $livre1,
    'Trouver un livre par ISBN'
);

// Test : livre inexistant
verifier(
    $bibliotheque->trouver('1234567890') === null,
    'Retourner null si le livre nexiste pas'
);

// Test : retourner tous les livres
verifier(
    count($bibliotheque->tous()) === 3,
    'Retourner tous les livres'
);

// Test : rechercher par titre
verifier(
    count($bibliotheque->rechercher('PHP')) === 1,
    'Rechercher un livre par titre'
);

// Test : rechercher par auteur
verifier(
    count($bibliotheque->rechercher('Cormen')) === 2,
    'Rechercher un livre par auteur'
);

// Test : recherche insensible à la casse
verifier(
    count($bibliotheque->rechercher('php')) === 1,
    'Recherche insensible à la casse'
);

// Test : ajouter un livre avec ISBN déjà existant
$exceptionDoublon = false;

try {
    $livreDoublon = new Livre(
        '9782100545261',
        'Autre livre',
        'Autre auteur'
    );

    $bibliotheque->ajouter($livreDoublon);
} catch (Exception $e) {
    $exceptionDoublon = true;
}

verifier(
    $exceptionDoublon,
    'Refuser un livre avec un ISBN déjà existant'
);

// Test : statistiques du catalogue

// Emprunter un livre
$livre2->emprunter();

$stats = $bibliotheque->statistiques();

verifier(
    $stats['total'] === 3,
    'Statistiques : nombre total de livres'
);

verifier(
    $stats['disponibles'] === 2,
    'Statistiques : nombre de livres disponibles'
);

verifier(
    $stats['empruntes'] === 1,
    'Statistiques : nombre de livres empruntés'
);

verifier(
    $stats['auteurs_differents'] === 2,
    'Statistiques : nombre d auteurs différents'
);

// Test : statistiques d'une bibliothèque vide

$bibliothequeVide = new Bibliotheque();
$statsVides = $bibliothequeVide->statistiques();

verifier(
    $statsVides['total'] === 0,
    'Bibliothèque vide : aucun livre'
);

verifier(
    $statsVides['disponibles'] === 0,
    'Bibliothèque vide : aucun livre disponible'
);

verifier(
    $statsVides['empruntes'] === 0,
    'Bibliothèque vide : aucun livre emprunté'
);

verifier(
    $statsVides['auteurs_differents'] === 0,
    'Bibliothèque vide : aucun auteur'
);
