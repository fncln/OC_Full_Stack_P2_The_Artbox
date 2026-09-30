<?php

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

    if (!empty($errors)) {
        $params = [
            'errors' => implode(',', $errors),
            'titre' => $titre,
            'artiste' => $artiste,
            'image' => $image,
            'description' => $description
        ];
        header('Location: ajouter.php?' . http_build_query($params));
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
