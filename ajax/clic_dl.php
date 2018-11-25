<?php
include('../config/dbconn.php');
$requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('', '".$_GET['chemin']."', NOW(), 'dl', '".$_GET['email']."')";
$query=$DB_con->prepare($requete);
$query->execute();
