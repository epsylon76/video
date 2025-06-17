<?php
// Turn on error reporting for debugging (REMOVE IN PRODUCTION)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

error_log("Script started.");

header('Content-Type: application/json');

// --- IMPORTANT: Include your mail_config.php ---
// Assuming mail_config.php is in the same directory as this script.
// Adjust path if it's elsewhere (e.g., '../mail_config.php' if it's in the parent folder).
require_once __DIR__ . '/../../config/mail_config.php';
// This will make the $mail object configured in mail_config.php available here.

// Your PHPMailer object is now available as $mail
// You already have:
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// (These are handled by mail_config.php if it's using 'use' statements)

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_POST['filename'] ?? '';

    // Define recipient(s) here. You can make this dynamic if needed.
    $recipientEmail = $_POST['mailto']; // <--- IMPORTANT: SET RECIPIENT EMAIL

    if (empty($filename)) {
        $response['message'] = 'Filename not provided.';
        error_log("send_capture_email.php: " . $response['message']);
        echo json_encode($response);
        exit();
    }

    // Determine the source directory of the image.
    // Assuming validated images are in /var/www/html/validated_captures/
    $imagePath = '/var/www/html/validated_captures/' . basename($filename);
    $templatePath = '/var/www/html/config/template_email/';
    // If you want to send *any* capture (not just validated ones) from the /captures/ folder:
    // $imagePath = '/var/www/html/captures/' . basename($filename);

    if (!file_exists($imagePath)) {
        $response['message'] = 'Image file not found: ' . $imagePath;
        error_log("send_capture_email.php: " . $response['message']);
        echo json_encode($response);
        exit();
    }

    try {
        // Clear any previous recipient/attachments from a previous use of the $mail object
        $mail->clearAllRecipients();
        $mail->clearAttachments();
        $mail->clearCustomHeaders();

        // Add recipients for THIS email
        $mail->addAddress($recipientEmail); // Add a recipient

        // Attachments
        // You can use AddEmbeddedImage if you want the image to show *inside* the email body (recommended)
        // AND addAttachment if you want it to also appear as a regular attachment
        //$mail->AddEmbeddedImage($imagePath, basename($filename), basename($filename)); // Embed for HTML body
        //$mail->addAttachment($imagePath, basename($filename)); // Add as a regular attachment

        // Content
        $mail->Subject = 'Les vidéos de votre saut !';

        //body
        $html = file_get_contents($templatePath . 'head.html');
        $html .= file_get_contents($templatePath . 'rmnp.html');
        $html .= file_get_contents($templatePath . 'footer.html');

        $captureUrl = 'http://video.abeilleparachutisme.fr/validated_captures/' . $filename;

        $html = str_replace('%HomeUrl%', 'https://www.abeilleparachutisme.fr', $html);
        $html = str_replace('%captureUrl%', $captureUrl, $html);
  
        $mail->Body = $html;

        $mail->send();
        $response['success'] = true;
        $response['message'] = 'Email sent successfully!';
        error_log("send_capture_email.php: Email sent successfully for: " . $filename);
    } catch (Exception $e) {
        $response['message'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        error_log("send_capture_email.php: Email Error: " . $response['message'] . " (Exception: " . $e->getMessage() . ")");
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit();
?>