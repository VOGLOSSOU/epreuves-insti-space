-- Script de création de la table ressources
-- À exécuter dans votre base de données MySQL

CREATE TABLE IF NOT EXISTS `ressources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ressource` varchar(200) NOT NULL,
  `departement` varchar(10) NOT NULL,
  `type_ressource` varchar(50) NOT NULL,
  `matiere` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `nom_contributeur` varchar(100) NOT NULL,
  `niveau_etudes` varchar(10) DEFAULT NULL,
  `fichier` varchar(255) NOT NULL,
  `nom_fichier_original` varchar(255) NOT NULL,
  `taille_fichier` bigint(20) NOT NULL,
  `ip_utilisateur` varchar(45) DEFAULT NULL,
  `statut` enum('en_attente','approuve','rejete') DEFAULT 'en_attente',
  `vues` int(11) DEFAULT 0,
  `date_ajout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_departement` (`departement`),
  KEY `idx_type_ressource` (`type_ressource`),
  KEY `idx_niveau_etudes` (`niveau_etudes`),
  KEY `idx_statut` (`statut`),
  KEY `idx_date_ajout` (`date_ajout`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer quelques données d'exemple (optionnel)
INSERT INTO `ressources` (`nom_ressource`, `departement`, `type_ressource`, `matiere`, `description`, `nom_contributeur`, `niveau_etudes`, `fichier`, `nom_fichier_original`, `taille_fichier`, `statut`, `vues`) VALUES
('Cours Complet - Algorithmes et Structures de Données', 'GEI', 'cours_pdf', 'Algorithmes', 'Cours magistral complet avec exemples pratiques et exercices corrigés', 'Jean Dupont', 'L2', 'example_cours.pdf', 'Cours_Algorithmes_L2.pdf', 2048576, 'approuve', 15),
('Mémoire - Système de Gestion Intelligent', 'GEI', 'memoire', 'Informatique', 'Mémoire de fin d\'études sur les systèmes intelligents appliqués à la gestion', 'Marie Martin', 'M2', 'example_memoire.pdf', 'Memoire_Systemes_Intelligents.pdf', 5242880, 'approuve', 8),
('TD Corrigés - Résistance des Matériaux', 'GC', 'td', 'RDM', 'Travaux dirigés avec corrections détaillées', 'Pierre Durand', 'L3', 'example_td.pdf', 'TD_RDM_L3.pdf', 1048576, 'approuve', 22);