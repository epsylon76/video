
<main role="main" class="container">
  <div class="row">

  <h1 style="padding-left:18px;">Navigation dans les dossiers</h1>
    <p  style="padding-left:18px;">
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
        <form action="/actions/set_partage" method="post" class="form-inline">
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
$('.clickpartage').click(function () {
  var type = $(this).data('typepartage'); // Extract info from data-* attributes
  var chemin = $(this).data('chemin');
  var retour = $(this).data('retour');
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  $('.modal-title').text('Partage de type ' + type);
  $('#hiddenchemin').val(chemin);
  $('#hiddenretour').val(retour);
  $('#hiddentype').val(type);
  $('.modal-body #chemin').text(chemin);
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


// activé quand on sort du focus de l'input
$('#input_tag').on('blur', function() {

  var contenu = $('#input_tag').val();
  var type = $('#input_tag').data('type');
  var nom_dossier = $('#input_tag').data('nom_dossier');

  $.ajax({
    url: '/ajax/ajax_tag.php',
    type: 'POST',
    data : { 
      'contenu' : contenu ,
      'nom_dossier': nom_dossier,
      'type' : type
    },
    success: function(response) {
        console.log(response);
    }
  });

});
</script>
