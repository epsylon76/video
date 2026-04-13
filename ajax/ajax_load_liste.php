<?php
// Désactive l'affichage des erreurs pour ne pas corrompre le JSON
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

include_once('../config/dbconn.php');
include_once('../config/config.php');

$params = get_params();
$data_path = $params['dossier_data'];

// Requête SQL
$requete = "SELECT * FROM `partage` ORDER BY `id` DESC LIMIT 50000";
$query = $DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();

$items = [];

foreach ($results as $ligne) {
    // 1. Formatage de la date
    $date = new DateTime($ligne['date']);
    $date_aff = $date->format('d/m/Y H:i');

    // 2. RECONSTRUCTION DE L'URL (SÉCURISÉE POUR LES CARACTÈRES SPÉCIAUX)
    // On découpe le chemin par les slashes pour encoder chaque dossier séparément
    // Cela évite que les "/" deviennent des "%2F" (ce qui cause le 404)
    $segments = explode('/', $ligne['chemin']);
    $segments_encodes = array_map('rawurlencode', $segments);
    $chemin_url = implode('/', $segments_encodes);

    // 3. INITIALISATION DES VARIABLES
    $icone = '<i class="fas fa-file text-secondary"></i>&nbsp;'; 
    $link_start = ''; 
    $link_end = '</a>';

    // 4. LOGIQUE DE TYPE (AVEC LES NOUVELLES ICÔNES)
    if ($ligne['type_partage'] == "video") {
        $icone = '<i class="fas fa-video text-primary"></i>&nbsp;';
        $link_start = '<a href="/admin/video/' . $chemin_url . '/" class="text-decoration-none fw-medium">';
    } 
    elseif ($ligne['type_partage'] == "photos") {
        $icone = '<i class="fas fa-camera text-success"></i>&nbsp;';
        $link_start = '<a href="/admin/dossiers/' . $chemin_url . '/" class="text-decoration-none fw-medium">';
    } 
    elseif ($ligne['type_partage'] == "dossier") {
        $icone = '<i class="fas fa-folder text-warning"></i>&nbsp;';
        $link_start = '<a href="/admin/dossiers/' . $chemin_url . '/" class="text-decoration-none fw-medium">';
    } else {
        $link_start = '<span class="text-muted">';
        $link_end = '</span>';
    }

    // 5. CONSTRUCTION DE LA LIGNE POUR DATATABLES
    $row = [];
    $row[0] = $ligne['id'];
    $row[1] = $date_aff;
    
    // Colonne Chemin : Utilisation de text-truncate pour la propreté visuelle
    $row[2] = '<div class="text-truncate d-flex align-items-center" style="max-width:550px;" title="' . htmlspecialchars($ligne['chemin']) . '">' 
                . $icone . $link_start . htmlspecialchars($ligne['chemin']) . $link_end . 
             '</div>';

    // Colonne Email / Lien public (Badge stylisé)
    $row[3] = '<a href="/cle/' . $ligne['cle'] . '" target="_blank" class="badge bg-light text-dark border text-decoration-none shadow-sm">
                <i class="fas fa-external-link-alt me-1 opacity-50"></i>' . htmlspecialchars($ligne['email']) . 
              '</a>';
    
    // Colonne Admin
    $row[4] = '<span class="badge bg-secondary opacity-75 fw-normal">' . htmlspecialchars($ligne['admin_login']) . '</span>';
    
    // Colonne Actions (Boutons circulaires modernes)
    $row[5] = '<div class="text-end no-resize" style="min-width:100px;">
                <a href="/actions/renvoiMail/' . $ligne['id'] . '" class="btn btn-outline-primary btn-sm rounded-circle me-1 shadow-sm" title="Renvoyer le mail" data-bs-toggle="tooltip">
                    <i class="fas fa-paper-plane"></i>
                </a>
                <a href="/actions/unsetPartage/' . $ligne['id'] . '" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" title="Supprimer" data-bs-toggle="tooltip" onclick="return confirm(\'Supprimer définitivement ce partage ?\')">
                    <i class="fas fa-trash-alt"></i>
                </a>
              </div>';

    $items[] = $row;
}

// 6. ENVOI DU JSON PROPRE
header('Content-Type: application/json');
echo json_encode(["data" => $items]);
exit;