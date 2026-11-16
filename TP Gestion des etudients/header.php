<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= h($titre ?? 'Gestion des Étudiants') ?></title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Gestion des Étudiants</h1>
        <?php if (connecte()): ?>
        <nav>
            <a href="liste.php">Liste</a>
            <a href="ajouter.php">Ajouter</a>
            <a href="logout.php">Déconnexion (<?= h($_SESSION['login']) ?>)</a>
        </nav>
        <?php endif; ?>
    </header>
    <main>
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash success"><?= h($_SESSION['flash']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
