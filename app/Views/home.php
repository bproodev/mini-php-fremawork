<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVP Framework</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
</head>
<body>
    <h1 class="title">Salut a toi le pro!</h1>
    <ul>
        <?php foreach($users as $user): ?>
            <li><?= htmlspecialchars($user->nom) ?></li>-
            <li><?= htmlspecialchars($user->prenom) ?></li>
        <?php endforeach ?>
    </ul>
    <a href="<?= BASE_PATH ?>/inscription">Inscrivez vous</a>
    <script src="<?= BASE_PATH ?>/assets/js/script.js"></script>
</body>
</html>


