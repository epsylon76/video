
<?php


//id de la BDD

$zip_name=$_GET['dl_photos'].$_GET['email'].".zip";

if(!file_exists('zip/'.$zip_name)){

  $folder = $partage->get_partage($_GET['dl_photos']);

  $folder = $folder['chemin'];


  //on retire le dernier slash de data
  $data=rtrim($data, '/');
  //on echappe les espaces de $folder
  $folder=str_replace(' ', '\ ', $folder);
  $folder=str_replace('(', '\(', $folder);
  $folder=str_replace(')', '\)', $folder);

  $commande='zip -jrm '.$zip_folder.$zip_name.' '.$data.$folder;
  //echo $commande;
  $commande = shell_exec($commande);
}

header("Location: /zip/".$zip_name);


?>
</body>
