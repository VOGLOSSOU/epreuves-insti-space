<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>INSTI - Portail des Examens</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Header avec Navigation -->
    <?php include 'includes/header.php' ?>

    <!-- Section Hero -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Bienvenue sur le Portail des Examens INSTI</h1>
                <p class="hero-subtitle">
                    Une initiative du Bureau des Section Fédéral des Entités (BSFE) 
                    pour faciliter l'accès aux examens passés et améliorer votre préparation académique.
                </p>
                <a href="epreuves.php" class="cta-button">Accéder aux Examens</a>
            </div>
            <div class="hero-image">
                <img src="images/bureau/bur.jpg" alt="Étudiants INSTI">
            </div>
        </div>
    </section>

    <!-- Section Ressources Partagées -->
    <section class="resources-section">
        <div class="container">
            <h2>Nouvelles Ressources Disponibles</h2>
            <p>
                En plus des épreuves d'examens, vous pouvez désormais accéder et partager d'autres ressources académiques : 
                cours PDF, mémoires de fin d'études, exposés, travaux dirigés et bien d'autres documents 
                partagés par vos aînés et collègues étudiants.
            </p>
            <a href="resources.php" class="resources-link">Accéder aux Ressources Partagées</a>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>
    <script src="scripts.js"></script>
</body>
</html>