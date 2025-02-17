<?php
$total = 0;


function rrmdir($src) {
  $dir = opendir($src);
  while(false !== ( $file = readdir($dir)) ) {
      if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.placeholder' )) {
          $full = $src . '/' . $file;
          if ( is_dir($full) ) {
              rrmdir($full);
          }
          else {
              unlink($full);
          }
      }
  }
  closedir($dir);
  rmdir($src);
}

$zipfolder = './zip/';

// Construct the iterator
$it = new RecursiveDirectoryIterator($zipfolder);

// Loop through files
foreach (new RecursiveIteratorIterator($it) as $file) {

  if ($file != $zipfolder.'.placeholder' && $file != $zipfolder.'.' && $file != $zipfolder.'..') {
    if(is_dir($file)){
      echo '<br>dossier : '.$file;
      rrmdir($file);
    }
  }
}

//header('location: /admin/stats/');
