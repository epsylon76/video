<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReMarketing Non Prévues</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Optional: Add some basic styling if needed */
        .container {
            margin-top: 20px;
        }
        #capturedImage {
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #f8f8f8;
            max-width: 100%; /* Ensure image is responsive */
            height: auto;
            margin-top: 15px; /* Margin above buttons */
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
            margin-top: 15px; /* Margin above buttons */
        }
    </style>
</head>
<body>

<div class="container" id="main_container">
    <div class="row">
        <div class="col-12">
            <h1> ReMarketing Non Prévues </h1>
            <br>
            <h3><?php echo $chemin;?></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php
            // Ensure this path is correct relative to the script executing it
            if (!is_executable('scripts/process_capture.sh')) {
                echo '<h1 style="color:red;">Script de capture non executable !</h1><br/>';
            }

            // This function should be defined once to avoid redefinition errors
            if (!function_exists('human_filesize')) {
                function human_filesize($bytes, $decimals = 2)
                {
                    $factor = floor((strlen($bytes) - 1) / 3);
                    if ($factor > 0)
                        $sz = 'KMGT'; // Corrected to match common usage if needed
                    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
                }
            }

            // IMPORTANT: Ensure $video_array and $data are defined before this point.
            // If they are not defined via an include or previous logic, you'll need to define them here
            // or include a file that defines them. For example:
            // include 'path/to/your/video_list_data.php';

            // Example placeholders if they are not yet defined (remove if truly defined elsewhere)
            if (!isset($data)) {
                 $data = '/var/www/html/data/'; // This should be the base path *on the server* that corresponds to the /data/ web URL
            }
            if (!isset($video_array)) {
                // This is a dummy array for demonstration. Replace with your actual video list.
                $video_array = [
                    '/var/www/html/data/videos/sample_video_1.mp4',
                    '/var/www/html/data/videos/another_video_rush.mov',
                    // Add more video paths as needed
                ];
                //error_log("DEBUG: Using dummy \$video_array. Please ensure your \$video_array is properly loaded.");
            }

            ?>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <label for="select_rush">Sélectionner un rush vidéo:</label>
            <select id="select_rush" class="form-control">
                <?php
                foreach ($video_array as $key => $vid) {
                    // Ensure $data path is stripped correctly to get web-accessible path
                    // $vid is expected to be the full server path
                    $cleanVidPath = str_replace($data, '', $vid);
                    $pathSegments = explode('/', $cleanVidPath);
                    $encodedSegments = array_map('rawurlencode', $pathSegments);
                    $finalEncodedSourceUrl = '/data/' . implode('/', $encodedSegments); // Web accessible URL for AJAX
                    $fullUrlVid = $vid; // Use the full server path for filesize check
                    
                    $fileSize = file_exists($fullUrlVid) ? filesize($fullUrlVid) : 0;
                    echo '<option value="' . htmlspecialchars($finalEncodedSourceUrl) . '">' . htmlspecialchars(basename($vid)) . ' - ' . human_filesize($fileSize) . '</option>';
                } ?>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <label for="capture_time">Temps de capture (secondes): <span id="capture_time_val">0</span> s</label>
            <input type="range" class="form-control" id="capture_time" min="0" value="0">
            <small class="text-muted d-block mt-1">Durée totale: <span id="total_video_duration">00:00</span></small>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12 text-center">
            <button id="capture_button" class="btn btn-primary">Capturer l'Image</button>
            <div id="capture_result" class="mt-2"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12 text-center">
            <div id="capturedImageContainer" style="display:none;">
                <img id="capturedImage" src="" alt="Captured Image">
                <input type="email" placeholder="email de la personne" id="email_personne" class="form-input" />
                <div class="button-group">
                    <button id="validateButton" class="btn btn-success">Valider et envoyer l'email</button>
                </div>
                <p id="validationMessage" class="mt-2"></p>
                <p id="emailMessage" class="mt-2"></p> </div>
        </div>
    </div>

</div>

