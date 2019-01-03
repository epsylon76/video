<div class="container" style="margin-top:30px;">
  <h1>Paramètres</h1>
  <h2>Logo</h2>
  <img src="./vue/img/logo.png" id="logo" style="border: 3px solid black; border-radius:10px; padding:30px; margin:10px;"/>

  <form action="./ctrl/upload_logo.php" method="post" enctype="multipart/form-data">
    Selectionnez un logo :
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer logo" name="submit">
  </form>

  <form action="./?page=parametres" method="post" >

    <h2>Core</h2>
    <h5>Dossier data</h5>
    <input type="text" name="dossier_data" size="70" value="<?php echo $params['dossier_data']; ?>"></input>

    <h5>Url site</h5>
    <input type="text" name="url_domaine" size="100" value="<?php echo $params['url_domaine']; ?>"></input>

    <h2>Design</h2>
    <h5>couleur fond</h5>
    <input type="color" name="couleur_fond" style="height:50px; width:50px; border:3px solid black; border-radius:10px;" value="<?php echo $params['couleur_fond']; ?>"></input>

    <h5>Titre Site</h5>
    <input type="text" name="page_titre" value="<?php echo $params['page_titre']; ?>"></input>

    <h5>Texte d'accueil</h5>
    <textarea name="accueil_texte" id="accueil_texte" ><?php echo $params['accueil_texte']; ?></textarea>

    <h2>Email</h2>

    <h5>Email</h5>
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

    <h2>Code Tracking analytics</h2>
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

    <h3>Interface réseau</h3>
    <input type="text" name="net_iface" id="net_iface" value="<?php echo $params['net_iface']; ?>" size="10"></input>
    <p>attention paramètre sensible</p>
    <br />

    <input type="submit" class="btn btn-success" value="Enregistrer"/>
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
