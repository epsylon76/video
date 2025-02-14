

<?php

//pr($_POST);
//cadence
$cadence = $_POST['cadence'];

//Destination

$dest = dirname($_POST['file']) . '/photos/';
echo '<br>destination : ' . $dest;
if (!is_dir($dest)) {
    echo mkdir($dest) ? '<br/>dossier crée' : '<br/>impossible';
}

if (is_writeable($dest)) {
    echo '<br/> WRITABLE !';
}

//SOURCE
$video_array = glob(dirname($_POST['file']) . '/{*.mp4,*.MP4}', GLOB_BRACE);

foreach ($video_array as $key => $vid) {
    $urlvid = str_replace($data, '', $vid);
    //Commande avec sortie dans le néant et en tache de fond
    $command = '/var/www/html/scripts/captures.sh "' . $vid . '" ' . $cadence . ' "' . $dest . '" '.$key.' > /dev/null 2>/dev/null &'; 
   
    echo '<br/>'.$command;
    $output = shell_exec($command); //Arguments passés sont  $1; $2; $3 dans le script Shell
}
//    /var/www/html/data/2024/07 JUILLET/12/1. Rousselet Pierre - Jack - np/Rush

header('location:/admin/dossiers/'.$_POST['retour']);