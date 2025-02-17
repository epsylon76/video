<div class="container">
  <h1>Statistiques</h1>

  <div class="row">
    <div class="col-3">
      Espace libre dossier Zip : <?php echo $free; ?>
    </div>

    <div class="col-5">
      <div class="progress" style="border:1px solid black;">
        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $percent; ?>%;"><?php echo floor($percent) . ' %'; ?></div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col">
      Taille du Contenu Zip : <?php echo $zipfoldersize; ?>
    </div>
    <div class="col">

    <a class="btn btn-danger" href="/actions/supprZip/">Vider le dossier Zip</a>

    </div>
  </div>


  <div class="row">

    <div class="col">
      <h4>Téléchargements</h4>
      Nombre de téléchargements en 24h : <?php echo $clics; ?><br>
      Nombre de téléchargements Total : <?php echo $clics_total; ?><br>
    </div>

  </div>

  <br>
  <a class="btn btn-primary" href="/admin/stats/introuvables/">Partages introuvables</a>

  <?php include('./ctrl/bande_passante.php')?>
 





</div> <!-- container -->