<?php echo $params['analytics']; ?>

<style>
  :root {
    --primary-color: #1e293b;
    --accent-color: #3b82f6;
    --border-radius: 1rem;
  }

  body {
    font-family: 'Inter', sans-serif;
  }

  /* Header Premium */
  .custom-header {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    position: relative;
    overflow: hidden;
  }

  .custom-header::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
  }

  .fw-black {
    font-weight: 900 !important;
    letter-spacing: -1px;
  }

  .logo-wrapper {
    transition: transform 0.3s ease;
   
  }

  .logo-wrapper:hover {
    transform: rotate(-2deg) scale(1.05);
  }

  /* Liste Items */
  .item-icon-wrapper {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    border-radius: 12px;
    font-size: 1.25rem;
  }

  .download-btn-circle {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    border-radius: 50%;
    color: #64748b;
    transition: all 0.3s ease;
  }

  .list-group-item:hover .download-btn-circle {
    background: #3b82f6;
    color: white;
    transform: scale(1.1);
  }

  .transition-all {
    transition: all 0.2s ease-in-out;
  }

  .list-group-item:hover {
    background-color: #ffffff !important;
    transform: translateX(5px);
  }

  /* Social & Sidebar */
  .social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: 0.3s;
  }

  .social-link.fb {
    background: #1877f2;
  }

  .social-link.tw {
    background: #1da1f2;
  }

  .social-link.tk {
    background: linear-gradient(45deg, #25f4ee, #fe2c55);
  }

  .social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    color: white;
  }

  /* Remerciements Card */
  .btn-email {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    padding: 8px 20px;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #1e293b;
  }

  .btn-email:hover {
    background: #f8fafc;
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }
</style>

<header class="custom-header py-5 shadow-sm">
  <div class="container py-3">
    <div class="row align-items-center g-4">
      <div class="col-md-7">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item small text-uppercase fw-bold"><a href="#" class="text-white-50 text-decoration-none">Abeille Parachutisme</a></li>
            <li class="breadcrumb-item small text-uppercase fw-bold active text-white" aria-current="page">Espace téléchargement</li>
          </ol>
        </nav>
        <h1 class="display-4 fw-black text-white mb-2">Bonjour ! ✨</h1>
        <p class="lead text-white-50 mb-0">Vos souvenirs sont prêts. Revivez vos émotions et partagez-les avec vos proches.</p>
      </div>
      <div class="col-md-5 text-md-end text-center">
        <div class="logo-wrapper p-2 d-inline-block">
          <img src="/vue/img/logo.png" alt="Logo" style="height: 170px; width: auto;">
        </div>
      </div>
    </div>
  </div>
</header>

<div class="container py-5">
  <div class="row g-5">
    <div class="col-lg-8">


      <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h5 fw-bold mb-0 text-dark">
          Vos souvenirs <span class="badge bg-primary-subtle text-primary rounded-pill ms-2 small"><?php echo count($liste); ?></span>
        </h2>
        <i class="fas fa-layer-group text-muted opacity-50"></i>
      </div>

      <div class="list-group list-group-flush rounded-4 shadow-sm border overflow-hidden bg-white">
        <?php foreach ($liste as $ligne):
          if ($ligne['type_partage'] == "video") {
            $icone = '<i class="fas fa-play-circle text-primary"></i>';
            $label = "Vidéo HD";
          } elseif ($ligne['type_partage'] == "photos") {
            $icone = '<i class="fas fa-images text-success"></i>';
            $label = "Album Photos";
          } else {
            $icone = '<i class="fas fa-folder-open text-warning"></i>';
            $label = "Dossier complet";
          }
        ?>
          <a href="/cle/<?php echo $uri[1] . '/' . $ligne['id']; ?>" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4 transition-all">
            <div class="flex-shrink-0 item-icon-wrapper me-3">
              <?php echo $icone; ?>
            </div>
            <div class="flex-grow-1 min-vw-0">
              <h6 class="mb-0 text-truncate fw-bold text-dark"><?php echo htmlspecialchars(basename($ligne['chemin'])); ?></h6>
              <small class="text-muted"><?php echo $label; ?></small>
            </div>
            <div class="ms-3 download-btn-circle">
              <i class="fas fa-arrow-right"></i>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="card mt-5 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-4 p-md-5">
          <div class="row align-items-center">
            <div class="col-md-8 border-md-end pe-md-4">
              <h4 class="fw-bold mb-3">Merci pour votre confiance ! 🚀</h4>
              <div class="text-muted lh-base">
                <?php echo $params['texte_espace']; ?>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="sticky-top" style="top: 2rem;">
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
          <div class="card-body p-4">
            <h5 class="fw-bold mb-3 small text-uppercase text-muted">Partager l'aventure</h5>
            <div class="d-flex gap-3 mb-4">
              <?php if ($params['partage_fb'] != ''): ?>
                <a href="<?php echo $params['partage_fb']; ?>" class="social-link fb" title="Facebook"><i class="fab fa-facebook-f"></i></a>
              <?php endif; ?>
              <?php if ($params['partage_twitter'] != ''): ?>
                <a href="<?php echo $params['partage_twitter']; ?>" class="social-link tw" title="X (Twitter)"><i class="fab fa-twitter"></i></a>
              <?php endif; ?>
              <a href="https://www.tiktok.com/" class="social-link tk" title="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>

            <hr class="my-4 opacity-10">

            <h5 class="fw-bold mb-3 small text-uppercase text-muted"><?php echo $params['titre_invitation']; ?></h5>
            <a href="https://<?php echo $params['url_invitation']; ?>" class="d-block transition-zoom">
              <img src="/vue/img/invitation.jpg" class="img-fluid rounded-4 shadow-sm" alt="Invitation">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>