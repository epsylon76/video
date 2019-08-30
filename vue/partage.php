<div style="width: 100%; height: 30vw;"
data-vide-bg="vue/img/video" data-vide-options="loop: true, muted: true, position: 0% 50%">
<h1 style="text-align:center; text-transform:uppercase; color:white; font-size:4vw; font-weight:800; margin-top:0; padding-top:13vw">votre espace vidéo et photos</h1>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="row" style="margin-top:20px;">

        <div class="col">

          <div class=" alert alert-secondary">
            <div class="row">
              <div class="col-sm-2">
                <img src="vue/img/logo.png" style="width:100px; height:100px">
              </div>
              <div class="col-sm-10">
                <h3>Votre Espace Vidéo et Photos</h3><br/>
                <p>Nous éspérons que vous avez passé un bon moment avec nous</p>
                <p>En cas de réclamation, veuillez envoyer un mail à videoabeilleparachutisme@gmail.com</p>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-sm">
          <h3>Liste des partages</h3>
          <?php

          foreach($liste as $ligne){

            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<a href=?cle='.$_GET['cle'].'&id='.$ligne['id'].'>';

            if($ligne['type_partage'] == "video"){$icone = '<i class="fas fa-video icone_ligne"></i>&nbsp;';}
            elseif($ligne['type_partage'] == "photos"){$icone = '<i class="fas fa-camera icone_ligne"></i>&nbsp;';}
            elseif($ligne['type_partage'] == "dossier"){$icone = '<i class="fas fa-file-archive icone_ligne"></i>&nbsp;';}

            echo $icone;

            echo basename($ligne['chemin']);


            echo '</div>'; //fin col 6

            echo '<div class="col-md-6 pull-right"><i class="fa fa-download icone_dl" aria-hidden="true"></i></div></a>';

            echo '</div>'; //fin row

          }

          ?>
        </div>

      </div>
    </div>
    <div class="col-md-4" style="margin-top:20px;">
      <h4>Partagez votre expérience</h4>
    </div>
  </div>
</div>


<style>
body{
  background-color:white!important;
}
.icone_ligne {
  margin:5px;
  display: inline-block;
  border-radius: 50px;
  background-color: <?php echo $params['couleur_fond']; ?>;
  box-shadow: 0px 0px 2px #888;
  padding: 0.5em 0.6em;
  color:black!important;
}
.icone_dl {
  margin:5px;
  display: inline-block;
  border-radius: 50px;
  background-color: lightgrey;
  box-shadow: 0px 0px 2px #888;
  padding: 0.5em 0.6em;
  color:black!important;
}
</style>

<script src="./includes/js/jquery.vide.min.js"></script>
