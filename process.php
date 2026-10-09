<?php
session_start();

// Vérifier que la  requête est en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifier les données du formulaire
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

    // En cas d'erreur, rediriger vers le formulaire    
    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        $_SESSION['inputs'] = [
            'titre' => $titre,
            'artiste' => $artiste,
            'image' => $image,
            'description' => $description
        ];

        header('Location: add.php');
        exit;
    
    }

// Enregistrer l'œuvre en base de données
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
    header('location: artwork.php?id=' . $db->lastInsertId());
    exit;

} else {
    header('location: add.php');      
}
