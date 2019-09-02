<?php

unlink("../vue/img/banniere.mp4");

if(isset($_POST)){
  if(isset($_FILES['file'])){
    $errors= array();
    $file_name = $_FILES['file']['name'];
    $file_size =$_FILES['file']['size'];
    $file_tmp =$_FILES['file']['tmp_name'];
    $file_type=$_FILES['file']['type'];

    //print_r($_FILES['file']['name']);

    $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);


    //$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));

    $expensions= array("mp4");

    if(in_array($file_ext,$expensions)=== false){
      $errors[]="extension not allowed, please choose a MP4...";
    }

    if($file_size > 80000000){
      $errors[]='Limite 80 MB';
    }


    //print_r($file_tmp); exit;
    if(empty($errors)==true){

      if (move_uploaded_file($_FILES['file']["tmp_name"], '../vue/img/banniere.mp4')) {
        echo "Le fichier a été envoyé.";
        header('location: /?page=parametres');
      } else {
        echo "Not uploaded because of error #".$_FILES["file"]["error"];
        /*
        UPLOAD_ERR_INI_SIZE = Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.
        UPLOAD_ERR_FORM_SIZE = Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.
        UPLOAD_ERR_PARTIAL = Value: 3; The uploaded file was only partially uploaded.
        UPLOAD_ERR_NO_FILE = Value: 4; No file was uploaded.
        UPLOAD_ERR_NO_TMP_DIR = Value: 6; Missing a temporary folder. Introduced in PHP 5.0.3.
        UPLOAD_ERR_CANT_WRITE = Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.        
        UPLOAD_ERR_EXTENSION = Value: 8; A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.
        */

      }

    }else{
      print_r($errors);
    }
  }
}
