<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><?php echo $params['page_titre']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/admin/dossiers/">Dossiers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/historique/">Historique</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/partage/">Partages</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/admin/stats/" id="bouton-stats">Stats</a>
        </li>
      </ul>
      <span class="nav-link" style="color:white">
        <?php echo $_SESSION['login']; ?>
      </span>
      <a class="nav-link btn btn-warning btn-sm" href="/admin/parametres/"><i class="fas fa-cog"></i></a>
      &nbsp;
      <a class="nav-link btn btn-danger btn-sm" href="/admin/action/deconnecter"><i class="fas fa-power-off"></i></a>
    </div>
  </nav>