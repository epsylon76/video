
<div class="container">
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
        echo '<a href=/?cle='.$_GET['cle'].'&id='.$ligne['id'].'>'.basename($ligne['chemin']).'</a>';
        echo '<br>';
        }

       ?>
    </div>

  </div>
</div>
