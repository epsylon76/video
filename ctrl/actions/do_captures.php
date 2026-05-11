

<?php

//pr($_POST);
//cadence
$cadence = max(1, min(4, (int) $_POST['cadence']));
$base_resolue = realpath($data);
$fichier_source = realpath($_POST['file'] ?? '');

if ($base_resolue === false || $fichier_source === false || strpos($fichier_source, $base_resolue . DIRECTORY_SEPARATOR) !== 0) {
    http_response_code(404);
    die('Fichier introuvable ou non autorisé.');
}

//Destination

$dest = dirname($fichier_source) . '/photos/';
echo '<br>destination : ' . $dest;
if (!is_dir($dest)) {
    echo mkdir($dest) ? '<br/>dossier crée' : '<br/>impossible';
}

if (is_writeable($dest)) {
    echo '<br/> WRITABLE !';
}

//SOURCE
$video_array = glob(dirname($fichier_source) . '/{*.mp4,*.MP4}', GLOB_BRACE);

foreach ($video_array as $key => $vid) {
    //Commande avec sortie dans le néant et en tache de fond
    $command = escapeshellarg(__DIR__.'/../../scripts/captures.sh') . ' ' . escapeshellarg($vid) . ' ' . $cadence . ' ' . escapeshellarg($dest) . ' ' . (int) $key . ' > /dev/null 2>/dev/null &'; 
   
    echo '<br/>'.$command;
    $output = shell_exec($command); //Arguments passés sont  $1; $2; $3 dans le script Shell
}
//    /var/www/html/data/2024/07 JUILLET/12/1. Rousselet Pierre - Jack - np/Rush

$retour = chemin_relatif_normalise($_POST['retour'] ?? '');
header('location:/admin/dossiers/'.chemin_pour_url($retour));
