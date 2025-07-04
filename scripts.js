   // Navigation responsive
   const hamburger = document.querySelector('.hamburger');
   const navMenu = document.querySelector('.nav-menu');

   hamburger.addEventListener('click', () => {
       navMenu.classList.toggle('active');
   });

   // Fermer le menu quand on clique sur un lien
   document.querySelectorAll('.nav-link').forEach(link => {
       link.addEventListener('click', () => {
           navMenu.classList.remove('active');
       });
   });

   // Animation au scroll
   window.addEventListener('scroll', () => {
       const header = document.querySelector('.header');
       if (window.scrollY > 50) {
           header.style.background = 'rgba(255, 255, 255, 0.95)';
       } else {
           header.style.background = 'white';
       }
   }); 












    // Gestion des dropdown des programmes
   document.querySelectorAll('.program-item').forEach(program => {
    program.addEventListener('click', () => {
        const dropdown = program.nextElementSibling;
        if (dropdown && dropdown.classList.contains('year-dropdown')) {
            dropdown.classList.toggle('active');
            const icon = program.querySelector('i');
            icon.classList.toggle('fa-chevron-up');
            icon.classList.toggle('fa-chevron-down');
        }
    });
});

// Gestion des années
document.querySelectorAll('.year-item').forEach(year => {
    year.addEventListener('click', (e) => {
        e.stopPropagation(); // Empêche la propagation au parent
        // Ici, vous pouvez ajouter la redirection vers la page des examens
        // window.location.href = `exams.html?year=${year.textContent}`;
    });
});








        // Filtrage des examens
        const searchInput = document.querySelector('.search-input');
        const filterSelects = document.querySelectorAll('.filter-select');
        const examCards = document.querySelectorAll('.exam-card');

        // Fonction de recherche
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            examCards.forEach(card => {
                const title = card.querySelector('.exam-title').textContent.toLowerCase();
                const info = card.querySelector('.exam-info').textContent.toLowerCase();
                const isVisible = title.includes(searchTerm) || info.includes(searchTerm);
                card.style.display = isVisible ? 'block' : 'none';
            });
        });

        // Gestion des filtres
        filterSelects.forEach(select => {
            select.addEventListener('change', () => {
                // Implémenter la logique de filtrage ici
                console.log('Filter changed:', select.value);
            });
        });

        // Gestion de la pagination
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelector('.page-btn.active')?.classList.remove('active');
                btn.classList.add('active');
                // Implémenter la logique de pagination ici
            });
        });

        