<main role="main" class="container">
  <h1 class="mt-5"><?php echo $titre_accueil; ?></h1>
  <p class="lead">Vous êtes sur la page d'accueil du système de partage de fichiers</p>
  <p class="lead">Vous avez reçu un email contenant le lien vers votre espace de partage,</p>
  <p class="lead">Dans le cas contraire, cliquez <a href="#">içi</a> pour reçevoir à nouveau le lien</p>
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
          <form action="./" method="post">
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
