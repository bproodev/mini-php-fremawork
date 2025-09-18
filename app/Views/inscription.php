<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Inscription</title>
</head>
<body>
    <h1>Page d'inscription</h1>
    <?php if (!empty($errors)): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $fieldErrors): ?>
                <?php foreach ($fieldErrors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li> <br>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    <?php elseif($user): ?>
        <p>Utilisateur, <?= htmlspecialchars($user["prenom"]) ?> a ete creer avec succes!</p>
    <?php else: ?>
        <form method="POST" action="<?= BASE_PATH ?>/sinscrire">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">S'inscrire</button>
        </form>
    <?php endif; ?>
</body>
</html>