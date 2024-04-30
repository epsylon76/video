<?php
include_once('../mdl/stats.php');
include('../config/dbconn.php');
$data = $_POST;
$requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('', '".$data['chemin']."', NOW(), '".$data['action']."', '".$data['email']."')";
$query=$DB_con->prepare($requete);
$query->execute();

$stats = new stats();
$stats->set_stats('dl_video', date("Y-m-d H:i:s"), $data['taille']);