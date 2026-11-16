<?php
session_start();
define('FICHIER', __DIR__ . '/data/etudiants.txt');
define('FILIERES', ['GI', 'IDIA', 'GE', 'GC']);
define('UTILISATEURS', ['admin' => '1234', 'prof' => 'azerty']);
function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function connecte(): bool { return isset($_SESSION['login']); }
function exiger_connexion(): void { if (!connecte()) { header('Location: index.php'); exit; } }
function nettoyer(string $s): string { $s = trim($s); $s = str_replace([';', "\n", "\r"], ' ', $s); return $s; }
function lire_etudiants(): array {
    $etudiants = [];
    if (file_exists(FICHIER)) {
        $lignes = file(FICHIER, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lignes as $ligne) {
            $parts = explode(';', $ligne);
            if (count($parts) >= 6) {
                $id = (int)$parts[0];
                $etudiants[$id] = [
                    'id' => $id, 'nom' => $parts[1], 'prenom' => $parts[2],
                    'filiere' => $parts[3], 'note' => (float)$parts[4], 'photo' => $parts[5]
                ];
            }
        }
    }
    return $etudiants;
}
function sauver_etudiants(array $liste): void {
    $lignes = [];
    foreach ($liste as $e) {
        $lignes[] = implode(';', [ $e['id'], nettoyer($e['nom']), nettoyer($e['prenom']), $e['filiere'], $e['note'], $e['photo'] ]);
    }
    if(!is_dir(__DIR__ . '/data')) mkdir(__DIR__ . '/data', 0777, true);
    file_put_contents(FICHIER, implode("\n", $lignes));
}
