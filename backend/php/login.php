<?php
session_start();

// Inclure le fichier de configuration pour la connexion à la base de données
require_once '../db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_connect'])) {
    // Récupérer et valider les données du formulaire
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Vérification que tous les champs sont remplis
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header("Location: ../../dashboard/login.php");
        exit();
    }

    try {
        // Requête pour vérifier si l'utilisateur existe avec cet email
        $query = "
            SELECT id, email, password 
            FROM admins 
            WHERE email = :email
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Récupérer les informations de l'admin
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'email existe et si le mot de passe correspond
        if ($admin && $password === $admin['password']) {
            // Régénérer l'ID de session pour éviter les attaques de fixation de session
            session_regenerate_id(true);

            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            // Redirection vers le tableau de bord
            header("Location: ../../dashboard/dashboard.php");
            exit();
        } else {
            // Message d'erreur si l'email ou le mot de passe est incorrect
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header("Location: ../../dashboard/login.php");
            exit();
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        $_SESSION['error'] = "Une erreur est survenue. Veuillez réessayer plus tard.";
        header("Location: ../../dashboard/login.php");
        exit();
    }
} else {
    // Si l'utilisateur accède directement au fichier sans soumettre le formulaire
    header("Location: ../../index.php");
    exit();
}