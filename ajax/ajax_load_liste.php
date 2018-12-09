<?php

include_once('../config/dbconn.php');
include_once('../config/config.php');

$params = get_params();
$data = $params['dossier_data'];

$requete="SELECT * from `partage` ";
$query=$DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$i=0;
foreach($results as $ligne){
  $date= new DateTime($ligne['date']);
  $date_aff = $date->format('d/m/Y H:i');

  if (file_exists($data.$ligne['chemin'])) {$exist = "";}else{$exist = "introuvable ";};

  $date_c = date ("F d Y H:i:s.", filectime($data.$ligne['chemin']));
  $date_c = new DateTime($date_c);
  $date_creation = $date_c->format('d/m/Y');

  $items[$i][0] = $ligne['id'];
  $items[$i][1] = $date_aff;
  $items[$i][2] = '<strong>'.$exist.$ligne['chemin'].'</strong>';
  $items[$i][3] = $date_creation;
  $items[$i][4] = '<a href="?cle='.$ligne['cle'].'">'.$ligne['email'].'</a>';
  $items[$i][5] = '<a href="?page=renvoi_mail&email='.$ligne['email'].'"><i class="fas fa-reply-all"></i></a>&nbsp;&nbsp;<a href="?page=unset_partage&id='.$ligne['id'].'"><i class="fas fa-trash-alt" style="color:red;"></i></a>';
  $i++;
}
$data = array("data" => $items); // l'array doit etre un array data []: puis les données
$retour = json_encode($data, true);

echo $retour;
