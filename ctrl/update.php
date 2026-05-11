<?php
include_once('./config/dbconn.php');

$createBandePassanteTable = "CREATE TABLE IF NOT EXISTS bande_passante(
                id_bp int auto_increment primary key,
                type varchar(30) NOT NULL,
                heure datetime NOT NULL,
                taille int NOT NULL
                )";


$createCheminTable = "CREATE TABLE IF NOT EXISTS chemin (
    id_chemin int auto_increment primary key,
    nom_chemin VARCHAR(50), 
    type VARCHAR(15)
)";

$createTagTable = "CREATE TABLE IF NOT EXISTS tag (
    id_tag int auto_increment primary key,
    nom_tag VARCHAR(50),
    id_chemin int,
    FOREIGN KEY (id_chemin) REFERENCES chemin(id_chemin)
)";

$createPartageIntrouvableScanTable = "CREATE TABLE IF NOT EXISTS partage_introuvable_scan (
    id_partage int primary key,
    chemin TEXT NOT NULL,
    introuvable TINYINT(1) NOT NULL DEFAULT 0,
    checked_at datetime NOT NULL,
    INDEX idx_introuvable_checked (introuvable, checked_at)
)";




$DB_con->exec($createBandePassanteTable);
$DB_con->exec($createCheminTable);
$DB_con->exec($createTagTable);
$DB_con->exec($createPartageIntrouvableScanTable);

?>
