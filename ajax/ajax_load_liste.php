<?php

include_once('../config/dbconn.php');
include_once('../config/config.php');

$params = get_params();
$data = $params['dossier_data'];

$requete = "SELECT * from `partage`";
$query = $DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$i = 0;
foreach ($results as $ligne) {
  $date = new DateTime($ligne['date']);
  $date_aff = $date->format('d/m/Y H:i');

  //  if (file_exists($data.$ligne['chemin'])) {$exist = true;}else{$exist = false;}

  if ($ligne['type_partage'] == "video") {
    $icone = '<i class="fas fa-video"></i>&nbsp;';
    $link = '<a href="/admin/video/' . $ligne['chemin'] . '/">';

  } 
  elseif ($ligne['type_partage'] == "photos") {
    $icone = '<i class="fas fa-camera"></i>&nbsp;';
    $link = '<a href="/admin/dossiers/' . $ligne['chemin'] . '/">';
  } 
  elseif ($ligne['type_partage'] == "dossier") {
    $icone = '<i class="fas fa-file-archive"></i>&nbsp;';
  }

  //  if($exist){
  //    $date_c = date ("F d Y H:i:s.", filectime($data.$ligne['chemin']));
  //    $date_c = new DateTime($date_c);
  //    $date_creation = $date_c->format('d/m/Y');
  //  }else{
  //    $date_creation = '<i class="fas fa-times" style="color:red"></i> fichier introuvable';
  //  }

  $items[$i][0] = $ligne['id'];
  $items[$i][1] = $date_aff;
  
//culcul url dossier
  if (substr($ligne['chemin'], -4, 1) == '.') {
    //c'est un fichier
    $pos = strrpos($ligne['chemin'], '/');
    $length = strlen($ligne['chemin']);
    $invertpos = $length - $pos;
    $newurl = substr($ligne['chemin'], -$length, -$invertpos);
    $url = urlencode($newurl);
  } else {
    $url = urlencode($ligne['chemin']);
  }

  $items[$i][2] = $icone;
  $items[$i][2] .= $link;
  $items[$i][2] .= $ligne['chemin'] . '</a>';

  //  $items[$i][3] = $date_creation;
  $items[$i][3] = '<a href="/cle/' . $ligne['cle'] . '">' . $ligne['email'] . '</a>';
  $items[$i][4] = $ligne['admin_login'];
  $items[$i][5] = '<a href="/actions/renvoiMail/' . $ligne['id'] . '"><i class="fas fa-reply-all"></i></a>&nbsp;&nbsp;<a href="/actions/unsetPartage/' . $ligne['id'] . '"><i class="fas fa-trash-alt" style="color:red;"></i></a>';
  $i++;
}
$data = array("data" => $items); // l'array doit etre un array data []: puis les données
$retour = json_encode($data, true);

echo $retour;
