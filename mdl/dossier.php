<?php

class dossier
{

  function contenu_dossier($chemin, $data)
  {
    $listefichiers = preg_grep('/^([^.])/', scandir($data . $chemin)); //exclut les fichiers commençant par un point
    $listefichiers = array_diff($listefichiers, ['Thumbs.db']); //retirer Thumbs.db
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
    global $uri;
    global $dossier;
    global $tag;

    $retour = '';
    $compteur_images = 0;
    $items = '';
    $nb_sous_dossiers = 0;
    $id_btn_tag = 1; //identifiant bouton de tag
    #en cas de retour à la racine on retire le trailing slash
    if ($chemin == '//') {
      $chemin = '/';
    }

    foreach ($listefichiers as $ligne) {

      global $partage;

      $type = $this->infos_fichier($data, $chemin, $ligne);

      //
      //TYPE DOSSIER
      //

      if ($type[0] == 'dir' || $type[0] == 'link') {
        #différentes conditions pour le type $dossier
        if ($ligne != '..' && $ligne != '.') {
          //calcul du nombre de sous dossiers
          $nb_sous_dossiers = $this->nb_sous_dossiers($data . $chemin . $ligne);
          //calcul du nombre de Photos
          $nb_photos = $this->detect_photos($data . $chemin . $ligne);

          if ($nb_photos >= 2) { //dossier de photos

            $items .= '<li class="list-group-item">';
            $items .= '<div class="d-flex justify-content-between">'; //ligne justifiée

            $items .= '<div class="col-6">'; //une div pour la justification
            $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="/admin/dossiers/' . $chemin . $ligne . '/">' . $ligne . '</a>';
            $items .= '<button type="button" style="margin-left: 10px; font-size:10px;" class="btn btn-light btn-sm clicktag" data-id_btn_tag="' . $id_btn_tag . '" data-nom_dossier="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-type="fichier" data-toggle="modal" data-target="#tagModal">#</button>';

            // Label pour afficher les tags
            $items .= '<label for="text" style="margin-left: 10px;" data-space="non" data-chemin="' . $chemin . $ligne . '" class="col-form-label label_tag" ><small id="id_small_tag_' . $id_btn_tag . '">';
            foreach ($tag->get_tag_from_chemin($chemin . $ligne) as $tags) {
              $items .= $tags['nom_tag'] . ' ';
            }
            $items .= '</small></label>';

            $items .= '</div>';


            if ($partage->nb_partages($chemin . $ligne) >= 1) {
              $badge_color = "badge-success";
            } else {
              $badge_color = "badge-warning";
            }

            //bouton de partage des photos

            $items .= '<button type="button" class="btn btn-success btn-sm clickpartage" data-typepartage="photos" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-toggle="modal" data-target="#partageModal" >
                <i class="fas fa-camera"></i>
                &nbsp;Partager&nbsp;&nbsp;
                <span class="badge ' . $badge_color . '">' . $partage->nb_partages($chemin . $ligne) . '</span>
                </button>';

            $id_btn_tag++;
          } else { //juste un dossier

            $items .= '<li class="list-group-item">';
            $items .= '<div class="d-flex justify-content-between">'; //ligne justifiée

            $items .= '<div class="col-6">'; //une div pour la justification
            $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="/admin/dossiers/' . $chemin . $ligne . '/">' . $ligne . '</a>';
            $items .= '<button type="button" style="margin-left: 10px; font-size:10px;" class="btn btn-light btn-sm clicktag" data-id_btn_tag="' . $id_btn_tag . '"  data-nom_dossier="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-type="fichier" data-toggle="modal" data-target="#tagModal">#</button>';

            // Label pour afficher les tags
            $items .= '<label for="text" style="margin-left: 10px;" data-chemin="' . $chemin . $ligne . '" class="col-form-label label_tag"><small id="id_small_tag_' . $id_btn_tag . '">';
            foreach ($tag->get_tag_from_chemin($chemin . $ligne) as $tags) {
              $items .= $tags['nom_tag'] . ' ';
            }
            $items .= '</small></label>';


            $items .= '</div>';
            $items .= '<div>'; //une div pour la justification
            $items .= '</div>';

            if ($partage->nb_partages($chemin . $ligne) >= 1) {
              $badge_color = "badge-success";
            } else {
              $badge_color = "badge-warning";
            }

            //bouton de partage des dossiers zip
            if ($nb_sous_dossiers <= 4 && $params['partage_dossier'] == true) {
              $items .= '<button type="button" class="btn btn-danger btn-sm  clickpartage"  data-typepartage="rushs" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-toggle="modal" data-target="#partageModal">';
              $items .= '<i class="fas fa-folder-plus"></i>';
              $items .= '&nbsp;Partager&nbsp;&nbsp;';
              $items .= '<span class="badge ' . $badge_color . '">' . $partage->nb_partages($chemin . $ligne) . '</span>';
              $items .= ' </button>';
            } else { // un dossier vide ou avec autre chose. regarder s'il s'appelle "rush" ou "rushs"
              if (strtolower($ligne) == "rush" || strtolower($ligne) == "rushs") {
                $items .= '<div>';
                $items .= '<a href="/admin/captures/' . $chemin . $ligne . '" class="btn btn-sm btn-info"><i class="fa-solid fa-images"></i></a>';  //captures photos
                $items .= '&nbsp;<button type="button" class="btn btn-danger btn-sm  clickpartage"  data-typepartage="rushs" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-toggle="modal" data-target="#partageModal">';
                $items .= '<i class="fa-regular fa-window-restore"></i>';
                $items .= '&nbsp;Partager&nbsp;&nbsp;';
                $items .= ' </button>';
                $items .= '</div>';
              } else {
                $items .= '<div>'; //une div pour remplacer le vide
                $items .= '</div>';
              }
            }

            $id_btn_tag++;
          }

          $items .= '</div>'; //row
          $items .= '</li>';
        } //fin if $ligne != '..' && $ligne != '.'

      } //fin type dossier
      elseif ($type[1] == 'mp4' || $type[1] == 'MP4' || $type[1] == 'mkv' || $type[1] == 'MKV' || $type[1] == 'avi' || $type[1] == 'AVI') {

        //
        //type VIDEO
        //



        //echo $chemin.$ligne.'<br>';
        //si partage vidéo
        $items .= '<li class="list-group-item">';
        $items .= '<div class="d-flex justify-content-between">'; //ligne

        $items .= '<div class="col-6">';
        $items .= '<i class="fas fa-video"></i>&nbsp;<a href="/admin/video/' . $chemin . $ligne . '">' . $ligne . '</a>';
        $items .= '<button type="button" id="btn_tag" style="margin-left: 10px; font-size:10px;" class="btn btn-light btn-sm clicktag"  data-id_btn_tag="' . $id_btn_tag . '" data-nom_dossier="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-type="fichier" data-toggle="modal" data-target="#tagModal">#</button>';

        // Label pour afficher les tags
        $items .= '<label for="text" style="margin-left: 10px;" data-space="non" data-chemin="' . $chemin . $ligne . '" class="col-form-label label_tag"><small id="id_small_tag_' . $id_btn_tag . '">';
        foreach ($tag->get_tag_from_chemin($chemin . $ligne) as $tags) {
          $items .= $tags['nom_tag'] . ' ';
        }
        $items .= '</small></label>';

        $items .= '</div>';

        if ($partage->nb_partages($chemin . $ligne) >= 1) {
          $badge_color = "badge-success";
        } else {
          $badge_color = "badge-warning";
        }


        $items .= '<span><button type="button" class="btn btn-primary btn-sm clickpartage" data-typepartage="video" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-toggle="modal" data-target="#partageModal">
        <i class="fas fa-video"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge ' . $badge_color . '">' . $partage->nb_partages($chemin . $ligne) . '</span></button>';



        $items .= '</li>';
        $id_btn_tag++;
      } elseif ($type[1] == 'jpg' || $type[1] == 'JPG') {
        $compteur_images++; //si photo on compte mais on affiche pas
      } elseif ($ligne != '.DS_Store' && $ligne != '._.DS_Store' && $ligne != 'Thumbs.db') {
        //autre fichier
        $items .= '<li class="list-group-item">';
        $items .= '<div class="d-flex justify-content-between">'; //ligne
        $items .= '<div class="col-6">'; //colonne droite
        $items .= '<i class="fas fa-file"></i>&nbsp;' . $ligne;
        $items .= '&nbsp;<a href="/data/' . $chemin . $ligne . '">‌‌<i class="fas fa-file-download"></i></a>';
        $items .= '</div>';
        $items .= '</div>';
        $items .= '</li>';
      }
    }
    // 
    // FIN DU  "for each" (on a fini d'itérer les fichiers contenu dans le chemin en cours)
    //

    if ($compteur_images > 2 && $nb_sous_dossiers == 0) {
      //mode dossier photos, on va afficher le bouton de téléchargement et le diaporama
      include('ctrl/photos.php');
    }


    //rendu de la liste
    $retour .= '<ul class="list-group list-group-flush">';
    $retour .= $items;
    $retour .= '</ul>';
    return $retour;
  } //fin affiche contenu


}
