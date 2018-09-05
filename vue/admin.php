
<main role="main" class="container">
  <div class="row">

    <h1>Navigation dans les dossiers</h1>
  </div>

    <?php echo $breadcrumb; ?>


    <p class="lead"><?php echo $dossier->affiche_contenu($listefichiers);?></p>

</main><!-- /.container -->
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
