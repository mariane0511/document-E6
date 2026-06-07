DROP DATABASE IF EXISTS auto_ecole_may_it;
CREATE DATABASE auto_ecole_may_it;
USE auto_ecole_may_it;

-- ============================================================
--  TABLE PARENT (commune à candidat et moniteur)
-- ============================================================

CREATE TABLE utilisateur (
    idutilisateur INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    telephone VARCHAR(15),
    sexe ENUM('Femme', 'Homme', 'Autre'),
    PRIMARY KEY (idutilisateur)
);

-- ============================================================
--  TABLE ADMIN (indépendante, pas dans l'héritage)
-- ============================================================

CREATE TABLE user (
    iduser INT(3) NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(50),
    mdp VARCHAR(255),
    droits ENUM('user', 'admin'),
    PRIMARY KEY (iduser)
);

-- ============================================================
--  TABLES METIER
-- ============================================================

CREATE TABLE formule (
    idformule INT(4) NOT NULL,
    libelle VARCHAR(50) NOT NULL,
    prix DECIMAL(6,2) NOT NULL,
    duree INT(3),
    typepublic VARCHAR(20),
    CONSTRAINT pk_formule PRIMARY KEY (idformule)
);

-- candidat hérite de utilisateur
CREATE TABLE candidat (
    idcandidat INT NOT NULL,
    nom VARCHAR(30) NOT NULL,
    prenom VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    mdp VARCHAR(50) NOT NULL,
    datenaissance DATE,
    etudiant BOOLEAN,
    sexe ENUM('Femme', 'Homme', 'Autre'),
    idformule INT(4) NOT NULL,
    CONSTRAINT pk_candidat PRIMARY KEY (idcandidat),
    CONSTRAINT fk_candidat_utilisateur FOREIGN KEY (idcandidat) REFERENCES utilisateur(idutilisateur),
    CONSTRAINT fk_formule FOREIGN KEY (idformule) REFERENCES formule(idformule)
);

-- moniteur hérite de utilisateur
CREATE TABLE moniteur (
    idmoniteur INT NOT NULL,
    nom VARCHAR(30) NOT NULL,
    prenom VARCHAR(30) NOT NULL,
    telephone VARCHAR(15),
    email VARCHAR(50),
    mdp VARCHAR(50) NOT NULL,
    date_embauche DATE,
    type_permis ENUM('permis A', 'permis B'),
    sexe ENUM('Femme', 'Homme', 'Autre'),
    CONSTRAINT pk_moniteur PRIMARY KEY (idmoniteur),
    CONSTRAINT fk_moniteur_utilisateur FOREIGN KEY (idmoniteur) REFERENCES utilisateur(idutilisateur)
);

CREATE TABLE modele (
    idmodele INT(4) NOT NULL,
    marque VARCHAR(30) NOT NULL,
    nommodele VARCHAR(30) NOT NULL,
    typeboite ENUM('auto', 'manuelle'),
    CONSTRAINT pk_modele PRIMARY KEY (idmodele)
);

CREATE TABLE vehicule (
    idvehicule INT(4) NOT NULL,
    immatriculation VARCHAR(15) NOT NULL,
    etat VARCHAR(20),
    idmoniteur INT,
    idmodele INT(4) NOT NULL,
    CONSTRAINT pk_vehicule PRIMARY KEY (idvehicule),
    CONSTRAINT fk_vehicule_moniteur FOREIGN KEY (idmoniteur) REFERENCES moniteur(idmoniteur),
    CONSTRAINT fk_modele FOREIGN KEY (idmodele) REFERENCES modele(idmodele)
);

CREATE TABLE lecon (
    idlecon INT(5) NOT NULL,
    datedebut DATETIME NOT NULL,
    datefin DATETIME NOT NULL,
    idcandidat INT NOT NULL,
    idmoniteur INT NOT NULL,
    idvehicule INT(4) NOT NULL,
    CONSTRAINT pk_lecon PRIMARY KEY (idlecon),
    CONSTRAINT fk_lecon_candidat FOREIGN KEY (idcandidat) REFERENCES candidat(idcandidat),
    CONSTRAINT fk_lecon_moniteur FOREIGN KEY (idmoniteur) REFERENCES moniteur(idmoniteur),
    CONSTRAINT fk_lecon_vehicule FOREIGN KEY (idvehicule) REFERENCES vehicule(idvehicule)
);

CREATE TABLE question_code (
    idquestion INT(5) NOT NULL AUTO_INCREMENT,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    bonne_reponse ENUM('A', 'B', 'C', 'D') NOT NULL,
    categorie VARCHAR(50),
    image VARCHAR(255),
    PRIMARY KEY (idquestion)
);

CREATE TABLE resultat_quiz (
    idresultat INT(5) NOT NULL AUTO_INCREMENT,
    idcandidat INT NOT NULL,
    date_quiz DATETIME NOT NULL,
    score INT(3) NOT NULL,
    total_questions INT(3) NOT NULL,
    temps_total INT(5),
    PRIMARY KEY (idresultat),
    FOREIGN KEY (idcandidat) REFERENCES candidat(idcandidat)
);

-- ============================================================
--  TRIGGERS CANDIDAT (héritage avec utilisateur)
-- ============================================================

DROP TRIGGER IF EXISTS insert_candidat;
DELIMITER //
CREATE TRIGGER insert_candidat
BEFORE INSERT ON candidat
FOR EACH ROW
BEGIN
    INSERT INTO utilisateur (nom, prenom, email, mdp, telephone, sexe)
    VALUES (NEW.nom, NEW.prenom, NEW.email, NEW.mdp, NULL, NEW.sexe);

    SET NEW.idcandidat = LAST_INSERT_ID();
END //
DELIMITER ;

DROP TRIGGER IF EXISTS update_candidat;
DELIMITER //
CREATE TRIGGER update_candidat
AFTER UPDATE ON candidat
FOR EACH ROW
BEGIN
    UPDATE utilisateur
    SET nom    = NEW.nom,
        prenom = NEW.prenom,
        email  = NEW.email,
        mdp    = NEW.mdp,
        sexe   = NEW.sexe
    WHERE idutilisateur = OLD.idcandidat;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS delete_candidat;
DELIMITER //
CREATE TRIGGER delete_candidat
AFTER DELETE ON candidat
FOR EACH ROW
BEGIN
    DELETE FROM utilisateur
    WHERE idutilisateur = OLD.idcandidat;
END //
DELIMITER ;

-- ============================================================
--  TRIGGERS MONITEUR (héritage avec utilisateur)
-- ============================================================

DROP TRIGGER IF EXISTS insert_moniteur;
DELIMITER //
CREATE TRIGGER insert_moniteur
BEFORE INSERT ON moniteur
FOR EACH ROW
BEGIN
    INSERT INTO utilisateur (nom, prenom, email, mdp, telephone, sexe)
    VALUES (NEW.nom, NEW.prenom, NEW.email, NEW.mdp, NEW.telephone, NEW.sexe);

    SET NEW.idmoniteur = LAST_INSERT_ID();
END //
DELIMITER ;

DROP TRIGGER IF EXISTS update_moniteur;
DELIMITER //
CREATE TRIGGER update_moniteur
AFTER UPDATE ON moniteur
FOR EACH ROW
BEGIN
    UPDATE utilisateur
    SET nom       = NEW.nom,
        prenom    = NEW.prenom,
        email     = NEW.email,
        mdp       = NEW.mdp,
        telephone = NEW.telephone,
        sexe      = NEW.sexe
    WHERE idutilisateur = OLD.idmoniteur;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS delete_moniteur;
DELIMITER //
CREATE TRIGGER delete_moniteur
AFTER DELETE ON moniteur
FOR EACH ROW
BEGIN
    DELETE FROM utilisateur
    WHERE idutilisateur = OLD.idmoniteur;
END //
DELIMITER ;

-- ============================================================
--  QUESTIONS DE CODE
-- ============================================================

INSERT INTO question_code (question, option_a, option_b, option_c, option_d, bonne_reponse, categorie) VALUES
('À un feu orange clignotant, vous devez :', 'Vous arrêter obligatoirement', 'Ralentir et céder le passage', 'Passer normalement', 'Accélérer pour passer', 'B', 'Signalisation'),
('La limitation de vitesse en agglomération est de :', '30 km/h', '50 km/h', '70 km/h', '90 km/h', 'B', 'Vitesse'),
('Le triangle de signalisation doit être placé à quelle distance minimum du véhicule en panne ?', '10 mètres', '30 mètres', '50 mètres', '100 mètres', 'B', 'Sécurité'),
('Sur autoroute, la distance de sécurité est de :', '1 seconde', '2 secondes', '3 secondes', '5 secondes', 'B', 'Sécurité'),
('Le taux d\'alcoolémie maximum autorisé pour un conducteur expérimenté est de :', '0,2 g/L', '0,5 g/L', '0,8 g/L', '1,0 g/L', 'B', 'Alcool'),
('Vous devez contrôler la pression de vos pneus :', 'À chaud', 'À froid', 'Peu importe', 'Jamais', 'B', 'Mécanique'),
('Le port de la ceinture de sécurité est obligatoire :', 'Seulement à l\'avant', 'Seulement sur autoroute', 'Partout', 'Nulle part', 'C', 'Sécurité'),
('En cas de pluie, la distance de freinage est :', 'Divisée par 2', 'Inchangée', 'Multipliée par 2', 'Multipliée par 4', 'C', 'Sécurité'),
('Un panneau triangulaire rouge et blanc indique :', 'Une interdiction', 'Un danger', 'Une obligation', 'Une indication', 'B', 'Signalisation'),
('La durée de validité du permis probatoire est de :', '1 an', '2 ans', '3 ans', '5 ans', 'C', 'Permis');

INSERT INTO formule (idformule, libelle, prix, duree, typepublic) VALUES
(1, 'Formule Classique', 800.00, 20, 'Adulte'),
(2, 'Formule Accélérée', 1200.00, 10, 'Adulte'),
(3, 'Formule Jeune', 700.00, 25, 'Etudiant'),
(4, 'Formule Complète', 1500.00, 30, 'Tous');

ALTER TABLE moniteur
MODIFY idmoniteur INT(11) NOT NULL AUTO_INCREMENT;

INSERT INTO moniteur
VALUES (
    NULL,
    'Dupont',
    'Jean',
    '0612345678',
    'm@gmail.com',
    'mdp123',
    '2024-09-01',
    'permis B',
    'Homme'
);
CREATE TABLE password_reset (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL
);
-- ========== MONITEURS ==========
INSERT INTO moniteur (idmoniteur, nom, prenom, telephone, email, mdp, date_embauche, type_permis, sexe) VALUES
(1, 'Dupont',   'Jean',    '0601020304', 'jean.dupont@may-it.fr',    'Moniteur@2024!', '2020-03-15', 'permis B', 'Homme'),
(2, 'Martin',   'Sophie',  '0605060708', 'sophie.martin@may-it.fr',  'Moniteur@2024!', '2021-06-01', 'permis B', 'Femme'),
(3, 'Bernard',  'Karim',   '0609101112', 'karim.bernard@may-it.fr',  'Moniteur@2024!', '2019-09-10', 'permis B', 'Homme'),
(4, 'Lefevre',  'Amina',   '0613141516', 'amina.lefevre@may-it.fr',  'Moniteur@2024!', '2022-01-20', 'permis A', 'Femme'),
(5, 'Moreau',   'Thomas',  '0617181920', 'thomas.moreau@may-it.fr',  'Moniteur@2024!', '2023-04-05', 'permis B', 'Homme');

-- ========== MODELES ==========
INSERT INTO modele (idmodele, marque, nommodele, typeboite) VALUES
(1,  'Renault',    'Clio V',    'manuelle'),
(2,  'Renault',    'Clio V',    'auto'),
(3,  'Peugeot',    '208',       'manuelle'),
(4,  'Peugeot',    '208',       'auto'),
(5,  'Citroën',    'C3',        'manuelle'),
(6,  'Citroën',    'C3',        'auto'),
(7,  'Volkswagen', 'Polo',      'manuelle'),
(8,  'Toyota',     'Yaris',     'auto'),
(9,  'Ford',       'Fiesta',    'manuelle'),
(10, 'Dacia',      'Sandero',   'manuelle');

-- ========== VEHICULES ==========
INSERT INTO vehicule (idvehicule, immatriculation, etat, idmoniteur, idmodele) VALUES
(1,  'AB-123-CD', 'bon',          4, 1),
(2,  'EF-456-GH', 'bon',          4, 3),
(3,  'IJ-789-KL', 'bon',          5, 5),
(4,  'MN-012-OP', 'bon',          5, 8),
(5,  'QR-345-ST', 'bon',          6, 2),
(6,  'UV-678-WX', 'bon',          6, 7),
(7,  'YZ-901-AB', 'bon',          7, 4),
(8,  'CD-234-EF', 'bon',          7, 6),
(9,  'GH-567-IJ', 'en révision',  8, 9),
(10, 'KL-890-MN', 'bon',          8, 10);

ALTER TABLE lecon ADD COLUMN statut VARCHAR(20) DEFAULT 'planifiee';

-- ========== admin ==========


INSERT INTO user (nom, prenom, email, mdp, droits)
VALUES ('Martin', 'Sophie', 'a@gmail.com', 'motdepasse456', 'admin');

DROP TRIGGER IF EXISTS insert_candidat;
DELIMITER //
CREATE TRIGGER insert_candidat
BEFORE INSERT ON candidat
FOR EACH ROW
BEGIN
    INSERT INTO utilisateur (nom, prenom, email, mdp, telephone, sexe)
    VALUES (NEW.nom, NEW.prenom, NEW.email, NEW.mdp, NULL, NEW.sexe);

    SET NEW.idcandidat = LAST_INSERT_ID();
END //
DELIMITER ;

DROP TRIGGER IF EXISTS update_candidat;
DELIMITER //
CREATE TRIGGER update_candidat
AFTER UPDATE ON candidat
FOR EACH ROW
BEGIN
    UPDATE utilisateur
    SET nom    = NEW.nom,
        prenom = NEW.prenom,
        email  = NEW.email,
        mdp    = NEW.mdp,
        sexe   = NEW.sexe
    WHERE idutilisateur = OLD.idcandidat;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS delete_candidat;
DELIMITER //
CREATE TRIGGER delete_candidat
AFTER DELETE ON candidat
FOR EACH ROW
BEGIN
    DELETE FROM utilisateur
    WHERE idutilisateur = OLD.idcandidat;
END //
DELIMITER ;

-- ============================================================
--  TRIGGERS MONITEUR (héritage avec utilisateur)
-- ============================================================

DROP TRIGGER IF EXISTS insert_moniteur;
DELIMITER //
CREATE TRIGGER insert_moniteur
BEFORE INSERT ON moniteur
FOR EACH ROW
BEGIN
    INSERT INTO utilisateur (nom, prenom, email, mdp, telephone, sexe)
    VALUES (NEW.nom, NEW.prenom, NEW.email, NEW.mdp, NEW.telephone, NEW.sexe);

    SET NEW.idmoniteur = LAST_INSERT_ID();
END //
DELIMITER ;

DROP TRIGGER IF EXISTS update_moniteur;
DELIMITER //
CREATE TRIGGER update_moniteur
AFTER UPDATE ON moniteur
FOR EACH ROW
BEGIN
    UPDATE utilisateur
    SET nom       = NEW.nom,
        prenom    = NEW.prenom,
        email     = NEW.email,
        mdp       = NEW.mdp,
        telephone = NEW.telephone,
        sexe      = NEW.sexe
    WHERE idutilisateur = OLD.idmoniteur;
END //
DELIMITER ;

DROP TRIGGER IF EXISTS delete_moniteur;
DELIMITER //
CREATE TRIGGER delete_moniteur
AFTER DELETE ON moniteur
FOR EACH ROW
BEGIN
    DELETE FROM utilisateur
    WHERE idutilisateur = OLD.idmoniteur;
END //
DELIMITER ;

-- ============================================================
-- MIGRATION MAY-IT v2 — Modifications Avril 2026
-- ============================================================

-- 1. Ajouter la colonne statut à la table lecon
--    Valeurs possibles : 'planifiee' (défaut), 'annulee', 'terminee'
ALTER TABLE lecon
    ADD COLUMN IF NOT EXISTS statut VARCHAR(20) DEFAULT 'planifiee'
        COMMENT 'Statut de la leçon : planifiee | annulee | terminee';

-- Si votre MySQL ne supporte pas IF NOT EXISTS pour ALTER TABLE :
-- ALTER TABLE lecon ADD COLUMN statut VARCHAR(20) DEFAULT 'planifiee';

-- 2. Mettre à jour les leçons existantes déjà passées
UPDATE lecon
SET statut = 'terminee'
WHERE datefin < NOW() AND statut = 'planifiee';

-- 3. (Optionnel) Index sur statut pour les requêtes filtrées
CREATE INDEX IF NOT EXISTS idx_lecon_statut ON lecon(statut);

-- ============================================================
-- FIN DE MIGRATION
-- ============================================================

-- ============================================================
-- Migration v3 - MAY-IT Améliorations
-- ============================================================
-- Aucune modification de schéma requise.
-- Les nouvelles fonctionnalités utilisent les tables existantes :
--   - resultat_quiz  → stats quiz moniteur + admin
--   - candidat + formule → factures admin
--   - lecon          → mes-eleves moniteur + modifier planning admin
--
-- Assurez-vous que la table resultat_quiz existe (migration_v2.sql)
-- et que quelques résultats de quiz ont été enregistrés pour tester.
--
-- Données de test optionnelles (quiz results) :
-- INSERT INTO resultat_quiz (idcandidat, date_quiz, score, total_questions, temps_total)
-- SELECT idcandidat, NOW() - INTERVAL FLOOR(RAND()*30) DAY, FLOOR(RAND()*11), 10, FLOOR(RAND()*300)+60
-- FROM candidat LIMIT 5;
