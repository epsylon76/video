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
      foreach($liste as $ligne){

        if($ligne['type_partage'] == "video"){
          //icone vidéo
          echo '<i class="fas fa-video"></i>&nbsp;&nbsp;';
        }elseif($ligne['type_partage'] == "photos"){
          //icone photos
          echo '<i class="fas fa-camera"></i>&nbsp;&nbsp;';
        }elseif($ligne['type_partage'] == "dossier"){
          //icone dossier zip
          echo '<i class="fas fa-file-archive"></i>&nbsp;&nbsp;';
        }


        echo '<a href='.$domain_url.'?cle='.$_GET['cle'].'&id='.$ligne['id'].'>'.basename($ligne['chemin']).'</a>';
        echo '<br>';
        }

       ?>
    </div>

  </div>
</div>
