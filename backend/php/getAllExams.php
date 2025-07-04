<?php
include '../backend/db/config.php' ;
try {

    // Récupérer toutes les épreuves
    $query = "SELECT * FROM epreuves";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $epreuves = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>