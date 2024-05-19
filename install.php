<?php

include_once("assets/includes/functionsObject.php");

$connexion = (new Base())->connecteBase();

// Requête SQL pour créer les tables
$sql = "
CREATE TABLE IF NOT EXISTS admin_table (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenoms VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    sexe VARCHAR(5) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS chauffeurs (
    chauffeur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenoms VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    sexe VARCHAR(5) NOT NULL,
    disponible INT NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    admin_created_id INT,
    admin_updated_id INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_created_id) REFERENCES admin_table(admin_id),
    FOREIGN KEY (admin_updated_id) REFERENCES admin_table(admin_id)
);

CREATE TABLE IF NOT EXISTS operateurs (
    operateur_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenoms VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    sexe VARCHAR(5) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    creator_id INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES admin_table(admin_id)
);

CREATE TABLE IF NOT EXISTS courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    point_depart VARCHAR(255) NOT NULL,
    point_arrivee VARCHAR(255) NOT NULL,
    date_heure DATETIME NOT NULL,
    chauffeur_id INT,
    operateur_id INT,
    admin_created_id INT,
    admin_updated_id INT,
    statut INT NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(chauffeur_id),
    FOREIGN KEY (operateur_id) REFERENCES operateurs(operateur_id),
    FOREIGN KEY (admin_created_id) REFERENCES admin_table(admin_id),
    FOREIGN KEY (admin_updated_id) REFERENCES admin_table(admin_id)
);";

// Exécution de la requête SQL pour créer les tables
try {
    $connexion->exec($sql);
    echo "Base de données installée avec succès !";
} catch (PDOException $e) {
    die("Erreur lors de la création des tables : " . $e->getMessage());
}

//mise en place du super Administrateur

$sql = "INSERT INTO admin_table (nom, prenoms, email, telephone, sexe, mot_de_passe) VALUES (?,?,?,?,?,?)";
$req = $connexion->prepare($sql);

try {
    $req->execute(["ABALO", "Jean-Claude", "kotchikpa2000@gmail.com", "94739951", "M", md5("abalo@000")]);
    echo "<br> Super Utilisateur créer avec succès ! <br>";
} catch (PDOException $e) {
    echo "<br> Erreur de création du super-Admin " . $e;
}

$connexion = null;
