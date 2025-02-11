<?php

include_once('../config/dbconn.php');
include_once('../config/config.php');
include_once('../config/fonctions.php');

include_once('../mdl/file_attente.php');
$file_attente = new file_attente();

$params = get_params();

$liste = $file_attente->liste();

foreach ($liste as $key => $un) {
  $liste[$key][2] = ($liste[$key][2] == 0) ? 'Programmé' : 'immediat';
  $liste[$key][1] = datetime_unix_humain($liste[$key][1]);
  if ($liste[$key][3] == '0000-00-00 00:00:00') {
    $liste[$key][3] = 'Non envoyé';
  } else {
    $liste[$key][3] = datetime_unix_humain($liste[$key][3]);
  }
}
$liste = array('data' => $liste);
$retour = json_encode($liste, true);

echo $retour;
