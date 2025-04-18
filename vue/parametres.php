<div class="container" style="margin-top:30px;">
  <h1>Paramètres</h1>

  <a class="btn btn-info" href="/admin/parametres/users/">Gestion Utilisateurs</a>

  <h2>Checks permissions</h2>
  <h6>Dossier data : <?php echo is_writable('data') ? 'OK' : 'NOK'; ?></h6>
  <h6>Dossier zip : <?php echo is_writable('zip') ? 'OK' : 'NOK'; ?></h6>
  <h6>Dossier img : <?php echo is_writable('vue/img') ? 'OK' : 'NOK'; ?></h6>
  <h6>Executable captures.sh : <?php echo is_executable('scripts/captures.sh') ? 'OK' : 'NOK'; ?></h6>


  <form action="/admin/parametres/" method="post">
    <input type="hidden" name="depart_file" value="<?php echo $params['depart_file']; ?>" />
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
    <textarea name="accueil_texte" id="accueil_texte"><?php echo $params['accueil_texte']; ?></textarea>

    <hr>
    <h2 class="text-center">Espace de Téléchargement</h2>

    <h5>Texte Accueil</h5>
    <textarea name="texte_espace" id="texte_espace"><?php echo $params['texte_espace']; ?></textarea>
    <br>
    <h5>boutons de partage sociaux</h5>

    <p><u>Laisser vide pour désactiver</u></p>

    Facebook : <input type="text" name="partage_fb" value="<?php echo $params['partage_fb']; ?>" style="width:500px;"></input><br>
    Twitter : <input type="text" name="partage_twitter" value="<?php echo $params['partage_twitter']; ?>" style="width:500px;"></input><br>
    <br>
    <h5>Titre invitation autre site</h5>
    <input type="text" name="titre_invitation" value="<?php echo $params['titre_invitation']; ?>" style="width:500px;"></input>
    <h5>Lien invitation autre site</h5>
    https://
    <input type="text" name="url_invitation" value="<?php echo $params['url_invitation']; ?>" style="width:500px;"></input>


    <hr>
    <h2 class="text-center">Email</h2>

    <h5>Objet Email</h5>
    <input type="text" name="email_sujet" id="email_sujet" value="<?php echo $params['email_sujet']; ?>" size="100"></input>

    <h5>Paragraphe 1</h5>
    <textarea name="email_corps" id="email_corps"><?php echo $params['email_corps']; ?></textarea>

    <h5>Texte bouton</h5>
    <input type="text" name="email_texte_bouton" id="email_texte_bouton" value="<?php echo $params['email_texte_bouton']; ?>" size="30"></input>

    <h5>Paragraphe 2 (après bouton)</h5>
    <textarea name="email_corps_2" id="email_corps_2"><?php echo $params['email_corps_2']; ?></textarea>

    <h5>Footer</h5>
    <textarea name="email_footer" id="email_footer"><?php echo $params['email_footer']; ?></textarea>


    <hr>
    <h2 class="text-center">Email Alternatif</h2>
    <p>Le texte bouton et le footer sont les mêmes que défini au dessus</p>

    <h5>Objet Email Alternatif</h5>
    <input type="text" name="email_sujet_alt" id="email_sujet_alt" value="<?php echo $params['email_sujet_alt']; ?>" size="100"></input>

    <h5>Paragraphe 1 Email Alternatif</h5>
    <textarea name="email_corps_alt" id="email_corps_alt"><?php echo $params['email_corps_alt']; ?></textarea>

    <h5>Paragraphe 2 Email Alternatif (après bouton)</h5>
    <textarea name="email_corps_2_alt" id="email_corps_2_alt"><?php echo $params['email_corps_2_alt']; ?></textarea>


    <hr>
    <h2 class="text-center">Code Tracking analytics</h2>
    <textarea name="analytics" id="analytics" style="width:100%; height:200px;"><?php echo $params['analytics']; ?></textarea>

    <h3>Activer partage dossier zip</h3>

    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="partage_dossier" id="inlineRadio1" value="1" <?php if ($params['partage_dossier']) {
                                                                                                        echo "checked";
                                                                                                      } ?>>
      <label class="form-check-label" for="inlineRadio1">activer</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="partage_dossier" id="inlineRadio2" value="0" <?php if (!$params['partage_dossier']) {
                                                                                                        echo "checked";
                                                                                                      } ?>>
      <label class="form-check-label" for="inlineRadio2">désactiver</label>
    </div>
    <br />

    <br><br><br>
    <input type="submit" class="btn btn-success btn-lg" value="Enregistrer les paramètres" />
  </form>
  <br><br><br>
  <hr>
  <hr>
  <br><br><br>
  <h1 class="text-center">MEDIAS</h1>

  <h3>MAX UPLOAD : <?php echo $max_upload ?></h3>


  <h2 class="text-center">Logo principal</h2>
  <img src="/vue/img/logo.png" id="logo" style="border: 3px solid black; border-radius:10px; padding:30px; margin:10px;" />

  <form action="/actions/uploadLogo/" method="post" enctype="multipart/form-data">
    Selectionnez un logo au <u>format PNG</u>:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer logo" name="submit">
  </form>

  <h2 class="text-center">Image Encart invitation (Espace de téléchargement)</h2>
  <img src="/vue/img/invitation.jpg" id="invitation" style="border: 3px solid black; border-radius:10px; padding:30px; margin:10px; max-width:300px;" />

  <form action="/actions/uploadInvitation/" method="post" enctype="multipart/form-data">
    Selectionnez une image au <u>format JPG</u> :
    <input type="file" name="invitation" id="invitation">
    <input type="submit" value="Envoyer Image" name="submit">
  </form>

  <h2 class="text-center">Bannière vidéo (Espace de téléchargement)</h2>
  <?php if (file_exists('vue/img/banniere.mp4')) { ?>
    <video style="width: 1000px;" loop muted controls autoplay>
      <source src="/vue/img/banniere.mp4" type="video/mp4" />
    </video>
  <?php } ?>
  <form action="/actions/uploadBanniere/" method="post" enctype="multipart/form-data">
    Selectionnez une vidéo au <u>format mp4</u> :
    <input type="file" name="file" id="banniere">
    <input type="submit" value="Envoyer Vidéo" name="submit">
  </form>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>

<script>
  ClassicEditor
    .create(document.querySelector('#email_corps'))
    .catch(error => {
      console.error(error);
    });
</script>

<script>
  ClassicEditor
    .create(document.querySelector('#email_corps_2'))
    .catch(error => {
      console.error(error);
    });
</script>

<script>
  ClassicEditor
    .create(document.querySelector('#email_corps_alt'))
    .catch(error => {
      console.error(error);
    });
</script>

<script>
  ClassicEditor
    .create(document.querySelector('#email_corps_2_alt'))
    .catch(error => {
      console.error(error);
    });
</script>

<script>
  ClassicEditor
    .create(document.querySelector('#email_footer'))
    .catch(error => {
      console.error(error);
    });
</script>

<script>
  ClassicEditor
    .create(document.querySelector('#accueil_texte'))
    .catch(error => {
      console.error(error);
    });
</script>

<script>
  ClassicEditor
    .create(document.querySelector('#texte_espace'))
    .catch(error => {
      console.error(error);
    });
</script>

<style>
  hr {
    border-top: 4px solid black;
  }
</style>