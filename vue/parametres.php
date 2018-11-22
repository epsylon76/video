

<div class="container" style="margin-top:30px;">
  <h2>Paramètres</h2>

  <h3>Logo Bannière</h3>
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
    <h4>Email</h4>
    <h5>Nom expéditeur Email</h5>
    <input type="text" name="email_expediteur" id="email_expediteur" value="<?php echo $params['email_expediteur']; ?>"></input>
    <h5>Objet Email</h5>
    <input type="text" name="email_sujet" id="email_sujet" value="<?php echo $params['email_sujet']; ?>"></input>
    <h5>Corps Email</h5>
    <textarea name="email_corps" id="email_corps"><?php echo $params['email_corps']; ?></textarea>
    <h5>Texte bouton</h5>
    <input type="text" name="email_texte_bouton" id="email_texte_bouton" value="<?php echo $params['email_texte_bouton']; ?>"></input>
    <h5>footer email</h5>

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
.create( document.querySelector( '#accueil_texte' ) )
.catch( error => {
  console.error( error );
} );
</script>
