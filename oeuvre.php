<?php
    // Si l'URL ne contient pas d'id et n'est pas un caractère numérique , on redirige sur la page d'accueil
    if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php');
        exit;
    }

    require_once 'db/db.php';

    $query = $db->prepare('SELECT * FROM oeuvres WHERE id = ?');
    $query->execute([intval($_GET['id'])]);
    $oeuvre = $query->fetch();


    

    // Si aucune oeuvre trouvé, on redirige vers la page d'accueil
    if(!$oeuvre) {
        header('Location: index.php');
        exit;
    }

    require 'header.php';
?>

<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <img src="<?= $oeuvre['image'] ?>" alt="<?= $oeuvre['titre'] ?>">
    </div>
    <div id="contenu-oeuvre">
        <h1><?= $oeuvre['titre'] ?></h1>
        <p class="description"><?= $oeuvre['artiste'] ?></p>
        <p class="description-complete">
             <?= $oeuvre['description'] ?>
        </p>
    </div>
</article>

<?php require 'footer.php'; ?>
