<?php



$octetstogigaoctets = (1024*1024*1024);

$totaldisk = disk_total_space('.');
$freedisk = disk_free_space('.');
$occupied = $totaldisk - $freedisk;

$percent = 0;
$free = HumanSize($freedisk);

$percent = 100 / $totaldisk;
$percent = $occupied * $percent;

$annee = date('Y');
$anneeB = $annee-1;


//

$zipfoldersize = 0;
$nbSupprimable = 0;
$zipfolder = './zip/';

// Construct the iterator
$it = new RecursiveDirectoryIterator($zipfolder);

// Loop through files
foreach(new RecursiveIteratorIterator($it) as $file) {
    if ($file->getExtension() == 'zip') {
      $zipfoldersize += filesize($file);
        if (time()-filemtime($file) > 1814400) {    //PLUS ANCIEN
            $nbSupprimable++;
          } 
    }
}

$zipfoldersize = HumanSize($zipfoldersize);

//nombre de clics sur télécharger dans les dernieres 24h
$clics = $partage->clic_24h();
$clics_total = $partage->clic_total();

//les partages introuvables

//$introuvable = $partage->introuvables($data);

include('vue/stats.php');
