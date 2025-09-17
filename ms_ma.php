<?php

require 'backend/php/exams/ms_ma.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examens - BSFE INSTI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'includes/header.php' ?>

    <section class="exams-section">
        <div class="exams-container">

                 <!-- Fil d'Ariane -->
                 <div class="breadcrumb">
                    <a href="index.php" class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        Accueil
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="epreuves.php" class="breadcrumb-item">
                        Epreuves
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-item">Espace Maintenance Auto</span>
                </div>

            <!-- Filtres et recherche -->
            <div class="filters-section">
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Rechercher un examen...">
                </div>
                <div class="filter-group">
                    <select class="filter-select">
                        <option value="">Année académique</option>
                        <option>2024-2025</option>
                        <option>2023-2024</option>
                        <option>2022-2023</option>
                    </select>
                    <select class="filter-select">
                        <option value="">Type d'examen</option>
                        <option>Examen final</option>
                        <option>Examen partiel</option>
                        <option>Rattrapage</option>
                    </select>
                    <select class="filter-select">
                        <option value="">Session</option>
                        <option>Janvier</option>
                        <option>Juin</option>
                        <option>Septembre</option>
                    </select>
                </div>
            </div>

            <?php if (!empty($epreuves)): ?>
            <!-- Grille des examens -->
            <div class="exams-grid">
                <!-- Exemple d'une carte d'examen -->
                <?php foreach ($epreuves as $epreuve): ?>
                <div class="exam-card" onclick="window.location.href='fichiers/<?= htmlspecialchars($epreuve['fichier']) ?>'">
                    <div class="exam-header">
                        <i class="fas fa-file-pdf exam-icon"></i>
                        <span class="exam-date"><?= htmlspecialchars($epreuve['session']) ?></span>
                    </div>
                    <h3 class="exam-title"><?= htmlspecialchars($epreuve['matiere']) ?></h3>
                    <p class="exam-info"><?= htmlspecialchars($epreuve['nom']) ?></p>
                    <div class="exam-meta">
                        <span><?= htmlspecialchars($epreuve['type_d_examen']) ?> • n° <?= htmlspecialchars($epreuve['id']) ?></span>
                        <a href="fichiers/<?= htmlspecialchars($epreuve['fichier']) ?>" class="download-btn" download>
                            <i class="fas fa-download"></i>
                            Télécharger
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Répéter pour d'autres examens... -->
            </div>
            <?php endif; ?>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn"><i class="fas fa-chevron-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

   
    <script src="scripts.js"></script>
    <?php include 'includes/footer.php' ?>
</body>
</html>