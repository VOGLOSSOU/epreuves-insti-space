<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Épreuve - BSFE INSTI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'includes/header.php' ?>

<!-- Messages de feedback -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<section class="upload-section">
    <div class="upload-container">

        <!-- Fil d'Ariane -->
        <div class="breadcrumb">
            <a href="index.php" class="breadcrumb-item">
                <i class="fas fa-home"></i>
                Accueil
            </a>
            <span class="breadcrumb-separator">/</span>
            <a href="epreuves.php" class="breadcrumb-item">
                Épreuves
            </a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-item">Ajouter une Épreuve</span>
        </div>

        <!-- En-tête du formulaire -->
        <div class="form-header">
            <h1>
                <i class="fas fa-plus-circle"></i>
                Ajouter une Nouvelle Épreuve
            </h1>
            <p>Contribuez à enrichir la base de données d'épreuves de l'INSTI en partageant vos examens passés.</p>
        </div>

        <!-- Formulaire d'ajout d'épreuve -->
        <form class="upload-form" action="backend/php/add.php" method="POST" enctype="multipart/form-data">

            <div class="form-row">
                <!-- Nom de l'épreuve -->
                <div class="form-group">
                    <label for="nom">
                        <i class="fas fa-file-alt"></i>
                        Nom de l'épreuve <span class="required">*</span>
                    </label>
                    <input type="text" id="nom" name="nom"
                           placeholder="Ex: 2ème Devoir de Maintenance Industrielle 2024-2025"
                           maxlength="200" required>
                    <small>Donnez un nom clair et descriptif à votre épreuve</small>
                </div>
            </div>

            <div class="form-row">
                <!-- Département -->
                <div class="form-group">
                    <label for="departement">
                        <i class="fas fa-building"></i>
                        Département <span class="required">*</span>
                    </label>
                    <select id="departement" name="departement" required>
                        <option value="">Choisir un département</option>
                        <option value="GEI">GEI - Génie Électrique et Informatique</option>
                        <option value="GC">GC - Génie Civil</option>
                        <option value="GE">GE - Génie Énergétique</option>
                        <option value="MS">MS - Maintenance des Systèmes</option>
                        <option value="GMP">GMP - Génie Mécanique et Productique</option>
                    </select>
                </div>

                <!-- Filière -->
                <div class="form-group">
                    <label for="filiere">
                        <i class="fas fa-graduation-cap"></i>
                        Filière <span class="required">*</span>
                    </label>
                    <select id="filiere" name="filiere" required>
                        <option value="">Choisir une filière</option>
                        <option value="IT">IT - Informatique et Télécommunication</option>
                        <option value="EE">EE - Électronique et Électrotechnique</option>
                        <option value="GC">GC - Génie Civil</option>
                        <option value="ER">ER - Énergie Renouvelable</option>
                        <option value="FC">FC - Froid et Climatisation</option>
                        <option value="MI">MI - Maintenance Industrielle</option>
                        <option value="MA">MA - Maintenance Automobile</option>
                        <option value="GMP">GMP - Génie Mécanique et Productique</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <!-- Type d'examen -->
                <div class="form-group">
                    <label for="type">
                        <i class="fas fa-clipboard-check"></i>
                        Type d'examen <span class="required">*</span>
                    </label>
                    <select id="type" name="type" required>
                        <option value="">Choisir un type d'examen</option>
                        <option value="Examen">📝 Examen</option>
                        <option value="Devoir">📓 Devoir</option>
                        <option value="Rattrapage">🔄 Rattrapage</option>
                        <option value="Reprise">↩️ Reprise</option>
                    </select>
                </div>

                <!-- Session -->
                <div class="form-group">
                    <label for="session">
                        <i class="fas fa-calendar-alt"></i>
                        Session <span class="required">*</span>
                    </label>
                    <input type="text" id="session" name="session"
                           placeholder="Ex: Janvier 2025"
                           maxlength="50" required>
                    <small>Indiquez la période de l'examen</small>
                </div>
            </div>

            <div class="form-row">
                <!-- Matière -->
                <div class="form-group full-width">
                    <label for="matiere">
                        <i class="fas fa-book"></i>
                        Matière <span class="required">*</span>
                    </label>
                    <input type="text" id="matiere" name="matiere"
                           placeholder="Ex: Anglais, Mathématiques, Physique..."
                           maxlength="100" required>
                    <small>Indiquez la matière concernée par cette épreuve</small>
                </div>
            </div>

            <div class="form-row">
                <!-- Fichier PDF -->
                <div class="form-group full-width">
                    <label for="fichier_pdf">
                        <i class="fas fa-file-pdf"></i>
                        Fichier PDF <span class="required">*</span>
                    </label>
                    <div class="file-upload-area">
                        <input type="file" id="fichier_pdf" name="fichier_pdf" accept=".pdf" required>
                        <div class="file-upload-text">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Cliquez pour choisir votre fichier PDF ou glissez-le ici</p>
                            <small>Taille maximale: 10 MB • Format accepté: PDF uniquement</small>
                        </div>
                    </div>
                    <div class="file-info" id="file-info" style="display: none;">
                        <i class="fas fa-file-pdf"></i>
                        <span id="file-name"></span>
                        <span id="file-size"></span>
                        <button type="button" id="remove-file">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Note importante -->
            <div class="form-note">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Note importante :</strong>
                    <p>En partageant cette épreuve, vous confirmez que vous en êtes l'auteur ou que vous avez l'autorisation de la partager.
                    Le contenu sera vérifié avant publication et pourra être supprimé s'il ne respecte pas les conditions d'utilisation.</p>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="history.back()">
                    <i class="fas fa-times"></i>
                    Annuler
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-upload"></i>
                    Ajouter l'Épreuve
                </button>
            </div>

        </form>
    </div>
</section>

<script>
// Gestion du fichier PDF
const fileInput = document.getElementById('fichier_pdf');
const fileUploadArea = document.querySelector('.file-upload-area');
const fileInfo = document.getElementById('file-info');
const fileName = document.getElementById('file-name');
const fileSize = document.getElementById('file-size');
const removeFileBtn = document.getElementById('remove-file');

fileInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        showFileInfo(file);
    }
});

// Drag and drop
fileUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

fileUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

fileUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0 && files[0].type === 'application/pdf') {
        fileInput.files = files;
        showFileInfo(files[0]);
    } else {
        alert('Veuillez sélectionner un fichier PDF valide.');
    }
});

function showFileInfo(file) {
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    fileInfo.style.display = 'flex';
    fileUploadArea.style.display = 'none';
}

removeFileBtn.addEventListener('click', function() {
    fileInput.value = '';
    fileInfo.style.display = 'none';
    fileUploadArea.style.display = 'block';
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Validation du formulaire
document.querySelector('.upload-form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('fichier_pdf');
    if (!fileInput.files[0]) {
        e.preventDefault();
        alert('Veuillez sélectionner un fichier PDF.');
        return;
    }

    if (fileInput.files[0].size > 10 * 1024 * 1024) { // 10 MB
        e.preventDefault();
        alert('Le fichier est trop volumineux. Taille maximale : 10 MB.');
        return;
    }
});
</script>

<script src="scripts.js"></script>
<?php include 'includes/footer.php' ?>
</body>
</html>