<div class="container" id="after_container" style="display:none">
    <h1>Envoi effectué !</h1>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Variables globales pour la durée de la vidéo et l'URL sélectionnée
    var currentVideoDuration = 0;
    var currentSelectedVideoUrl = '';

    // Helper function to format seconds into MM:SS or HH:MM:SS
    function formatTime(totalSeconds) {
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = Math.floor(totalSeconds % 60);

        const pad = (num) => String(num).padStart(2, '0');

        if (hours > 0) {
            return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
        } else {
            return `${pad(minutes)}:${pad(seconds)}`;
        }
    }


    // Function to handle the validation
    function validateImage(filename) {
        const validateButton = document.getElementById('validateButton');
        const validationMessage = document.getElementById('validationMessage');
        const emailMessage = document.getElementById('emailMessage'); // Added to show email status

        validateButton.disabled = true; // Prevent double clicks
        validationMessage.textContent = 'Validating...';
        emailMessage.textContent = ''; // Clear previous email messages

        const formData = new FormData();
        formData.append('filename', filename);

        fetch('/ajax/validate_capture.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                validationMessage.textContent = data.message;
                // --- NEW: Trigger email sending after successful validation ---
                sendEmail(filename); // Pass the filename to the sendEmail function
                
            } else {
                validationMessage.textContent = "Validation failed: " + data.message;
                validateButton.disabled = false; // Re-enable if validation fails
            }
        })
        .catch(error => {
            console.error('Error validating image:', error);
            validationMessage.textContent = "An error occurred during validation.";
            validateButton.disabled = false;
        });
    }

    // Function to handle sending email (now called by validateImage)
    function sendEmail(filename) {
        // No need to disable a button here, as it's not a direct user click
        const emailMessage = document.getElementById('emailMessage');
        const mailto = $('#email_personne').val();
        emailMessage.textContent = 'Envoi de l\'email en cours...'; // Update status for email

        const formData = new FormData();
        formData.append('filename', filename);
        formData.append('mailto', mailto);

        fetch('/ctrl/actions/send_rmnp_mail.php', { // Call the new PHP script
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                emailMessage.textContent = data.message;
                // Optionally, hide the entire container after sending email if done
                // document.getElementById('capturedImageContainer').style.display = 'none';
            } else {
                emailMessage.textContent = "Échec de l'envoi de l'email: " + data.message;
            }
            // After validation and email attempt, you might want to hide the container
            // or perform other cleanup actions.
            document.getElementById('capturedImageContainer').style.display = 'none';
            document.getElementById('capture_result').innerHTML = ''; // Clear the capture display
            $('#main_container').fadeOut();
            $('#after_container').fadeIn();
        })
        .catch(error => {
            console.error('Error sending email:', error);
            emailMessage.textContent = "Une erreur est survenue lors de l'envoi de l'email.";
            document.getElementById('capturedImageContainer').style.display = 'none'; // Hide on error
            document.getElementById('capture_result').innerHTML = ''; // Clear on error
        });
    }

    $(document).ready(function () {
        $('#select_rush').change(function () {
            currentSelectedVideoUrl = $(this).val();

            $.ajax({
                url: '/ajax/get_video_duration.php', // Path to your new PHP script
                type: 'POST',
                data: {
                    video_url: currentSelectedVideoUrl
                },
                success: function (response) {
                    if (response.success) {
                        currentVideoDuration = response.duration;
                        $('#capture_time').attr('max', Math.floor(currentVideoDuration));
                        $('#capture_time').val(0);
                        $('#capture_time_val').text(0);

                        $('#total_video_duration').text(formatTime(currentVideoDuration));
                        console.log("Video duration (from server):", currentVideoDuration, "seconds");
                    } else {
                        currentVideoDuration = 0;
                        $('#capture_time').attr('max', 0);
                        $('#capture_time').val(0);
                        $('#capture_time_val').text(0);

                        $('#total_video_duration').text('N/A');
                        console.error("Failed to get duration from server:", response.message);
                        alert("Erreur: Impossible d'obtenir la durée de la vidéo. " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    currentVideoDuration = 0;
                    $('#capture_time').attr('max', 0);
                    $('#capture_time').val(0);
                    $('#capture_time_val').text(0);

                    $('#total_video_duration').text('N/A');
                    console.error("AJAX Error getting duration:", status, error, xhr.responseText);
                    alert("Erreur de communication avec le serveur pour obtenir la durée.");
                }
            });
        });

        $('#capture_time').on('input', function () {
            var time = $(this).val();
            $('#capture_time_val').text(time);
        });

        // Trigger the initial change to load the first video's duration
        $('#select_rush').trigger('change');

        $('#capture_button').click(function () {
            var captureTime = $('#capture_time').val();

            if (!currentSelectedVideoUrl || currentVideoDuration === 0) {
                $('#capture_result').html('<p class="text-danger">Veuillez sélectionner une vidéo valide et attendre la durée.</p>');
                return;
            }

            // Hide previous results and disable buttons for a new capture
            document.getElementById('capturedImageContainer').style.display = 'none';
            document.getElementById('capturedImage').src = '';
            document.getElementById('validationMessage').textContent = '';
            document.getElementById('emailMessage').textContent = ''; // Clear email message
            document.getElementById('validateButton').disabled = true; // Start disabled


            $.ajax({
                url: '/ajax/process_capture.php',
                type: 'POST',
                data: {
                    video_url: currentSelectedVideoUrl,
                    capture_time: captureTime
                },
                beforeSend: function () {
                    $('#capture_result').html('<p>Capture en cours... <img src="loading.gif" alt="Loading"></p>');
                },
                success: function (response) {
                    if (response.success) {
                        $('#capture_result').html('<p>Capture réussie :</p>');
                        
                        const capturedImageContainer = document.getElementById('capturedImageContainer');
                        const capturedImage = document.getElementById('capturedImage');
                        const validateButton = document.getElementById('validateButton');
                        // const sendEmailButton = document.getElementById('sendEmailButton'); // REMOVED: No longer needed

                        capturedImage.src = response.image_url; // This URL should be like /captures/Capture_xyz.jpg
                        capturedImageContainer.style.display = 'block';

                        // Make sure validate button is clickable
                        validateButton.disabled = false; 
                        // sendEmailButton.disabled = true; // REMOVED: No longer needed

                        // Set filename for the validate button
                        validateButton.dataset.filename = response.filename;
                        // sendEmailButton.dataset.filename = response.filename; // REMOVED: No longer needed

                        // Attach event listener for the validate button
                        validateButton.onclick = null; // Clear previous handler
                        validateButton.onclick = function() {
                            validateImage(validateButton.dataset.filename);
                        };

                        // REMOVED: No longer need to attach onclick to sendEmailButton here
                        // sendEmailButton.onclick = null;
                        // sendEmailButton.onclick = function() {
                        //     sendEmail(sendEmailButton.dataset.filename);
                        // };

                    } else {
                        $('#capture_result').html('<p class="text-danger">Erreur de capture : ' + response.message + '</p>');
                        document.getElementById('capturedImageContainer').style.display = 'none'; // Hide if capture fails
                    }
                },
                error: function (xhr, status, error) {
                    $('#capture_result').html('<p class="text-danger">Erreur de communication avec le serveur : ' + error + '</p>');
                    document.getElementById('capturedImageContainer').style.display = 'none'; // Hide if capture fails
                    console.error("AJAX Error:", status, error, xhr.responseText);
                }
            });
        });
    });
</script>
</body>
</html>