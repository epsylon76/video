<?php

include_once('../config/dbconn.php');
include_once('../config/config.php');

$requete="SELECT * from `partage` ";
$query=$DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$i=0;
foreach($results as $ligne){
  $date= new DateTime($ligne['date']);
  $date_aff = $date->format('d/m/Y H:i');

  if (file_exists($data.$ligne['chemin'])) {$exist = "";}else{$exist = "introuvable ";};

  $items[$i][0] = $ligne['id'];
  $items[$i][1] = $date_aff;
  $items[$i][2] = $exist.$ligne['chemin'];
  $items[$i][3] = $ligne['email'];
  $items[$i][4] = '<a href="?page=renvoi_mail&email='.$ligne['email'].'"><i class="fas fa-reply-all"></i></a>&nbsp;&nbsp;<a href="?page=unset_partage&id='.$ligne['id'].'&cle='.$ligne['cle'].'"><i class="fas fa-trash-alt"></i></a>';

  $i++;
}
$data = array("data" => $items); // l'array doit etre un array data []: puis les données
$retour = json_encode($data, true);

echo $retour;