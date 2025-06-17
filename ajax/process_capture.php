<?php
// Turn on error reporting for debugging (REMOVE IN PRODUCTION)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

error_log("process_capture.php: Script started."); // DEBUG

// Set the content type for JSON response
header('Content-Type: application/json');

error_log("process_capture.php: Headers sent."); // DEBUG

// Ensure the script is only accessible via POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("process_capture.php: Method Not Allowed (Non-POST request)."); // DEBUG
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed.']);
    exit();
}

// Get data sent from the frontend via AJAX
$videoUrl = $_POST['video_url'] ?? '';      // e.g., /data/2025/06%20JUIN/14/video.mp4
$captureTime = $_POST['capture_time'] ?? 0; // e.g., 30 (seconds)

error_log("process_capture.php: Inputs received - videoUrl: " . $videoUrl . ", captureTime: " . $captureTime); // DEBUG

// --- Initial Validation of Input ---
if (empty($videoUrl)) {
    error_log("process_capture.php: Error - No video URL provided."); // DEBUG
    echo json_encode(['success' => false, 'message' => 'No video URL provided for capture.']);
    exit();
}
$captureTime = floatval($captureTime);
if ($captureTime < 0) {
    error_log("process_capture.php: Error - Invalid capture time provided."); // DEBUG
    echo json_encode(['success' => false, 'message' => 'Invalid capture time provided. Must be a positive number.']);
    exit();
}

error_log("process_capture.php: Inputs validated."); // DEBUG

// --- Define Server Paths ---
// !! IMPORTANT: CONFIRM THESE PATHS ON YOUR SERVER !!
$baseMountPath = '/var/www/html/data';
$outputPathDir = '/var/www/html/captures/'; // Ensure this path ends with a slash
$captureScriptPath = '/var/www/html/scripts/process_capture.sh';

// !! NEW: PATH TO YOUR WATERMARK IMAGE !!
$watermarkImagePath = '/var/www/html/captures/abeille.png'; // <--- CHANGE THIS TO YOUR ACTUAL WATERMARK PATH

// Check if watermark image exists and is readable
if (!file_exists($watermarkImagePath) || !is_readable($watermarkImagePath)) {
    error_log(__FILE__ . ": Watermark image not found or not readable at: " . $watermarkImagePath);
    echo json_encode(['success' => false, 'message' => 'Watermark image not found or not readable on the server. (Code: WM-001)']);
    exit();
}
error_log("process_capture.php: Watermark image path verified: " . $watermarkImagePath); // DEBUG


error_log("process_capture.php: Defined paths - baseMountPath: " . $baseMountPath . ", outputPathDir: " . $outputPathDir . ", captureScriptPath: " . $captureScriptPath); // DEBUG

// --- Map Web URL to Server File System Path for Input Video ---
$relativePath = str_replace('/data/', '', $videoUrl);
$decodedRelativePath = rawurldecode($relativePath);
$videoFilePath = $baseMountPath . '/' . $decodedRelativePath;

error_log("process_capture.php: Constructed videoFilePath: " . $videoFilePath); // DEBUG

// --- Verify Input Video File Existence and Accessibility ---
$resolvedVideoFilePath = realpath($videoFilePath);

if ($resolvedVideoFilePath === false || !file_exists($resolvedVideoFilePath)) {
    $debugMessage = 'Input video file not found on server or could not be accessed. Attempted path: "' . $videoFilePath . '". Resolved path: "' . ($resolvedVideoFilePath === false ? 'false (path not found/accessible)' : $resolvedVideoFilePath) . '".';
    error_log(__FILE__ . ": " . $debugMessage);
    echo json_encode(['success' => false, 'message' => 'Input video file not found or could not be accessed on the server. Please check server logs for details. (Code: VF-001)']);
    exit();
}
$videoFilePath = $resolvedVideoFilePath;

error_log("process_capture.php: Video file resolved to: " . $videoFilePath); // DEBUG

// --- Setup Output Directory for Captured Images ---
if (!is_dir($outputPathDir)) {
    error_log("process_capture.php: Output directory " . $outputPathDir . " does not exist. Attempting to create."); // DEBUG
    if (!mkdir($outputPathDir, 0775, true)) {
        error_log(__FILE__ . ": Failed to create capture directory: " . $outputPathDir);
        echo json_encode(['success' => false, 'message' => 'Failed to create capture directory on server. Check server permissions. (Code: CD-001)']);
        exit();
    }
    error_log("process_capture.php: Output directory created."); // DEBUG
}
if (!is_writable($outputPathDir)) {
    error_log(__FILE__ . ": Capture directory not writable: " . $outputPathDir);
    echo json_encode(['success' => false, 'message' => 'Capture directory on server is not writable. Check server permissions. (Code: CD-002)']);
    exit();
}

