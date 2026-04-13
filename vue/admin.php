<style>
  /* Supprime le soulignement des liens de dossiers */
  .dossier-link {
    text-decoration: none;
    color: #333;
    transition: color 0.2s ease-in-out;
    display: block;
    padding: 8px;
    border-radius: 5px;
  }

  /* Effet au survol pour simuler une sélection */
  .dossier-link:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: #0d6efd;
    /* Le bleu primaire de Bootstrap 5 */
  }

  /* Style pour l'icône à côté du nom */
  .dossier-link i {
    margin-right: 10px;
    color: #ffca28;
    /* Couleur "Dossier" classique */
  }
</style>

<main role="main" class="container mt-4">
  <div class="row">
    <div class="col-12 px-3">
      <h1>Navigation dans les dossiers</h1>
      <p class="text-muted">
        Le partage fonctionne par nom de dossier. Si les noms des dossiers sont modifiés, le partage devient inaccessible.
      </p>
    </div>
  </div>

  <?php echo $breadcrumb; ?>

  <div class="lead">
    <?php echo $dossier->affiche_contenu($listefichiers); ?>
  </div>
</main>

<div class="modal fade" id="partageModal" tabindex="-1" aria-labelledby="partageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/actions/set_partage" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="partageModalLabel">Nouveau Partage</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-dark">
          <div id="chemin" class="fw-bold mb-3"></div>

          <input type="hidden" name="chemin" id="hiddenchemin">
          <input type="hidden" name="chemin_retour" id="hiddenretour">
          <input type="hidden" name="type_partage" id="hiddentype">

          <div class="mb-3">
            <label for="ChampEmail" class="form-label">Email :</label>
            <input id="ChampEmail" type="email" class="form-control" name="email" required>
            <div id="AvertissementDejaPartage" class="form-text text-danger fw-bold" style="display:none">
              Partage déjà fait avec cet email, utiliser le bouton de renvoi dans "Partages".
            </div>
          </div>

          <div id="SelecteursTypes">
            <label class="form-label d-block">Type d'email</label>
            <div class="mb-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="email_type" id="email_normal" value="1" checked>
                <label class="form-check-label" for="email_normal">Normal</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="email_type" id="email_alternatif" value="2">
                <label class="form-check-label" for="email_alternatif">Alternatif</label>
              </div>
            </div>

            <h5 class="mt-4">Délai d'envoi</h5>
            <div class="mb-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="immediat" id="delai_attente" value="0" checked>
                <label class="form-check-label" for="delai_attente">File d'attente</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="immediat" id="delai_immediat" value="1">
                <label class="form-check-label" for="delai_immediat">Immédiat</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button id="BoutonPartager" type="submit" class="btn btn-success">Partager</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/actions/setTag" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="tagModalLabel">Gestion des Tags</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-dark">
          <input type="hidden" name="nom_dossier" id="hiddenNomDossier">
          <input type="hidden" name="retour" id="hiddenCheminRetour">
          <input type="hidden" name="type" id="hiddenTypeFichier">
          <input type="hidden" name="tag" id="hiddenTagLabel">

          <div class="mb-3">
            <label for="input_tag" class="form-label text-dark">Tag(s) :</label>
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


  //TEST si l'email a déjà été utilisé
  $('#ChampEmail').keyup(function() {
    var value = $(this).val();
    var chemin = $('#hiddenchemin').val();
    $.ajax({
      url: '/ajax/check_deja_partage.php',
      type: 'POST',
      data: {
        'email': value,
        'chemin': chemin
      },
      datatype: 'json',
      success: function(result) {
        if (result == 'true') {
          $('#BoutonPartager').attr('disabled', true);
          $('#AvertissementDejaPartage').fadeIn();
          $('#SelecteursTypes').fadeOut();
        } else {
          $('#BoutonPartager').attr('disabled', false);
          $('#AvertissementDejaPartage').fadeOut();
          $('#SelecteursTypes').fadeIn();
        }
      }
    });
  })
</script>