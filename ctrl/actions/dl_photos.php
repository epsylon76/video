<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Assume $uri, $partage, $stats, $data are defined elsewhere in your application.
// For debugging, ensure $data is correctly set to your photos root, e.g.:
// $data = '/path/to/your/photos_root/';

$folder = ''; // Initialize $folder
$zipname = 'photos.zip'; // Default zip name

if ($uri[0] == 'cle') { // mode client
    $folder_data = $partage->get_partage($uri[2]);
    if ($folder_data && isset($folder_data['chemin'])) {
        $folder = $folder_data['chemin'];
    } else {
        // Handle case where folder path is not found for the key
        die("Error: Client folder path not found for key " . htmlspecialchars($uri[2]));
    }
    // zipname will include a unique path for the client, e.g., 'key_id/photos.zip'
    $zipname = $uri[2] . $uri[1] . '/photos.zip';

    // adds the download to the database
    if (isset($stats) && method_exists($stats, 'set_stats')) {
        $stats->set_stats('dl_photos', date("Y-m-d H:i:s"), $uri[4] ?? 'unknown_user');
    }
} else { // admin mode or other
    $slices = array_slice($uri, 2);
    $chemin = '';
    foreach ($slices as $u) {
        $chemin .= $u . '/';
    }
    $chemin = rtrim($chemin, '/');
    $chemin = urldecode($chemin);
    $folder = $chemin;
    // $zipname remains 'photos.zip' as default
}

// Ensure $data is defined, or provide a sensible default/error
if (!isset($data)) {
    // This is a placeholder. REPLACE with your actual photo data root path.
    $data = '/var/www/html/your_actual_photo_data_root/';
    error_log("Warning: \$data variable was not explicitly set. Using fallback: " . $data);
}

echo "Base data path: " . htmlspecialchars($data) . "<br>";
echo "Folder (relative to data path): " . htmlspecialchars($folder) . "<br>";

if (!empty($folder)) { // prevents zipping from root
    // Concatenate the full source path for 7z
    $full_source_folder_path = $data . $folder . '/';

    // Define the base directory for all zips
    $base_zip_output_dir = '/var/www/html/zip/';

    // Construct the full path to the specific zip file
    // dirname($zipname) will correctly handle 'key_id/photos.zip' or just 'photos.zip'
    $target_zip_directory = $base_zip_output_dir . dirname($zipname);
    $zipCheck = $target_zip_directory . '/' . basename($zipname);

    echo "Full source folder path: " . htmlspecialchars($full_source_folder_path) . "<br>";
    echo "Target zip directory: " . htmlspecialchars($target_zip_directory) . "<br>";
    echo "Full zip file path: " . htmlspecialchars($zipCheck) . "<br>";

    // --- IMPORTANT: CREATE THE DIRECTORY IF IT DOES NOT EXIST ---
    if (!is_dir($target_zip_directory)) {
        echo "Attempting to create directory: " . htmlspecialchars($target_zip_directory) . "<br>";
        // Use mkdir with recursive=true to create parent directories if they don't exist
        // 0775 is a common permission: owner rwx, group rwx, others rx
        if (!mkdir($target_zip_directory, 0775, true)) {
            // If mkdir fails, it's almost always a permissions issue or an invalid path
            die("ERROR: Failed to create target zip directory: " . htmlspecialchars($target_zip_directory) . ". Please check file permissions for its parent directory and the path itself.");
        }
        echo "Successfully created directory: " . htmlspecialchars($target_zip_directory) . "<br>";
    } else {
        echo "Target zip directory already exists: " . htmlspecialchars($target_zip_directory) . "<br>";
    }
    // --- END OF DIRECTORY CREATION ---


    if (!file_exists($zipCheck) || $uri[0] != 'cle') { // Créer si le fichier n'existe pas OU si nous sommes en mode admin (écraser)

        // Vérifier si le fichier existe et si nous sommes en mode admin.
        // Si c'est le cas, supprimer le fichier zip existant.
        if (file_exists($zipCheck) && $uri[0] != 'cle') {
            echo "Mode administrateur détecté. Suppression du fichier zip existant : " . htmlspecialchars($zipCheck) . "<br>";
            if (!unlink($zipCheck)) {
                // Enregistrer une erreur si la suppression échoue
                error_log("Échec de la suppression du fichier zip existant : " . $zipCheck);
                die("Impossible de supprimer l'ancien fichier zip. Veuillez vérifier les permissions du fichier.");
            }
        }

        // Trouver le chemin complet de 7z. Exécutez `which 7z` sur votre terminal serveur.
        $path_to_7z = '/usr/bin/7z'; // IMPORTANT : VÉRIFIEZ CE CHEMIN SUR VOTRE SERVEUR !

        // Construire la commande 7z de manière sécurisée en utilisant escapeshellarg
        // Cette commande va zipper le *contenu* du dossier $full_source_folder_path
        $command = $path_to_7z . " a -mcp " . escapeshellarg($zipCheck) . " " . escapeshellarg($full_source_folder_path . '*');

        echo "Exécution de la commande 7z : " . htmlspecialchars($command) . "<br>";

        // Définir la locale pour 7z pour une gestion correcte des noms de fichiers
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);

        $output = [];
        $returnValue = null;
        exec($command, $output, $returnValue); // Utiliser exec pour capturer la sortie et la valeur de retour

        echo "Sortie de la commande 7z :<br>";
        echo "<pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";
        echo "Valeur de retour de 7z : " . $returnValue . "<br>";

        if ($returnValue === 0) {
            echo "Fichier zip créé avec succès : " . htmlspecialchars($zipCheck) . "<br>";
        } else {
            echo "ERREUR : 7z n'a pas réussi à créer le fichier zip. Code de retour : " . $returnValue . ". Voir la sortie ci-dessus pour plus de détails.<br>";
            error_log("7z a échoué. Commande : " . $command . " Sortie : " . implode("\n", $output) . " Retour : " . $returnValue);
            die("Impossible de créer le fichier zip. Veuillez contacter le support.");
        }
    } else {
        echo "Le fichier zip existe déjà et nous ne sommes pas en mode admin. Création 7z ignorée.<br>";
    }
} else {
    echo "Folder path is empty. Zip generation prevented.<br>";
}

// NECESSITE LE PAQUET p7zip et p7zip-full

// Redirect only if the zip file actually exists
if (file_exists($zipCheck)) {
    // Make sure the HTTP header is relative to the web root
    $redirect_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $zipCheck);
    // Ensure it starts with a slash
    if (substr($redirect_path, 0, 1) !== '/') {
        $redirect_path = '/' . $redirect_path;
    }
    echo "Redirecting to: " . htmlspecialchars($redirect_path) . "<br>"; // For debugging
    header('location:' . $redirect_path);
    exit; // Always exit after a header redirect
} else {
    echo "ERROR: Zip file was not found after creation attempt. Cannot redirect.<br>";
}
