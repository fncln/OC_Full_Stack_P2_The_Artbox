<?php
require_once 'db.php';
require_once '../oeuvres.php';

$query = $db->prepare('
    INSERT INTO oeuvres (id, titre, artiste, description, image)
    VALUES (:id, :titre, :artiste, :description, :image)
');

foreach ($oeuvres as $oeuvre) {
    $query->execute([
        'id'            =>$oeuvre['id'],
        'titre'         =>$oeuvre['titre'],
        'artiste'        =>$oeuvre['artiste'],
        'description'   =>$oeuvre['description'],
        'image'         =>$oeuvre['image'],
    ]);
}

echo "Toutes les œuvres ont été importées avec succès !";

