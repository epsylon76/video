<?php
include_once('../config/dbconn.php');
include_once('../config/config.php');


$requete = "SELECT * from `partage` WHERE `chemin` = :chemin AND `email` = :email";
$query = $DB_con->prepare($requete);
$query->bindParam(':chemin', $_POST['chemin']);
$query->bindParam(':email', $_POST['email']);
$query->execute();
$results = $query->fetchAll();

if($results){
    echo 'true';
}else{
    echo 'false';
}

