<?php 
   include '../includes/checkAdminConnec.php';
   include '../backend/php/getAllExams.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Gestion des Epreuves</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body::-webkit-scrollbar{
            display: none;
            width; 0px;
        }
        body{
            overflow: hidden;
        }
        table tbody::-webkit-scrollbar{
            display: none;
            width; 0px;
        }
        table{
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- En-tête avec bannière -->
    <div class="bg-blue-600 text-white py-6 px-4 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">Gestion des Epreuves</h1>
            <p class="mt-2 text-blue-100">Système de gestion des Epreuves</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container mx-auto px-4 py-8">
        <!-- Bouton d'ajout -->
        <div class="mb-6">
            <button onclick="window.location.href='add.php'" class="group relative bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition duration-200 hover:scale-105 flex items-center">
                <i class="fas fa-plus-circle text-xl mr-2"></i>
                <span>Ajouter une épreuve</span>
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-200"></div>
            </button>
        </div>

        <!-- Tableau des livres -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
            <?php if (!empty($epreuves)): ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">Département</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">Filière</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">Session</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-500 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Exemple de ligne -->
                        <?php foreach ($epreuves as $epreuve): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($epreuve['nom']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600"><?= htmlspecialchars($epreuve['departement']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600"><?= htmlspecialchars($epreuve['filiere']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($epreuve['type_d_examen']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600"><?= htmlspecialchars($epreuve['session']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($epreuve['matiere']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button onclick="editBook(1)" class="text-blue-500 hover:text-blue-700 mx-2 transition-colors duration-200">
                                    <i class="fas fa-edit text-xl"></i>
                                </button>
                                <button onclick="deleteBook(1)" class="text-red-500 hover:text-red-700 mx-2 transition-colors duration-200">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>Aucune épreuve trouvée.</p>
                <?php endif; ?>    
            </div>
        </div>
    </div>

    <script>
        // Fonctions pour gérer le modal
        function showAddForm() {
            document.getElementById('modalTitle').textContent = 'Ajouter un livre';
            document.getElementById('bookForm').reset();
            document.getElementById('bookModal').classList.remove('hidden');
        }

        function hideModal() {
            document.getElementById('bookModal').classList.add('hidden');
        }

        function editBook(id) {
            document.getElementById('modalTitle').textContent = 'Modifier le livre';
            document.getElementById('bookModal').classList.remove('hidden');
        }

        function deleteBook(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')) {
                console.log('Suppression du livre', id);
            }
        }

        function handleSubmit(event) {
            event.preventDefault();
            console.log('Soumission du formulaire');
            hideModal();
        }

        // Fermer le modal en cliquant en dehors
        document.getElementById('bookModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal();
            }
        });
    </script>
</body>
</html>