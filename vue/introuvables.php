<div class="container-fluid px-md-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-exclamation-triangle text-warning me-2"></i>Partages introuvables
            </h1>
            <p class="text-muted mb-0">Ces partages pointent vers des fichiers ou dossiers qui n'existent plus sur le disque.</p>
        </div>

        <div class="d-flex gap-2">
            <button type="button" id="scan-introuvables" class="btn btn-outline-primary rounded-pill shadow-sm">
                <i class="fas fa-rotate me-1"></i> Analyser
            </button>
            <?php if($introuvable): ?>
                <a href="/actions/clearIntrouvables/"
                   class="btn btn-danger rounded-pill shadow-sm"
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer TOUS les partages invalides connus ?');">
                    <i class="fas fa-broom me-1"></i> Tout nettoyer
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div id="scan-status" class="alert alert-light border d-none" role="status"></div>

    <?php if($introuvable): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0"> <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">ID</th>
                                <th>Chemin du fichier / dossier</th>
                                <th style="width: 180px;">Dernière analyse</th>
                                <th class="text-end pe-4" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($introuvable as $ligne): ?>
                                <tr>
                                    <td class="ps-4 text-muted small">#<?php echo $ligne['id']; ?></td>
                                    <td>
                                        <code class="text-break text-danger bg-light px-2 py-1 rounded small">
                                            <?php echo htmlspecialchars($ligne['chemin']); ?>
                                        </code>
                                    </td>
                                    <td class="text-muted small">
                                        <?php
                                            $checked_at = new DateTime($ligne['checked_at']);
                                            echo $checked_at->format('d/m/Y H:i');
                                        ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="/actions/unsetPartage/<?php echo $ligne['id']; ?>"
                                           class="btn btn-outline-danger btn-sm rounded-circle"
                                           title="Supprimer ce partage"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5 bg-white rounded-3 shadow-sm">
            <i class="fas fa-check-circle fa-4x text-success mb-3 opacity-25"></i>
            <h4 class="text-dark">Tout est en ordre !</h4>
            <p class="text-muted">Il n'y a aucun partage introuvable connu actuellement.</p>
            <a href="/admin/stats/" class="btn btn-primary mt-2">Retour aux statistiques</a>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('scan-introuvables');
    const status = document.getElementById('scan-status');

    if (!button || !status) {
        return;
    }

    button.addEventListener('click', function () {
        let lastId = 0;
        let checked = 0;
        let found = 0;

        button.disabled = true;
        status.classList.remove('d-none', 'alert-danger');
        status.classList.add('alert-light');
        status.textContent = 'Analyse en cours...';

        const scanBatch = function () {
            const body = new URLSearchParams();
            body.append('last_id', lastId);
            body.append('limit', 100);

            fetch('/actions/scanIntrouvables/', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: body.toString()
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Erreur HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(function (data) {
                    checked += Number(data.checked || 0);
                    found = Number(data.total_introuvables || found);
                    lastId = Number(data.last_id || lastId);
                    status.textContent = checked + ' partages vérifiés, ' + found + ' introuvables connus.';

                    if (data.done) {
                        window.location.reload();
                        return;
                    }

                    scanBatch();
                })
                .catch(function () {
                    button.disabled = false;
                    status.classList.remove('alert-light');
                    status.classList.add('alert-danger');
                    status.textContent = "L'analyse a été interrompue. Relancez-la dans un instant.";
                });
        };

        scanBatch();
    });
});
</script>
