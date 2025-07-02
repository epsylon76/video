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


    if (!file_exists($zipCheck) || $uri[0] != 'cle') { // Create if not exists OR in admin mode (overwrite)
        // Find the full path to 7z. Run `which 7z` on your server terminal.
        $path_to_7z = '/usr/bin/7z'; // IMPORTANT: VERIFY THIS PATH ON YOUR SERVER!

        // Construct the 7z command safely using escapeshellarg
        // This command will zip the *contents* of $full_source_folder_path
        $command = $path_to_7z . " a -mcp " . escapeshellarg($zipCheck) . " " . escapeshellarg($full_source_folder_path . '*');

        echo "Executing 7z command: " . htmlspecialchars($command) . "<br>";

        // Set locale for 7z for correct filename handling
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);

        $output = [];
        $returnValue = null;
        exec($command, $output, $returnValue); // Use exec to capture output and return value

        echo "7z Command Output:<br>";
        echo "<pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";
        echo "7z Return Value: " . $returnValue . "<br>";

        if ($returnValue === 0) {
            echo "Zip file created successfully: " . htmlspecialchars($zipCheck) . "<br>";
        } else {
            echo "ERROR: 7z failed to create zip file. Return code: " . $returnValue . ". See output above for details.<br>";
            error_log("7z failed. Command: " . $command . " Output: " . implode("\n", $output) . " Return: " . $returnValue);
            die("Could not create zip file. Please contact support.");
        }
    } else {
        echo "Zip file already exists and not in admin mode. Skipping 7z creation.<br>";
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

?>