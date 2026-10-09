<?php
    require 'header.php';
    require_once 'db/db.php';
    $oeuvres = $db->query('SELECT * FROM oeuvres ORDER BY id ASC')->fetchAll();
?>

<div id="liste-oeuvres">
    <?php foreach($oeuvres as $oeuvre): ?>
        <article class="oeuvre">
            <a href="artwork.php?id=<?= htmlspecialchars($oeuvre['id']) ?>">
                <img src="<?= htmlspecialchars($oeuvre['image']) ?>" alt="<?= htmlspecialchars($oeuvre['titre']) ?>">
                <h2><?= htmlspecialchars($oeuvre['titre']) ?></h2>
                <p class="description"><?= htmlspecialchars($oeuvre['artiste']) ?></p>
            </a>
        </article>
    <?php endforeach; ?>
</div>
<?php require 'footer.php'; ?>
