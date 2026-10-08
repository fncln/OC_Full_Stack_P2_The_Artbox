<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $artiste = trim($_POST['artiste'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $errors = [];

    if (empty($titre)) {
        $errors[] = 'titre';
    }

    if (empty($artiste)) {
        $errors[]= "artiste";
    }

    if (empty($image)) {
        $errors[]= 'image';
    } elseif (!filter_var($image, FILTER_VALIDATE_URL) || !str_starts_with($image, 'https://')) {
        $errors[] = 'url';
    }

    if (empty($description)) {
        $errors[]= "description";
    } elseif (strlen($description)<3) {
        $errors[]= "description_courte";
    }
    // Pas de négation "!". Comptage des erreurs.    
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['inputs'] = [
            'titre' => $titre,
            'artiste' => $artiste,
            'image' => $image,
            'description' => $description
        ];

        header('Location: ajouter.php');
        exit;
    
    }

require_once 'db/db.php';

$query = $db->prepare('
    INSERT INTO oeuvres (titre, artiste, image, description) 
    VALUES (:titre, :artiste, :image, :description)
');

$query->execute([
    'titre' => $titre, 
    'artiste' => $artiste, 
    'image' => $image, 
    'description'=> $description,
]);
    header('location: oeuvre.php?id=' . $db->lastInsertId());
    exit;

} else {
    header('location: ajouter.php');      
}
