<?php
include('../config/dbconn.php');
$data = $_POST;
$requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('', '".$data['chemin']."', NOW(), '".$data['action']."', '".$data['email']."')";
$query=$DB_con->prepare($requete);
$query->execute();
