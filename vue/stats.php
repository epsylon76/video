<div class="container-fluid px-md-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Statistiques Système</h1>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary btn-sm rounded-pill" href="/admin/stats/introuvables/">
                <i class="fas fa-search-location me-1"></i> Partages introuvables
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0 text-muted small text-uppercase fw-bold">Occupation Dossier ZIP</h5>
                        <span class="badge bg-light text-dark border"><?php echo $zipfoldersize; ?> utilisés</span>
                    </div>
                    
                    <div class="progress mb-2" style="height: 25px; border-radius: 50px; background-color: #e9ecef;">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                             role="progressbar" 
                             style="width: <?php echo $percent; ?>%; border-radius: 50px;">
                             <span class="fw-bold"><?php echo floor($percent); ?> %</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>0%</span>
                        <span>Espace libre : <strong><?php echo $free; ?></strong></span>
                        <span>100%</span>
                    </div>

                    <hr class="my-3 opacity-50">
                    
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="small mb-0 text-muted">Nettoyer les fichiers temporaires générés pour les téléchargements.</p>
                        <a class="btn btn-danger btn-sm px-3" href="/actions/supprZip/" onclick="return confirm('Vider tout le dossier ZIP ?');">
                            <i class="fas fa-trash-alt me-1"></i> Vider le dossier Zip
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <div class="display-6 fw-bold mb-0"><?php echo $clics; ?></div>
                    <div class="text-white-50 text-uppercase small fw-bold">Clics (24h)</div>
                    <hr class="my-3 border-white opacity-25">
                    <div class="h4 mb-0"><?php echo $clics_total; ?></div>
                    <div class="text-white-50 text-uppercase small fw-bold">Total Historique</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 text-muted small text-uppercase fw-bold">
                        <i class="fas fa-network-wired me-2 text-primary"></i>Analyse de la bande passante
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <?php include('./ctrl/bande_passante.php') ?>
                </div>
            </div>
        </div>
    </div>
</div>