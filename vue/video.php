<?php
if (!isset($_SESSION['login'])) {
    echo $params['analytics']; 
}

/**
 * LOGIQUE DE NAVIGATION DYNAMIQUE
 */
if ($mode != 'client') {
    // Mode ADMIN
    // On récupère les segments de l'URL
    $segments = $uri; // ex: ['admin', 'video', '2026', '04 AVRIL', ...]
    
    // 1. Pour le bouton Retour : on enlève le dernier élément (le fichier) 
    // et on remplace 'video' par 'dossiers' pour revenir à la liste
    $retour_segments = $segments;
    array_pop($retour_segments); // Enlève le nom du fichier
    
    // Remplacement de 'video' par 'dossiers' dans l'URL de retour
    foreach ($retour_segments as $key => $value) {
        if ($value == 'video') {
            $retour_segments[$key] = 'dossiers';
        }
    }
    $url_retour = '/' . implode('/', $retour_segments);

    // 2. Pour le Breadcrumb : on crée une liste propre sans le segment 'video'
    $breadcrumb_items = array_filter($segments, function($v) {
        return $v !== 'video';
    });
} else {
    // Mode CLIENT
    $url_retour = '/cle/' . ($uri[1] ?? '');
    $breadcrumb_items = ['Abeille', 'Ma Vidéo'];
}
?>

<link href="/includes/css/video.css" rel="stylesheet">
<script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>

<style>
    .video-display-zone {
        background-color: #000;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        line-height: 0;
    }
    .fluid_video_wrapper { width: 100% !important; height: auto !important; }
    
    .info-section {
        margin-top: 3rem;
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .btn-action {
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    /* Style du breadcrumb pour l'admin */
    .breadcrumb-admin {
        text-transform: capitalize;
        font-size: 0.9rem;
    }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.2rem; vertical-align: middle; }
</style>

<div class="container-fluid px-md-5 py-4">
    
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h1 class="h2 fw-bold text-dark mb-0"><?php echo htmlspecialchars($nom_fichier); ?></h1>
            </div>
            
            <a class="btn btn-outline-secondary px-4 shadow-sm fw-bold" href="<?php echo $url_retour; ?>">
                <i class="fas fa-arrow-left me-2"></i> Retour au dossier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="video-display-zone">
                <video id="id-video" controls preload="auto">
                    <source id="id-source" src="<?php echo urldecode($chemin); ?>" type="video/mp4" />
                </video>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <div class="info-section p-4 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <div class="d-flex flex-column">
                            <span class="text-muted small fw-bold text-uppercase">Informations</span>
                            <div class="mt-1">
                                <span class="badge bg-light text-dark border p-2">
                                    <i class="fas fa-hdd me-2 text-primary"></i>
                                    <?php echo HumanSize($taille_fichier); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 text-center text-md-end">
                        <a id="bouton-dl"
                            class="btn btn-primary btn-action shadow-sm"
                            data-taille="<?php echo $taille_fichier ?>"
                            data-chemin="<?php echo $chemin; ?>"
                            data-email="<?php echo $email ?? ''; ?>"
                            data-action="dl_video"
                            href="<?php echo $chemin; ?>"
                            download="<?php echo $nom_fichier; ?>">
                            <i class="fas fa-download me-2"></i> Télécharger la vidéo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var myFP = fluidPlayer('id-video', {
        layoutControls: {
            fillToContainer: true,
            responsive: true,
            primaryColor: "#0d6efd",
            playButtonShowing: true
        }
    });
</script>