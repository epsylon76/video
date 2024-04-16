<?php

class dossier
{

  function contenu_dossier($chemin, $data)
  {

    $listefichiers = preg_grep('/^([^.])/', scandir($data . $chemin)); //exclut les fichiers commençant par un point
    natsort($listefichiers);
    return $listefichiers;
  }

  function infos_fichier($data, $chemin, $fichier)
  {
    $type_fichier[0] = filetype($data . $chemin . $fichier);

    #si ce n'est pas un dossier on donne son extension
    if ($type_fichier[0] == 'file') {
      $extension = pathinfo($data . $chemin . $fichier);
      $type_fichier[1] = $extension['extension'];
    }

    return $type_fichier;
  }


  function detect_photos($sousdossier)
  {
    global $data;
    $liste = scandir($sousdossier);
    $nb = 0;
    foreach ($liste as $item) {
      if ($item != '.' && $item != '..') {
        $type = filetype($sousdossier . '/' . $item);
        if ($type == 'file') {
          $ext = pathinfo($sousdossier . '/' . $item);
          if ($ext['extension'] == "jpg" || $ext['extension'] == "JPG") {
            $nb++;
          }
        }
      }
    }
    return $nb;
  }

  function nb_sous_dossiers($sousdossier)
  {
    $nb_sous_dossiers = 0;
    $sous_dossiers = scandir($sousdossier);
    foreach ($sous_dossiers as $sous) {
      if ($sous != "." && $sous != "..") {
        $type = filetype($sousdossier . '/' . $sous);
        if ($type == 'dir') {
          $nb_sous_dossiers++;
        }
      }
    }
    return $nb_sous_dossiers;
  }


  function affiche_contenu($listefichiers)
  {

    global $data;
    global $chemin;
    global $params;
    $retour = '';
    $compteur_images = 0;
    $items = '';
    $nb_sous_dossiers = 0;
    #en cas de retour à la racine on retire le trailing slash
    if ($chemin == '//') {
      $chemin = '/';
    }

    foreach ($listefichiers as $ligne) {

      global $partages;

      $type = $this->infos_fichier($data, $chemin, $ligne);

      //TYPE DOSSIER
      if ($type[0] == 'dir' || $type[0] == 'link') {
        #différentes conditions pour le type $dossier
        switch ($ligne) {
          case '..':
            //rien
            break;

          case '.':
            //rien
            break;

          default:

            //clean les url
            $ligneurl = urlencode($ligne);
            $cheminurl = urlencode($chemin);


            //calcul du nombre de sous dossiers
            $nb_sous_dossiers = $this->nb_sous_dossiers($data . $chemin . $ligne);
            //calcul du nombre de Photos
            $nb_photos = $this->detect_photos(rtrim($data, '/') . $chemin . $ligne);

            $items .= '<li class="list-group-item">';
            $items .= '<div class=" row justify-content-between">'; //ligne
            $items .= '<div class="col-md-6">'; //colonne 4
            $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="?page=dossiers&chemin=' . $cheminurl . $ligneurl . '/">' . $ligne . '</a>';
            if ($partages->nb_partages($chemin . $ligne) >= 1) {
              $badge_color = "badge-success";
            } else {
              $badge_color = "badge-warning";
            }
            $items .= '</div>'; //fin colonne gauche

            $items .= '<div class="col-md-6"  style="text-align:right">'; //colonne droite

            //bouton de partage des photos
            if ($nb_photos >= 1) {
              //$items .= '<a class="btn btn-sm btn-primary" href="?page=admin_dl_photos&dl_photos='.$chemin.$ligne.'">Télécharger <i class="fas fa-download"></i></a>';
              $items .= '<button type="button" class="btn btn-success btn-sm clickpartage"
            data-typepartage="photos"
            data-chemin="' . $chemin . $ligne . '"
            data-retour="' . $chemin . '"
            data-toggle="modal"
            data-target="#partageModal">
            <i class="fas fa-camera"></i>
            &nbsp;Partager&nbsp;&nbsp;
            <span class="badge ' . $badge_color . '">' . $partages->nb_partages($chemin . $ligne) . '</span>
            </button>';
            }

            //bouton de partage des dossiers zip
            if ($nb_sous_dossiers <= 4 && $params['partage_dossier'] == true) {

              $items .= '<button type="button" class="btn btn-danger btn-sm  clickpartage"
            data-typepartage="dossier"
            data-chemin="' . $chemin . $ligne . '"
            data-retour="' . $chemin . '"
            data-toggle="modal"
            data-target="#partageModal">
            <i class="fas fa-folder-plus"></i>
            &nbsp;Partager&nbsp;&nbsp;
            <span class="badge ' . $badge_color . '">' . $partages->nb_partages($chemin . $ligne) . '</span>
            </button>';
            }

            $items .= '</div>'; //col droite
            $items .= '</div>'; //row
            $items .= '</li>';
            break;
        }
      } //fin type dossier
      elseif ($type[1] == 'mp4' || $type[1] == 'MP4' || $type[1] == 'mkv' || $type[1] == 'MKV' || $type[1] == 'avi' || $type[1] == 'AVI') {

        //type VIDEO

        //clean les url
        $ligneurl = urlencode($ligne);
        $cheminurl = urlencode($chemin);
        //echo $chemin.$ligne.'<br>';
        //si partage vidéo
        $items .= '<li class="list-group-item">';
        $items .= '<div class="row justify-content-between">'; //ligne
        //colonne gauche
        $items .= '<div class="col-md-6">';
        $items .= '<i class="fas fa-video"></i>&nbsp;<a href="?page=video&video=' . $cheminurl . $ligneurl . '">' . $ligne . '</a>';
        if ($partages->nb_partages($chemin . $ligne) >= 1) {
          $badge_color = "badge-success";
        } else {
          $badge_color = "badge-warning";
        }
        $items .= '</div>';

        //colonne droite
        $items .= '<div class="col-md-6" style="text-align:right">';

        $items .= '<button type="button" class="btn btn-primary btn-sm  clickpartage"
        data-typepartage="video"
        data-chemin="' . $chemin . $ligne . '"
        data-retour="' . $chemin . '"
        data-toggle="modal"
        data-target="#partageModal">
        <i class="fas fa-video"></i>
        &nbsp;Partager&nbsp;&nbsp;
        <span class="badge ' . $badge_color . '">' . $partages->nb_partages($chemin . $ligne) . '</span>
        </button>';
        $items .= '</div>';
        $items .= '</div>';
        $items .= '</li>';
      } elseif ($type[1] == 'jpg' || $type[1] == 'JPG') {
        $compteur_images++; //si photo on compte mais on affiche pas
      } elseif ($ligne != '.DS_Store' && $ligne != '._.DS_Store' && $ligne != 'Thumbs.db') {
        //autre fichier
        $items .= '<li class="list-group-item">';
        $items .= '<div class="row justify-content-between">'; //ligne
        $items .= '<div class="col-md-6">'; //colonne droite
        $items .= '<i class="fas fa-file"></i>&nbsp;' . $ligne;
        $items .= '&nbsp;<a href="./data' . $chemin . $ligne . '">‌‌<i class="fas fa-file-download"></i></a>';
        $items .= '</div>';
        $items .= '</div>';
        $items .= '</li>';
      }
    } // for each (on a fini d'itérer les fichiers contenu dans le chemin en cours)


    if ($compteur_images > 2 && $nb_sous_dossiers == 0) { //mode dossier photos
      $retour .= '<h3> Photos </h3>';
      $retour .= 'Il y a <strong>&nbsp;' . $compteur_images . '</strong>&nbsp;photos dans ce dossier&nbsp;<a class="btn btn-sm btn-primary" href="?page=admin_dl_photos&dl_photos=' . $chemin . '">Télécharger <i class="fas fa-download"></i></a>';
      $retour .= '<div style="margin-top: 50px;" class="d-flex justify-content-start"><p>Voici un apercu de vos photo: </p></div>';
      $retour .= '<div class="d-flex justify-content-center">';    
      $retour .= '<div class="slider-photo" style="width: 75%; heigth:75%;>';

      foreach($listefichiers as $ligne) {
        $url = "/data" . $chemin . $ligne;
        $retour .= '<img class="img-fluid" data-lazy="' .$url .'">';
      }

      $retour .= "</div>";
      $retour .= "</div>";

    }

    //rendu de la liste
    $retour .= '<ul class="list-group list-group-flush">';
    $retour .= $items;
    $retour .= '</ul>';
    return $retour;
  } //fin affiche contenu


