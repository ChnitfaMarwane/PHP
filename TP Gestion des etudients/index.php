<?php
require_once 'functions.php';
if (connecte()) { header('Location: liste.php'); exit; }
$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    if (isset(UTILISATEURS[$login]) && UTILISATEURS[$login] === $mdp) {
        $_SESSION['login'] = $login;
        setcookie('dernier_user', $login, time() + 7 * 24 * 3600);
        header('Location: liste.php');
        exit;
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
$dernier_user = $_COOKIE['dernier_user'] ?? '';
$titre = "Connexion";
include 'header.php';
?>
<div class="carte">
    <h2>Connexion</h2>
    <?php if ($erreur): ?><div class="flash error"><?= h($erreur) ?></div><?php endif; ?>
    <form method="post">
        <label>Login:</label>
        <input type="text" name="login" value="<?= h($login ?? $dernier_user) ?>" required>
        <label>Mot de passe:</label>
        <input type="password" name="mdp" required>
        <button type="submit">Se connecter</button>
    </form>
</div>
<?php include 'footer.php'; ?>
