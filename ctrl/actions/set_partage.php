<?php



if (!isset($_POST['email']) && !isset($_POST['chemin'])) {
  //rejeter
} else {


  $email = $_POST['email'];
  $chemin = chemin_relatif_normalise($_POST['chemin']);
  $chemin_retour = chemin_relatif_normalise($_POST['chemin_retour']);
  $type_partage = $_POST['type_partage'];
  $email_type = $_POST['email_type'];
  $immediat = $_POST['immediat'];
  $chemin_resolu = chemin_data_ou_404($data, $chemin);

  //verifier d'abord l'heure du dernier partage sinon celui quon fera immediatement faussera le calcul
  $hours = $partage->last_partage($_POST['email']); //heures depuis le dernier partage

  if ($type_partage == 'rushs') {
    $type_partage = 'video';
    $base_resolue = realpath($data);
    $liste_fichiers = glob($chemin_resolu . '/*.mp4');
    $liste_fichiers = array_merge($liste_fichiers, glob($chemin_resolu . '/*.MP4'));
    foreach ($liste_fichiers as $un) {
      $un = chemin_relatif_normalise(substr($un, strlen($base_resolue)));
      //set partage
      $retour = $partage->set_partage($un, $email, $type_partage, $_SESSION['login'], $email_type, $immediat);
        //ajout à l'historique ($id_admin,$id_partage,$action)
      $historique->set_partage($_SESSION['login'], $chemin, $email);
    }
  }else{
//set partage
  $retour = $partage->set_partage($chemin, $email, $type_partage, $_SESSION['login'], $email_type, $immediat);
  //ajout à l'historique ($id_admin,$id_partage,$action)
  $historique->set_partage($_SESSION['login'], $chemin, $email);
  }

  //si le dernier partage a été fait il y a moins de 6h
  if ($hours >= 6) {
    //mise en liste d'attente
    $file_attente->add($retour['id'], $immediat);
  }

}
if ($chemin_retour == '/') {
  $chemin_retour = '';
}
header('Location:/admin/dossiers/' . chemin_pour_url($chemin_retour));
