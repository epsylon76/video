<div class="container">

  <h1>Dossier compréssé</h1>
  <p>Téléchargement d'un dossier compréssé</p>
  <h4>Selon la taille, le téléchargement peut prendre un certain temps</h4>
  <?php  if(isset($_GET['id'])){ ?>
  <a class="btn btn-success" href="?cle=<?php echo $_GET['cle'] ?>"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>
  <?php } ?>

  <?php
  if(isset($_GET['id'])){
    ?>
    <div class="text-center" style="margin-top:50px; margin-bottom:50px;">
      <a class="btn btn-primary btn-lg ld-ext-right" id="dl_button" href="?cle=<?php echo $_GET['cle'] ?>&dl_dossier=<?php echo $_GET['id'];?>">
        <i class="fas fa-download"></i> Télécharger le dossier
        <div class="ld ld-ring ld-spin"></div>
      </a>
    </div>
    <?php
  }
  ?>

</div> <!--container -->

<script>
  $("#dl_button").click(function(){
    $("#dl_button").addClass("running");
  });
</script>
