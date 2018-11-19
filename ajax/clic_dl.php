<?php
include('../config/dbconn.php');
$requete="INSERT INTO `historique` (`id_admin`,`id_partage`,`date`,`action`) VALUES ('0', '".$_GET['id']."', NOW(), 'dl')";
$query=$DB_con->prepare($requete);
$query->execute();
