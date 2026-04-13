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
    global $partage;

    $retour = '';
    $compteur_images = 0;
    $items = '';
    $nb_sous_dossiers_total = 0;
    $id_btn_tag = 1;

    // Nettoyage et sécurité du chemin
    if ($chemin == '//' || $chemin == '') {
      $chemin = '';
    } else {
      // On s'assure que le chemin finit par un slash s'il n'est pas vide
      $chemin = rtrim($chemin, '/') . '/';
    }

    foreach ($listefichiers as $ligne) {
      // On ignore les dossiers système et fichiers cachés
      if ($ligne == '..' || $ligne == '.' || strpos($ligne, '.') === 0) {
        continue;
      }

      $type = $this->infos_fichier($data, $chemin, $ligne);

      // --- CAS : DOSSIER (DIR) OU LIEN SYMBOLIQUE (LINK) ---
      if ($type[0] == 'dir' || $type[0] == 'link') {

        $nb_sous_dossiers = $this->nb_sous_dossiers($data . $chemin . $ligne);
        $nb_photos = $this->detect_photos($data . $chemin . $ligne);
        $nb_partages_count = $partage->nb_partages($chemin . $ligne);

        // Couleur du badge de partage
        $badge_color = ($nb_partages_count >= 1) ? "text-bg-success" : "text-bg-warning";

        $items .= '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-bottom">';

        // GAUCHE : Icône + Lien + Tags
        $items .= '<div class="d-flex align-items-center flex-grow-1 overflow-hidden">';
        $items .= '<i class="fas fa-folder text-warning fa-lg me-3"></i>';
        $items .= '<div class="text-truncate">';
        $items .= '<a href="/admin/dossiers/' . $chemin . $ligne . '/" class="text-decoration-none text-dark fw-bold h6 mb-0">' . $ligne . '</a>';

        // Affichage des tags (en dessous ou à côté sur mobile)
        $items .= '<div class="d-flex align-items-center mt-1">';
        $items .= '<button type="button" class="btn btn-outline-secondary btn-sm me-2 py-0 px-1 clicktag" style="font-size:10px;" data-id_btn_tag="' . $id_btn_tag . '" data-nom_dossier="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-type="fichier" data-bs-toggle="modal" data-bs-target="#tagModal">#</button>';
        $items .= '<small id="id_small_tag_' . $id_btn_tag . '" class="text-muted label_tag" data-chemin="' . $chemin . $ligne . '">';
        foreach ($tag->get_tag_from_chemin($chemin . $ligne) as $tags) {
          $items .= '<span class="badge border text-dark fw-normal me-1" style="font-size:11px;">' . htmlspecialchars($tags['nom_tag']) . '</span>';
        }
        $items .= '</small></div></div></div>';

        // DROITE : Boutons d'action
        $items .= '<div class="ms-3 d-flex gap-2">';

        if ($nb_photos >= 2) {
          // Dossier Photo détecté
          $items .= '<button type="button" class="btn btn-sm btn-success rounded-pill px-3 clickpartage" data-typepartage="photos" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-bs-toggle="modal" data-bs-target="#partageModal">';
          $items .= '<i class="fas fa-camera me-1"></i> Partager <span class="badge rounded-pill bg-white text-dark ms-1">' . $nb_partages_count . '</span>';
          $items .= '</button>';
        } else {
          // Dossier Rush ou Standard
          $items .= '<div class="btn-group">';
          if (strtolower($ligne) == "rush" || strtolower($ligne) == "rushs") {
           
            $items .= '<a href="/admin/captures/' . $chemin . $ligne . '" class="btn btn-sm btn-outline-secondary" title="Captures"><i class="fa-solid fa-images"></i></a>';
          }
          $items .= '<button type="button" class="btn btn-sm btn-danger px-3 clickpartage" data-typepartage="rushs" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-bs-toggle="modal" data-bs-target="#partageModal">';
          $items .= '<i class="fas fa-share-nodes me-1"></i> Partager <span class="badge rounded-pill bg-white text-dark ms-1">' . $nb_partages_count . '</span>';
          $items .= '</button>';
          $items .= '</div>';
        }
        $items .= '</div>';
        $items .= '</li>';

        $id_btn_tag++;
      }

      // --- CAS : VIDÉO (MP4, MKV, AVI) ---
      elseif (in_array(strtolower($type[1] ?? ''), ['mp4', 'mkv', 'avi'])) {
        $nb_partages_count = $partage->nb_partages($chemin . $ligne);

        $items .= '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3 border-bottom">';
        $items .= '<div class="d-flex align-items-center flex-grow-1 overflow-hidden">';
        $items .= '<i class="fas fa-play-circle text-primary fa-lg me-3"></i>';
        $items .= '<div class="text-truncate">';
        $items .= '<a href="/admin/video/' . $chemin . $ligne . '" class="text-decoration-none text-dark fw-bold h6 mb-0">' . $ligne . '</a>';
        $items .= '<div class="mt-1">';
        $items .= '<button type="button" class="btn btn-outline-secondary btn-sm me-2 py-0 px-1 clicktag" style="font-size:10px;" data-id_btn_tag="' . $id_btn_tag . '" data-nom_dossier="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-type="fichier" data-bs-toggle="modal" data-bs-target="#tagModal">#</button>';
        $items .= '<small id="id_small_tag_' . $id_btn_tag . '" class="text-muted">';
        foreach ($tag->get_tag_from_chemin($chemin . $ligne) as $tags) {
          $items .= '<span class="badge border text-dark fw-normal me-1">' . htmlspecialchars($tags['nom_tag']) . '</span>';
        }
        $items .= '</small></div></div></div>';

        $items .= '<button type="button" class="btn btn-sm btn-primary rounded-pill px-3 clickpartage" data-typepartage="video" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-bs-toggle="modal" data-bs-target="#partageModal">';
        $items .= '<i class="fas fa-video me-1"></i> Partager <span class="badge rounded-pill bg-white text-dark ms-1">' . $nb_partages_count . '</span>';
        $items .= '</button>';

        $items .= '</li>';
        $id_btn_tag++;
      }

      // --- CAS : COMPTEUR PHOTOS (Pour déclencher la galerie) ---
      elseif (isset($type[1]) && strtolower($type[1]) == 'jpg') {
        $compteur_images++;
      }
    }

    // --- CONSTRUCTION DU RETOUR ---

    // 1. Liste des fichiers/dossiers
    if ($items != '') {
      $retour .= '<div class="bg-white rounded-4 shadow-sm border overflow-hidden">';
      $retour .= '<ul class="list-group list-group-flush">';
      $retour .= $items;
      $retour .= '</ul></div>';
    }

    // 2. Si c'est un dossier de photos (Album), on affiche un appel à l'action élégant
    if ($compteur_images > 2) {
      $retour .= '<div class="mt-4 p-4 text-center bg-dark text-white rounded-4 shadow-lg">';
      $retour .= '<i class="fas fa-images fa-3x mb-3 text-warning"></i>';
      $retour .= '<h4>Cet emplacement contient ' . $compteur_images . ' photos</h4>';
      $retour .= '<p class="text-secondary">Vous pouvez visionner l\'album complet en mode galerie.</p>';
      $retour .= '<a href="/admin/photos/' . rtrim($chemin, '/') . '" class="btn btn-warning fw-bold px-4 py-2 mt-2">';
      $retour .= '<i class="fas fa-eye me-2"></i> Visionner l\'album';
      $retour .= '</a></div>';
    }

    return $retour;
  }
}
