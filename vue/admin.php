<main role="main" class="container">
  <div class="row">

    <h1 style="padding-left:18px;">Navigation dans les dossiers</h1>
    <p style="padding-left:18px;">
      Le partage fonctionne par nom de dossier, si les noms des dossiers sont modifiés le partage devient inaccessible<br>
    </p>

  </div>

  <?php echo $breadcrumb; ?>

  <p class="lead"><?php echo $dossier->affiche_contenu($listefichiers); ?></p>

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
        <form action="/actions/set_partage" method="post" >
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
          <h5>Délai d'envoi</h5>
          <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="delai_attente" name="immediat" class="custom-control-input" value="0" checked>
              <label class="custom-control-label" for="delai_attente">File d'attente</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="delai_immediat" name="immediat" class="custom-control-input" value="1">
              <label class="custom-control-label" for="delai_immediat">Immédiat</label>
            </div>
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-success">Partager</button>
      </div>
      </form>
    </div>
  </div>
</div>




<div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="chemin" style="font-weight:800;"></div>
        <br>
        <form action="/actions/setTag" method="post">
          <!-- hidden -->
          <input type="hidden" name="nom_dossier" id="hiddenNomDossier">
          <input type="hidden" name="retour" id="hiddenCheminRetour">
          <input type="hidden" name="type" id="hiddenTypeFichier">
          <input type="hidden" name="tag" id="hiddenTagLabel">
          <!-- hidden -->
          <div class="form-group">
            <label for="input_tag" class="col-form-label">Tag(s) :&nbsp;</label>
            <input id="input_tag" type="text" name="liste_tag" class="form-control">
          </div>

      </div>
      <div class="modal-footer">
        <button type="submit" id="enregistrer_tag" class="btn btn-success">Enregistrer</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Lazy slick -->
<link rel="stylesheet" type="text/css" href="/includes/js/slick/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="/includes/js/slick/slick.css" />
<script type="text/javascript" src="/includes/js/slick/slick.min.js"></script>

<script>
  $('.slider-photo').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    dots: false

  });


  $('.clickpartage').click(function() {
    var type = $(this).data('typepartage'); // Extract info from data-* attributes
    var chemin = $(this).data('chemin');
    var retour = $(this).data('retour');
    var modal = $(this);
    $('.modal-title').text('Partage de type ' + type);
    $('#hiddenchemin').val(chemin);
    $('#hiddenretour').val(retour);
    $('#hiddentype').val(type);
    $('.modal-body #chemin').text(chemin);
  });

  $('#partageModal').on('shown.bs.modal', function() {
    $('#email').focus();
  });


  $('.clicktag').click(function() {
    var type = $(this).data('type');
    var nom_dossier = $(this).data('nom_dossier');
    var retour = $(this).data('retour');
    var cheminLabel = $('.label_tag').data('chemin');
    var idBtn = $(this).data('id_btn_tag');

    var contenu = $('#id_small_tag_' + idBtn).text();

    $('#input_tag').val(contenu);

    var modal = $(this);
    $('.modal-title').text('Tag(s) du ' + type + ' ' + nom_dossier);
    $('#hiddenNomDossier').val(nom_dossier);
    $('#hiddenCheminRetour').val(retour);
    $('#hiddenTypeFichier').val(type);
    $('#hiddenTagLabel').val(contenu);

  });

  $('#tagModal').on('shown.bs.modal', function() {
    $('#input_tag').focus();
  });
</script>