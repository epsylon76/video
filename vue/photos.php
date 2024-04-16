<?php echo $params['analytics']; //analytics seulement sur la vue client 
?>

<link rel="stylesheet" type="text/css" href="./includes/js/slick/slick-theme.css"/>
<link rel="stylesheet" type="text/css" href="./includes/js/slick/slick.css"/>
<script type="text/javascript" src="./includes/js/slick/slick.min.js"></script>


<div class="container">

  <h1>Vos Photos</h1>

  <p>Vos photos vont être rassemblées dans un dossier zip et le Téléchargement commencera</p>
  <p><strong>Date</strong> : <?php echo date('d/m/Y', $date); ?></p>
  <p><strong>Nombre de photos</strong> : <?php echo $nb; ?> </p>
  <p><strong>Taille</strong> : <?php echo number_format($taille / 1048576, 2); ?> Mo</p>

  <div class="text-center" style="margin-top:50px; margin-bottom:50px;">

    <a class="btn btn-primary btn-sm d-flex justify-content-start" style="font-size: 16px;"id="dl_button" href="?cle=<?php echo $_GET['cle'] ?>&dl_photos=<?php echo $_GET['id']; ?>">
        <i class="fas fa-download"></i> Télécharger toutes les photos
    </a>

    <div style="margin-top: 50px;" class="d-flex justify-content-start"><p>Voici un apercu de vos photo: </p></div>
      <div class="d-flex justify-content-center">
        <div class="slider-photo" style="width: 75%; heigth:75%;">

          <?php 
          
            $folder = $partage->get_partage($_GET['id']);
            
            $chemin = $folder['chemin'];
            
            $listefichiers = $dossier->contenu_dossier($chemin, $data);

            foreach($listefichiers as $ligne) {

              $url = "/data" . $chemin . "/". $ligne;

              echo '<img class="img-fluid" data-lazy="' .$url .'">';
            }

          ?>
      
        </div>
      </div>
    </div> 

    <?php if (isset($_GET['id'])) { ?>
      <a class="btn btn-success" href="?cle=<?php echo $_GET['cle'] ?>"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>
    <?php } ?>

  </div>


</div> <!--container -->

<style>
  body {
    background-color: white !important;
  }
</style>

<script>
  $("#dl_button").click(function(){
    $('#dl_button').removeClass('btn-success');
    $('#dl_button').addClass('btn-warning');
    $('#dl_button').text('Création du fichier...');
  })



  $('.slider-photo').slick({
  lazyLoad: 'ondemand',
  slidesToShow: 1,
  slidesToScroll: 1,
  fade: true,
  dots: false

});
</script>
