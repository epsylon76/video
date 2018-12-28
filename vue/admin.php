
<main role="main" class="container">
  <div class="row">

    <h1>Navigation dans les dossiers</h1>
    <p>
      Le partage fonctionne par nom de dossier, si les noms des dossiers sont modifiés le partage devient inaccessible<br>
      <u>Les dossiers trop volumineux ne sont pas partageables</u>
    </p>
    <ul>
      <li><i class="fas fa-camera"></i> -> Le partage est de type photos et affichera un diaporama et le bouton de téléchargement</li>
      <li><i class="fas fa-video"></i> -> Le partage est de type vidéo et affichera un lecteur vidéo et le bouton de téléchargement</li>
      <li><i class="fas fa-folder-plus"></i> -> Le partage est de type dossier compréssé !!! attention à n'utiliser que rarement !!!</li>
    </ul>
  </div>

    <?php echo $breadcrumb; ?>

    <p class="lead"><?php echo $dossier->affiche_contenu($listefichiers);?></p>

</main><!-- /.container -->

<div class="modal fade" id="partageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nouveau Partage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="chemin"></div>
        <form action="?page=set_partage" method="post">
          <!-- hidden -->
          <input type="hidden" name="chemin" id="hiddenchemin">
          <input type="hidden" name="chemin_retour" id="hiddenretour">
          <input type="hidden" name="type_partage" id="hiddentype">
          <!-- hidden -->
          <div class="form-group">
            <label for="email" class="col-form-label">Email :</label>
            <input type="email" class="form-control form-control-sm" id="email" name="email" required size="30">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-success">partager</button>
      </div>
    </form>
    </div>
  </div>
</div>


<script>
$('#partageModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var type = button.data('typepartage') // Extract info from data-* attributes
  var chemin = button.data('chemin')
  var retour = button.data('retour')
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Partage de type ' + type)
  modal.find('#hiddenchemin').val(chemin)
  modal.find('#hiddenretour').val(retour)
  modal.find('#hiddentype').val(type)
  //modal.find('.modal-body input').val(type)
  modal.find('.modal-body #chemin').text(chemin)
})
</script>
