<?php 
// --- LOGIQUE DU CONTRÔLEUR ---
$reste = $file_attente->reste('programme');
$now = date('Y-m-d H:i:s');

if ($params['depart_file'] <= $now) {
    if ($params['file_termine'] == 0) {
        // EN COURS
        $status_state = 'active';
        $status_label = 'Envoi en cours';
        $status_color = '#98fb98'; // lightgreen
        $status_icon = 'fa-sync fa-spin';
        $status_text = 'Le moteur d\'envoi est actuellement actif.';
    } else {
        // TERMINÉ
        $status_state = 'finished';
        $status_label = 'Session terminée';
        $status_color = '#add8e6'; // lightblue
        $status_icon = 'fa-check-circle';
        $status_text = 'Tous les emails de cette session ont été envoyés.';
    }
} else {
    // PROGRAMMÉ / EN ATTENTE
    $status_state = 'waiting';
    $status_label = 'Programmé';
    $status_color = '#ffa500'; // orange
    $status_icon = 'fa-clock';
    $status_text = 'En attente du déclenchement automatique.';
}
?>

<div class="container-fluid px-md-5 py-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Gestion des Envois</h1>
            <p class="text-muted small mb-0">
                <i class="far fa-clock me-1"></i> Heure système : <strong><?php echo date('d/m/Y H:i');?></strong>
            </p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-white text-dark border shadow-sm p-2 px-3 rounded-pill">
                  <div class="d-flex gap-2">
                         <span class="badge rounded-pill text-dark border px-3" style="background-color: #ffa500;">Attente</span>
                         <span class="badge rounded-pill text-dark border px-3" style="background-color: #98fb98;">En cours</span>
                         <span class="badge rounded-pill text-dark border px-3" style="background-color: #add8e6;">OK</span>
                    </div>
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="d-flex flex-column flex-lg-row">
                
                <div class="p-4 d-flex align-items-center justify-content-center text-center transition-all" 
                     style="background-color: <?php echo $status_color; ?>; min-width: 280px;">
                    <div>
                        <div class="status-icon-bg mb-3">
                            <i class="fas <?php echo $status_icon; ?> fa-3x text-dark opacity-75"></i>
                        </div>
                        <h3 class="h5 fw-black mb-1 text-dark text-uppercase"><?php echo $status_label; ?></h3>
                        <?php if ($status_state == 'active'): ?>
                            <div class="badge bg-dark text-white px-3 py-2 rounded-pill mt-2 shadow-sm">
                                <span class="h6 mb-0"><?php echo $reste; ?></span> emails restants
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-4 p-lg-5 flex-grow-1 bg-white">
                    <form action="/actions/set_envois" method="post">
                        <div class="row align-items-end g-3">
                            <div class="col-lg-8">
                                <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">
                                    Début des envois (Date & Heure)
                                </label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-0"><i class="far fa-calendar-plus text-muted"></i></span>
                                    <input type="datetime-local" 
                                           name="depart_file" 
                                           class="form-control bg-light border-0 fw-bold" 
                                           value="<?php echo str_replace(' ', 'T', $params['depart_file']); ?>" 
                                           required>
                                </div>
                                <div class="form-text mt-2 italic text-muted">
                                    <?php echo $status_text; ?>
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <button type="submit" class="btn btn-dark btn-lg w-100 py-3 rounded-3 shadow fw-bold">
                                    <i class="fas fa-save me-2 text-warning"></i>Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center px-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i>File d'attente</h5>
                  
                </div>
                <div class="table-responsive p-3">
                    <table id="liste" class="table table-hover align-middle w-100">
                        <thead class="table-light text-muted small uppercase">
                            <tr>
                                <th>Email</th>
                                <th>Date d'ajout</th>
                                <th>Type</th>
                                <th class="text-end">Statut</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white py-3 border-0 px-4">
                    <h5 class="mb-0 fw-bold text-danger"><i class="fas fa-redo-alt me-2"></i>Actions groupées</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="p-3 bg-light rounded-4 mb-4 border border-dashed">
                        <h6 class="fw-bold mb-3 small">Renvoi par date</h6>
                        <form action="/actions/renvoi_bulk" method="post">
                            <input type="date" name="date" class="form-control form-control-lg mb-3 border-0 shadow-sm" required>
                            
                            <div class="d-flex gap-3 mb-4 justify-content-center">
                                <div class="form-check form-check-inline custom-option">
                                    <input class="form-check-input" type="radio" name="immediat" id="chk_immediat" value="1">
                                    <label class="form-check-label fw-bold small" for="chk_immediat text-primary">IMMÉDIAT</label>
                                </div>
                                <div class="form-check form-check-inline custom-option">
                                    <input class="form-check-input" type="radio" name="immediat" id="chk_programme" value="0" checked>
                                    <label class="form-check-label fw-bold small" for="chk_programme text-muted">PROGRAMMÉ</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 rounded-3 fw-bold border-2">
                                <i class="fas fa-paper-plane me-2"></i>Lancer le renvoi
                            </button>
                        </form>
                    </div>
                    <div class="small text-muted text-center italic">
                        <i class="fas fa-info-circle me-1"></i> Cette action duplique les partages pour la date sélectionnée.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
    .fw-black { font-weight: 900; }
    .tracking-wider { letter-spacing: 0.05em; }
    .transition-all { transition: all 0.4s ease; }
    
    /* Style Spécifique au Pilot */
    .status-icon-bg {
        width: 80px; height: 80px; background: rgba(0,0,0,0.05);
        border-radius: 22px; display: inline-flex; align-items: center; justify-content: center;
    }
    
    /* Radios Custom */
    .custom-option .form-check-input:checked { background-color: #dc3545; border-color: #dc3545; }

    /* DataTable Overrides */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 50px; padding: 6px 15px; border: 1px solid #e2e8f0; outline: none;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #000 !important; color: white !important; border: none !important; border-radius: 8px;
    }
    
    /* Animation pulse si en cours */
    <?php if($status_state == 'active'): ?>
    .status-icon-bg { animation: pulse-green 2s infinite; }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.1); }
        70% { box-shadow: 0 0 0 15px rgba(0, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0); }
    }
    <?php endif; ?>
</style>

<script>
$(document).ready(function() {
    $('#liste').DataTable({
        "ajax": {
            "url": "/ajax/ajax_load_file.php",
            "type": "POST"
        },
        "columnDefs": [
            { "targets": 1, "type": "date-euro" },
            { "targets": 3, "className": "text-end" }
        ],
        "ordering": true,
        "order": [[1, 'desc']],
        "pageLength": 25,
        "dom": '<"d-flex justify-content-between mb-3"f>rt<"d-flex justify-content-between mt-3"ip>',
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        "drawCallback": function(settings) {
            // Optionnel : ajouter des tooltips ou formater des badges ici
        }
    });

    // Auto-refresh léger de la page toutes les 2 minutes pour l'heure système et le statut
    setTimeout(function() {
        location.reload();
    }, 120000);
});
</script>