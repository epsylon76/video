
<main role="main" class="container">
  <div class="row">

    <h1>Navigation dans les dossiers</h1>
    <p>
      Le partage fonctionne par nom de dossier, si les noms des dossiers sont modifiés le partage devient inaccessible<br>
    </p>

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
        <div id="chemin" style="font-weight:800;"></div>
        <br>
        <form action="?page=set_partage" method="post" class="form-inline">
          <!-- hidden -->
          <input type="hidden" name="chemin" id="hiddenchemin">
          <input type="hidden" name="chemin_retour" id="hiddenretour">
          <input type="hidden" name="type_partage" id="hiddentype">
          <!-- hidden -->
          <div class="form-group">
            <label for="email" class="col-form-label">Email :&nbsp;</label>
            <input type="email" class="form-control form-control-sm" id="email" name="email" required size="30">
          </div>

          <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="email_normal" name="email_type" class="custom-control-input" value="1" checked>
              <label class="custom-control-label" for="email_normal">Normal</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="email_alternatif" name="email_type" class="custom-control-input" value="2">
              <label class="custom-control-label" for="email_alternatif">Alternatif</label>
            </div>
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

<!-- Lazy slick -->
<link rel="stylesheet" type="text/css" href="/includes/js/slick/slick-theme.css"/>
<link rel="stylesheet" type="text/css" href="/includes/js/slick/slick.css"/>
<script type="text/javascript" src="/includes/js/slick/slick.min.js"></script>

<script>
$('#partageModal').on('show.bs.modal', function (event) {
  console.log('modal opened');

  var button = $(event.relatedTarget); // Button that triggered the modal
  var type = button.data('typepartage'); // Extract info from data-* attributes
  var chemin = button.data('chemin');
  var retour = button.data('retour');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('.modal-title').text('Partage de type ' + type);
  modal.find('#hiddenchemin').val(chemin);
  modal.find('#hiddenretour').val(retour);
  modal.find('#hiddentype').val(type);
  //modal.find('.modal-body input').val(type);
  modal.find('.modal-body #chemin').text(chemin);
});
  
  $('#partageModal').on('shown.bs.modal', function () {
  $('#email').focus();
});


$('.slider-photo').slick({
  lazyLoad: 'ondemand',
  slidesToShow: 1,
  slidesToScroll: 1,
  fade: true,
  dots: false

});

  
</script>