error_log("process_capture.php: Output directory verified/writable."); // DEBUG

// --- NEW LOGIC: Delete existing .jpg files in the capture folder ---
error_log("process_capture.php: Attempting to delete existing .jpg files in " . $outputPathDir); // DEBUG
try {
    $files = glob($outputPathDir . '*.jpg'); // Get all .jpg files
    if ($files === false) {
        throw new Exception("Failed to read directory contents for deletion.");
    }
    foreach ($files as $file) {
        if (is_file($file)) { // Ensure it's a file, not a directory
            if (unlink($file)) {
                error_log("process_capture.php: Deleted file: " . $file); // DEBUG
            } else {
                error_log("process_capture.php: Failed to delete file: " . $file); // DEBUG - Log but don't stop execution
            }
        }
    }
    error_log("process_capture.php: Finished attempting to delete existing .jpg files."); // DEBUG
} catch (Exception $e) {
    error_log(__FILE__ . ": Error during file deletion: " . $e->getMessage());
    // Decide if you want to fail here or proceed. For now, we'll log and proceed.
    // echo json_encode(['success' => false, 'message' => 'Error during cleanup of old images. (Code: CL-001)']);
    // exit();
}
// --- END NEW LOGIC ---

// --- Check Capture Script Existence and Executability ---
if (!file_exists($captureScriptPath) || !is_executable($captureScriptPath)) {
    error_log(__FILE__ . ": Capture script not found or not executable at: " . $captureScriptPath);
    echo json_encode(['success' => false, 'message' => 'Server capture script not found or not executable. Please check server paths and permissions. (Code: CS-001)']);
    exit();
}

error_log("process_capture.php: Capture script verified."); // DEBUG

// --- Generate Unique Filename and Public URL for Captured Image ---
$uniqueKey = uniqid('capture_');
$publicImageUrl = '/captures/' . $uniqueKey . '.jpg';

error_log("process_capture.php: Generated unique key: " . $uniqueKey . ", publicImageUrl: " . $publicImageUrl); // DEBUG

// --- Build and Execute the FFmpeg Command via the Bash Script ---
// Now passing the watermark image path as an additional argument ($5)
$command = $captureScriptPath . ' ' .
            escapeshellarg($videoFilePath) . ' ' .
            escapeshellarg($captureTime) . ' ' .
            escapeshellarg($outputPathDir) . ' ' .
            escapeshellarg($uniqueKey) . ' ' .
            escapeshellarg($watermarkImagePath) . // <--- NEW ARGUMENT
            ' 2>&1'; // Redirect stderr to stdout for full FFmpeg output/errors

error_log("process_capture.php: Executing command: " . $command); // DEBUG

$output = [];
$returnCode = 0;
exec($command, $output, $returnCode);

error_log("process_capture.php: Command executed. Return code: " . $returnCode . ", Output: " . implode("\n", $output)); // DEBUG

// --- Check Result of Capture ---
if ($returnCode === 0) {
    // The actual filename of the captured image (e.g., 'capture_abc.jpg')
    $capturedFilename = $uniqueKey . '.jpg';

    error_log("process_capture.php: Capture successful. Sending success response with filename: " . $capturedFilename); // DEBUG
    echo json_encode([
        'success' => true,
        'image_url' => $publicImageUrl, // This is the web-accessible URL (e.g., /captures/capture_abc.jpg)
        'filename' => $capturedFilename // <--- ADD THIS LINE! This is what your JS expects
    ]);
} else {
    $errorMessage = 'Image capture failed due to FFmpeg/script error.';
    $details = implode("\n", $output);
    error_log(__FILE__ . ": " . $errorMessage . " Command: " . $command . "\nOutput: " . $details);
    echo json_encode([
        'success' => false,
        'message' => 'Image capture failed. Please check server logs for FFmpeg output. (Code: FC-001)',
        // 'details' => $details // Uncomment for more details during development
    ]);
}

error_log("process_capture.php: Script finished."); // DEBUG

?>