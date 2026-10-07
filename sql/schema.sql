-- ============================================================
-- KELASI
-- Plateforme d'inscription scolaire en ligne - RDC
-- MySQL 8+
-- ============================================================

CREATE DATABASE IF NOT EXISTS kelasi
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE kelasi;

SET NAMES utf8mb4;

-- ============================================================
-- 1. UTILISATEURS
-- Administrateurs + parents/tuteurs
-- ============================================================

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(191) NOT NULL UNIQUE,

    password_hash VARCHAR(255) NOT NULL,

    role ENUM('admin', 'parent')
        NOT NULL DEFAULT 'parent',

    is_active TINYINT(1)
        NOT NULL DEFAULT 1,

    created_at TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    last_login_at TIMESTAMP NULL DEFAULT NULL

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 2. ANNÉES SCOLAIRES
-- ============================================================

CREATE TABLE annees_scolaires (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    libelle VARCHAR(20) NOT NULL UNIQUE,

    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,

    est_active TINYINT(1)
        NOT NULL DEFAULT 0,

    created_at TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT chk_annee_dates
        CHECK (date_fin > date_debut)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 3. NIVEAUX / CLASSES SCOLAIRES (RDC)
-- ============================================================

CREATE TABLE classes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    cycle ENUM(
        'maternelle',
        'primaire',
        'eb',
        'humanite'
    ) NOT NULL,

    niveau VARCHAR(50) NOT NULL,

    ordre INT UNSIGNED NOT NULL,

    created_at TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_classe_niveau (niveau),
    UNIQUE KEY uq_classe_ordre (ordre)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 4. ÉLÈVES
-- ============================================================

CREATE TABLE eleves (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(80) NOT NULL,
    postnom VARCHAR(80) NULL,
    prenom VARCHAR(80) NOT NULL,

    sexe ENUM('M', 'F') NOT NULL,

    date_naissance DATE NOT NULL,
    lieu_naissance VARCHAR(150) NULL,

    nationalite VARCHAR(80)
        NOT NULL DEFAULT 'Congolaise',

    adresse TEXT NULL,

    parent_id INT UNSIGNED NULL,

    parent_nom VARCHAR(150) NOT NULL,
    parent_lien VARCHAR(50) NULL,
    parent_email VARCHAR(191) NULL,
    telephone VARCHAR(30) NOT NULL,

    date_creation TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    date_modification TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_eleve_parent
        FOREIGN KEY (parent_id)
        REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    INDEX idx_eleve_nom (nom),
    INDEX idx_eleve_parent (parent_id),
    INDEX idx_eleve_date_naissance (date_naissance)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 5. INSCRIPTIONS
-- ============================================================

CREATE TABLE inscriptions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    numero_dossier VARCHAR(30) NOT NULL UNIQUE,

    eleve_id INT UNSIGNED NOT NULL,

    classe_id INT UNSIGNED NOT NULL,

    annee_scolaire_id INT UNSIGNED NOT NULL,

    statut ENUM(
        'brouillon',
        'en_attente',
        'en_examen',
        'validee',
        'rejetee',
        'annulee'
    ) NOT NULL DEFAULT 'en_attente',

    motif_rejet TEXT NULL,

    observations TEXT NULL,

    date_soumission TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    date_traitement TIMESTAMP NULL DEFAULT NULL,

    traite_par INT UNSIGNED NULL,

    created_at TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP
        NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_inscription_eleve
        FOREIGN KEY (eleve_id)
        REFERENCES eleves(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_inscription_classe
        FOREIGN KEY (classe_id)
        REFERENCES classes(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_inscription_annee
        FOREIGN KEY (annee_scolaire_id)
        REFERENCES annees_scolaires(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_inscription_admin
        FOREIGN KEY (traite_par)
        REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    UNIQUE KEY uq_eleve_annee (
        eleve_id,
        annee_scolaire_id
    ),

    INDEX idx_inscription_statut (statut),
    INDEX idx_inscription_classe (classe_id),
    INDEX idx_inscription_annee (annee_scolaire_id),
    INDEX idx_inscription_date (date_soumission)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 6. ANNÉE SCOLAIRE DE TEST
-- ============================================================

INSERT INTO annees_scolaires
    (libelle, date_debut, date_fin, est_active)
VALUES
    ('2026-2027', '2026-09-01', '2027-07-31', 1);


-- ============================================================
-- 7. NIVEAUX SCOLAIRES RDC
-- ============================================================

INSERT INTO classes (cycle, niveau, ordre) VALUES

('maternelle', '1ère maternelle', 1),
('maternelle', '2ème maternelle', 2),
('maternelle', '3ème maternelle', 3),

('primaire', '1ère primaire', 4),
('primaire', '2ème primaire', 5),
('primaire', '3ème primaire', 6),
('primaire', '4ème primaire', 7),
('primaire', '5ème primaire', 8),
('primaire', '6ème primaire', 9),

('eb', '7ème EB', 10),
('eb', '8ème EB', 11),

('humanite', '1ère humanité', 12),
('humanite', '2ème humanité', 13),
('humanite', '3ème humanité', 14),
('humanite', '4ème humanité', 15);


-- ============================================================
-- 8. COMPTES DE TEST (mot de passe : "password")
-- ============================================================

-- Hash Bcrypt de "password" :
-- $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

INSERT INTO users (
    username,
    email,
    password_hash,
    role
) VALUES (
    'admin',
    'admin@kelasi.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin'
);

INSERT INTO users (
    username,
    email,
    password_hash,
    role
) VALUES (
    'parent1',
    'parent@kelasi.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'parent'
);


-- ============================================================
-- FIN DU SCRIPT
-- ============================================================