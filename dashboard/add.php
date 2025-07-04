<?php 
   include '../includes/checkAdminConnec.php'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Gestion des Epreuves</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Ajout de style pour le conteneur d'erreur */
        .error-message {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: inline-block;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Conteneur de messages d'erreur -->
    <div id="error-container">
        <?php
            // Vérifier si des erreurs sont présentes dans la session
            if (isset($_SESSION['error_message'])) {
                echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
        ?>
    </div>

    <!-- Formulaire d'ajout d'épreuve -->
    <div class="form-container">
        <h3 class="text-2xl font-bold text-gray-900">Ajouter une épreuve</h3>
        <form action="../backend/php/add.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="2 ème Devoir de Maintenance Industrielle 2022 - 2023" required>
            </div>
            <div>
                <label for="departement">Département</label>
                <select id="departement" name="departement" required>
                    <option value="">Choisir un département</option>
                    <option value="GEI">GEI</option>
                    <option value="GC">GC</option>
                    <option value="GE">GE</option>
                    <option value="MS">MS</option>
                    <option value="GMP">GMP</option>
                </select>
            </div>
            <div>
                <label for="filiere">Filière</label>
                <select id="filiere" name="filiere" required>
                    <option value="">Choisir une filière</option>
                    <option value="IT">IT</option>
                    <option value="EE">EE</option>
                    <option value="GC">GC</option>
                    <option value="ER">ER</option>
                    <option value="FC">FC</option>
                    <option value="MI">MI</option>
                    <option value="MA">MA</option>
                    <option value="GMP">GMP</option>
                </select>
            </div>
            <div>
                <label for="type">Type d'examen</label>
                <select id="type" name="type" required>
                    <option value="">Choisir un type d'examen</option>
                    <option value="Examen">Examen</option>
                    <option value="Devoir">Devoir</option>
                    <option value="Rattrapage">Rattrapage</option>
                    <option value="Reprise">Reprise</option>
                </select>
            </div>
            <div>
                <label for="session">Session</label>
                <input type="text" id="session" name="session" placeholder="Janvier 2025" required> 
            </div>
            <div>
                <label for="matiere">Matière</label>
                <input type="text" id="matiere" name="matiere" placeholder="Anglais" required>
            </div>
            <div>
                <label for="fichier_pdf">Fichier PDF</label>
                <input type="file" id="fichier_pdf" name="fichier_pdf" required>
            </div>
            <div>
                <button type="submit">Enregistrer</button>
            </div>
        </form>
    </div>

</body>
</html>