<?php

include_once('../config/dbconn.php');

$requete="SELECT * from `partage` ";
$query=$DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$i=0;
foreach($results as $ligne){
  $items[$i][0] = $ligne['id'];
  $items[$i][1] = $ligne['date'];
  $items[$i][2] = $ligne['chemin'];
  $items[$i][3] = $ligne['email'];

  $i++;
}
$data = array("data" => $items); // l'array doit etre un array data []: puis les données
$retour = json_encode($data, true);

echo $retour;
