<?php
if (!isset($_SESSION['login'])) {
  echo $params['analytics']; //analytics seulement sur la vue client 
}
?>

<link href="/includes/css/photos.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/includes/js/slick/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="/includes/js/slick/slick.css" />
<script type="text/javascript" src="/includes/js/slick/slick.min.js"></script>


<!-- si c'est un client ajouter la div  sinon l'enlever -->
<?php if ($mode == 'client') {
  echo '<div class="container">';
}
?>

<h1 style="margin-top: 10px;  display:flex; justify-content:center; font-size:2rem;">Vos Photos</h1>

<div class="text-center">

  <div class="d-flex justify-content-center">
    <div data-chemin="<?php echo $chemin?>" data-data="<?php echo $data ?>" class="slider-photo" style="width: 75%;">

      <?php

      $folder = $partage->get_partage($uri[2]);

      // $chemin = $folder['chemin'];

      $listefichiers = $dossier->contenu_dossier($chemin, $data);

      foreach ($listefichiers as $ligne) {
        $url = "/data/" . $chemin . "/" . $ligne;
        echo '<img class="img-fluid" data-lazy="' . $url . '">';
      }

      ?>

    </div>
  </div>

  <?php if ($mode == 'client') {
    echo '</div>';
  }
  ?>

  <div style="margin-top: 20px;">


    <div>
      <p><strong>Nombre de photos</strong> : <?php echo $nb; ?> </p>
      <p><strong>Taille</strong> : <?php echo number_format($taille / 1048576, 2); ?> Mo</p>

      <div style="display: flex; justify-content:center;">

        <?php
        if ($mode == 'client') {
        ?>
          <a class="btn btn-primary" style="font-size:14;" id="bouton-dl" data-taille="<?php echo $taille ?>" data-chemin="<?php echo $chemin; ?>" data-email="<?php echo $email; ?>" data-action="dl_photos" href="/cle/<?php echo $uri[1] ?>/<?php echo $id_partage; ?>/dl/<?php echo $taille?>">
            <i class="fas fa-download"></i> Télécharger toutes les photos
          </a>
        <?php
        } else { // mode admin
        ?>
          <a class="btn btn-primary" style="font-size:14;" href="/actions/dlPhotos/<?php echo $chemin; ?>">
            <i class="fas fa-download"></i> Télécharger toutes les photos
          </a>
        <?php
        }
        ?>
      </div>
      <div style="display: flex; justify-content:center;">
        <small>Vos photos vont être rassemblées dans un dossier zip et le Téléchargement commencera</small>
      </div>
    </div>

  </div>

  <div>
    <?php if (isset($uri[1])) {
      if ($mode == 'client') {
        echo '<a class="btn btn-success" href="/cle/' . $uri[1] . '" style="margin-top:20px;"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>';
      } else {

        $slice = array_slice($uri, 0, count($uri) - 1);

        $url = '';
        foreach ($slice as $u) {
          $url .= $u . '/';
        }
    ?>
        <div style="display:flex;justify-content:flex-start; width:79.16px;">
          <a class="btn btn-success" href="/<?php echo $url; ?>" style="margin-top:20px;">
            <i class="fas fa-arrow-left">&nbsp;</i>retour
          </a>
        </div>
    <?php
      }
    } ?>


  </div>


</div> <!--container -->



<script>
  $("#bouton-dl").click(function() {
    $('#bouton-dl').removeClass('btn-success');
    $('#bouton-dl').addClass('btn-warning');
    $('#bouton-dl').text('Création du fichier...');
  })



  $('.slider-photo').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    dots: false,
    speed: 400,

  });
</script>