<?php
$target_dir = "../vue/img/";

if(file_exists("../vue/img/invitation.jpg")){
  unlink("../vue/img/invitation.jpg");
}


$target_file = $target_dir . basename($_FILES["invitation"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["invitation"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["invitation"]["size"] > 8000000) {
    echo "Désolé, le fichier est trop gros.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" ) {
    echo "Erreur, seul les fichiers jpg sont autorisés.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Votre fichier n'a pas été envoyé.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["invitation"]["tmp_name"], $target_dir.'invitation.jpg')) {
        echo "Le fichier ". basename( $_FILES["invitation"]["name"]). " a été envoyé.";
        header('location: ../?page=parametres');
    } else {
        echo "Désolé, il y a eu une erreur";
    }
}
?>
