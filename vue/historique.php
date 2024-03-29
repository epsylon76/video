<div class="container">
  <h2>Tableau historique</h2>
  <p> historique sur 500 évènements</p>


  <ul>
    <?php
    foreach ($liste_historique as $ligne) {
      //couleur
      if($ligne['action'] == "dl_video"){$couleur = "alert-primary"; $icone= '<i class="fas fa-download">&nbsp;</i><i class="fas fa-video"></i>';}
      if($ligne['action'] == "dl_photos"){$couleur = "alert-primary"; $icone= '<i class="fas fa-download">&nbsp;</i><i class="fas fa-camera"></i>';}
      if($ligne['action'] == "dl_dossier"){$couleur = "alert-primary"; $icone= '<i class="fas fa-download">&nbsp;</i><i class="fas fa-file-archive"></i>';}
      if($ligne['action'] == "set_partage"){$couleur = "alert-success"; $icone = '<i class="fas fa-share-alt"></i>';}
      if($ligne['action'] == "unset_partage"){$couleur = "alert-danger"; $icone = '<i class="fas fa-trash"></i>';}
      if($ligne['action'] == "login_admin"){$couleur = "alert-warning"; $icone = '<i class="fas fa-sign-in-alt"></i>';}
      if($ligne['action'] == "clear_introuvables"){$couleur = "alert-warning"; $icone = '<i class="fas fa-trash"></i>'; $ligne['partage_chemin'] = 'Effacement des partages introuvables';}


      echo '<div class="alert '.$couleur.'" role="alert">';

      $date= new DateTime($ligne['date']);
      $date_aff = $date->format('d/m/Y H:i');

      echo '<strong>'.$date_aff.'</strong> - '.$icone.' - '.$ligne['partage_chemin'].' - '.$ligne['email'].' - '.$ligne['admin_login'];

      echo '</div>';
    }
    ?>

  </ul>
</div>
