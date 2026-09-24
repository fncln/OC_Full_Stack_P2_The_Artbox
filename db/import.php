<?php
require_once 'db.php';
require_once '../oeuvres.php';

$query = $db->prepare('
    INSERT INTO oeuvres (id, titre, artiste, description, image)
    VALUES (:id, :titre, :artiste, :description, :image)
');

foreach ($oeuvres as $o) {
    $query->execute([
        'id'            =>$o['id'],
        'titre'         =>$o['titre'],
        'artiste'        =>$o['artiste'],
        'description'   =>$o['description'],
        'image'         =>$o['image'],
    ]);
}

echo "Toutes les œuvres ont été importées avec succès !";