  function diapo_photos($liste)
  {

    global $data;
    global $chemin;
    $retour = '';
    $compteur_images = 0;
    #en cas de retour à la racine on retire le trailing slash

    foreach ($liste as $ligne) {

      $type = $this->infos_fichier($data, $chemin, $ligne);

      if ($type[0] != 'dir' && $type[0] != 'link') {
        #conditions d'affichage
        #si image
        if ($type[1] == 'jpg' || $type[1] == 'JPG') {
          $retour .= '<img class="owl-lazy" data-src="./data' . $chemin . $ligne . '" style="max-width: 100%;">';
          $compteur_images++;
        }
      }
    }
    if ($compteur_images > 1) {
      $retour .= 'Il y a ' . $compteur_images . ' photos';
    }
    return $retour;
  }

  function breadcrumb($chemin)
  {
    global $data;
    $lien = '';
    $retour = '<nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center">
    <ol class="breadcrumb">';

    $bread = trim($chemin, '/');
    $bread = explode('/', $bread);

    $retour .= '<li class="breadcrumb-item"><a href="?page=dossiers&chemin=/">Racine</a></li>';

    foreach ($bread as $ligne) {
      $lien  .= '/' . $ligne;
      $retour .= '<li class="breadcrumb-item"><a href="?page=dossiers&chemin=' . $lien . '/">' . $ligne . '</a></li>';
    }

    $retour .= '</ol>';

    if ($chemin != '/') {
      //précédent, suivant
      $retour .= '<div class="text-right">';
      $liste_up = scandir($data . $chemin . '/../');
      array_shift($liste_up); //retrait .
      array_shift($liste_up); //retrait ..

      //place de notre dossier dans la liste du parent
      $i = array_search($ligne, $liste_up); //le dernier = actuel
      //précédent
      if ($i >= 1) {
        $precedent = str_replace($ligne, '', $lien) . $liste_up[$i - 1];
        $retour .= '<a href="?page=dossiers&chemin=' . urlencode($precedent) . '/" class="btn btn-secondary"><-</a> ';
      }
      //suivant
      if (isset($liste_up[$i + 1])) {
        $suivant = str_replace($ligne, '', $lien) . $liste_up[$i + 1];
        $retour .= '<a href="?page=dossiers&chemin=' . urlencode($suivant) . '/" class="btn btn-secondary">-></a>';
      }
      $retour .= '</div>';
    }


    $retour .= '</nav>';
    return $retour;
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
}
