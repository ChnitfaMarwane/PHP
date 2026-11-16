document.addEventListener('DOMContentLoaded', () => {
    const btnSupprimer = document.querySelectorAll('.btn-supprimer');
    btnSupprimer.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm("Voulez-vous vraiment supprimer cet étudiant ?")) e.preventDefault();
        });
    });
    const rechercheInput = document.getElementById('recherche-input');
    const lignes = document.querySelectorAll('.ligne-etudiant');
    if (rechercheInput && lignes.length > 0) {
        rechercheInput.addEventListener('input', (e) => {
            const terme = e.target.value.toLowerCase();
            lignes.forEach(ligne => {
                const nom = ligne.querySelector('.nom-val').textContent.toLowerCase();
                const prenom = ligne.querySelector('.prenom-val').textContent.toLowerCase();
                if (nom.includes(terme) || prenom.includes(terme)) ligne.style.display = '';
                else ligne.style.display = 'none';
            });
        });
    }
});
