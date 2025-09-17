<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partager une Ressource - BSFE INSTI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include 'includes/header.php' ?>

<!-- Messages de feedback -->
<?php if (isset($_SESSION['upload_success'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo $_SESSION['upload_success']; unset($_SESSION['upload_success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['upload_error'])): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $_SESSION['upload_error']; unset($_SESSION['upload_error']); ?>
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
                <a href="resources.php" class="breadcrumb-item">
                    Ressources Partagées
                </a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item">Partager une Ressource</span>
            </div>

            <!-- En-tête du formulaire -->
            <div class="form-header">
                <h1>
                    <i class="fas fa-upload"></i>
                    Partager une Ressource
                </h1>
                <p>Aidez vos collègues étudiants en partageant vos cours, mémoires, exposés et autres ressources académiques.</p>
            </div>

            <!-- Formulaire d'upload -->
            <form class="upload-form" action="backend/php/upload_resource.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-row">
                    <!-- Nom de la ressource -->
                    <div class="form-group">
                        <label for="nom_ressource">
                            <i class="fas fa-file-alt"></i>
                            Nom de la ressource <span class="required">*</span>
                        </label>
                        <input type="text" id="nom_ressource" name="nom_ressource" required
                               placeholder="Ex: Cours magistral avec études de cas industriels"
                               maxlength="200">
                        <small>Donnez un nom clair et descriptif à votre ressource</small>
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
                            <option value="MS">MS - Mathématiques et Sciences</option>
                            <option value="GMP">GMP - Génie Mécanique et Productique</option>
                        </select>
                    </div>

                    <!-- Type de ressource -->
                    <div class="form-group">
                        <label for="type_ressource">
                            <i class="fas fa-tags"></i>
                            Type de ressource <span class="required">*</span>
                        </label>
                        <select id="type_ressource" name="type_ressource" required>
                            <option value="">Choisir un type</option>
                            <option value="cours_pdf">Cours PDF</option>
                            <option value="memoire">Mémoire</option>
                            <option value="expose">Exposé</option>
                            <option value="td">TD (Travaux Dirigés)</option>
                            <option value="projet">Projet</option>
                            <option value="tp">TP (Travaux Pratiques)</option>
                            <option value="exercices">Exercices Corrigés</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Matière -->
                    <div class="form-group">
                        <label for="matiere">
                            <i class="fas fa-book"></i>
                            Matière <span class="required">*</span>
                        </label>
                        <input type="text" id="matiere" name="matiere" required
                               placeholder="Ex: Algorithmes et Structures de Données"
                               maxlength="150">
                        <small>Indiquez la matière ou le domaine concerné</small>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Description -->
                    <div class="form-group full-width">
                        <label for="description">
                            <i class="fas fa-align-left"></i>
                            Description brève <span class="required">*</span>
                        </label>
                        <textarea id="description" name="description" required
                                  placeholder="Ex: Cours complet avec exemples pratiques et exercices corrigés"
                                  maxlength="500" rows="4"></textarea>
                        <small><span id="char-count">0</span>/500 caractères</small>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Nom du contributeur -->
                    <div class="form-group">
                        <label for="nom_contributeur">
                            <i class="fas fa-user"></i>
                            Votre nom <span class="required">*</span>
                        </label>
                        <input type="text" id="nom_contributeur" name="nom_contributeur" required
                               placeholder="Ex: Jean Dupont"
                               maxlength="100">
                        <small>Votre nom sera affiché publiquement comme contributeur</small>
                    </div>

                    <!-- Niveau d'études (optionnel) -->
                    <div class="form-group">
                        <label for="niveau_etudes">
                            <i class="fas fa-graduation-cap"></i>
                            Niveau d'études
                        </label>
                        <select id="niveau_etudes" name="niveau_etudes">
                            <option value="">Non spécifié</option>
                            <option value="L1">L1 - 1ère année</option>
                            <option value="L2">L2 - 2ème année</option>
                            <option value="L3">L3 - 3ème année</option>
                            <option value="M1">M1 - 1ère année Master</option>
                            <option value="M2">M2 - 2ème année Master</option>
                        </select>
                        <small>Niveau pour lequel cette ressource est destinée</small>
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
                        <p>En partageant cette ressource, vous confirmez que vous en êtes l'auteur ou que vous avez l'autorisation de la partager. 
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
                        Partager la Ressource
                    </button>
                </div>

            </form>
        </div>
    </section>

    <script>
        // Gestion du compteur de caractères pour la description
        document.getElementById('description').addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('char-count').textContent = charCount;
            
            if (charCount > 450) {
                document.getElementById('char-count').style.color = '#dc3545';
            } else {
                document.getElementById('char-count').style.color = '#6c757d';
            }
        });

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