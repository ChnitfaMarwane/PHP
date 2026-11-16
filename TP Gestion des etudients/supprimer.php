<?php
require_once 'functions.php';
exiger_connexion();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$etudiants = lire_etudiants();
if (isset($etudiants[$id])) {
    $photo = $etudiants[$id]['photo'];
    if ($photo && file_exists('uploads/' . $photo)) unlink('uploads/' . $photo);
    unset($etudiants[$id]);
    sauver_etudiants($etudiants);
    $_SESSION['flash'] = "Étudiant supprimé avec succès.";
}
header('Location: liste.php');
exit;
