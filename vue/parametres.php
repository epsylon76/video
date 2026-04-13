<div class="container-fluid px-md-5 py-4">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cog me-2"></i>Paramètres Système</h1>
    <div>
      <a class="btn btn-primary shadow-sm rounded-pill" href="/admin/parametres/users/">
        <i class="fas fa-users-cog me-1"></i> Gestion Utilisateurs
      </a>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Permissions Dossiers</div>
              <div class="small font-weight-bold">
                Data: <?php echo is_writable('data') ? '<span class="text-success">OK</span>' : '<span class="text-danger">NOK</span>'; ?> |
                Zip: <?php echo is_writable('zip') ? '<span class="text-success">OK</span>' : '<span class="text-danger">NOK</span>'; ?>
              </div>
            </div>
            <div class="col-auto"><i class="fas fa-folder-open fa-2x text-gray-300"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Base de données</div>
              <a href="/config/adminsql.php?db=abeille&username=abeille&server=localhost" class="btn btn-sm btn-outline-info">Accès SQL Admin</a>
            </div>
            <div class="col-auto"><i class="fas fa-database fa-2x text-gray-300"></i></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <ul class="nav nav-pills mb-4 bg-white p-2 rounded shadow-sm" id="configTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="core-tab" data-bs-toggle="pill" data-bs-target="#core" type="button">⚙️ Core & Design</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="content-tab" data-bs-toggle="pill" data-bs-target="#content" type="button">📝 Contenus & Accueil</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="email-tab" data-bs-toggle="pill" data-bs-target="#email" type="button">📧 Emails Configuration</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="medias-tab" data-bs-toggle="pill" data-bs-target="#medias" type="button">🖼️ Médias & Uploads</button>
    </li>
  </ul>

  <form action="/admin/parametres/" method="post">
    <div class="tab-content" id="configTabsContent">

      <div class="tab-pane fade show active" id="core" role="tabpanel">
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-header bg-white py-3">
            <h5>Configuration Serveur</h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold">Dossier Data (chemin absolu)</label>
                <input type="text" name="dossier_data" class="form-control" value="<?php echo $params['dossier_data']; ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">URL du domaine</label>
                <input type="text" name="url_domaine" class="form-control" value="<?php echo $params['url_domaine']; ?>">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold d-block">Couleur thème principal</label>
                <input type="color" name="couleur_fond" class="form-control form-control-color w-100" value="<?php echo $params['couleur_fond']; ?>" style="height: 45px;">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold d-block">Partage Dossier Zip</label>
                <div class="btn-group w-100" role="group">
                  <input type="radio" class="btn-check" name="partage_dossier" id="zip_on" value="1" <?php echo $params['partage_dossier'] ? 'checked' : ''; ?>>
                  <label class="btn btn-outline-success" for="zip_on">Activer</label>
                  <input type="radio" class="btn-check" name="partage_dossier" id="zip_off" value="0" <?php echo !$params['partage_dossier'] ? 'checked' : ''; ?>>
                  <label class="btn btn-outline-danger" for="zip_off">Désactiver</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="content" role="tabpanel">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="mb-4">
              <label class="form-label fw-bold">Titre du site (Balise Title)</label>
              <input type="text" name="page_titre" class="form-control" value="<?php echo $params['page_titre']; ?>">
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">Texte d'accueil (Landing Page)</label>
              <textarea name="accueil_texte" class="ck-editor-instance" id="accueil_texte"><?php echo $params['accueil_texte']; ?></textarea>
            </div>
            <div class="mb-4">
              <label class="form-label fw-bold">Texte d'introduction (Espace Client)</label>
              <textarea name="texte_espace" class="ck-editor-instance" id="texte_espace"><?php echo $params['texte_espace']; ?></textarea>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label class="form-label fw-bold"><i class="fab fa-facebook text-primary me-1"></i> Lien Facebook</label>
                <input type="text" name="partage_fb" class="form-control" value="<?php echo $params['partage_fb']; ?>" placeholder="Laisser vide pour désactiver">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold"><i class="fab fa-twitter text-info me-1"></i> Lien Twitter</label>
                <input type="text" name="partage_twitter" class="form-control" value="<?php echo $params['partage_twitter']; ?>" placeholder="Laisser vide pour désactiver">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="email" role="tabpanel">
        <div class="accordion shadow-sm" id="accordionEmail">
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#emailStandard">Email Standard</button></h2>
            <div id="emailStandard" class="accordion-collapse collapse show" data-bs-parent="#accordionEmail">
              <div class="accordion-body">
                <div class="mb-3">
                  <label class="form-label fw-bold">Objet de l'email</label>
                  <input type="text" name="email_sujet" class="form-control" value="<?php echo $params['email_sujet']; ?>">
                </div>
                <textarea name="email_corps" class="ck-editor-instance"><?php echo $params['email_corps']; ?></textarea>
                <div class="my-3 p-3 bg-light rounded border text-center">
                  <label class="fw-bold d-block mb-2">Bouton de téléchargement</label>
                  <input type="text" name="email_texte_bouton" class="form-control w-50 mx-auto" value="<?php echo $params['email_texte_bouton']; ?>">
                </div>
                <textarea name="email_corps_2" class="ck-editor-instance"><?php echo $params['email_corps_2']; ?></textarea>
              </div>
            </div>
          </div>
          <div class="accordion-item mt-3 shadow-sm border-top">
            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#emailAlt">Email Alternatif (Relance)</button></h2>
            <div id="emailAlt" class="accordion-collapse collapse" data-bs-parent="#accordionEmail">
              <div class="accordion-body">
                <div class="mb-3">
                  <label class="form-label fw-bold">Objet Alternatif</label>
                  <input type="text" name="email_sujet_alt" class="form-control" value="<?php echo $params['email_sujet_alt']; ?>">
                </div>
                <textarea name="email_corps_alt" class="ck-editor-instance"><?php echo $params['email_corps_alt']; ?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="medias" role="tabpanel">
        <div class="alert alert-info">Poids max autorisé : <strong><?php echo $max_upload ?></strong></div>
        <div class="row g-4 text-center">
          <div class="col-md-4">
            <div class="card h-100 p-3 shadow-sm">
              <h6>Logo Principal</h6>
              <div class="bg-dark p-3 rounded mb-3"><img src="/vue/img/logo.png" style="max-height:80px;"></div>
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('uploadLogo').click()">Changer logo</button>
            </div>
          </div>
          <div class="col-md-8">
          </div>
        </div>
      </div>
    </div>

