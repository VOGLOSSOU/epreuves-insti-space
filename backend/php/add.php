<?php
session_start();

$_SESSION['error_message'] = ' ';
// Inclure le fichier de configuration pour la connexion à la base de données
include('../db/config.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs du formulaire
    if (
        isset($_POST['nom']) && isset($_POST['departement']) && isset($_POST['filiere']) &&
        isset($_POST['type']) && isset($_POST['session']) && isset($_POST['matiere']) && isset($_FILES['fichier_pdf'])
    ) {
        // Récupérer les valeurs des champs du formulaire
        $nom = htmlspecialchars(trim($_POST['nom']));
        $departement = htmlspecialchars(trim($_POST['departement']));
        $filiere = htmlspecialchars(trim($_POST['filiere']));
        $type = htmlspecialchars(trim($_POST['type']));
        $session = htmlspecialchars(trim($_POST['session']));
        $matiere = htmlspecialchars(trim($_POST['matiere']));

        // Vérification de l'unicité du nom de l'épreuve
        $checkSql = "SELECT COUNT(*) FROM epreuves WHERE nom = :nom";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':nom', $nom);
        $checkStmt->execute();
        $existingCount = $checkStmt->fetchColumn();

        if ($existingCount > 0) {
            $_SESSION['error_message'] = "❌ Erreur : Une épreuve avec le nom '$nom' existe déjà. Veuillez choisir un nom différent pour éviter les doublons.";
            header("Location: ../../add.php");
            exit();
        }

        // Vérification de l'extension du fichier (seul le PDF est autorisé)
        $allowed_extensions = ['pdf'];
        $file_info = pathinfo($_FILES['fichier_pdf']['name']);
        $file_extension = strtolower($file_info['extension']);

        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error_message'] = "❌ Erreur : Format de fichier non autorisé. Seuls les fichiers PDF sont acceptés. Votre fichier était de type : $file_extension";
            header("Location: ../../add.php");
            exit();
        }

        // Définir le dossier de destination pour l'upload
        $upload_dir = '../../fichiers/';
        $file_name = time() . '_' . basename($_FILES['fichier_pdf']['name']); // Nom unique pour éviter les conflits
        $upload_file = $upload_dir . $file_name;

        // Déplacer le fichier téléchargé dans le dossier de destination
        if (move_uploaded_file($_FILES['fichier_pdf']['tmp_name'], $upload_file)) {
            // Préparer la requête SQL pour insérer les données dans la base
            $sql = "INSERT INTO epreuves (nom, departement, filiere, type_d_examen, session, matiere, fichier) 
                    VALUES (:nom, :departement, :filiere, :type_d_examen, :session, :matiere, :fichier)";

            // Préparer la requête
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':departement', $departement);
            $stmt->bindParam(':filiere', $filiere);
            $stmt->bindParam(':type_d_examen', $type);
            $stmt->bindParam(':session', $session);
            $stmt->bindParam(':matiere', $matiere);
            $stmt->bindParam(':fichier', $file_name);

            // Exécuter la requête
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "✅ Succès ! L'épreuve '$nom' a été ajoutée avec succès à la base de données.";
                header('Location: ../../add.php');
                exit();
            } else {
                $_SESSION['error_message'] = "❌ Erreur : Impossible d'enregistrer l'épreuve dans la base de données. Veuillez réessayer.";
                header("Location: ../../add.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "❌ Erreur lors de l'upload du fichier. Vérifiez que le fichier n'est pas corrompu et que sa taille ne dépasse pas 10 MB.";
            header("Location: ../../add.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "❌ Erreur : Tous les champs du formulaire sont obligatoires. Veuillez remplir tous les champs avant de soumettre.";
        header("Location: ../../add.php");
        exit();
    }
}
?>