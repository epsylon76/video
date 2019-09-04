<div class="container" style="margin-top:30px;">
  <h1>Paramètres</h1>


  <form action="./?page=parametres" method="post" >

    <h2 class="text-center">Core</h2>
    <h5>Dossier data</h5>
    <input type="text" name="dossier_data" size="70" value="<?php echo $params['dossier_data']; ?>"></input>

    <h5>Url site</h5>
    <input type="text" name="url_domaine" size="100" value="<?php echo $params['url_domaine']; ?>"></input>

    <hr>
    <h2 class="text-center">Design</h2>
    <h5>couleur fond</h5>
    <input type="color" name="couleur_fond" style="height:50px; width:50px; border:3px solid black; border-radius:10px;" value="<?php echo $params['couleur_fond']; ?>"></input>

    <hr>
    <h2 class="text-center">Accueil</h2>
    <h5>Titre Site</h5>
    <input type="text" name="page_titre" value="<?php echo $params['page_titre']; ?>"></input>

    <h5>Texte d'accueil</h5>
    <textarea name="accueil_texte" id="accueil_texte" ><?php echo $params['accueil_texte']; ?></textarea>

    <hr>
    <h2 class="text-center">Espace de Téléchargement</h2>

    <h5>Texte Accueil</h5>
    <textarea name="texte_espace" id="texte_espace"><?php echo $params['texte_espace']; ?></textarea>

    <h5>boutons de partage sociaux</h5>
    <p>Laisser vide pour désactiver</p>
    Facebook : <input type="text" name="partage_fb" value="<?php echo $params['partage_fb']; ?>"></input><br>
    Twitter : <input type="text" name="partage_twitter" value="<?php echo $params['partage_twitter']; ?>"></input><br>

    <h5>Titre invitation autre site</h5>
    <input type="text" name="titre_invitation" value="<?php echo $params['titre_invitation']; ?>"></input>


    <hr>
    <h2 class="text-center">Email</h2>

    <h5>Email expediteur</h5>
    <input type="text" name="email_expediteur" id="email_expediteur" value="<?php echo $params['email_expediteur']; ?>" size="50"></input>

    <h5>Objet Email</h5>
    <input type="text" name="email_sujet" id="email_sujet" value="<?php echo $params['email_sujet']; ?>"  size="100"></input>

    <h5>Corps Email</h5>
    <textarea name="email_corps" id="email_corps"><?php echo $params['email_corps']; ?></textarea>

    <h5>Texte bouton</h5>
    <input type="text" name="email_texte_bouton" id="email_texte_bouton" value="<?php echo $params['email_texte_bouton']; ?>" size="30"></input>

    <h5>Corps Email 2 (après bouton)</h5>
    <textarea name="email_corps_2" id="email_corps_2"><?php echo $params['email_corps_2']; ?></textarea>

    <h5>footer email</h5>
    <textarea name="email_footer" id="email_footer"><?php echo $params['email_footer']; ?></textarea>
    <hr>
    <h2 class="text-center">Code Tracking analytics</h2>
    <textarea name="analytics" id="analytics" style="width:100%; height:200px;"><?php echo $params['analytics']; ?></textarea>

    <h3>Activer partage dossier zip</h3>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="partage_dossier" id="inlineRadio1" value="true" <?php if($params['partage_dossier']){echo "checked";} ?>>
      <label class="form-check-label" for="inlineRadio1">activer</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="partage_dossier" id="inlineRadio2" value="false" <?php if(!$params['partage_dossier']){echo "checked";} ?>>
      <label class="form-check-label" for="inlineRadio2">désactiver</label>
    </div>
    <br/>

<br><br><br>
    <input type="submit" class="btn btn-success btn-lg" value="Enregistrer les paramètres"/>
  </form>
  <br><br><br>
  <hr><hr>
  <br><br><br>
  <h1 class="text-center">MEDIAS</h1>

  <h2 class="text-center">Logo principal</h2>
  <img src="./vue/img/logo.png" id="logo" style="border: 3px solid black; border-radius:10px; padding:30px; margin:10px;"/>

  <form action="./ctrl/upload_logo.php" method="post" enctype="multipart/form-data">
    Selectionnez un logo au <u>format PNG</u>:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer logo" name="submit">
  </form>

  <h2 class="text-center">Image Encart invitation (Espace de téléchargement)</h2>
  <img src="./vue/img/invitation.jpg" id="invitation" style="border: 3px solid black; border-radius:10px; padding:30px; margin:10px; max-width:300px;"/>

  <form action="./ctrl/upload_invitation.php" method="post" enctype="multipart/form-data">
    Selectionnez une image au <u>format JPG</u> :
    <input type="file" name="invitation" id="invitation">
    <input type="submit" value="Envoyer Image" name="submit">
  </form>

  <h2 class="text-center">Bannière vidéo (Espace de téléchargement)</h2>
  <div style="width: 300px; height: 150px;" data-vide-bg="vue/img/video" data-vide-options="loop: true, muted: true"></div>
  <form action="./ctrl/upload_banniere.php" method="post" enctype="multipart/form-data">
    Selectionnez une vidéo au <u>format mp4</u> :
    <input type="file" name="file" id="banniere">
    <input type="submit" value="Envoyer Vidéo" name="submit">
  </form>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>

<script>
ClassicEditor
.create( document.querySelector( '#email_corps' ) )
.catch( error => {
  console.error( error );
} );
</script>

<script>
ClassicEditor
.create( document.querySelector( '#email_corps_2' ) )
.catch( error => {
  console.error( error );
} );
</script>

<script>
ClassicEditor
.create( document.querySelector( '#email_footer' ) )
.catch( error => {
  console.error( error );
} );
</script>

<script>
ClassicEditor
.create( document.querySelector( '#accueil_texte' ) )
.catch( error => {
  console.error( error );
} );
</script>

<script>
ClassicEditor
.create( document.querySelector( '#texte_espace' ) )
.catch( error => {
  console.error( error );
} );
</script>

<style>
hr{
  border-top:4px solid black;
}
</style>
