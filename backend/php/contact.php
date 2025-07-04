<?php
session_start();
// Inclure le fichier de configuration pour la connexion à la base de données
require_once '../db/config.php';

$_SESSION["error"] = " " ;
// Vérifier si le formulaire est soumis via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs des champs du formulaire
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Vérification des champs obligatoires
    if (empty($nom) || empty($prenom) || empty($message)) {
        $_SESSION["error"] =  "Tous les champs sont obligatoires.";
        exit;
    }

    try {

        // Préparer la requête d'insertion
        $query = "INSERT INTO messages (nom, prenom, message, date_d_envoie) VALUES (:nom, :prenom, :message, NOW())";
        $stmt = $pdo->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Votre message a été envoyé avec succès.";
            header("Location: ../../index.php");
            exit();
        } else {
            $_SESSION["error"] = "Une erreur s'est produite lors de l'envoi du message.";
        }

    } catch (PDOException $e) {
       $_SESSION["error"] ="Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    $_SESSION["error"] = "Requête invalide.";
}
?>