<?php 
session_start();

require 'header.php'; 

$messages = [
    'titre'              => "Le titre est obligatoire.",
    'artiste'            => "L'artiste est obligatoire.",
    'image'              => "L'image est obligatoire.",
    'url'                => "L'URL de l'image n'est pas valide.",
    'description'        => "La description est obligatoire.",
    'description_courte' => "La description doit contenir au moins 3 caractères."
];

$values = $_SESSION['inputs'] ?? [
    'titre'       => '',
    'artiste'     => '',
    'image'       => '',
    'description' => ''
];

$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['inputs'], $_SESSION['errors']);

function getErrorClass(array $keys, array $errors): string {
    foreach ($keys as $key) {
        if (in_array($key, $errors, true)) { return 'input-error';
        }
    }
    return '';
}

// Afficher les messages d'erreur 
function displayErrorMessage(array $keys, array $errors, array $messages): void {
    foreach ($keys as $key) {
        if (in_array($key, $errors, true)) {
            echo '<p class="error">' . $messages[$key] . '</p>';
            break;
        }
    }
}

// Afficher le formulaire
?>
<form action="process.php" method="POST">
    <div class="champ-formulaire">
        <label for="titre">Titre de l'œuvre</label>
        <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($values['titre']) ?>" class="<?= getErrorClass(['titre'], $errors) ?>">
        <?php displayErrorMessage(['titre'], $errors, $messages); ?>
    </div>

    <div class="champ-formulaire">
        <label for="artiste">Auteur de l'œuvre</label>
        <input type="text" name="artiste" id="artiste" value="<?= htmlspecialchars($values['artiste']) ?>" class="<?= getErrorClass(['artiste'], $errors) ?>">
        <?php displayErrorMessage(['artiste'], $errors, $messages); ?>
    </div>

    <div class="champ-formulaire">
        <label for="image">URL de l'image</label>
        <input type="url" name="image" id="image" value="<?= htmlspecialchars($values['image']) ?>" class="<?= getErrorClass(['image', 'url'], $errors) ?>">
        <?php displayErrorMessage(['image', 'url'], $errors, $messages); ?>
    </div>

    <div class="champ-formulaire">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="<?= getErrorClass(['description', 'description_courte'], $errors) ?>"><?= htmlspecialchars($values['description']) ?></textarea>
        <?php displayErrorMessage(['description', 'description_courte'], $errors, $messages); ?>
    </div>

    <input type="submit" value="Valider" name="submit">
</form>

<?php require 'footer.php'; ?>