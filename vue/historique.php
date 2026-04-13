<div class="container-fluid px-md-4 py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-history me-2 text-primary"></i>Tableau historique</h2>
            <p class="text-muted mb-0">Historique des 500 derniers événements</p>
        </div>
        <span class="badge rounded-pill bg-light text-dark border shadow-sm px-3 py-2">
            Total : <?php echo count($liste_historique); ?>
        </span>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 180px;">Date & Heure</th>
                        <th style="width: 60px;">Action</th>
                        <th>Chemin / Information</th>
                        <th>Email / Utilisateur</th>
                        <th class="text-end pe-3">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($liste_historique as $ligne) {
                        // Configuration des styles par action
                        $badge_class = "text-bg-secondary"; // Par défaut
                        $icone = '<i class="fas fa-info-circle"></i>';

                        switch ($ligne['action']) {
                            case "dl_video":
                                $badge_class = "text-bg-primary";
                                $icone = '<i class="fas fa-download me-1"></i><i class="fas fa-video"></i>';
                                break;
                            case "dl_photos":
                                $badge_class = "text-bg-primary";
                                $icone = '<i class="fas fa-download me-1"></i><i class="fas fa-camera"></i>';
                                break;
                            case "dl_dossier":
                                $badge_class = "text-bg-primary";
                                $icone = '<i class="fas fa-download me-1"></i><i class="fas fa-file-archive"></i>';
                                break;
                            case "set_partage":
                                $badge_class = "text-bg-success";
                                $icone = '<i class="fas fa-share-alt"></i>';
                                break;
                            case "unset_partage":
                                $badge_class = "text-bg-danger";
                                $icone = '<i class="fas fa-trash"></i>';
                                break;
                            case "login_admin":
                                $badge_class = "text-bg-warning";
                                $icone = '<i class="fas fa-sign-in-alt"></i>';
                                break;
                            case "clear_introuvables":
                                $badge_class = "text-bg-warning";
                                $icone = '<i class="fas fa-broom"></i>';
                                $ligne['partage_chemin'] = 'Effacement des partages introuvables';
                                break;
                        }

                        $date = new DateTime($ligne['date']);
                        $date_aff = $date->format('d/m/Y H:i');
                    ?>
                        <tr>
                            <td class="ps-3 fw-bold text-muted" style="font-size: 0.9rem;">
                                <?php echo $date_aff; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge <?php echo $badge_class; ?> p-2" title="<?php echo $ligne['action']; ?>">
                                    <?php echo $icone; ?>
                                </span>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 400px;" title="<?php echo $ligne['partage_chemin']; ?>">
                                    <?php echo $ligne['partage_chemin']; ?>
                                </div>
                            </td>
                            <td>
                                <span class="text-primary" style="font-size: 0.9rem;"><?php echo $ligne['email']; ?></span>
                            </td>
                            <td class="text-end pe-3">
                                <span class="badge bg-light text-dark border fw-normal"><?php echo $ligne['admin_login']; ?></span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>