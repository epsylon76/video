<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$folder = $_GET['dl_photos'];

//on retire le dernier slash de data
$folder = rtrim($folder, '/');

//on concatene
$folder = $data . $folder . '/';

echo 'dossier : '.$folder;

$zipname = 'photos.zip';
$zipPath = './zip/'.$zipname;
//VERIFIER S'il existe pas déjà, le supprimer avant
if(file_exists($zipPath)){
unlink($zipPath);
}


//SINON le créer
$commande = "7z a -mcp /var/www/html/zip/".$zipname." '".$folder."*'";
echo $commande;
$locale = 'fr_FR.UTF-8';
setlocale(LC_ALL, $locale);
putenv('LC_ALL='.$locale);
shell_exec($commande);

sleep(10);


header('location:/zip/'.$zipname);

