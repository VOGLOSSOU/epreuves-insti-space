<?php
// Script pour incrémenter le compteur de vues d'une ressource
header('Content-Type: application/json');

try {
    // Vérifier que c'est une requête POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Méthode non autorisée');
    }
    
    // Vérifier que l'ID de la ressource est fourni
    if (!isset($_POST['resource_id']) || !is_numeric($_POST['resource_id'])) {
        throw new Exception('ID de ressource invalide');
    }
    
    $resourceId = intval($_POST['resource_id']);
    
    // Connexion à la base de données
    include __DIR__ . '/../db/config.php';
    
    // Vérifier que la table ressources existe
    $checkTableSql = "SHOW TABLES LIKE 'ressources'";
    $checkStmt = $pdo->prepare($checkTableSql);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() === 0) {
        throw new Exception('Table ressources non trouvée');
    }
    
    // Vérifier que la ressource existe
    $checkResourceSql = "SELECT id FROM ressources WHERE id = ?";
    $checkResourceStmt = $pdo->prepare($checkResourceSql);
    $checkResourceStmt->execute([$resourceId]);
    
    if ($checkResourceStmt->rowCount() === 0) {
        throw new Exception('Ressource non trouvée');
    }
    
    // Incrémenter le compteur de vues
    $updateSql = "UPDATE ressources SET vues = vues + 1 WHERE id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $result = $updateStmt->execute([$resourceId]);
    
    if ($result) {
        // Récupérer le nouveau nombre de vues
        $getViewsSql = "SELECT vues FROM ressources WHERE id = ?";
        $getViewsStmt = $pdo->prepare($getViewsSql);
        $getViewsStmt->execute([$resourceId]);
        $newViews = $getViewsStmt->fetchColumn();
        
        echo json_encode([
            'success' => true,
            'message' => 'Compteur de vues mis à jour',
            'resource_id' => $resourceId,
            'new_views' => $newViews
        ]);
    } else {
        throw new Exception('Erreur lors de la mise à jour');
    }
    
} catch (PDOException $e) {
    error_log("Erreur PDO dans increment_views.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erreur de base de données'
    ]);
    
} catch (Exception $e) {
    error_log("Erreur dans increment_views.php: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>