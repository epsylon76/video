<main role="main" class="container" style="margin-top:100px;">
  <img src="./vue/img/logo.png" id="logo" class="img-fluid mb-3" alt="Logo" /> <?php echo $params['accueil_texte']; ?>
</main>

<footer class="footer py-3 bg-light"> <div class="container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Administration
    </button>
  </div>
</footer>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="color:black;">
  <div class="modal-dialog"> <div class="modal-content">
      <form action="/actions/login_admin" method="post"> <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Accès administration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="loginform">
            <div class="mb-3"> <label for="login" class="form-label">Utilisateur</label>
              <input type="text" class="form-control" id="login" name="login" required>
            </div>
            <div class="mb-3">
              <label for="Password" class="form-label">Mot de Passe</label>
              <input type="password" class="form-control" id="Password" name="pass" required>
            </div>
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