</div>

<div class="sticky-bottom bg-white p-3 mt-5 border-top shadow text-center">
  <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-lg">
    <i class="fas fa-save me-2"></i> Enregistrer tous les paramètres
  </button>
</div>
</form>

<form id="uploadLogoForm" action="/actions/uploadLogo/" method="post" enctype="multipart/form-data" class="d-none">
  <input type="file" name="fileToUpload" id="uploadLogo" onchange="this.form.submit()">
</form>
</div>

<style>
  body {
    background-color: #f4f7f6;
  }

  .card {
    border-radius: 12px;
  }

  .nav-pills .nav-link {
    color: #555;
    font-weight: 500;
  }

  .nav-pills .nav-link.active {
    background-color: var(--bs-primary);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .ck-editor__editable {
    min-height: 200px;
  }

  .sticky-bottom {
    z-index: 1000;
  }

  .border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
  }

  .border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
  }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Initialise tous les éditeurs d'un coup
    const editors = document.querySelectorAll('.ck-editor-instance');
    editors.forEach(editor => {
      ClassicEditor
        .create(editor, {
          toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
        })
        .catch(error => {
          console.error(error);
        });
    });

    // Gestion de l'onglet actif après rechargement (facultatif)
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
      const tabTrigger = new bootstrap.Tab(document.querySelector(`#${activeTab}`));
      tabTrigger.show();
    }

    const tabLinks = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabLinks.forEach(link => {
      link.addEventListener('shown.bs.tab', (e) => {
        localStorage.setItem('activeTab', e.target.id);
      });
    });
  });
</script>