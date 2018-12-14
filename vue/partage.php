<div class="container">
  <img src="./vue/img/logo.png" id="logo"/>
  <div class="row">
    <div class="col-sm">
    <h1>Votre Espace Vidéo et Photos</h1><br/>
    <p>Nous éspérons que vous avez passé un bon moment avec nous</p>
    <p>En cas de réclamation, veuillez envoyer un mail à videoabeilleparachutisme@gmail.com</p>
  </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <h3>Liste des partages</h3>
      <?php
      $i=1;
      foreach($liste as $ligne){

        echo '<div class="alert alert-secondary">';

        echo '<a href=?cle='.$_GET['cle'].'&id='.$ligne['id'].'><strong>'.$i.' - </strong>';

        if($ligne['type_partage'] == "video"){$icone = '<i class="fas fa-video"></i>&nbsp;';}
        elseif($ligne['type_partage'] == "photos"){$icone = '<i class="fas fa-camera"></i>&nbsp;';}
        elseif($ligne['type_partage'] == "dossier"){$icone = '<i class="fas fa-file-archive"></i>&nbsp;';}

        echo $icone;

        echo basename($ligne['chemin']).'</a>';
        echo '</div>';
        $i++;
        }

       ?>
    </div>

  </div>
</div>
