<?php
// Set the content type for JSON response
header('Content-Type: application/json');

// Ensure the script is only accessible via POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed.']);
    exit();
}

// Get the video URL from the AJAX request (e.g., /data/2025/06%20JUIN/14/video.mp4)
$videoUrl = $_POST['video_url'] ?? '';

// Validate the incoming data
if (empty($videoUrl)) {
    echo json_encode(['success' => false, 'message' => 'No video URL provided.']);
    exit();
}

// --- Map Web URL to Server File System Path ---
// Your web server's DocumentRoot is likely /var/www/html/
// And your videos are served from /var/www/html/data/
$baseMountPath = '/var/www/html/data'; // !! IMPORTANT: CONFIRM THIS IS YOUR ACTUAL SMB MOUNT POINT !!

// Remove the '/data/' prefix from the URL to get the relative path within your data directory
// Example: "/data/2025/06%20JUIN/video.mp4" becomes "2025/06%20JUIN/video.mp4"
$relativePath = str_replace('/data/', '', $videoUrl);

// --- CRITICAL STEP: URL-decode the relative path for filesystem access ---
// The $videoUrl from JavaScript is URL-encoded (%20 for spaces).
// Filesystem paths use actual spaces, not %20.
// rawurldecode() is the inverse of rawurlencode() (which was used in your PHP for the <option> value).
$decodedRelativePath = rawurldecode($relativePath); // Example: "2025/06 JUIN/video.mp4"

// Construct the full filesystem path using the DECODED path
$videoFilePath = $baseMountPath . '/' . $decodedRelativePath;

// --- Verify File Existence and Permissions ---
// realpath() resolves symbolic links and checks if the path exists.
// It returns the absolute canonicalized filesystem path or false on failure.
$resolvedVideoFilePath = realpath($videoFilePath);

if ($resolvedVideoFilePath === false || !file_exists($resolvedVideoFilePath)) {
    // Log detailed error for debugging on the server side
    $debugMessage = 'Video file not found on server. Attempted path: "' . $videoFilePath . '". Resolved path: "' . ($resolvedVideoFilePath === false ? 'false (path not found/accessible)' : $resolvedVideoFilePath) . '".';
    error_log(__FILE__ . ": " . $debugMessage); // Log to PHP error log (e.g., /var/log/apache2/error.log)

    // Send a user-friendly error message to the client
    echo json_encode([
        'success' => false,
        'message' => 'Video file not found on server or could not be accessed. Please check server logs for details.',
        // Optionally, include details for development, but remove for production
        // 'details' => $debugMessage
    ]);
    exit();
}

// If we reach here, $resolvedVideoFilePath is the verified, absolute filesystem path.
// Use this path for ffprobe/ffmpeg.
$videoFilePath = $resolvedVideoFilePath;

// --- FFprobe Configuration ---
// Full path to the FFprobe executable on your VM
// Verify this path with 'which ffprobe' in your VM's terminal
$ffprobePath = '/usr/bin/ffprobe'; // !! IMPORTANT: CONFIRM THIS PATH ON YOUR SERVER !!

// Check if ffprobe executable exists and is executable
if (!file_exists($ffprobePath) || !is_executable($ffprobePath)) {
    error_log(__FILE__ . ": FFprobe not found or not executable at: " . $ffprobePath);
    echo json_encode(['success' => false, 'message' => 'Server FFprobe tool not found or not executable.']);
    exit();
}

// --- Construct the FFprobe Command ---
// -v error: Suppress verbose output, only show errors
// -show_entries format=duration: Show only the duration field from format section
// -of default=noprint_wrappers=1:nokey=1: Output in a simple format, no wrappers, no key name
// escapeshellarg() is CRUCIAL for security! Never pass raw user input to shell commands.
$command = $ffprobePath . ' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . escapeshellarg($videoFilePath) . ' 2>&1'; // Redirect stderr to stdout to capture all output

// --- Execute the FFprobe Command ---
$output = [];    // Array to store output lines from the command
$returnCode = 0; // Return code of the command (0 for success)
exec($command, $output, $returnCode);

// Check FFprobe's return code and output to determine success or failure
if ($returnCode === 0 && !empty($output[0])) {
    $duration = floatval($output[0]); // Convert the output (which is a string) to a float
    echo json_encode(['success' => true, 'duration' => $duration]);
} else {
    // FFprobe command failed or didn't return a duration
    $errorMessage = 'Failed to get video duration from FFprobe.';
    $details = implode("\n", $output);
    error_log(__FILE__ . ": " . $errorMessage . " Command: " . $command . "\nOutput: " . $details);

    echo json_encode([
        'success' => false,
        'message' => $errorMessage . ' Please check server logs for details.',
        // 'details' => $details // Optionally include for development, remove for production
    ]);
}

?>