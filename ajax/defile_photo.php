<?php
include_once('../mdl/dossier.php');
include_once('../mdl/stats.php');
include('../config/dbconn.php');

$data = $_POST;
$taille = filesize('..'.$data['imgSrc']);
echo $data['imgSrc'].' '.$taille;

$stats = new stats();
$stats->set_stats($data['action'], date("Y-m-d H:i:s"), $taille); 



?>