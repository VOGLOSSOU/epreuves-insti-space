<?php

try {
    // Connexion à la base de données - Chemin corrigé
    include __DIR__ . '/../../db/config.php';
    
    // Vérifier si la table ressources existe
    $checkTableSql = "SHOW TABLES LIKE 'ressources'";
    $checkStmt = $pdo->prepare($checkTableSql);
    $checkStmt->execute();
    $tableExists = $checkStmt->rowCount() > 0;
    
    if (!$tableExists) {
        // Si la table n'existe pas, initialiser des valeurs par défaut
        $ressources = [];
        $totalPages = 1;
        $totalResources = 0;
    } else {
        // Construction de la requête avec filtres
        $sql = "SELECT * FROM ressources WHERE 1=1";
        $params = [];
        
        // Vérifier si la colonne statut existe
        $checkColumnSql = "SHOW COLUMNS FROM ressources LIKE 'statut'";
        $checkColumnStmt = $pdo->prepare($checkColumnSql);
        $checkColumnStmt->execute();
        $statutExists = $checkColumnStmt->rowCount() > 0;
        
        if ($statutExists) {
            $sql .= " AND statut = 'approuve'";
        }

        // Filtres optionnels
        if (!empty($_GET['department'])) {
            $sql .= " AND departement = ?";
            $params[] = $_GET['department'];
        }

        if (!empty($_GET['type'])) {
            $sql .= " AND type_ressource = ?";
            $params[] = $_GET['type'];
        }

        if (!empty($_GET['niveau'])) {
            $sql .= " AND niveau_etudes = ?";
            $params[] = $_GET['niveau'];
        }

        if (!empty($_GET['search'])) {
            $sql .= " AND (nom_ressource LIKE ? OR matiere LIKE ? OR description LIKE ?)";
            $searchTerm = '%' . $_GET['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        // Pagination
        $limit = 12; // Nombre de ressources par page
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        // Compter le total pour la pagination
        $countSql = str_replace('SELECT *', 'SELECT COUNT(*)', $sql);
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute($params);
        $totalResources = $countStmt->fetchColumn();
        $totalPages = ceil($totalResources / $limit);

        // Ajouter la pagination à la requête
        // Vérifier si la colonne date_ajout existe
        $checkDateSql = "SHOW COLUMNS FROM ressources LIKE 'date_ajout'";
        $checkDateStmt = $pdo->prepare($checkDateSql);
        $checkDateStmt->execute();
        $dateExists = $checkDateStmt->rowCount() > 0;

        if ($dateExists) {
            $sql .= " ORDER BY date_ajout DESC LIMIT $limit OFFSET $offset";
        } else {
            $sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
        }

        // Exécuter la requête
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $ressources = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
} catch (PDOException $e) {
    error_log("Erreur PDO dans get_ressources.php: " . $e->getMessage());
    // En cas d'erreur, initialiser des valeurs par défaut
    $ressources = [];
    $totalPages = 1;
    $totalResources = 0;
} catch (Exception $e) {
    error_log("Erreur générale dans get_ressources.php: " . $e->getMessage());
    // En cas d'erreur, initialiser des valeurs par défaut
    $ressources = [];
    $totalPages = 1;
    $totalResources = 0;
}

// Fonction pour mapper les types de ressources pour l'affichage
function getTypeDisplay($type) {
    $types = [
        'cours_pdf' => 'Cours PDF',
        'memoire' => 'Mémoire',
        'expose' => 'Exposé',
        'td' => 'TD',
        'tp' => 'TP',
        'projet' => 'Projet',
        'exercices' => 'Exercices',
        'autre' => 'Autre'
    ];
    return isset($types[$type]) ? $types[$type] : $type;
}

// Fonction pour mapper les départements
function getDepartmentDisplay($dept) {
    $departments = [
        'GEI' => 'Génie Électrique et Informatique',
        'GC' => 'Génie Civil',
        'GE' => 'Génie Énergétique',
        'MS' => 'Mathématiques et Sciences',
        'GMP' => 'Génie Mécanique et Productique'
    ];
    return isset($departments[$dept]) ? $departments[$dept] : $dept;
}

// Fonction pour obtenir l'icône selon le type
function getTypeIcon($type) {
    $icons = [
        'cours_pdf' => 'fas fa-book',
        'memoire' => 'fas fa-graduation-cap',
        'expose' => 'fas fa-presentation',
        'td' => 'fas fa-file-alt',
        'tp' => 'fas fa-flask',
        'projet' => 'fas fa-cogs',
        'exercices' => 'fas fa-pencil-alt',
        'autre' => 'fas fa-file'
    ];
    return isset($icons[$type]) ? $icons[$type] : 'fas fa-file';
}

// Fonction pour formater la taille du fichier
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Fonction pour mettre à jour le compteur de vues
function incrementViews($resourceId, $pdo) {
    try {
        $stmt = $pdo->prepare("UPDATE ressources SET vues = vues + 1 WHERE id = ?");
        $stmt->execute([$resourceId]);
    } catch (PDOException $e) {
        error_log("Erreur increment views: " . $e->getMessage());
    }
}

// Fonction pour récupérer les meilleurs contributeurs
function getTopContributors($pdo, $limit = 3) {
    try {
        // Utiliser exactement la même requête que le test manuel
        $sql = "SELECT nom_contributeur, COUNT(*) as total_contributions FROM ressources GROUP BY nom_contributeur ORDER BY total_contributions DESC LIMIT ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Log pour déboguer
        error_log("getTopContributors: " . count($result) . " contributeurs trouvés");

        return $result;
    } catch (PDOException $e) {
        error_log("Erreur getTopContributors: " . $e->getMessage());
        return [];
    }
}
?>