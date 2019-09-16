<?php
ini_set('max_execution_time', 300);
$folder = $partage->get_partage($_GET['dl_photos']);

$folder = $folder['chemin'];
//on retire le dernier slash de data
$data=rtrim($data, '/');

//on concatene
$folder=$data.$folder.'/';


$i=0;
if ($handle = opendir($folder)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && $entry != "Thumbs.db") {
            $liste[$i]=$entry;
            $i++;
        }
    }
    closedir($handle);
}

use ZipStream\ZipStream;
# Autoload the dependencies
require './vendor/autoload.php';

# create a new zipstream object
$zip = new ZipStream('photos.zip'); // à changer

foreach($liste as $file){
  $zip->addFileFromPath($file, $folder.$file);
}

# finish the zip stream
$zip->finish();
