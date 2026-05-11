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

function chemin_depuis_segments_url($segments)
{
  $segments = array_map('rawurldecode', $segments);
  $segments = array_filter($segments, function ($segment) {
    return $segment !== '';
  });

  return implode('/', $segments);
}

function chemin_pour_url($chemin)
{
  $chemin = trim($chemin, '/');
  if ($chemin === '') {
    return '';
  }

  return implode('/', array_map('rawurlencode', explode('/', $chemin)));
}

function chemin_relatif_normalise($chemin)
{
  $chemin = str_replace('\\', '/', $chemin);
  $chemin = preg_replace('#/+#', '/', $chemin);

  return trim($chemin, '/');
}

function chemin_data_resolu($base, $chemin)
{
  $base_real = realpath($base);
  if ($base_real === false) {
    return false;
  }

  $chemin = chemin_relatif_normalise($chemin);
  $candidat = $chemin === '' ? $base_real : $base_real . DIRECTORY_SEPARATOR . $chemin;
  $candidat_real = realpath($candidat);

  if ($candidat_real === false) {
    return false;
  }

  if ($candidat_real !== $base_real && strpos($candidat_real, $base_real . DIRECTORY_SEPARATOR) !== 0) {
    return false;
  }

  return $candidat_real;
}

function chemin_data_ou_404($base, $chemin)
{
  $chemin_resolu = chemin_data_resolu($base, $chemin);
  if ($chemin_resolu === false) {
    http_response_code(404);
    die('Chemin introuvable ou non autorisé.');
  }

  return $chemin_resolu;
}

function breadcrumb($chemin)
{
  global $data, $dossier;
  $lien = '';
  
  $retour = '<div class="d-flex justify-content-between align-items-center bg-white p-2 px-3 rounded-3 shadow-sm mb-4 border">
      <nav aria-label="breadcrumb" class="me-2">
        <ol class="breadcrumb mb-0 flex-nowrap">';

  $bread = trim($chemin, '/');
  $bread = ($bread == '') ? [] : explode('/', $bread);

  $retour .= '<li class="breadcrumb-item"><a href="/admin/dossiers/" class="text-muted" title="Retour à la racine"><i class="fas fa-home"></i></a></li>';

  $current_folder = '';
  foreach ($bread as $ligne) {
    $current_folder = $ligne; 
    $lien  .= '/' . $ligne;
    
    $nom_propre = htmlspecialchars($ligne);
    
    $retour .= '<li class="breadcrumb-item" title="' . $nom_propre . '">
                  <a href="/admin/dossiers/' . chemin_pour_url($lien) . '/" class="text-decoration-none">' . $nom_propre . '</a>
                </li>';
  }

  $retour .= '</ol></nav>';

  if ($chemin != '/' && $chemin != '') {
    $retour .= '<div class="d-flex gap-1 flex-shrink-0">';
    
    $to_scan = chemin_data_ou_404($data, dirname(chemin_relatif_normalise($chemin)));
    $liste_up = scandir($to_scan);
    $liste_up = array_values(array_diff($liste_up, array('.', '..')));

    $i = array_search($current_folder, $liste_up);

    $prev_btn = '<button class="btn btn-sm btn-light border-0 text-muted" disabled><i class="fas fa-chevron-left fa-xs"></i></button>';
    if ($i !== false && $i > 0) {
            $prev_folder = $liste_up[$i - 1];
        if (!pathinfo($prev_folder, PATHINFO_EXTENSION)) {
            $precedent = str_replace($current_folder, '', $lien) . $prev_folder;
            $prev_btn = '<a href="/admin/dossiers/' . chemin_pour_url($precedent) . '/" class="btn btn-sm btn-light border shadow-sm px-2" title="Précédent : ' . htmlspecialchars($prev_folder) . '"><i class="fas fa-chevron-left fa-xs text-primary"></i></a>';
        }
    }
    
    $next_btn = '<button class="btn btn-sm btn-light border-0 text-muted" disabled><i class="fas fa-chevron-right fa-xs"></i></button>';
    if ($i !== false && isset($liste_up[$i + 1])) {
            $next_folder = $liste_up[$i + 1];
        if (!pathinfo($next_folder, PATHINFO_EXTENSION)) {
            $suivant = str_replace($current_folder, '', $lien) . $next_folder;
            $next_btn = '<a href="/admin/dossiers/' . chemin_pour_url($suivant) . '/" class="btn btn-sm btn-light border shadow-sm px-2" title="Suivant : ' . htmlspecialchars($next_folder) . '"><i class="fas fa-chevron-right fa-xs text-primary"></i></a>';
        }
    }

    $retour .= $prev_btn . $next_btn;
    $retour .= '</div>';
  }

  $retour .= '</div>';
  return $retour;
}


function datetime_unix_humain($date_unix)
{
    $date = new DateTime($date_unix);
    return ($date->format('d/m/Y H:i'));
}
