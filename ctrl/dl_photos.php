<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$folder = $partage->get_partage($_GET['dl_photos']);

$folder = $folder['chemin'];
//on retire le dernier slash de data
$data = rtrim($data, '/');

//on concatene
$folder = $data . $folder . '/';


$zipname = $_GET['cle'].$_GET['dl_photos'].'.zip';
$zipPath = './zip/'.$zipname;
//VERIFIER S'il n'existe pas déjà
if(!file_exists($zipPath)){

//SINON le créer
$commande = "7z a -mcp /var/www/html/zip/".$zipname." '".$folder."*'";
echo $commande;
$locale = 'fr_FR.UTF-8';
setlocale(LC_ALL, $locale);
putenv('LC_ALL='.$locale);
shell_exec($commande);

sleep(10);

}

header('location:/zip/'.$zipname);
