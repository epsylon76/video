<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$folder = $partage->get_partage($uri[2]);
$folder = $folder['chemin'];

//on retire le dernier slash de data
$data = rtrim($data, '/');

//on concatene
$folder = $data . $folder . '/';
$zipname = $uri[2].$uri[1].'.zip';

$zipCheck = './zip/'.$zipname;


//VERIFIER S'il n'existe pas déjà
if(!file_exists($zipCheck)){
//SINON le créer
$commande = "7z a -mcp ".$zipCheck." '".$folder."*'";
echo $commande;
$locale = 'fr_FR.UTF-8';
setlocale(LC_ALL, $locale);
putenv('LC_ALL='.$locale);
shell_exec($commande);

sleep(10);
}

header('location:/zip/'.$zipname);
