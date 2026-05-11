<section class="hero-accueil d-flex align-items-center justify-content-center text-white text-center">
  <video autoplay muted loop playsinline class="hero-video-bg">
    <source src="/vue/img/banniere.mp4" type="video/mp4">
  </video>
  <div class="hero-overlay-dark"></div>
  <div class="hero-content-accueil">
    <img src="./vue/img/logo.png" id="logo" class="img-fluid mb-4" alt="Logo" />
    <div class="accueil-texte">
      <?php echo $params['accueil_texte']; ?>
    </div>
  </div>
</section>

<button type="button" class="btn-admin-discret" data-bs-toggle="modal" data-bs-target="#modalAdmin" title="Administration">
  <i class="fas fa-lock fa-xs"></i>
</button>

<div class="modal fade" id="modalAdmin" tabindex="-1" aria-labelledby="modalAdminLabel" aria-hidden="true" style="color:black;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/actions/login_admin" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAdminLabel">Accès administration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="login" class="form-label">Utilisateur</label>
            <input type="text" class="form-control" id="login" name="login" required>
          </div>
          <div class="mb-3">
            <label for="Password" class="form-label">Mot de Passe</label>
            <input type="password" class="form-control" id="Password" name="pass" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Accès</button>
        </div>
      </form>
    </div>
  </div>
</div>
