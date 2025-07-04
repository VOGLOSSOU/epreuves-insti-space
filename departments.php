<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Départements - BSFE INSTI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'includes/header.php' ?>

    <section class="departments-section">
        <div class="departments-container">
            <!-- Fil d'Ariane -->
            <div class="breadcrumb">
                <a href="index.php" class="breadcrumb-item">
                    <i class="fas fa-home"></i>
                    Accueil
                </a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item">Départements</span>
            </div>

            <!-- Titre de la section -->
            <h1 class="department-title">Explorez les Départements</h1>

            <!-- Grille des départements -->
            <div class="departments-grid">
                <!-- Département  -->
                <div class="department-card">
                    <div class="department-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h2 class="department-title">Génie Electrique & Informatique</h2>
                    <p>Explorez les examens des programmes scientifiques.</p>
                    <ul class="programs-list">
                        <li class="program-item">
                            Votre Filière
                            <i class="fas fa-chevron-down"></i>
                        </li>
                        <div class="year-dropdown">
                            <div class="year-item" onclick="window.location.href='gei_it.php'">Informatique et Télécommunication</div>
                            <div class="year-item" onclick="window.location.href='gei_ee.php'">Electronique et Electrotechnique</div>
                        </div>
                    </ul>
                </div>

                <!-- Département Ingénierie -->
                <div class="department-card">
                    <div class="department-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h2 class="department-title">Génie Civil</h2>
                    <p>Découvrez les examens en ingénierie.</p>
                    <ul class="programs-list" onclick="window.location.href='gc.php'">
                        <li class="program-item">
                            Voir
                        </li>
                        <!-- <div class="year-dropdown">
                            <div class="year-item" onclick="window.location.href='exams.html'">Informatique et Télécommunication</div>
                            <div class="year-item" onclick="window.location.href='exams.html'">Electronique et Electrotechnique</div>
                        </div> -->
                    </ul>
                </div>

                       <!-- Département  -->
                       <div class="department-card">
                        <div class="department-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h2 class="department-title">Génie Energétique</h2>
                        <p>Explorez les examens des programmes scientifiques.</p>
                        <ul class="programs-list">
                            <li class="program-item">
                                Votre Filière
                                <i class="fas fa-chevron-down"></i>
                            </li>
                            <div class="year-dropdown">
                                <div class="year-item" onclick="window.location.href='ge_er.php'">Energie Renouvelable</div>
                                <div class="year-item" onclick="window.location.href='ge_fc.php'">Froid & Climatisation</div>
                            </div>
                        </ul>
                    </div>

                           <!-- Département  -->
                <div class="department-card">
                    <div class="department-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h2 class="department-title">Maintenance des Systèmes</h2>
                    <p>Explorez les examens des programmes scientifiques.</p>
                    <ul class="programs-list">
                        <li class="program-item">
                            Votre Filière
                            <i class="fas fa-chevron-down"></i>
                        </li>
                        <div class="year-dropdown">
                            <div class="year-item" onclick="window.location.href='ms_mi.php'">Maintenance Industrielle</div>
                            <div class="year-item" onclick="window.location.href='ms_ma.php'">Maintenance Automobile</div>
                        </div>
                    </ul>
                </div>

                       <!-- Département  -->
                       <div class="department-card">
                        <div class="department-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h2 class="department-title">Génie Mécanique & Productic</h2>
                        <p>Explorez les examens des programmes scientifiques.</p>
                        <ul class="programs-list">
                            <li class="program-item" onclick="window.location.href='gmp.php'">
                                Voir
                            </li>
                            <!-- <div class="year-dropdown">
                                <div class="year-item" onclick="window.location.href='exams.html'">Informatique et Télécommunication</div>
                                <div class="year-item" onclick="window.location.href='exams.html'">Electronique et Electrotechnique</div>
                            </div> -->
                        </ul>
                    </div>

                <!-- Autres départements... -->
            </div>
        </div>
    </section>
    <?php include 'includes/footer.php' ?>
    <script src="scripts.js"></script>
</body>
</html>