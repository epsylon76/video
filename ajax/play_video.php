<?php
include_once('../mdl/stats.php');
$data = $_POST;

$stats = new stats();
$stats->set_stats($data['action'], date("Y-m-d H:i:s") , $data['chemin']);


?>