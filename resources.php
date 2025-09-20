<?php
session_start();

// Valeurs par défaut au cas où get_ressources.php échoue
if (!isset($ressources)) $ressources = [];
if (!isset($totalResources)) $totalResources = 0;
if (!isset($totalPages)) $totalPages = 1;
if (!isset($page)) $page = 1;

require 'backend/php/ressources/get_ressources.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ressources Partagées - INSTI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'includes/header.php' ?>

<!-- Messages de feedback -->
<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<section class="exams-section">
    <div class="exams-container">

        <!-- Fil d'Ariane -->
        <div class="breadcrumb">
            <a href="index.php" class="breadcrumb-item">
                <i class="fas fa-home"></i>
                Accueil
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-item">Ressources Partagées</span>
        </div>

        <!-- Statistiques -->
        <div class="stats-section">
            <div class="stat-item">
                <i class="fas fa-file-alt"></i>
                <span><?php echo $totalResources; ?> ressources disponibles</span>
            </div>
        </div>

        <!-- Section Meilleurs Contributeurs - Version Marketing Ultra-Dynamique -->
        <?php
        $topContributors = getTopContributors($pdo, 3);
        if (!empty($topContributors)):
        ?>
        <div class="contributors-banner">
            <div class="contributors-content">
                <div class="contributors-header">
                    <div class="contributors-badge">
                        <i class="fas fa-crown"></i>
                        <span>ÉLITE</span>
                    </div>
                    <div class="contributors-main-text">
                        <div class="contributors-highlight">
                            <strong><?php echo count($topContributors); ?> HÉROS</strong> ont déjà rejoint la révolution !
                        </div>
                        <div class="contributors-names">
                            <?php
                            foreach ($topContributors as $index => $contributor) {
                                $medals = ['🥇', '🥈', '🥉'];
                                $medal = isset($medals[$index]) ? $medals[$index] : '🏅';
                                echo '<span class="hero-name">' . $medal . ' ' . htmlspecialchars($contributor['nom_contributeur']) . '</span>';
                                if ($index < count($topContributors) - 1) echo ' • ';
                            }
                            ?>
                            <span class="and-more">+ d'autres légendes...</span>
                        </div>
                    </div>
                </div>f
                <div class="contributors-action">
                    <div class="contributors-challenge">
                        <div class="challenge-text">
                            🎯 <strong>TON TOUR DE BRILLER !</strong>
                        </div>
                        <div class="challenge-subtitle">
                            Partage tes ressources et deviens une star !
                        </div>
                    </div>
                    <a href="upload-resource.php" class="contributors-cta-btn">
                        <span class="btn-text">JE REJOINS L'ÉLITE</span>
                        <i class="fas fa-rocket"></i>
                    </a>
                </div>
            </div>
            <div class="contributors-sparkles">
                <div class="sparkle">✨</div>
                <div class="sparkle">⭐</div>
                <div class="sparkle">🌟</div>
                <div class="sparkle">💫</div>
                <div class="sparkle">🎇</div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Bouton d'ajout de ressource -->
        <div class="add-resource-section">
            <a href="upload-resource.php" class="add-resource-btn">
                <i class="fas fa-plus"></i>
                Partager une Ressource
            </a>
        </div>

        <!-- Filtres et recherche -->
        <div class="filters-section">
            <div class="search-bar">
                <input type="text" id="search-input" class="search-input" 
                       placeholder="Rechercher une ressource..."
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="filter-group">
                <select class="filter-select" id="filter-department">
                    <option value="">Tous les départements</option>
                    <option value="GEI" <?php echo ($_GET['department'] ?? '') === 'GEI' ? 'selected' : ''; ?>>GEI - Génie Électrique et Informatique</option>
                    <option value="GC" <?php echo ($_GET['department'] ?? '') === 'GC' ? 'selected' : ''; ?>>GC - Génie Civil</option>
                    <option value="GE" <?php echo ($_GET['department'] ?? '') === 'GE' ? 'selected' : ''; ?>>GE - Génie Énergétique</option>
                    <option value="MS" <?php echo ($_GET['department'] ?? '') === 'MS' ? 'selected' : ''; ?>>MS - Mathématiques et Sciences</option>
                    <option value="GMP" <?php echo ($_GET['department'] ?? '') === 'GMP' ? 'selected' : ''; ?>>GMP - Génie Mécanique et Productique</option>
                </select>
                <select class="filter-select" id="filter-type">
                    <option value="">Type de ressource</option>
                    <option value="cours_pdf" <?php echo ($_GET['type'] ?? '') === 'cours_pdf' ? 'selected' : ''; ?>>Cours PDF</option>
                    <option value="memoire" <?php echo ($_GET['type'] ?? '') === 'memoire' ? 'selected' : ''; ?>>Mémoire</option>
                    <option value="expose" <?php echo ($_GET['type'] ?? '') === 'expose' ? 'selected' : ''; ?>>Exposé</option>
                    <option value="td" <?php echo ($_GET['type'] ?? '') === 'td' ? 'selected' : ''; ?>>TD</option>
                    <option value="tp" <?php echo ($_GET['type'] ?? '') === 'tp' ? 'selected' : ''; ?>>TP</option>
                    <option value="projet" <?php echo ($_GET['type'] ?? '') === 'projet' ? 'selected' : ''; ?>>Projet</option>
                    <option value="exercices" <?php echo ($_GET['type'] ?? '') === 'exercices' ? 'selected' : ''; ?>>Exercices</option>
                    <option value="autre" <?php echo ($_GET['type'] ?? '') === 'autre' ? 'selected' : ''; ?>>Autre</option>
                </select>
                <select class="filter-select" id="filter-niveau">
                    <option value="">Niveau d'études</option>
                    <option value="L1" <?php echo ($_GET['niveau'] ?? '') === 'L1' ? 'selected' : ''; ?>>L1 - 1ère année</option>
                    <option value="L2" <?php echo ($_GET['niveau'] ?? '') === 'L2' ? 'selected' : ''; ?>>L2 - 2ème année</option>
                    <option value="L3" <?php echo ($_GET['niveau'] ?? '') === 'L3' ? 'selected' : ''; ?>>L3 - 3ème année</option>
                    <option value="M1" <?php echo ($_GET['niveau'] ?? '') === 'M1' ? 'selected' : ''; ?>>M1 - 1ère année Master</option>
                    <option value="M2" <?php echo ($_GET['niveau'] ?? '') === 'M2' ? 'selected' : ''; ?>>M2 - 2ème année Master</option>
                </select>
            </div>
        </div>
        
        <!-- Grille des ressources -->
        <div class="exams-grid" id="resources-grid">
            <?php if (!empty($ressources)): ?>
                <?php foreach ($ressources as $ressource): ?>
                <div class="exam-card resource-card">
                    <div class="exam-header">
                        <i class="<?php echo getTypeIcon($ressource['type_ressource']); ?> resource-icon" data-type="<?php echo $ressource['type_ressource']; ?>"></i>
                        <span class="exam-date"><?php echo getTypeDisplay($ressource['type_ressource']); ?></span>
                    </div>
                    <h3 class="exam-title"><?php echo htmlspecialchars($ressource['nom_ressource']); ?></h3>
                    <p class="exam-info">
                        <?php echo htmlspecialchars($ressource['matiere']); ?>
                        <?php if ($ressource['niveau_etudes']): ?>
                            - <?php echo htmlspecialchars($ressource['niveau_etudes']); ?>
                        <?php endif; ?>
                    </p>
                    <p class="resource-description"><?php echo htmlspecialchars($ressource['description']); ?></p>
                    <div class="exam-meta">
                        <span>
                            Partagé par: <?php echo htmlspecialchars($ressource['nom_contributeur']); ?>
                            <!-- • <i class="fas fa-eye"></i> <?php echo $ressource['vues']; ?> -->
                            • <?php echo formatFileSize($ressource['taille_fichier']); ?>
                        </span>
                        <a href="fichiers/ressources/<?php echo htmlspecialchars($ressource['fichier']); ?>" 
                           class="download-btn" 
                           onclick="incrementViewCount(<?php echo $ressource['id']; ?>)"
                           target="_blank">
                            <i class="fas fa-download"></i>
                            Télécharger
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Message si aucune ressource -->
        <?php if (empty($ressources)): ?>
        <div class="no-resources">
            <i class="fas fa-folder-open"></i>
            <h3>Aucune ressource trouvée</h3>
            <?php if (!empty($_GET['search']) || !empty($_GET['department']) || !empty($_GET['type']) || !empty($_GET['niveau'])): ?>
                <p>Aucune ressource ne correspond à vos critères de recherche.</p>
                <a href="resources.php" class="btn-reset-filters">
                    <i class="fas fa-undo"></i>
                    Réinitialiser les filtres
                </a>
            <?php else: ?>
                <p>Soyez le premier à partager une ressource !</p>
            <?php endif; ?>
            <a href="upload-resource.php" class="add-resource-btn">
                <i class="fas fa-plus"></i>
                Partager une Ressource
            </a>
        </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="page-btn">
                    <i class="fas fa-chevron-left"></i>
                </a>
            <?php endif; ?>
            
            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                   class="page-btn <?php echo $i === $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="page-btn">
                    <i class="fas fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<script src="scripts.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const filterDepartment = document.getElementById('filter-department');
    const filterType = document.getElementById('filter-type');
    const filterNiveau = document.getElementById('filter-niveau');
    
    let searchTimeout;
    
    // Fonction pour appliquer les filtres via URL
    function applyFilters() {
        const params = new URLSearchParams();
        
        if (searchInput.value.trim()) params.set('search', searchInput.value.trim());
        if (filterDepartment.value) params.set('department', filterDepartment.value);
        if (filterType.value) params.set('type', filterType.value);
        if (filterNiveau.value) params.set('niveau', filterNiveau.value);
        
        // Rediriger avec les nouveaux paramètres
        window.location.href = 'resources.php?' + params.toString();
    }
    
    // Recherche avec délai pour éviter trop de requêtes
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 800); // Attendre 800ms après la dernière frappe
    });
    
    // Filtres immédiats
    filterDepartment.addEventListener('change', applyFilters);
    filterType.addEventListener('change', applyFilters);
    filterNiveau.addEventListener('change', applyFilters);
});

// Fonction pour incrémenter le compteur de vues
function incrementViewCount(resourceId) {
    // Envoyer une requête AJAX pour incrémenter les vues
    fetch('backend/php/ressources/increment_views.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'resource_id=' + resourceId
    }).catch(err => console.log('Erreur lors de l\'incrémentation des vues'));
}
</script>

<?php include 'includes/footer.php' ?>
</body>
</html>