
<?php


//il faudra lui donner le nom de l'id de la BDD

$zip_name="email.mail@mail.com.zip";

if(!file_exists('zip/'.$zip_name)){


  // si déjà existant on envoie direct le lien vers le zip
  $folder=$_GET['dl_photos'];
  //on retire le dernier slash de data
  $data=rtrim($data, '/');
  //on echappe les espaces de $folder
  $folder=str_replace(' ', '\ ', $folder);
  $folder=str_replace('(', '\(', $folder);
  $folder=str_replace(')', '\)', $folder);

  $commande='zip -r '.$zip_folder.$zip_name.' '.$data.$folder;
//echo $commande;
  $commande = shell_exec($commande);
}

header("Location: /zip/".$zip_name);


?>
</body>
