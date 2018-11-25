<div class="container" style="margin-top:30px;">
  <h2>Paramètres</h2>

  <h3>Logo Bannière</h3>
  <img src="./vue/img/logo.png" id="logo"/>
  <form action="./ctrl/upload_logo.php" method="post" enctype="multipart/form-data">
    Selectionnez un logo :
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Envoyer logo" name="submit">
  </form>

  <form action="./?page=parametres" method="post" >
    <h5>Titre Page</h5>
    <input type="text" name="page_titre" value="<?php echo $params['page_titre']; ?>"></input>

    <h5>Texte d'accueil</h5>
    <textarea name="accueil_texte" id="accueil_texte" ><?php echo $params['accueil_texte']; ?></textarea>

    <h3>Email</h3>

    <h5>Nom expéditeur Email</h5>
    <input type="text" name="email_expediteur" id="email_expediteur" value="<?php echo $params['email_expediteur']; ?>" size="30"></input>

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

    <input type="submit" class="btn btn-success" value="Enregistrer"/>
  </form>

</div>

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
