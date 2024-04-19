<?php echo $params['analytics']; //analytics seulement sur la vue client 

?>


<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<div style="width: 100%; height: 22vw;" data-vide-bg="vue/img/banniere" data-vide-options="loop: true, muted: true, position: 0% 50%">
  <h1 style="text-align:center; text-transform:uppercase; color:white; font-size:4vw; font-weight:800; margin-top:0; padding-top:8vw">votre espace vidéo et photos</h1>
</div>

<div class="container">
  <div class="row justify-content-between">
    <div class="col-md-6">


      <div class="row" style="padding-top:20px;">
        <div class="col-sm">
        <div class="row">
          <p>Tout est içi : regardez, partagez et revivez ce moment avec vos proches !</p>
        </div>
          <div class="row">
            <h3>Liste des partages</h3>
            <div style="margin-top:4px; margin-left:20px" class="fb-share-button" data-href="<?php echo $url_domaine.'/?cle='.$_GET['cle']; ?>" data-layout="button_count">
            </div>
          </div>
          <?php

          foreach ($liste as $ligne) {

            echo '<div class="row" style="display: flex;  justify-content: space-between;">';
            echo '<span style="overflow:hidden">';
            echo '<a href=/cle/' . $uri[1] . '/' . $ligne['id'] . '>';

            if ($ligne['type_partage'] == "video") {
              $icone = '<i class="fas fa-video icone_ligne"></i>&nbsp;';
            } elseif ($ligne['type_partage'] == "photos") {
              $icone = '<i class="fas fa-camera icone_ligne"></i>&nbsp;';
            } elseif ($ligne['type_partage'] == "dossier") {
              $icone = '<i class="fas fa-file-archive icone_ligne"></i>&nbsp;';
            }

            echo $icone;

            echo basename($ligne['chemin']);


            echo '</span>';

            echo '<span><i class="fa fa-download icone_dl" aria-hidden="true"></i></div></a>';

            echo '</span>';
          }
          ?>

        </div>

      </div>

      <div class="row" style="margin-top:20px;">
        <div class=" alert alert-secondary">
          <div class="row">
            <div class="col-sm-3">
              <img src="vue/img/logo.png" style="width:100px; height:100px">
            </div>
            <div class="col-sm-9">
              <?php echo $params['texte_espace']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>






    <div class="col-md-4" style="margin-top:20px;">
      <h4>Rejoignez nous sur les réseaux !</h4>
      <?php if ($params['partage_fb'] != '') {
        echo '<a href="' . $params['partage_fb'] . '" class="icone_partage"><i class="fab fa-facebook-square"></i></a>';
      }
      if ($params['partage_twitter'] != '') {
        echo '<a href="' . $params['partage_twitter'] . '" class="icone_partage"><i class="fab fa-twitter-square"></i></a>';
      }
      ?>
      <h4 style="text-transform:uppercase"><?php echo $params['titre_invitation']; ?></h4>
      <a href="https://<?php echo $params['url_invitation']; ?>"><img src="vue/img/invitation.jpg" style="max-width:300px;"></a>
    </div>
  </div>
</div>


<style>
  body {
    background-color: white !important;
  }

  .icone_ligne {
    margin: 5px;
    display: inline-block;
    border-radius: 50px;
    background-color: <?php echo $params['couleur_fond']; ?>;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
    color: black !important;
  }

  .icone_dl {
    margin: 5px;
    display: inline-block;
    border-radius: 50px;
    background-color: lightgrey;
    box-shadow: 0px 0px 2px #888;
    padding: 0.5em 0.6em;
    color: black !important;
  }
</style>

<script src="./includes/js/jquery.vide.min.js"></script>