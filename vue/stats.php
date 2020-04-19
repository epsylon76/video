<div class="container">
  <h1>Statistiques</h1>

  <div class="row">
    <div class="col">
      Espace libre sur le serveur : <?php echo $free; ?>
    </div>
  </div>
<?php
foreach($freedata as $undata){
  ?>
  <div class="row">
    <div class="col">
      Espace libre sur <?php echo $undata['nom'];?> : <?php echo $undata['free']; ?>
    </div>
  </div>
<?php } ?>
  <div class="row">

    <div class="col">
      Taille du dossier ZIP : <?php echo $taille.' Go'; ?> , limite : <?php echo $limite;?> Go
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
      Nombre de téléchargements Total : <?php echo $clics_total; ?><br>
    </div>

  </div>

  <br>
  <a class="btn btn-primary" href="?page=introuvables">Partages introuvables</a>






</div> <!-- container -->
