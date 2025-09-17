<?php
session_start();

// Configuration de la base de données - REMPLACE CES VALEURS
include '../db/config.php';

// Configuration des uploads
$upload_dir = '../../fichiers/ressources/';
$max_file_size = 10 * 1024 * 1024; // 10 MB
$allowed_extensions = ['pdf'];
$allowed_mime_types = ['application/pdf'];

// Fonction pour nettoyer les données
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fonction pour générer un nom de fichier unique
function generate_unique_filename($original_name) {
    $extension = pathinfo($original_name, PATHINFO_EXTENSION);
    $timestamp = time();
    $random = mt_rand(1000, 9999);
    return "resource_" . $timestamp . "_" . $random . "." . $extension;
}

// Fonction pour obtenir l'adresse IP du client
function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

try {
    // Vérifier que c'est une requête POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Méthode non autorisée');
    }

    // Vérifier que tous les champs obligatoires sont présents
    $required_fields = ['nom_ressource', 'departement', 'type_ressource', 'matiere', 'description', 'nom_contributeur'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $field_names = [
                'nom_ressource' => 'Nom de la ressource',
                'departement' => 'Département',
                'type_ressource' => 'Type de ressource',
                'matiere' => 'Matière',
                'description' => 'Description',
                'nom_contributeur' => 'Nom du contributeur'
            ];
            $field_name = isset($field_names[$field]) ? $field_names[$field] : $field;
            throw new Exception("❌ Erreur : Le champ '$field_name' est obligatoire. Veuillez le remplir avant de soumettre.");
        }
    }

    // Nettoyer et valider les données
    $nom_ressource = clean_input($_POST['nom_ressource']);
    $departement = clean_input($_POST['departement']);
    $type_ressource = clean_input($_POST['type_ressource']);
    $matiere = clean_input($_POST['matiere']);
    $description = clean_input($_POST['description']);
    $nom_contributeur = clean_input($_POST['nom_contributeur']);
    $niveau_etudes = !empty($_POST['niveau_etudes']) ? clean_input($_POST['niveau_etudes']) : null;

    // Validation des longueurs
    if (strlen($nom_ressource) > 200) {
        throw new Exception('❌ Erreur : Le nom de la ressource ne peut pas dépasser 200 caractères. Votre nom fait ' . strlen($nom_ressource) . ' caractères.');
    }
    if (strlen($matiere) > 150) {
        throw new Exception('❌ Erreur : Le nom de la matière ne peut pas dépasser 150 caractères. Votre matière fait ' . strlen($matiere) . ' caractères.');
    }
    if (strlen($description) > 500) {
        throw new Exception('❌ Erreur : La description ne peut pas dépasser 500 caractères. Votre description fait ' . strlen($description) . ' caractères.');
    }
    if (strlen($nom_contributeur) > 100) {
        throw new Exception('❌ Erreur : Le nom du contributeur ne peut pas dépasser 100 caractères. Votre nom fait ' . strlen($nom_contributeur) . ' caractères.');
    }

    // Validation des valeurs
    $departements_valides = ['GEI', 'GC', 'GE', 'MS', 'GMP'];
    if (!in_array($departement, $departements_valides)) {
        throw new Exception("❌ Erreur : Département '$departement' non valide. Les départements valides sont : GEI, GC, GE, MS, GMP.");
    }

    $types_valides = ['cours_pdf', 'memoire', 'expose', 'td', 'projet', 'tp', 'exercices', 'autre'];
    if (!in_array($type_ressource, $types_valides)) {
        throw new Exception("❌ Erreur : Type de ressource '$type_ressource' non valide. Choisissez un type dans la liste proposée.");
    }

    if ($niveau_etudes && !in_array($niveau_etudes, ['L1', 'L2', 'L3', 'M1', 'M2'])) {
        throw new Exception("❌ Erreur : Niveau d'études '$niveau_etudes' non valide. Les niveaux valides sont : L1, L2, L3, M1, M2.");
    }

    // Vérifier le fichier
    if (!isset($_FILES['fichier_pdf']) || $_FILES['fichier_pdf']['error'] !== UPLOAD_ERR_OK) {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la taille maximale autorisée par le serveur.',
            UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille maximale autorisée par le formulaire.',
            UPLOAD_ERR_PARTIAL => 'Le fichier n\'a été que partiellement uploadé.',
            UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été sélectionné.',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
            UPLOAD_ERR_CANT_WRITE => 'Échec de l\'écriture du fichier sur le disque.',
            UPLOAD_ERR_EXTENSION => 'Une extension PHP a arrêté l\'upload du fichier.'
        ];
        $error_code = $_FILES['fichier_pdf']['error'] ?? UPLOAD_ERR_NO_FILE;
        $error_msg = isset($error_messages[$error_code]) ? $error_messages[$error_code] : 'Erreur inconnue lors de l\'upload.';
        throw new Exception("❌ Erreur d'upload : $error_msg");
    }

    $file = $_FILES['fichier_pdf'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = $file['type'];

    // Vérifier la taille
    if ($file_size > $max_file_size) {
        $file_size_mb = round($file_size / (1024 * 1024), 2);
        throw new Exception("❌ Erreur : Le fichier est trop volumineux ($file_size_mb MB). Taille maximale autorisée : 10 MB.");
    }

    // Vérifier l'extension
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions)) {
        throw new Exception("❌ Erreur : Format de fichier '$file_extension' non autorisé. Seuls les fichiers PDF sont acceptés.");
    }

    // Vérifier le type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_mime_types)) {
        throw new Exception("❌ Erreur : Type de fichier '$mime_type' non valide. Seuls les fichiers PDF sont acceptés.");
    }

    // Créer le dossier de destination s'il n'existe pas
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            throw new Exception('❌ Erreur : Impossible de créer le dossier de destination pour les fichiers.');
        }
    }

    // Générer un nom de fichier unique
    $unique_filename = generate_unique_filename($file_name);
    $file_path = $upload_dir . $unique_filename;

    // Déplacer le fichier
    if (!move_uploaded_file($file_tmp, $file_path)) {
        throw new Exception('❌ Erreur : Impossible de sauvegarder le fichier sur le serveur. Vérifiez les permissions du dossier.');
    }

    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insérer en base de données
    $sql = "INSERT INTO ressources (
        nom_ressource, 
        departement, 
        type_ressource, 
        matiere, 
        description, 
        nom_contributeur, 
        niveau_etudes, 
        fichier, 
        nom_fichier_original, 
        taille_fichier, 
        ip_utilisateur
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $nom_ressource,
        $departement,
        $type_ressource,
        $matiere,
        $description,
        $nom_contributeur,
        $niveau_etudes,
        $unique_filename,
        $file_name,
        $file_size,
        get_client_ip()
    ]);

    if ($result) {
        // Succès - rediriger vers la page des ressources avec un message
        $_SESSION['upload_success'] = "✅ Succès ! Votre ressource '$nom_ressource' a été ajoutée avec succès et sera visible après modération par l'administrateur.";
        header('Location: ../../resources.php');
        exit;
    } else {
        throw new Exception('Erreur lors de l\'insertion en base de données');
    }

} catch (PDOException $e) {
    // Supprimer le fichier si l'insertion en base a échoué
    if (isset($file_path) && file_exists($file_path)) {
        unlink($file_path);
    }

    error_log("Erreur PDO dans upload_resource.php: " . $e->getMessage());
    $_SESSION['upload_error'] = "❌ Erreur de base de données : Impossible de sauvegarder les informations de la ressource. Veuillez réessayer plus tard.";

} catch (Exception $e) {
    // Supprimer le fichier en cas d'erreur
    if (isset($file_path) && file_exists($file_path)) {
        unlink($file_path);
    }

    error_log("Erreur dans upload_resource.php: " . $e->getMessage());
    $_SESSION['upload_error'] = $e->getMessage();
}

// En cas d'erreur, rediriger vers le formulaire
header('Location: ../../upload-resource.php');
exit;
?>