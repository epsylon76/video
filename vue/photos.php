<?php
if (!isset($_SESSION['login'])) {
  echo $params['analytics']; 
}

/**
 * LOGIQUE DE NAVIGATION
 */
if ($mode != 'client') {
    $segments = $uri;
    $retour_segments = $segments;
    array_pop($retour_segments);
    foreach ($retour_segments as $key => $value) {
        if ($value == 'photos') $retour_segments[$key] = 'dossiers';
    }
    $url_retour = '/' . implode('/', array_map('rawurlencode', array_map('rawurldecode', $retour_segments)));
    $breadcrumb_items = array_filter($segments, function($v) { return $v !== 'photos'; });
} else {
    $url_retour = '/cle/' . ($uri[1] ?? '');
    $breadcrumb_items = ['Abeille', 'Album Photos'];
}
?>

<style>
    :root {
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.1);
    }

    /* Grille de photos moderne */
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px 0;
    }

    .photo-item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 3/2;
        cursor: pointer;
        background: #1a1a1a;
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .photo-item:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s;
    }

    /* Barre d'actions flottante */
    .floating-header {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 15px 25px;
        border: 1px solid rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
        z-index: 1000;
        margin-bottom: 40px;
    }

    .btn-dl-modern {
        background: #000;
        color: #fff;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 700;
        transition: all 0.3s;
        border: none;
    }

    .btn-dl-modern:hover {
        background: #333;
        transform: translateY(-2px);
        color: #fff;
    }

    /* Overlay de visualisation plein écran (Remplace Slick) */
    .fullscreen-viewer {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .viewer-content img {
        max-height: 90vh;
        max-width: 90vw;
        border-radius: 8px;
        box-shadow: 0 0 50px rgba(0,0,0,1);
    }

    .close-viewer {
        position: absolute;
        top: 30px; right: 30px;
        color: #fff; font-size: 2rem; cursor: pointer;
    }
</style>

<div class="container-fluid px-md-5 py-4">
    
    <div class="floating-header shadow-sm d-flex justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb_items as $index => $item): ?>
                        <li class="breadcrumb-item <?php echo ($index === array_key_last($breadcrumb_items)) ? 'active fw-bold' : ''; ?>">
                            <?php echo htmlspecialchars(urldecode($item)); ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
            <h4 class="mb-0 fw-black mt-1">Album HD <span class="badge bg-light text-dark border ms-2" style="font-size: 0.8rem; vertical-align: middle;"><?php echo $nb; ?> clichés</span></h4>
        </div>

        <div class="d-flex gap-3 align-items-center">
            <a href="<?php echo htmlspecialchars($url_retour, ENT_QUOTES, 'UTF-8'); ?>" class="text-dark text-decoration-none fw-bold me-3 d-none d-sm-block">
                <i class="fas fa-times me-2"></i> Fermer
            </a>
            <?php if ($mode == 'client'): ?>
                <a id="bouton-dl" class="btn-dl-modern" 
                   data-taille="<?php echo $taille ?>" data-chemin="<?php echo htmlspecialchars($chemin, ENT_QUOTES, 'UTF-8'); ?>" 
                   data-email="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" data-action="dl_photos" 
                   href="/cle/<?php echo rawurlencode($uri[1]); ?>/<?php echo rawurlencode($id_partage); ?>/dl/<?php echo rawurlencode($taille); ?>">
                    <i class="fas fa-arrow-down me-2"></i> Télécharger tout
                </a>
            <?php else: ?>
                <a class="btn-dl-modern" href="/actions/dlPhotos/<?php echo chemin_pour_url($chemin); ?>">
                    <i class="fas fa-shield-halved me-2"></i> ZIP Admin
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="photo-grid">
        <?php
        $listefichiers = $dossier->contenu_dossier($chemin, $data);
        foreach ($listefichiers as $index => $ligne) {
            $url = "/data/" . chemin_pour_url($chemin . "/" . $ligne);
            $url_js = htmlspecialchars(json_encode($url), ENT_QUOTES, 'UTF-8');
            $url_html = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
            echo '
            <div class="photo-item" onclick="openViewer('.$url_js.')">
                <img src="'.$url_html.'" loading="lazy" alt="Photo Abeille">
            </div>';
        }
        ?>
    </div>

</div>

<div id="viewer" class="fullscreen-viewer">
    <span class="close-viewer" onclick="closeViewer()">&times;</span>
    <div class="viewer-content">
        <img id="viewer-img" src="" alt="Zoom Photo">
    </div>
</div>

<script>
    function openViewer(url) {
        document.getElementById('viewer-img').src = url;
        document.getElementById('viewer').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Bloque le scroll
    }

    function closeViewer() {
        document.getElementById('viewer').style.display = 'none';
        document.body.style.overflow = 'auto'; // Libère le scroll
    }

    // Fermeture avec la touche Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeViewer();
    });

    // Animation au téléchargement
    $("#bouton-dl").click(function() {
        $(this).html('<i class="fas fa-circle-notch fa-spin me-2"></i> Création du ZIP...');
    });
</script>
