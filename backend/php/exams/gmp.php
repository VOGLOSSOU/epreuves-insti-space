<?php
require_once 'backend/db/config.php';

// Définir les variables pour le département et la filière
$departement = "gmp"; 
$filiere = "gmp"; 

try {

    // Préparer la requête pour récupérer les épreuves filtrées
    $query = "SELECT * FROM epreuves WHERE departement = :departement AND filiere = :filiere ORDER BY id DESC";
    $stmt = $pdo->prepare($query);

    // Lier les paramètres
    $stmt->bindParam(':departement', $departement, PDO::PARAM_STR);
    $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les épreuves correspondantes
    $epreuves = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

?>