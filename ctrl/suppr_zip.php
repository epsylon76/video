<?php
$total = 0;


$zipfolder = './zip/';

// Construct the iterator
$it = new RecursiveDirectoryIterator($zipfolder);

// Loop through files
foreach (new RecursiveIteratorIterator($it) as $file) {
  if ($file->getExtension() == 'zip') {
    $total += filesize($file);
    //echo $file;
    if (time() - filemtime($file) > 1814400) {    //PLUS ANCIEN
      unlink($file);
      //echo ' ancien ';
    }
    //echo '<br/>';
  }
}

header('location: ?page=stats');
