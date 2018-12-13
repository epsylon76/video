<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="?page=dossiers">Dossiers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=historique">historique</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=liste">Partages</a>
        </li>

      </ul>
      <span class="nav-link" style="color:white">
        <?php echo $_SESSION['login']; ?>
      </span>
      <a class="nav-link btn btn-warning btn-sm" href="?page=parametres"><i class="fas fa-cog"></i></a>
      &nbsp;
      <a class="nav-link btn btn-danger btn-sm" href="?action=deco"><i class="fas fa-power-off"></i></a>
    </div>
  </nav>
