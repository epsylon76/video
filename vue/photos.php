<?php echo $params['analytics']; //analytics seulement sur la vue client 
?>

<link href="./includes/css/photos.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./includes/js/slick/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="./includes/js/slick/slick.css" />
<script type="text/javascript" src="./includes/js/slick/slick.min.js"></script>


<div class="container">
  <h1 style="margin-top: 10px;  display:flex; justify-content:center; font-size:2rem;">Vos Photos</h1>

  <div class="text-center">


    <div class="d-flex justify-content-center">
      <div class="slider-photo" style="width: 75%; heigth:75%;">

        <?php

        $folder = $partage->get_partage($_GET['id']);

        $chemin = $folder['chemin'];

        $listefichiers = $dossier->contenu_dossier($chemin, $data);

        foreach ($listefichiers as $ligne) {

          $url = "/data" . $chemin . "/" . $ligne;

          echo '<img class="img-fluid" data-lazy="' . $url . '">';
        }

        ?>

      </div>
    </div>
  </div>


  <div style="margin-top: 20px;">


    <div>
      <p><strong>Date</strong> : <?php echo date('d/m/Y', $date); ?></p>
      <p><strong>Nombre de photos</strong> : <?php echo $nb; ?> </p>
      <p><strong>Taille</strong> : <?php echo number_format($taille / 1048576, 2); ?> Mo</p>

      <div style="display: flex; justify-content:center;">
        <a class="btn btn-primary" style="font-size:14;" id="dl_button" href="?cle=<?php echo $_GET['cle'] ?>&dl_photos=<?php echo $_GET['id']; ?>">
          <i class="fas fa-download"></i> Télécharger toutes les photos
        </a>
      </div>
      <div style="display: flex; justify-content:center;">
        <small>Vos photos vont être rassemblées dans un dossier zip et le Téléchargement commencera</small>
      </div>
    </div>

  </div>

  <div>
    <?php if (isset($_GET['id'])) { ?>
      <a class="btn btn-success" href="?cle=<?php echo $_GET['cle'] ?>" style="margin-top:20px;"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>
    <?php } ?>
  </div>

</div>


</div> <!--container -->



<script>
  $("#dl_button").click(function() {
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