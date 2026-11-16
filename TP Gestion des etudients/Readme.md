# Gestion des Étudiants

Une application web simple en PHP natif pour gérer une liste d'étudiants (réalisée dans le cadre d'un TP). Les données sont sauvegardées dans un fichier texte.

<img width="1025" height="897" alt="image" src="https://github.com/user-attachments/assets/7ad482da-94c2-4669-82a5-a632efaf8a90" />

## Fonctionnalités
* **Authentification** : Connexion sécurisée (Comptes par défaut : `admin` / `1234` ou `prof` / `azerty`).
* **Tableau de bord** : Affichage du nombre d'étudiants, de la moyenne et de la meilleure note.
* **Gestion (CRUD)** : Ajout, modification et suppression d'étudiants avec photo de profil.
* **Navigation** : Barre de recherche dynamique et options de tri (par ajout, nom, filière, note).

## Installation
1. Extrayez les fichiers dans le dossier racine de votre serveur web (`htdocs` pour XAMPP, `www` pour WAMP).
2. Assurez-vous que le service **Apache** est démarré.
3. Accédez à l'application via votre navigateur à l'adresse : `http://localhost/gestion_etudiants`
