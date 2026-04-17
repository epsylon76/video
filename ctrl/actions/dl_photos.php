<?php
ini_set('max_execution_time', 300);

$folder = '';
$zipname = 'photos.zip';

if ($uri[0] == 'cle') { // mode client
    $folder_data = $partage->get_partage($uri[2]);
    if ($folder_data && isset($folder_data['chemin'])) {
        $folder = $folder_data['chemin'];
    } else {
        die("Erreur : dossier introuvable pour la clé " . htmlspecialchars($uri[2]));
    }
    $zipname = $uri[2] . $uri[1] . '/photos.zip';

    if (isset($stats) && method_exists($stats, 'set_stats')) {
        $stats->set_stats('dl_photos', date("Y-m-d H:i:s"), $uri[4] ?? 'unknown_user');
    }
} else { // mode admin
    $slices = array_slice($uri, 2);
    $chemin = '';
    foreach ($slices as $u) {
        $chemin .= $u . '/';
    }
    $chemin = rtrim($chemin, '/');
    $chemin = urldecode($chemin);
    $folder = $chemin;
}

if (!isset($data)) {
    die("Erreur : variable \$data non définie.");
}

if (!empty($folder)) {
    $full_source_folder_path = $data . $folder . '/';
    $base_zip_output_dir = $_SERVER['DOCUMENT_ROOT'] . '/zip/';

    $target_zip_directory = $base_zip_output_dir . dirname($zipname);
    $zipCheck = $target_zip_directory . '/' . basename($zipname);

    if (!is_dir($target_zip_directory)) {
        if (!mkdir($target_zip_directory, 0775, true)) {
            die("Erreur : impossible de créer le répertoire " . htmlspecialchars($target_zip_directory));
        }
    }

    if (!file_exists($zipCheck) || $uri[0] != 'cle') {
        if (file_exists($zipCheck) && $uri[0] != 'cle') {
            if (!unlink($zipCheck)) {
                die("Impossible de supprimer l'ancien fichier zip.");
            }
        }

        $path_to_7z = '/usr/bin/7z';
        $command = $path_to_7z . " a -mcp " . escapeshellarg($zipCheck) . " " . escapeshellarg($full_source_folder_path . '*');

        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);

        $output = [];
        $returnValue = null;
        exec($command, $output, $returnValue);

        if ($returnValue !== 0) {
            error_log("7z a échoué. Commande : " . $command . " Sortie : " . implode("\n", $output) . " Retour : " . $returnValue);
            die("Impossible de créer le fichier zip.");
        }
    }
}

if (isset($zipCheck) && file_exists($zipCheck)) {
    $redirect_path = str_replace($base_zip_output_dir, '/zip/', $zipCheck);
    if (substr($redirect_path, 0, 1) !== '/') {
        $redirect_path = '/' . $redirect_path;
    }
    header('Location: ' . $redirect_path);
    exit;
} else {
    die("Erreur : fichier zip introuvable après création.");
}
