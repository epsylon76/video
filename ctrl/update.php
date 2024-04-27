<?php
include_once('./config/dbconn.php');

$createTable = "CREATE TABLE IF NOT EXISTS bande_passante(
                id_bp int auto_increment primary key,
                type varchar(30) NOT NULL,
                heure datetime NOT NULL,
                taille int NOT NULL
                )";

$DB_con->exec($createTable);

?>