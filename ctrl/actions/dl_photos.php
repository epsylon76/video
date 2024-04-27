<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// include_once('ctrl/photos.php');

if ($uri[0] == 'cle') { //mode client
    $folder = $partage->get_partage($uri[2]);
    $folder = $folder['chemin'];
    $zipname = $uri[2] . $uri[1] . '.zip';

    // ajoute le téléchargement dans la base de donné 
    $stats->set_stats('téléchargement_photos', date("Y-m-d H:i:s"), $_SESSION['taille']);
} else {
    $slices = array_slice($uri, 3);
    $chemin = '';
    foreach ($slices as $u) {
        $chemin .= $u . '/';
    }
    $chemin = rtrim($chemin, '/');
    $chemin = urldecode($chemin);
    $folder = $chemin;
    $zipname = $uri[2] . '.zip';
}

echo $data . $folder . '/';

if (!empty($folder)) { //empeche la génération d'un zip à la racine
   
    //on concatene
    $folder = $data . $folder . '/';
    $zipCheck = './zip/' . $zipname;

    
    if (!file_exists($zipCheck) || $uri[0] != 'cle') { //On ne le crée que si le fichier n'existe pas déjà  OU en mode admin on réécrit par dessus "DlPhotos.zip"
        //SINON le créer
        $commande = "7z a -mcp " . $zipCheck . " '" . $folder . "*'";
        echo $commande;
        $locale = 'fr_FR.UTF-8';
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);
        shell_exec($commande);

        sleep(10);
    }
} 
header('location:/zip/' . $zipname);
