<?php

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['filename']) && !empty($_POST['filename'])) {
        $filename = basename($_POST['filename']); // Sanitize filename to prevent directory traversal
        
        $sourceDir = '/var/www/html/captures/';
        $destinationDir = '/var/www/html/validated_captures/';

        $sourcePath = $sourceDir . $filename;
        $destinationPath = $destinationDir . $filename;

        // Check if the source file exists
        if (!file_exists($sourcePath)) {
            $response['message'] = "Source file does not exist: " . $sourcePath;
            error_log("Validate Capture Error: " . $response['message']);
        } elseif (!is_writable($sourceDir)) {
            $response['message'] = "Source directory not writable: " . $sourceDir;
            error_log("Validate Capture Error: " . $response['message']);
        } elseif (!is_writable($destinationDir)) {
            $response['message'] = "Destination directory not writable: " . $destinationDir;
            error_log("Validate Capture Error: " . $response['message']);
        } else {
            // Attempt to move the file
            if (rename($sourcePath, $destinationPath)) {
                $response['success'] = true;
                $response['message'] = "Image '" . $filename . "' validated and moved.";
            } else {
                $response['message'] = "Failed to move image '" . $filename . "'. Check permissions for " . $sourcePath . " and " . $destinationDir;
                error_log("Validate Capture Error: " . $response['message'] . " from " . $sourcePath . " to " . $destinationPath);
            }
        }
    } else {
        $response['message'] = "Filename not provided.";
    }
} else {
    $response['message'] = "Invalid request method. Only POST is allowed.";
}

echo json_encode($response);
?>