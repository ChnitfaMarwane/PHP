<?php
require_once 'functions.php';
exiger_connexion();
$etudiants = lire_etudiants();
$q = $_GET['q'] ?? '';
$tri = $_GET['tri'] ?? 'ajout';
if ($q !== '') {
    $etudiants = array_filter($etudiants, function($e) use ($q) {
        return stripos($e['nom'], $q) !== false || stripos($e['prenom'], $q) !== false;
    });
}
usort($etudiants, function($a, $b) use ($tri) {
    if ($tri === 'nom') return strcasecmp($a['nom'], $b['nom']);
    if ($tri === 'filiere') return strcasecmp($a['filiere'], $b['filiere']);
    if ($tri === 'note') return $b['note'] <=> $a['note'];
    return $a['id'] <=> $b['id'];
});
$nb_etudiants = count($etudiants);
$moyenne = 0; $meilleure = 0;
if ($nb_etudiants > 0) {
    $notes = array_column($etudiants, 'note');
    $moyenne = array_sum($notes) / $nb_etudiants;
    $meilleure = max($notes);
}
$titre = "Liste des étudiants";
include 'header.php';
?>
<div class="stats">
    <p>Étudiants affichés : <?= $nb_etudiants ?></p>
    <p>Moyenne : <?= $nb_etudiants > 0 ? number_format($moyenne, 2) : '-' ?></p>
    <p>Meilleure note : <?= $nb_etudiants > 0 ? $meilleure : '-' ?></p>
</div>
<form method="get" class="carte" id="form-recherche">
    <input type="text" name="q" id="recherche-input" value="<?= h($q) ?>" placeholder="Rechercher...">
    <select name="tri">
        <option value="ajout" <?= $tri === 'ajout' ? 'selected' : '' ?>>Par ordre d'ajout</option>
        <option value="nom" <?= $tri === 'nom' ? 'selected' : '' ?>>Par nom</option>
        <option value="filiere" <?= $tri === 'filiere' ? 'selected' : '' ?>>Par filière</option>
        <option value="note" <?= $tri === 'note' ? 'selected' : '' ?>>Par note décroissante</option>
    </select>
    <button type="submit">Filtrer</button>
</form>
<table id="table-etudiants">
    <thead><tr><th>Photo</th><th>Nom</th><th>Prénom</th><th>Filière</th><th>Note</th><th>Actions</th></tr></thead>
    <tbody>
        <?php if (empty($etudiants)): ?>
        <tr><td colspan="6" class="center">Aucun étudiant</td></tr>
        <?php else: ?>
            <?php foreach ($etudiants as $e): ?>
            <tr class="ligne-etudiant">
                <td>
                    <?php if (!empty($e['photo']) && file_exists("uploads/{$e['photo']}")): ?>
                        <img src="uploads/<?= h($e['photo']) ?>" alt="Photo" class="photo-ronde">
                    <?php endif; ?>
                </td>
                <td class="nom-val"><?= h(strtoupper($e['nom'])) ?></td>
                <td class="prenom-val"><?= h(ucfirst($e['prenom'])) ?></td>
                <td><?= h($e['filiere']) ?></td>
                <td class="<?= $e['note'] >= 10 ? 'note-vert' : 'note-rouge' ?>"><?= h($e['note']) ?></td>
                <td>
                    <a href="ajouter.php?id=<?= $e['id'] ?>">Modifier</a>
                    <a href="supprimer.php?id=<?= $e['id'] ?>" class="btn-supprimer">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>
