<main role="main" class="container" style="margin-top:100px;">
  <img src="./vue/img/logo.png" id="logo"/>
  <?php echo $params['accueil_texte']; ?>
</main>

<footer class="footer">
  <div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Administration
    </button>
  </div>
</footer>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="color:black;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Accès administration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="loginform">
          <form action="/actions/login_admin" method="post">
            <div class="form-group">
              <label for="login">Utilisateur</label>
              <input type="text" class="form-control" id="login" name="login">
            </div>
            <div class="form-group">
              <label for="Password1">Mot de Passe</label>
              <input type="password" class="form-control" id="Password" name="pass">
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" style="margin-left:20px;">Accès</button>
      </form>
      </div>
    </div>
  </div>
</div>
