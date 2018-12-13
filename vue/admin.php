
<main role="main" class="container">
  <div class="row">

    <h1>Navigation dans les dossiers</h1>
    <p>
      Le partage fonctionne par nom de dossier, si les noms des dossiers sont modifiés le partage devient inaccessible<br>
      <u>Les dossiers trop volumineux ne sont pas partageables</u>
    </p>

    <p><i class="fas fa-camera"></i> -> Le partage est de type photos et affichera un diaporama et le bouton de téléchargement</p>
    <p><i class="fas fa-video"></i> -> Le partage est de type vidéo et affichera un lecteur vidéo et le bouton de téléchargement</p>
    <p><i class="fas fa-folder-plus"></i> -> Le partage est de type dossier compréssé !!! attention à n'utiliser que rarement !!!</p>
  </div>

  <?php echo $breadcrumb; ?>

  <p class="lead"><?php echo $dossier->affiche_contenu($listefichiers);?></p>

</main><!-- /.container -->
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
