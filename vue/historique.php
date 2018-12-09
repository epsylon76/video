<div class="container">
  <h3>Tableau historique</h3>
  <p> historique sur 500 évènements</p>


  <ul>
    <?php
    foreach ($liste_historique as $ligne) {
      //couleur
      if($ligne['action'] == "dl"){$couleur = "alert-primary"; $icone= '<i class="fas fa-download"></i>';}
      if($ligne['action'] == "set_partage"){$couleur = "alert-success"; $icone = '<i class="fas fa-share-alt"></i>';}
      if($ligne['action'] == "unset_partage"){$couleur = "alert-danger"; $icone = '<i class="fas fa-trash"></i>';}
      if($ligne['action'] == "login_admin"){$couleur = "alert-warning"; $icone = '<i class="fas fa-sign-in-alt"></i>';}


      echo '<div class="alert '.$couleur.'" role="alert">';

      $date= new DateTime($ligne['date']);
      $date_aff = $date->format('d/m/Y H:i');

      echo $icone;
      echo '&nbsp;';
      echo $date_aff;
      echo ' | ';
      echo $ligne['partage_chemin'];
      echo ' | ';
      echo $ligne['email'];
      echo ' | ';
      echo $ligne['admin_login'];

      echo '</div>';
    }
    ?>

  </ul>
</div>
