<div class="container-fluid px-md-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-exclamation-triangle text-warning me-2"></i>Partages introuvables
            </h1>
            <p class="text-muted mb-0">Ces partages pointent vers des fichiers ou dossiers qui n'existent plus sur le disque.</p>
        </div>
        
        <?php if($introuvable): ?>
            <a href="/actions/clearIntrouvables/" 
               class="btn btn-danger rounded-pill shadow-sm" 
               onclick="return confirm('Êtes-vous sûr de vouloir supprimer TOUS les partages invalides ?');">
                <i class="fas fa-broom me-1"></i> Tout nettoyer
            </a>
        <?php endif; ?>
    </div>

    <?php if($introuvable): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0"> <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">ID</th>
                                <th>Chemin du fichier / dossier</th>
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
            <p class="text-muted">Il n'y a aucun partage introuvable actuellement.</p>
            <a href="/admin/stats/" class="btn btn-primary mt-2">Retour aux statistiques</a>
        </div>
    <?php endif; ?>
</div>