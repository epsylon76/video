
<div class="container">
  <h1>Statistiques</h1>
  <div class="row">

    <div class="col">
      Taille du dossier ZIP : <?php echo $taille.' Mo'; ?>
    </div>

    <div class="col">
      <div class="progress">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"  style="width: <?php echo $percent; ?>%" aria-valuenow="<?php echo $taille; ?>" aria-valuemin="0" aria-valuemax="100000"><?php echo floor($percent).' %'; ?></div>
      </div>
    </div>


  </div>


  <div class="row">

    <div class="col">
      Nombre partages "Prévue" : <?php echo $npstat['prevues']; ?><br>
      Nombre partages "NP jour même" : <?php echo $npstat['npjour']; ?><br>
      Nombre partages "NP Post-jour" : <?php echo $npstat['nppost']; ?><br>
      Nombre de téléchargements en 24h : <?php echo $clics; ?><br>
    </div>

  </div>

  <br>

  <?php
  if($introuvable){
    echo '<h5>Partages introuvables</h5>';
    foreach($introuvable as $ligne){
      ?>

      <div class="row">
        <div class="col">
          <?php echo $ligne['id']; ?>
          &nbsp;
          <?php echo $ligne['chemin']; ?>
          &nbsp;
          <a href="?page=unset_partage&id=<?php echo $ligne['id']; ?>&retour=stats"><i class="fas fa-trash-alt" style="color:red;"></i></a>
        </div>
      </div>

      <?php
    }
  }
  ?>





</div> <!-- container -->
