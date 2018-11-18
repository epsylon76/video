
<main role="main" class="container">
  <div class="row">

    <h1>Navigation dans les dossiers</h1>
    <p>Le partage fonctionne par nom de dossier, si les noms des dossiers sont modifiés le partage devient inaccessible</p>
  </div>

    <?php echo $breadcrumb; ?>

    <p class="lead"><?php echo $dossier->affiche_contenu($listefichiers);?></p>

</main><!-- /.container -->
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
