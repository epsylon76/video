<?php
$nomTag = rawurldecode($uri[2]);
$listeTag = $tag->get_tag_from_nom_tag($nomTag);
?>

<div class="container-fluid px-md-4 py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/tags" class="text-decoration-none">Tags</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($nomTag); ?></li>
        </ol>
    </nav>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="h4 mb-0">
            <i class="fas fa-hashtag me-2 text-primary"></i>Contenus liés au tag : 
            <span class="text-primary fw-bold"><?php echo htmlspecialchars($nomTag); ?></span>
        </h3>
        <span class="badge bg-secondary rounded-pill">
            <?php echo count($listeTag); ?> élément(s)
        </span>
    </div>

    <div class="card shadow-sm border-0">
        <div class="list-group list-group-flush rounded-3">
            <?php
            foreach($listeTag as $tags):
                $type = $dossier->infos_fichier($data, $tags['nom_chemin'], '');
                
                // Détermination de l'icône et du lien selon le type
                if ($type[0] == 'dir' || $type[0] == 'link') { 
                    $icon = '<i class="fas fa-folder fa-lg text-warning me-3"></i>';
                    $url = '../dossiers/' . chemin_pour_url($tags["nom_chemin"]);
                    $label = "Dossier";
                } else {
                    $icon = '<i class="fas fa-video fa-lg text-primary me-3"></i>';
                    $url = '../video/' . chemin_pour_url($tags["nom_chemin"]);
                    $label = "Fichier Vidéo";
                }
            ?>
                <a href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" class="list-group-item list-group-item-action d-flex align-items-center py-3 transition-all">
                    <div class="d-flex align-items-center flex-grow-1">
                        <?php echo $icon; ?>
                        <div class="text-truncate">
                            <span class="d-block fw-medium text-dark"><?php echo htmlspecialchars($tags["nom_chemin"], ENT_QUOTES, 'UTF-8'); ?></span>
                            <small class="text-muted"><?php echo $label; ?></small>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-light ms-3"></i>
                </a>
            <?php endforeach; ?>

            <?php if(empty($listeTag)): ?>
                <div class="p-5 text-center text-muted">
                    <i class="fas fa-ghost fa-3x mb-3 opacity-25"></i>
                    <p>Aucun contenu n'est associé à ce tag pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Effet de transition fluide */
.transition-all {
    transition: all 0.2s ease;
}

.list-group-item-action:hover {
    background-color: #f8f9fa;
    padding-left: 1.25rem !important; /* Petit décalage vers la droite au survol */
}

.list-group-item-action:hover .fa-chevron-right {
    color: #0d6efd !important;
    transform: translateX(3px);
}
</style>
