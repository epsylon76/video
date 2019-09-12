<?php echo $params['analytics']; //analytics seulement sur la vue client ?>

<div class="container">

  <h1>Vos Photos</h1>

  <p>Vos photos vont être rassemblées dans un dossier zip et le Téléchargement commencera</p>
  <p><strong>Date</strong> : <?php echo date('d/m/Y', $date); ?></p>
  <p><strong>Nombre de photos</strong> : <?php echo $nb; ?> </p>
  <p><strong>Taille</strong> : <?php echo number_format($taille / 1048576, 2); ?> Mo</p>

    <div class="text-center" style="margin-top:50px; margin-bottom:50px;">
      <a class="btn btn-primary btn-lg" id="dl_button" href="?cle=<?php echo $_GET['cle'] ?>&dl_photos=<?php echo $_GET['id'];?>">
        <i class="fas fa-download"></i> Télécharger toutes les photos
      </a>
    </div>

    <?php  if(isset($_GET['id'])){ ?>
    <a class="btn btn-success" href="?cle=<?php echo $_GET['cle'] ?>"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>
    <?php } ?>

</div> <!--container -->

<style>
body{
  background-color:white!important;
}
</style>
