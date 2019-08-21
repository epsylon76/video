<?php

include_once('../config/dbconn.php');
include_once('../config/config.php');

$params = get_params();
$data = $params['dossier_data'];

$requete="SELECT * from `partage`";
$query=$DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$i=0;
foreach($results as $ligne){
  $date= new DateTime($ligne['date']);
  $date_aff = $date->format('d/m/Y H:i');

//  if (file_exists($data.$ligne['chemin'])) {$exist = true;}else{$exist = false;}

  if($ligne['type_partage'] == "video"){$icone = '<i class="fas fa-video"></i>&nbsp;';}
  elseif($ligne['type_partage'] == "photos"){$icone = '<i class="fas fa-camera"></i>&nbsp;';}
  elseif($ligne['type_partage'] == "dossier"){$icone = '<i class="fas fa-file-archive"></i>&nbsp;';}

//  if($exist){
//    $date_c = date ("F d Y H:i:s.", filectime($data.$ligne['chemin']));
//    $date_c = new DateTime($date_c);
//    $date_creation = $date_c->format('d/m/Y');
//  }else{
//    $date_creation = '<i class="fas fa-times" style="color:red"></i> fichier introuvable';
//  }

  $items[$i][0] = $ligne['id'];
  $items[$i][1] = $date_aff;
  $items[$i][2] = $icone.'<strong>'.$ligne['chemin'].'</strong>';
//  $items[$i][3] = $date_creation;
  $items[$i][3] = '<a href="?cle='.$ligne['cle'].'">'.$ligne['email'].'</a>';
  $items[$i][4] = $ligne['admin_login'];
  $items[$i][5] = '<a href="?page=renvoi_mail&email='.$ligne['email'].'"><i class="fas fa-reply-all"></i></a>&nbsp;&nbsp;<a href="?page=unset_partage&id='.$ligne['id'].'"><i class="fas fa-trash-alt" style="color:red;"></i></a>';
  $i++;
}
$data = array("data" => $items); // l'array doit etre un array data []: puis les données
$retour = json_encode($data, true);

echo $retour;
