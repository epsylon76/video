<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #1a1a1a; border-bottom: 1px solid rgba(255,255,255,0.1);">
  <div class="container-fluid"> 
    <a class="navbar-brand fw-bold" href="#"><?php echo $params['page_titre']; ?></a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0"> 
        <li class="nav-item"><a class="nav-link" href="/admin/dossiers/">Dossiers</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/envois/">Envois</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/historique/">Historique</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/partage/">Partages</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/stats/" id="bouton-stats">Stats</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin/tags/" id="bouton-tags">Tags</a></li>
      </ul>
      
      <div class="d-flex align-items-center"> 
        <span class="navbar-text me-3 text-white-50 small"> 
          Connecté en tant que : <strong class="text-white"><?php echo $_SESSION['login']; ?></strong>
        </span>
        
        <a class="btn btn-outline-light btn-sm me-2" href="/admin/parametres/" title="Paramètres">
          <i class="fas fa-cog"></i>
        </a>
        
        <a class="btn btn-outline-danger btn-sm" href="/actions/deconnecter" title="Déconnexion">
          <i class="fas fa-power-off"></i>
        </a>
      </div>
    </div>
  </div>
</nav>