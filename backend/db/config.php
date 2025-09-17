<?php
$host = 'srv1580.hstgr.io';
$dbname = 'u433704782_bsfe'; 
$username = 'u433704782_nathan_le_dev';
$password = 'Nathan_et_Junior_1607_09_09_mdp_@_#';

try {
    // Créer une connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer les options PDO pour gérer les erreurs et les exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>