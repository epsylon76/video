<div class="container-fluid px-md-4 py-4">
    <div class="d-flex align-items-center mb-4">
        <h3 class="h4 mb-0">
            <i class="fas fa-tags me-2 text-primary"></i>Gestion des Tags
        </h3>
        <span class="ms-3 badge rounded-pill bg-light text-dark border">
            <?php echo count($liste_tag); ?> tags au total
        </span>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap gap-2">
                <?php foreach($liste_tag as $tag): ?>
                    <a href="/admin/tags/<?php echo urlencode($tag['nom_tag']); ?>" 
                       class="btn btn-outline-secondary btn-sm d-flex align-items-center rounded-pill px-3 py-2 shadow-sm transition-hover">
                        
                        <span class="fw-bold"><?php echo htmlspecialchars($tag['nom_tag']); ?></span>
                        
                        <span class="badge bg-primary ms-2 rounded-pill">
                            <?php echo $tag['occurrences']; ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <?php if(empty($liste_tag)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-tag fa-3x text-light mb-3"></i>
                    <p class="text-muted">Aucun tag trouvé dans la base de données.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Petit effet de survol pour rendre l'interface vivante */
.transition-hover {
    transition: all 0.2s ease-in-out;
    border-color: #dee2e6;
    color: #495057;
    text-decoration: none;
}

.transition-hover:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd;
    transform: translateY(-2px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    color: #0d6efd;
}

/* On s'assure que le badge interne ne bouge pas au hover */
.transition-hover:hover .badge {
    background-color: #0d6efd !important;
}
</style>