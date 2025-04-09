<?php


function pr($data)
{
  echo "<pre>";
  print_r($data); // or var_dump($data);
  echo "</pre>";
}

function HumanSize($Bytes)
{
  $Type = array("o", "Ko", "Mo", "Go", "To", "Po", "Exa", "Zetta", "Yotta");
  $Index = 0;
  while ($Bytes >= 1024) {
    $Bytes /= 1024;
    $Index++;
  }
  return ("" . floor($Bytes) . " " . $Type[$Index]);
}

function breadcrumb($chemin)
{
  global $data, $dossier;
  $lien = '';
  $retour = '<nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center">
      <ol class="breadcrumb">';

  $bread = trim($chemin, '/');
  $bread = explode('/', $bread);

  $retour .= '<li class="breadcrumb-item"><a href="/admin/dossiers/">Racine</a></li>';

  foreach ($bread as $ligne) {
    $lien  .= '/' . $ligne;
    $retour .= '<li class="breadcrumb-item"><a href="/admin/dossiers' . $lien . '/">' . $ligne . '</a></li>';
  }

  $retour .= '</ol>';

  if ($chemin != '/' && $chemin != '') {
    //précédent, suivant
    $retour .= '<div class="text-right">';
    $to_scan = urldecode($data . $chemin . '/../');
    $liste_up = scandir($to_scan);
    array_shift($liste_up); //retrait .
    array_shift($liste_up); //retrait ..

    //place de notre dossier dans la liste du parent
    $i = array_search($ligne, $liste_up); //le dernier = actuel
    //précédent

    if ($i >= 1) {
      $testextension = pathinfo($data . $liste_up[$i]);
      if (!isset($testextension['extension'])) {
        $precedent = str_replace($ligne, '', $lien) . $liste_up[$i - 1];
        $retour .= '<a href="/admin/dossiers' . $precedent . '/" class="btn btn-secondary"><i class="fas fa-arrow-left"></i></a> ';
      }
    }
    //suivant

    if (isset($liste_up[$i + 1])) {
      $testextension = pathinfo($data . $liste_up[$i + 1]);
      if (!isset($testextension['extension'])) {
        $suivant = str_replace($ligne, '', $lien) . $liste_up[$i + 1];
        $retour .= '<a href="/admin/dossiers' . $suivant . '/" class="btn btn-secondary"><i class="fas fa-arrow-right"></i></a>';
      }
    }
    $retour .= '</div>';
  }


  $retour .= '</nav>';
  return $retour;
}


function datetime_unix_humain($date_unix)
{
    $date = new DateTime($date_unix);
    return ($date->format('d/m/Y H:i'));
}