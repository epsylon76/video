<?php

include_once('../config/dbconn.php');

$requete="SELECT * from `partage` ";
$query=$DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$i=0;
foreach($results as $ligne){
  $date= new DateTime($ligne['date']);
  $date_aff = $date->format('d/m/Y H:i');

  $items[$i][0] = $ligne['id'];
  $items[$i][1] = $date_aff;
  $items[$i][2] = $ligne['chemin'];
  $items[$i][3] = $ligne['email'].' <a href="?page=renvoi_mail&email='.$ligne['email'].'">renvoi</a>';
  $items[$i][4] = '<a href="?page=unset_partage&id='.$ligne['id'].'&cle='.$ligne['cle'].'">x</a>';

  $i++;
}
$data = array("data" => $items); // l'array doit etre un array data []: puis les données
$retour = json_encode($data, true);

echo $retour;
