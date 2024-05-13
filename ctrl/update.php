<?php
include_once('./config/dbconn.php');

$createBandePassanteTable = "CREATE TABLE IF NOT EXISTS bande_passante(
                id_bp int auto_increment primary key,
                type varchar(30) NOT NULL,
                heure datetime NOT NULL,
                taille int NOT NULL
                )";

//
// J'ai inversé les deux requetes, sinon la création de la clé étrangère ne pouvait pas fonctionner
//

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




$DB_con->exec($createBandePassanteTable);
$DB_con->exec($createCheminTable);
$DB_con->exec($createTagTable);

?>