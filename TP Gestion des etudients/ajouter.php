<?php
require_once 'functions.php';
exiger_connexion();
$etudiants = lire_etudiants();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$etudiant = $id > 0 && isset($etudiants[$id]) ? $etudiants[$id] : null;
$nom = $etudiant['nom'] ?? '';
$prenom = $etudiant['prenom'] ?? '';
$filiere = $etudiant['filiere'] ?? '';
$note = $etudiant['note'] ?? '';
$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $filiere = $_POST['filiere'] ?? '';
    $note = $_POST['note'] ?? '';
    if (empty(trim($nom))) $erreurs[] = "Le nom est obligatoire.";
    if (empty(trim($prenom))) $erreurs[] = "Le prénom est obligatoire.";
    if (!in_array($filiere, FILIERES)) $erreurs[] = "Filière invalide.";
    if (!is_numeric($note) || $note < 0 || $note > 20) $erreurs[] = "La note doit être un nombre entre 0 et 20.";
    $photo = $etudiant['photo'] ?? '';
    if (empty($erreurs) && isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            if ($_FILES['photo']['size'] <= 1048576) {
                $nom_photo = uniqid() . '.' . $ext;
                if(!is_dir('uploads')) mkdir('uploads', 0777, true);
                if (move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $nom_photo)) {
                    if ($photo && file_exists('uploads/' . $photo)) unlink('uploads/' . $photo);
                    $photo = $nom_photo;
                }
            } else { $erreurs[] = "La photo dépasse 1 Mo."; }
        } else { $erreurs[] = "Extension non autorisée (jpg, jpeg, png uniquement)."; }
    }
    if (empty($erreurs)) {
        if ($etudiant) {
            $etudiants[$id] = ['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'filiere' => $filiere, 'note' => $note, 'photo' => $photo];
            $_SESSION['flash'] = "Étudiant modifié avec succès.";
        } else {
            $new_id = empty($etudiants) ? 1 : max(array_keys($etudiants)) + 1;
            $etudiants[$new_id] = ['id' => $new_id, 'nom' => $nom, 'prenom' => $prenom, 'filiere' => $filiere, 'note' => $note, 'photo' => $photo];
            $_SESSION['flash'] = "Étudiant ajouté avec succès.";
        }
        sauver_etudiants($etudiants);
        header('Location: liste.php');
        exit;
    }
}
$titre = $etudiant ? "Modifier" : "Ajouter";
include 'header.php';
?>
<div class="carte">
    <h2><?= $titre ?> un étudiant</h2>
    <?php if (!empty($erreurs)): ?>
        <div class="flash error"><ul><?php foreach ($erreurs as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Nom :</label><input type="text" name="nom" value="<?= h($nom) ?>" required>
        <label>Prénom :</label><input type="text" name="prenom" value="<?= h($prenom) ?>" required>
        <label>Filière :</label>
        <select name="filiere">
            <?php foreach (FILIERES as $f): ?><option value="<?= h($f) ?>" <?= $f === $filiere ? 'selected' : '' ?>><?= h($f) ?></option><?php endforeach; ?>
        </select>
        <label>Note :</label><input type="text" name="note" value="<?= h($note) ?>" required>
        <label>Photo (facultatif, max 1 Mo) :</label><input type="file" name="photo" accept=".jpg, .jpeg, .png">
        <button type="submit">Enregistrer</button>
    </form>
</div>
<?php include 'footer.php'; ?>
