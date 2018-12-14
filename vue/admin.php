
<main role="main" class="container">
  <div class="row">

    <h1>Navigation dans les dossiers</h1>
    <p>
      Le partage fonctionne par nom de dossier, si les noms des dossiers sont modifiés le partage devient inaccessible<br>
      <u>Les dossiers trop volumineux ne sont pas partageables</u>
    </p><br>

    <p><i class="fas fa-camera"></i> -> Le partage est de type photos</p><br>
    <p><i class="fas fa-video"></i> -> Le partage est de type vidéo</p><br>
    <p><i class="fas fa-folder-plus"></i> -> Le partage est de type dossier compréssé <u>attention à n'utiliser que rarement</u></p><br>
  </div>

  <?php echo $breadcrumb; ?>

  <p class="lead"><?php echo $dossier->affiche_contenu($listefichiers);?></p>

</main><!-- /.container -->
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
